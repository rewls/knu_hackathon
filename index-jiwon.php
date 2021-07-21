<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
  <?php
    include $_SERVER['DOCUMENT_ROOT'].'/broswertest.php';
  ?>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta property="og:image" content="https://bolgogi.gabia.io/logo.png">
    <meta name="viewport" content="width=device-width">
    <title>경북대 도서관</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="top_bar.css">
    <script src="/jquery-3.2.0.min.js"></script>
    <script type="text/javascript">
    var result_html = "";
    var PreviousBook="";
    var BookLocData = "";

    function Search(cnt){
      var max_int = 20;
      var ParsedData = "";
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
        url:'/book_search.php',
        type:'POST',
        data:{type:type_arr[type],
          name:$(".search_bar>input").val(),
          max:20,
          offset:cnt*max_int},
          success:function(data){
          ParsedData = JSON.parse(data);
          var temp_imagechecker = '';
          for(var i=0;i<ParsedData.list.length;i++){
            temp_imagechecker = ParsedData.list[i].imgUrl ? ParsedData.list[i].imgUrl : "img/NoUrl.jpg"
            result_html = result_html + '<div class="info-box">'+
          '<img class="book-img" src="'+ temp_imagechecker +'" alt="'+ParsedData.list[i].title+'">'
            +'<span class="material-icons check-icon">star_border</span>'
            +'<div>'
              +'<span class="book-title"> '+ParsedData.list[i].title+' </span>'
              +'<span class="book-author"> '+ParsedData.list[i].author+' / '+ParsedData.list[i].publication+' </span>'
              +'<span class="material-icons">room</span>'
              +'<span class="book-status">'+ParsedData.list[i].location+' ['+ParsedData.list[i].code+']  '+ParsedData.list[i].state +'</span>'
              +'<span class="book-detail"> [ 상세 정보 ] </span>'
            +'</div>'
          +'</div>';
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

          $(".check-icon").click(function(){
            $(".check-icon").toggleClass("check");
            if($(this).hasClass("check")){
              var book_info={id:123456,title:"제목",code:"ㅁㅇㄴㅍ3241"};
              $.ajax({
                url:'/wishlist_add.php',
                type:'POST',
                data:{book:JSON.stringify(book_info)},
                success:function(data){
                  console.log(data);
                }
              });
            }
            else{
              $.ajax({
                url:'/wishlist_del.php',
                type:'POST',
                data:{id:123456},
                success:function(data){
                  console.log(data);
                }
              });
            }
          });
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
            url:'/wishlist_read.php',
            type:'POST',
            success:function(data){
              console.log(JSON.parse(data));
            }
          });
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
        padding-top: 8px;
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
        padding-top: 10px;
        vertical-align: top;
        padding-left: 1px;
        font-family: 'NSR';
        font-size: 110%;
        font-weight: bold;
          display: block;
      }
      .book-detail {
        vertical-align: top;
        padding-top: 10px;
        font-family:Nanum Gothic;
        font-family: 'NSR';
        font-size: 120%;
        font-weight: normal;
        color: #8faadc;
          display: block;
      }
      .check-icon {
        padding:10px;
        position: absolute;
        bottom: 0px;
        right:0px;
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
    </style>
  </head>
  <body>
    <div class="top">
      <img src="logo.png" class="logo"></img>
      <span class="logo_text"><a href="https://bulgogi.gabia.io/index2.php" style="text-decoration:none;color:white;"> 경북대 도서관 </a></span>
    </div>
    <div class="top_menu">
      <span class="top_side"></span>
      <span id="book_search" class="menu_top on">도서 검색</span>
      <span id="book_select" class="menu_top">찜한 도서</span>
      <span id="course_search" class="menu_top">경로 탐색</span>
      <span class="top_side"></span>
    </div>
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
      <article id="contents">
      </article>
    </div>
    <div id="book_select_container" class="container">

    </div>
    <div id="course_search_container" class="container">

    </div>
  </body>
</html>
