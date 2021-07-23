<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
  <?php
    include $_SERVER['DOCUMENT_ROOT'].'/API/broswertest.php';
  ?>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta property="og:image" content="https://bolgogi.gabia.io/logo.png">
    <meta name="viewport" content="width=device-width">
    <title>경북대 도서관</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/m/css/top_bar.css">
    <script src="/jquery-3.2.0.min.js"></script>
    <script type="text/javascript">
      var result_html = "";         // 책 검색시 결과 값을 표시할 HTML
      var temp_html = "";           // 관심도서 불러올 때 결과 값을 표시할 임시 HTML
      var PreviousBook="";          // 이전 책 담는 변수(중복방지)
      var Lib = "";                 // 소장 도서관 임시변수
      var titleArr=[];              // 관심도서 Sorting에 필요한 변수
      var DispOrder=[];             // 관심도서 Sorting에 필요한 변수

      var SearchBookLoc = function(BookID){                                     // Func > 책 위치 찾는 함수
          var BookLocData = "";     //서가 위치
          var ShelfNum = "";        //서가 번호
          var BookCode = "";        //도서 번호
          var BookState = "";       //예약 상태
          $.ajax({
            url:'/API/book_location.php',
            type:'POST',
            data:{id:BookID},
            success:function(data){
              data = JSON.parse(data);
              //console.log(data.list);
              if (data.isJungDo == false){                                      // isJungDo == False 이면,
                $("#DetailLoc").html("중앙도서관에 없습니다."+'<div class="button_align"><button style="margin-top:15px;" onclick="closePopup()">닫기</button></div>');
              }
              else{                                                             // isJungDo == True
                var BookLocInfo_html = "";
                for(var i=0; i < data.list.length; i++){
                  BookLocData = data.list[i].location;
                  ShelfNum = data.list[i].shelf;
                  BookCode = data.list[i].code;
                  BookState = data.list[i].state;
                  BookLocInfo_html = BookLocInfo_html + '<div style="border: 2px solid red;margin:10px;padding:10px;">책 위치: '+BookLocData+'<br>서고 번호: '+ShelfNum+'<br>도서 코드: '+BookCode+'<br>대출 여부: '+BookState+'</div>'
                  BookLocData = ""; ShelfNum = ""; BookCode = "";
                }
                $("#DetailLoc").html(BookLocInfo_html+'<div class="button_align"><button style="margin-top:15px;" onclick="closePopup()">닫기</button></div>');
                BookLocInfo_html = "";
              }
            }
          });
      }                                                                         // end of the SearchBookLoc() Func

      function Search(cnt){                                                      // Search() Func
        var max_int = 20;
        var ParsedData = "";
        var nowWish = "";
        if($(".search_bar>input").val()==""){
          alert("검색어를 입력해주세요");
          return;
        }
        if (PreviousBook != $(".search_bar>input").val() || cnt == 0){          // 도서 중복 검색 및 표시방지
          result_html = "";
        }
        var type = $(".drop_result").text();
        var type_arr={전체:"all",제목:"title",저자:"author",출판사:"publisher"};
        PreviousBook = $(".search_bar>input").val()
        $.ajax({                                                                // nowWish에 위시리스트 저장 (찜목록 도서와 검색시 도서의 찜여부 연동)
          url:'/API/wishlist_read.php',
          async: false,
          type:'POST',
          success:function(data){
            nowWish = JSON.parse(data);
          }
        });
        $.ajax({                                                                // Call book_search.php [url, type, data{type,name,max,offset}]
          url:'/API/book_search.php',
          async: false,
          type:'POST',
          data:{type:type_arr[type],
            name:$(".search_bar>input").val(),
            max:20,
            offset:cnt*max_int},
          success:function(data){                                                // Success Func > 검색 성공시 화면에 표시하는 코드
            ParsedData = JSON.parse(data);
            var temp_imagechecker = '';
            for(var i=0;i<ParsedData.list.length;i++){
              Lib = ParsedData.list[i].location;
              if (Lib==null){
                continue;
              }
              temp_imagechecker = ParsedData.list[i].imgUrl ? ParsedData.list[i].imgUrl : "img/NoUrl.jpg"
              result_html = result_html + '<div class="info-box">'
              +'<img class="book-img" src="'+ temp_imagechecker +'" alt="'+ParsedData.list[i].title+'">'
              +'<div booktitle="'+ ParsedData.list[i].title +'" bookcode="['+ ParsedData.list[i].code +']" author="'+ ParsedData.list[i].author+'|'+ParsedData.list[i].publication +'" imgsrc="'+ temp_imagechecker +'" state="'+ ParsedData.list[i].location+'|'+ParsedData.list[i].state +'">'
                +'<span id="'+ParsedData.list[i].id+'" class="check-icon"></span>'
                +'<span class="book-code"> '+'['+ParsedData.list[i].code+']'+' </span>'
                +'<span class="book-title"> '+ParsedData.list[i].title+' </span>'
                +'<span class="book-author"> '+ParsedData.list[i].author+' / '+ParsedData.list[i].publication+' </span>'
                +'<span class="material-icons">room</span>'
                +'<span class="book-status"> '+ParsedData.list[i].location+' - '+ParsedData.list[i].state+' </span>'
                +'<span class="book-detail" style="width:116px;" onclick="showPopup('+ParsedData.list[i].id+')"> [ 상세 정보 ] </span>'
              +'</div>'
            +'</div>';

            if (Lib!="중앙도서관"){
              result_html = result_html.replace('<span id="'+ParsedData.list[i].id+'" class="check-icon"></span>','')
            }
            for(var j=0;j<nowWish.list.length;j++){                             // 위시리스트와 검색리스트의 찜 연동
              //console.log(nowWish.list[j].id+ " " +ParsedData.list[i].id);
              if (nowWish.list[j].id == ParsedData.list[i].id){
                result_html = result_html.replace('<span id="'+ParsedData.list[i].id+'" class="check-icon"></span>', '<span id="'+ParsedData.list[i].id+'" class="check-icon checked"></span>');
                break;
              }
            }
            }
            if (ParsedData.list.length < max_int){                              // Display "more Search"
              $("#contents").html(result_html);
            }
            else{
              $("#contents").html(result_html+'<p style="margin-top: 20px;"><div id="more" style="text-align:center;"><strong onclick="Search('+cnt+1+')" style="cursor:pointer">더보기</strong></div></p>');
            }
            $(".book-title").click(function(){                                  // Book Title Append
              $(this).parent('div').toggleClass("full");
            });
            $(".check-icon").click(function() {                                 // Wishlist Add & Del
              $(this).toggleClass("checked");
              if($(this).hasClass("checked")){
                var book_info={id:Number($(this).attr('id')),imgUrl: $(this).parent('div').attr('imgsrc'),title:$(this).parent('div').attr('booktitle'),author:$(this).parent('div').attr('author').split("|")[0], publication:$(this).parent('div').attr('author').split("|")[1],code:$(this).parent('div').attr('bookcode'),location:$(this).parent('div').attr('state').split("|")[0],state:$(this).parent('div').attr('state').split("|")[1]};

                if ($(this).parent('div').attr('state').split('|')[1] != "대출가능"){
                  if (confirm("현재 대출가능한 도서가 아닙니다. 찜하시겠습니까?") != 0){
                    $.ajax({
                      url:'/API/wishlist_add.php',
                      type:'POST',
                      data:{book:JSON.stringify(book_info)},
                      success:function(data){
                        //console.log(data);
                      }
                    });
                  }
                  else{
                    $.ajax({
                      url:'/API/wishlist_del.php',
                      type:'POST',
                      data:{id:Number($(this).attr('id'))},
                      success:function(data){
                        //console.log(data);
                      }
                    });
                    $(this).toggleClass("checked");
                  }
                }
                else{
                  $.ajax({
                    url:'/API/wishlist_add.php',
                    type:'POST',
                    data:{book:JSON.stringify(book_info)},
                    success:function(data){
                      //console.log(data);
                    }
                  });
                }
              }
              else{
                $.ajax({
                  url:'/API/wishlist_del.php',
                  type:'POST',
                  data:{id:Number($(this).attr('id'))},
                  success:function(data){
                    //console.log(data);
                  }
                });
              }
            });
          }
        })
      }                                                                         // end of the Search() Func

      function loadWish(srt) {                                                  // loadWish() Func > 위시리스트를 불러와서 출력하는 함수
        var tmp = "";       // wishlist Data를 임시 저장
        temp_html = ""      // temp_html 초기화
        DispOrder = [];     // 가나다 정렬시 필요한 변수 초기

        $.ajax({                                                                // call wishlist_read.php > tmp에 저장
          url:'/API/wishlist_read.php',
          async: false,
          type:'POST',
          success:function(data){
            tmp = JSON.parse(data);
            console.log(tmp);
            if (tmp.list.length == 0){
              $("#deleteAll").css("display","none");
              $("#Rsort").css("display","none");
            }
            else{
              $("#deleteAll").css("display","block");
              $("#Rsort").css("display","block");
            }
            if (srt==0){                                                        // 최신순 정렬
              for(var i=0; i<tmp.list.length; i++){
                //console.log(tmp.list[i]);
                temp_html = temp_html + '<div class="info-box">'
                +'<img class="book-img" src="'+ tmp.list[i].imgUrl +'" alt="'+tmp.list[i].title+'">'
                +'<div booktitle="'+ tmp.list[i].title +'" bookcode="['+ tmp.list[i].code +']" author="'+ tmp.list[i].author +'|'+tmp.list[i].publication +'" imgsrc="'+tmp.list[i].imgUrl+'" state="'+ tmp.list[i].location+'|'+tmp.list[i].state +'">'
                  +'<span id="'+tmp.list[i].id+'" class="check-icon checked"></span>'
                  +'<span class="book-code"> '+'['+tmp.list[i].code+']'+' </span>'
                  +'<span class="book-title"> '+tmp.list[i].title+' </span>'
                  +'<span class="book-author"> '+tmp.list[i].author+' / '+tmp.list[i].publication+' </span>'
                  +'<span class="material-icons">room</span>'
                  +'<span class="book-status"> '+tmp.list[i].location+' - '+tmp.list[i].state+' </span>'
                  +'<span class="book-detail" style="width:116px;" onclick="showPopup('+tmp.list[i].id+')"> [ 상세 정보 ] </span>'
                +'</div>'
              +'</div>';
              }
            }
            else{                                                               // 가나다순 정렬
              for(var i=0; i<tmp.list.length; i++){
                titleArr.push(tmp.list[i].title + "|" + i);
              }
              titleArr = titleArr.sort();
              for(var k=0; k < tmp.list.length; k++){
                DispOrder.push(titleArr[k].split('|')[1]);
              }
              //console.log(DispOrder);
              titleArr = [];
              for(var l in DispOrder){
                temp_html = temp_html + '<div class="info-box">'
                +'<img class="book-img" src="'+ tmp.list[DispOrder[l]].imgUrl +'" alt="'+tmp.list[DispOrder[l]].title+'">'
                +'<div booktitle="'+ tmp.list[DispOrder[l]].title +'" bookcode="['+ tmp.list[DispOrder[l]].code +']" author="'+ tmp.list[DispOrder[l]].author +'|'+tmp.list[DispOrder[l]].publication +'" imgsrc="'+tmp.list[DispOrder[l]].imgUrl+'" state="'+ tmp.list[DispOrder[l]].location+'|'+tmp.list[DispOrder[l]].state +'">'
                  +'<span id="'+tmp.list[DispOrder[l]].id+'" class="check-icon checked"></span>'
                  +'<span class="book-code"> '+'['+tmp.list[DispOrder[l]].code+']'+' </span>'
                  +'<span class="book-title"> '+tmp.list[DispOrder[l]].title+' </span>'
                  +'<span class="book-author"> '+tmp.list[DispOrder[l]].author+' / '+tmp.list[DispOrder[l]].publication+' </span>'
                  +'<span class="material-icons">room</span>'
                  +'<span class="book-status"> '+tmp.list[DispOrder[l]].location+' - '+tmp.list[DispOrder[l]].state+' </span>'
                  +'<span class="book-detail" style="width:116px;" onclick="showPopup('+tmp.list[DispOrder[l]].id+')"> [ 상세 정보 ] </span>'
                +'</div>'
              +'</div>';
              }
            }
            //titleArr = [];
          $("#wishcontents").html(temp_html);                                   // Display WishList Table
          $(".book-title").click(function(){                                    // book-title append
            $(this).parent('div').toggleClass("full");
          });
          $(".check-icon").click(function() {                                   // Wishlist Add & Del
            $(this).toggleClass("checked");
            if($(this).hasClass("checked")){
              var book_info={id:Number($(this).attr('id')),imgUrl: $(this).parent('div').attr('imgsrc'),title:$(this).parent('div').attr('booktitle'),author:$(this).parent('div').attr('author').split("|")[0], publication:$(this).parent('div').attr('author').split("|")[1],code:$(this).parent('div').attr('bookcode'),location:$(this).parent('div').attr('state').split("|")[0],state:$(this).parent('div').attr('state').split("|")[1]};
              $.ajax({
                url:'/API/wishlist_add.php',
                type:'POST',
                data:{book:JSON.stringify(book_info)},
                success:function(data){
                  //console.log(data);
                }
              });
            }
            else{
              $.ajax({
                url:'/API/wishlist_del.php',
                type:'POST',
                data:{id:Number($(this).attr('id'))},
                success:function(data){
                  //console.log(data);
                }
              });
            }
          });
        }
        });
      }                                                                         // end of the loadWish() Func

      function FindRoad() {
        var tmp = "";
        var tmp1 = "";
        var tmpCrs = "";
        var shelf = [];
        $.ajax({                                                                // nowWish에 위시리스트 저장 (찜목록 도서와 검색시 도서의 찜여부 연동)
          url:'/API/wishlist_read.php',
          async: false,
          type:'POST',
          success:function(data){
            tmp = JSON.parse(data);
          }
        });
        console.log(tmp);
        for(var i=0; i<tmp.list.length; i++){
          $.ajax({
            url:'/API/book_location.php',
            async: false,
            type:'POST',
            data:{id:tmp.list[i].id},
            success:function(data){
              tmp1 = JSON.parse(data);
              console.log(tmp1);
              for(var j=tmp1.list.length-1; j > -1; j--){
                if (tmp1.list[j].state == "대출가능"){
                  if (tmp1.list[j].location == "1층 베스트셀러"){
                    tmpCrs = {floor:1, shelf:"베스트셀러"};
                    shelf.push(tmpCrs);
                    break;
                  }
                  else if (tmp1.list[j].location == "1층 북갤러리"){
                    tmpCrs = {floor:1, shelf:"북갤러리"};
                    shelf.push(tmpCrs);
                    break;
                  }
                  else {
                    tmpCrs = {floor:Number(tmp1.list[j].location.split('층')[0]), shelf:tmp1.list[j].shelf};
                    shelf.push(tmpCrs);
                    break;
                  }
                }
              }
            }
          });
        }
        console.log(shelf);
        $.ajax({
          url:'/API/cal_path.php',
          type:'POST',
          data:{shelf_list:JSON.stringify(shelf)},
          success:function(data){
            console.log(data);
          }
        });
      }
      var t_html = "";
      var pathArr = [];
      function GetRoad() {
        var tmpPath = "";
        pathArr = ["",];
        var rsltRoad = {path:["D-1", "1-B", "2-B",{floor:2,shelf: "5"}, {floor:2,shelf:"51"}, {floor:2,shelf:"104"}, {floor:2,shelf:"145"}, {floor:2,shelf:"147"},"2-A", "1-A", "1-3"], img:[{floor:1,url:"https://cdn.pixabay.com/photo/2021/04/06/21/08/crown-anemone-6157488_960_720.jpg"},{floor:2,url:"https://cdn.pixabay.com/photo/2015/05/03/14/40/woman-751236_960_720.jpg"}]};
        for (var i=0; i < rsltRoad['img'].length; i++){
          t_html = t_html + '<div><img src="'+rsltRoad['img'][i]['url']+'"></img></div>';
        }
          //$("#course_search_container").html(t_html);
        for (var i=0; i < rsltRoad['path'].length; i++){
          if (typeof(rsltRoad['path'][i]['floor']) == "number"){
            tmpPath = rsltRoad['path'][i]['floor'] + "층 " + rsltRoad['path'][i]['shelf'] + "번 서가"
            pathArr.push(tmpPath);
          }
          else{
            pathArr.push(rsltRoad['path'][i]);
          }
        }
        console.log(pathArr);
        pathArr.push("");
      }
      var cnt = 0;
      function nextRoad(){
        console.log(cnt)
        cnt = cnt + 1
        if (pathArr.length == cnt+3){
          btn = document.getElementById('nxt');
          btn.disabled = 'disabled';
        }
        $("#previousR").html("<span>"+pathArr[cnt]+"</span>");
        $("#nowR").html("<span>"+pathArr[cnt+1]+"</span>");
        $("#nextR").html("<span>"+pathArr[cnt+2]+"</span>");
        document.getElementById("img").style = "transform: translateX(-120%)";
        //$("#imgBoard").html('<img id="img" style="position: absolute;left: 50%;top: 40%;height: 500px;  width: 888px;margin-top: -380px;margin-left: -444px;transition: all 0.5s;transform: translateX(0%);" src="./testmap.png" />');

        btn = document.getElementById('prv');
        btn.disabled = false;
      }
      function previousRoad(){
        console.log(cnt);
        cnt = cnt - 1;
        if (cnt <= 0){
          btn = document.getElementById('prv');
          btn.disabled = 'disabled';
        }
        $("#previousR").html("<span>"+pathArr[cnt]+"</span>");
        $("#nowR").html("<span>"+pathArr[cnt+1]+"</span>");
        $("#nextR").html("<span>"+pathArr[cnt+2]+"</span>");
        document.getElementById("img").style = "transform: translateX(120%)";
        btn = document.getElementById('nxt');
        btn.disabled = false;
      }
      function deleteWishAll() {                                                // deleteWishAll() Func
        $("#deleteAll").css("display:block");
        $("#deleteAll").css("display:block");
        $.ajax({
          url:'/API/wishlist_del_all.php',
          type:'POST',
          success:function(data){
            $("#book_select").click();
          }
        });
      }

      function showPopup(n) {                                                   // showPopup() func
        const popup = document.querySelector('#popup');
        popup.classList.remove('multiple-filter');
        popup.classList.remove('hide');
        SearchBookLoc(n);
      }

      function closePopup() {                                                   // closePopup() func
        const popup = document.querySelector('#popup');
        $("#DetailLoc").html('<div style="padding:100px;"></div><div class="loader">');
        popup.classList.add('hide');
      }

      $(document).ready(function() {
        $(".loader").delay("500").fadeOut();                                    // Design
        $(".menu_top").click(function(){
          $(".menu_top").removeClass("on");
          $(".container").removeClass("on");
          $(this).addClass("on");
          $("#"+$(this).attr('id')+"_container").addClass("on");
        });
        $("#book_select").click(function(){
          $.ajax({
            url:'/API/wishlist_read.php',
            type:'POST',
            success:function(data){
              //console.log(JSON.parse(data));
              Tgchange = false;
              $('#sortToggle').text('추가순 정렬');
              loadWish(0);
            }
          });
        });
        $("#book_search").click(function(){
          if($(".search_bar>input").val()!=""){
            $(".loader").delay("1000").fadeOut();
            Search(0);
          }
        });
        $(".dropbtn").click(function(){
          $(".list").toggleClass("on");
        });
        $(".list>span").click(function(){
          $(".drop_result").text($(this).text());
        });

        $("#search_commit").on('click',function(){
          $(".loader").delay("1000").fadeOut();
          Search(0);
        });
        $(".search_bar>input").keydown(function(key){
          if(key.keyCode==13){
            $("#search_commit").click();
          }
        });
        Tgchange = false;
        $('#sortToggle').click(function(){
          if(Tgchange){
            Tgchange = false;
            $('#sortToggle').text('추가순 정렬');
            loadWish(0);
          }else{
            Tgchange = true;
            $('#sortToggle').text('가나다순 정렬');
            loadWish(1);
          }
        })
      });
    </script>
    <style>
      .search_bar{
        z-index: 10;
        position: absolute;
        margin-top: 20px;
        width:55%;
        height: 50px;
        left: 50%;
        transform: translateX(-50%);
      }
      .dropbtn{
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        cursor: pointer;
      }
      .list{
        box-shadow: 0px 6px 6px 0px rgb(0 0 0 / 28%);
        width: 90px;
        padding-bottom:5px;
        border-radius: 0 0 0.5em 0.5em;
        border-style: none;
        position: absolute;
        background: #fff;
        top:17px;
        left:-4px;
        display: none;
      }
      .list.on{
        display: block;
      }
      .dropbtn>.list>span{
        display: block;
        width: 70px;
        cursor:pointer;
        padding-right: 10px;
        padding-left: 10px;
        padding-bottom: 3px;
      }
      .dropbtn>.list>span:hover{
        background: #eee;
      }
      input:focus {outline:none;}
      .search_bar>input{
        width: calc(100% - 105px);
        height: 50px;
        padding: 0px 20px 0px 85px;
        box-shadow: 0 3px 6px 0 rgb(0 0 0 / 28%);
        background-color: #ffffff;
        border: none;
        font-family: NotoSansCJKkr;
        font-size: 20px;
        font-weight: normal;
        font-stretch: normal;
        font-style: normal;
        line-height: 1.48;
        letter-spacing: normal;
        text-align: left;
        border-radius: 1em;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
      }
      .drop_result{
        position: absolute;
        transform: translateY(-50%);
        top: 50%;
        width: 50px;
        text-align: center;
      }
      #search_commit{
        background-image: url(/img/search_icon.png);
        width: 48px;
        height: 48px;
        border: none;
        background-color: rgba( 255, 255, 255, 0 );
        position: absolute;
        top: 50%;
        right: 8px;
        transform: translateY(-50%);
        background-size: cover;
      }
      button{
        cursor: pointer;
      }
      .drop_icon{
        position: absolute;
        transform: translateY(-50%);
        top: 50%;
        left: 50px;
      }
      #contents{
        position: absolute;
        top: 80px;
        left: 50%;
        transform: translateX(-50%);
        width: 60%;
        height: auto;
      }
      #wishcontents{
        position: absolute;
        top: 80px;
        left: 50%;
        transform: translateX(-50%);
        width: 60%;
        height: auto;
      }
      #deleteAll {
        position: absolute;
        top: 60px;
        left: 50%;
        transform: translateX(-50%);
        width: 60%;
        height: auto;
        display:none;
      }
      #Rsort {
        position: absolute;
        top: 60px;
        left: 28%;
        transform: translateX(-50%);
        height: auto;
        display:none;
      }
      /*#announce{
        position: absolute;
        top: 80px;
        left: 50%;
        transform: translateX(-50%);
        width: 60%;
        height: auto;
      }*/
      .info-box {
        border:1px solid silver;
        padding: 14px;
        overflow:hidden;
        position: relative;
        white-space:nowrap;
        margin:20px 10px 0px 10px;
      }

      .info-box>div{
        display: inline-block;
        margin-left: 10px;
        width:calc(100% - 101px);
      }
      .info-box>div>.material-icons{
        display: none;
      }
      .book-img {
        border: none;
        box-shadow: 0 3px 6px 0 rgb(0 0 0 / 28%);
        width:95px;
        height:130px;
        float: left;
        margin: 5px;
        position:static;
      }
      .book-img.smaller {
        width:70px;
        height:86px;
      }
      .book-title {
        vertical-align: top;
        font-family:MGB;
        font-size: 22px;
        font-weight: bolder;
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
          display: block;
      }
      .full>.book-author,.full>.book-status{
        display: none;
      }
      .full .book-title {
        display: block;
        white-space: normal;
      }
      .book-author {
        vertical-align: top;
        padding-top: 2px;
        font-family:NSR;
        font-size: 15px;
        color: #686868;
        font-weight: lighter;
          display: block;
      }
      .book-status {
        padding-top: 7px;
        vertical-align: top;
        padding-left: 1px;
        font-family: 'NSR';
        font-size: 110%;
        font-weight: bold;
          display: block;
      }
      .book-detail {
        vertical-align: top;
        padding-top: 7px;
        font-family:Nanum Gothic;
        font-family: 'NSR';
        font-size: 120%;
        font-weight: normal;
        color: #8faadc;
          display: block;
      }
      .check-icon {
        background: url(/img/heart_1.png);
        background-size: cover;
        position: absolute;
        bottom: 10px;
        right: 10px;
        height:30px;
        width:30px;
        cursor: pointer;
      }
      .book-code{
        vertical-align: top;
        padding-top: 2px;
        font-family:NSR;
        font-size: 13px;
        font-weight: 600;
        color: #333;
        display: block;
      }
      .check-icon.checked{
        background: url(/img/heart.png);
        background-size: cover;
        animation-name: HeartAni;
        animation-duration:0.3s;
        animation-iteration-count:1;
      }
      #popup {
      display: flex;
      justify-content: center;
      align-items: center;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, .7);
      z-index: 1000;
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      }

      #popup.hide {
        display: none;
      }

      #popup .content {
        padding: 20px;
        background: #fff;
        border-radius: 5px;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, .3);
        //text-align: center;
      }
      #popup .button_align{
        text-align: center;
      }
      @media (max-width:1320px){

      }
      @media (max-width:1100px){
        .top_side{
          display: none;
        }
        .top_menu{
          grid-template-columns:1fr 1fr 1fr;
        }
        .search_bar{
          width: calc(100% - 165px);
        }
        #contents{
          position: absolute;
          top: 80px;
          left: 50%;
          transform: translateX(-50%);
          width: 100%;
          height: auto;
        }
      }
      @media (max-width:700px){
        .search_bar{
          width: calc(100% - 80px);
        }
        .search_bar>input{
          width: calc(100% - 80px);
        }
        .drop_result{
          left:-15px;
        }
        .drop_icon{
          left:35px;
        }
      }
      .loader {
      	border: 16px solid #f3f3f3;
      	border-top: 16px solid #3498db;
      	border-radius: 50%;
      	width: 120px;
      	height: 120px;
      	animation: spin 2s linear infinite;
      	position: fixed;
      	top: 50%;
      	left: 50%;
      	transform: translate(-50%, -50%);
      }
      .wrap{
          width: 90%;
          margin: 10px auto;
      }
      .previous {
        border: 1px solid black;
        float: left;
        width: 15%;
        box-sizing: border-box;
        position: absolute;
        left: 25%;
        top: 33%;
        height: 42%;
        text-align: center;
        border-radius:0.5em;
        -moz-border-radius: 0.5em;
        -webkit-border-radius: 0.5em;
        background-color: white;
      }
      .now {
        border: 1px solid black;
        float: left;
        width: 15%;
        box-sizing: border-box;
        position: absolute;
        top: 33%;
        left: 43%;
        height: 42%;
        text-align: center;
        border-radius:0.5em;
        -moz-border-radius: 0.5em;
        -webkit-border-radius: 0.5em;
        background-color: white;
      }
      .next {
        border: 1px solid black;
        float: right;
        width: 15%;
        box-sizing: border-box;
        position: absolute;
        right: 24%;
        top: 33%;
        height: 42%;
        text-align: center;
        border-radius:0.5em;
        -moz-border-radius: 0.5em;
        -webkit-border-radius: 0.5em;
        background-color: white;
      }
      .book-small {
        padding-top: 25px;
        vertical-align: top;
        width: 300px;
        font-family: 'NSR';
        font-size: 100%;
        font-weight: bold;
        display: block;
      }
      #img{
        position: absolute;
        left: 50%;
        top: 40%;
        height: 500px;
        width: 888px;
        margin-top: -380px;
        margin-left: -444px;
        transition: all 0.5s;
        transform: translate(0%, 100px);
      }
      @keyframes spin {
      	0% {transform:translate(-50%, -50%) rotate(0deg); }
      	100% {transform:translate(-50%, -50%) rotate(360deg); }
      }
      @keyframes HeartAni{0%, 100%{width:30px; height:30px;} 50%{width:40px; height:40px;}}
    </style>
  </head>
  <body onload="GetRoad()">
    <?php
      include $_SERVER['DOCUMENT_ROOT'].'/m/html/top_bar.html';
    ?>
    <div id="book_search_container" class="container on">
      <div class="search_bar">
        <input type="text" name="book" placeholder="소장 도서 검색">
        <div class="dropbtn">
          <span class="drop_result">전체</span>
          <span class="material-icons drop_icon">
            arrow_drop_down
          </span>
          <div class="list">
            <span>전체</span>
            <span>제목</span>
            <span>저자</span>
            <span>출판사</span>
          </div>
        </div>
        <button id="search_commit"></button>
      </div>
      <article id="contents"></article>
      <div class="loader"></div>
    </div><!--end of container -->
    <div id="book_select_container" class="container">
      <div id="announce" style="text-align: center;margin-top: 13px;">찜 목록이 정상적으로 보이지 않는 경우, 전체 삭제 버튼을 누른 후 다시 시도해보세요.</div>
      <div id="deleteAll" style="text-align: right;"><button style="margin-right: 10px;" onclick="deleteWishAll()">전체 삭제</button></div>
      <div id="Rsort" style="text-align: left;width:150px;"><button id="sortToggle" style="margin-left:10px;">추가순 정렬</button></div>
      <article id="wishcontents"></article>
    </div><!--end of container -->
    <div id="course_search_container" class="container">
      <button onclick="FindRoad()">찾기</button>
      <button onclick="GetRoad()">길찾기</button>
      <div id="imgBoard">
        <img id="img" style="
        position: absolute;
        left: 50%;
        top: 40%;
        height: 500px;
        width: 888px;
        margin-top: -380px;
        margin-left: -444px;
        transition: all 0.5s;
        transform: translateX(0%);" src="./testmap.png" />
      </div>
      <div id="stBar" style="position:fixed;bottom:0;width:100%;height: 110px;background:skyblue;">
        <button id="prv" style="position:absolute;float:left;left:3%;top:45%" onclick="previousRoad()" disabled="disabled">이전</button>
        <button id="nxt" style="position:absolute;float:right;right:3%;top:45%;" onclick="nextRoad()">다음</button>
        <div class="wrap">
          <div class="previous"><strong id="previousR" style="position: relative;top: 20%;"></strong></div>
          <div class="now"><strong id="nowR" style="position: relative;top: 20%;">D-1</strong></div>
          <div class="next"><strong id="nextR" style="position: relative;top: 20%;">1-B</strong></div>
        </div>
      </div>

      <div class="info-box"style="position: fixed;bottom: 20%;background:white;border:2px solid silver;left: 50%;transform: translateX(-50%);padding:2px;">
        <img class="book-img smaller"  src="http://image.aladin.co.kr/product/10560/18/cover/8960779989_1.jpg" alt="버번 위스키의 모든 것">
        <div>
          <span class="book-code"> [청009 ㅂ 호.] </span>
          <span class="book-title"> 버번 위스키의 모든 것 </span>
          <span class="book-small"> 서가 번호 : 123 </span>
        </div>
      </div>
    </div><!--end of container -->
    <div id="popup" class="hide">
      <div class="content">
        <article id="DetailLoc"><div style="padding:100px;"></div><div class="loader"></article>
      </div>
    </div><!--end of popup -->
  </body>
</html>
