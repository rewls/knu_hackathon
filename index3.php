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
      var result_html = "";
      var temp_html = "";
      var PreviousBook="";
      var Lib = "";
      var titleArr=[];
      var DispOrder=[];

      var SearchBookLoc = function(BookID){
          var BookLocData = "";
          var ShelfNum = ""
          var BookCode = ""
          $.ajax({
            url:'/API/book_location.php',
            type:'POST',
            data:{id:BookID},
            success:function(data){
              data = JSON.parse(data);
              if (data.isJungDo == false){
                $("#DetailLoc").html("중앙도서관에 없습니다.");
              }
              else{
                BookLocData = data.list[0].location; //0은 중도 1은 상주 근데 차피 상주는 표시X
                ShelfNum = data.list[0].shelf;
                BookCode = data.list[0].code;
                $("#DetailLoc").html("책 위치: "+BookLocData+"<br>서고 번호: "+ShelfNum+"<br>도서 코드: "+BookCode);
                BookLocData = ""; ShelfNum = ""; BookCode = "";
              }
            }
          });
      }

      function Search(cnt){
        var max_int = 20;
        var ParsedData = "";
        var nowWish = "";
        if($(".search_bar>input").val()==""){
          alert("검색어를 입력해주세요");
          return;
        }
        if (PreviousBook != $(".search_bar>input").val() || cnt == 0){
          result_html = "";
        }
        var type = $(".drop_result").text();
        var type_arr={전체:"all",제목:"title",저자:"author",출판사:"publisher"};
        PreviousBook = $(".search_bar>input").val()
        $.ajax({
          url:'/API/wishlist_read.php',
          async: false,
          type:'POST',
          success:function(data){
            nowWish = JSON.parse(data);
          }
        });
        $.ajax({
          url:'/API/book_search.php',
          async: false,
          type:'POST',
          data:{type:type_arr[type],
            name:$(".search_bar>input").val(),
            max:20,
            offset:cnt*max_int},
          success:function(data){
            ParsedData = JSON.parse(data);
            var temp_imagechecker = '';
            for(var i=0;i<ParsedData.list.length;i++){
              Lib = ParsedData.list[i].location;
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
                +'<span class="book-detail" onclick="showPopup('+ParsedData.list[i].id+')"> [ 상세 정보 ] </span>'
              +'</div>'
            +'</div>';

            if (Lib==null){
              result_html = result_html.replace('<span class="book-detail" onclick="showPopup('+ParsedData.list[i].id+')"> [ 상세 정보 ] </span>', '');
            }
            for(var j=0;j<nowWish.list.length;j++){
              console.log(nowWish.list[j].id+ " " +ParsedData.list[i].id);
              if (nowWish.list[j].id == ParsedData.list[i].id){
                result_html = result_html.replace('<span id="'+ParsedData.list[i].id+'" class="check-icon"></span>', '<span id="'+ParsedData.list[i].id+'" class="check-icon checked"></span>');
                break;
              }
            }
            }
            if (ParsedData.list.length < max_int){
              $("#contents").html(result_html);
            }
            else{
              $("#contents").html(result_html+'<p style="margin-top: 20px;"><div id="more" style="text-align:center;"><strong onclick="Search('+cnt+1+')" style="cursor:pointer">더보기</strong></div></p>');
            }
            $(".book-title").click(function(){
              $(this).parent('div').toggleClass("full");
            });
            $(".check-icon").click(function() {
              $(this).toggleClass("checked");
              if($(this).hasClass("checked")){
                var book_info={id:Number($(this).attr('id')),imgUrl: $(this).parent('div').attr('imgsrc'),title:$(this).parent('div').attr('booktitle'),author:$(this).parent('div').attr('author').split("|")[0], publication:$(this).parent('div').attr('author').split("|")[1],code:$(this).parent('div').attr('bookcode'),location:$(this).parent('div').attr('state').split("|")[0],state:$(this).parent('div').attr('state').split("|")[1]};
                $.ajax({
                  url:'/API/wishlist_add.php',
                  type:'POST',
                  data:{book:JSON.stringify(book_info)},
                  success:function(data){
                    console.log(data);
                  }
                });
              }
              else{
                $.ajax({
                  url:'/API/wishlist_del.php',
                  type:'POST',
                  data:{id:Number($(this).attr('id'))},
                  success:function(data){
                    console.log(data);
                  }
                });
              }
            });
          }
        })
      }

      function showPopup(n) {
        const popup = document.querySelector('#popup');
        popup.classList.remove('multiple-filter');
        popup.classList.remove('hide');
        SearchBookLoc(n);
      }

      function closePopup() {
        const popup = document.querySelector('#popup');
        popup.classList.add('hide');
      }

      function loadWish(srt) {
        var tmp = "";
        temp_html = ""
        DispOrder = [];

        $.ajax({
          url:'/API/wishlist_read.php',
          async: false,
          type:'POST',
          success:function(data){
            tmp = JSON.parse(data);
            if (srt==0){
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
                  +'<span class="book-detail" onclick="showPopup('+tmp.list[i].id+')"> [ 상세 정보 ] </span>'
                +'</div>'
              +'</div>';
              }
            }
            else{
              for(var i=0; i<tmp.list.length; i++){
                titleArr.push(tmp.list[i].title + "|" + i);
              }
              titleArr = titleArr.sort();
              for(var k=0; k < tmp.list.length; k++){
                DispOrder.push(titleArr[k].split('|')[1]);
              }
              console.log(DispOrder);
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
                  +'<span class="book-detail" onclick="showPopup('+tmp.list[DispOrder[l]].id+')"> [ 상세 정보 ] </span>'
                +'</div>'
              +'</div>';
              }
              //btn = document.getElementById('Ganada');
              //btn.disabled = false;
            }
            //titleArr = [];
          $("#wishcontents").html(temp_html);
          $(".book-title").click(function(){
            $(this).parent('div').toggleClass("full");
          });
          $(".check-icon").click(function() {
            $(this).toggleClass("checked");
            if($(this).hasClass("checked")){
              var book_info={id:Number($(this).attr('id')),imgUrl: $(this).parent('div').attr('imgsrc'),title:$(this).parent('div').attr('booktitle'),author:$(this).parent('div').attr('author').split("|")[0], publication:$(this).parent('div').attr('author').split("|")[1],code:$(this).parent('div').attr('bookcode'),location:$(this).parent('div').attr('state').split("|")[0],state:$(this).parent('div').attr('state').split("|")[1]};
              $.ajax({
                url:'/API/wishlist_add.php',
                type:'POST',
                data:{book:JSON.stringify(book_info)},
                success:function(data){
                  console.log(data);
                }
              });
            }
            else{
              $.ajax({
                url:'/API/wishlist_del.php',
                type:'POST',
                data:{id:Number($(this).attr('id'))},
                success:function(data){
                  console.log(data);
                }
              });
            }
          });
        }
        });
      }

      function deleteWishAll() {
        $.ajax({
          url:'/API/wishlist_del_all.php',
          type:'POST',
          success:function(data){
            $("#book_select").click();
          }
        });
      }

      $(document).ready(function() {
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
              console.log(JSON.parse(data));
              Tgchange = false;
              $('#sortToggle').text('추가순 정렬');
              loadWish(0);
            }
          });
        });
        $("#book_search").click(function(){
          if($(".search_bar>input").val()!=""){
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
      @keyframes HeartAni{0%, 100%{width:30px; height:30px;} 50%{width:40px; height:40px;}}
    </style>
  </head>
  <body>
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
    </div><!--end of container -->
    <div id="book_select_container" class="container">
      <div style="text-align: center;"><br>찜 목록이 정상적으로 보이지 않는 경우, 전체 삭제 버튼을 누른 후 다시 시도해보세요.</div>
      <div style="text-align: right;"><strong style="margin-right:10px" onclick="deleteWishAll()">전체 삭제</strong></div>
      <div style="text-align: left;"><button id="sortToggle" style="margin-left:20px;">추가순 정렬</button></div>
      <article id="wishcontents"></article>
    </div><!--end of container -->
    <div id="course_search_container" class="container">

    </div><!--end of container -->
    <div id="popup" class="hide">
      <div class="content">
        <article id="DetailLoc">

        </article>
        <div class="button_align"><button style="margin-top:15px;" onclick="closePopup()">닫기</button></div>
      </div>
    </div><!--end of popup -->
  </body>
</html>
