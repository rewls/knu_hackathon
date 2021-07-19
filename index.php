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
    <script src="/jquery-3.2.0.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $(".top_menu>span").click(function(){
          $(".top_menu>span").removeClass("on");
          $(".container").removeClass("on");
          $(this).addClass("on");
          $("#"+$(this).attr('id')+"_container").addClass("on");
        });
        $(".dropbtn").click(function(){
          $(".list").toggleClass("on");
        });
        $(".list>span").click(function(){
          $(".drop_result").text($(this).text());
        });

        $("#search_commit").on('click',function() {
          $.ajax({
            url:'/book_search.php',
            type:'POST',
            data:{type:"all",name:"박지원"},
            success:function(data){
              console.log(data);
              // var result = JSON.parse(data);
              // console.log(result);
            }
          })
        });

      });
    </script>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Nanum+Gothic:wght@400;700;800&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap');
    body{font-family: 'NotoSansCJKkr', sans-serif;}
      html,body{
        width:100%;
        height:100%;
        margin:0;
      }
      *::-webkit-scrollbar {
          width: 0.7em;
          border-radius: 0.5em 0.5em 0.5em 0.5em;
      }

      *::-webkit-scrollbar-thumb {
          background-color: #4b4b4b33;
          border-radius: 0.5em 0.5em 0.5em 0.5em;
      }
      *::-webkit-scrollbar-track {
          border-radius: 0.5em 0.5em 0.5em 0.5em;
      }
      .top{
        background: #e60000;
        padding:10px 0px;
        font-size: 20px;
        font-weight: bold;
        position:relative;
        height:30px;
      }
      .top>.logo{
        display: inline-block;
        width: 30px;
        height: 30px;
        position: absolute;
        top:50%;
        transform:translateY(-50%);
        left: 5px;
      }
      .top>.logo_text{
        display: inline-block;
        color: #ffffff;
        position: absolute;
        top:50%;
        transform:translateY(-50%);
        left:40px;
      }
      .top_menu{
        width:100%;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        text-align: center;
        height: 40px;
        grid-column-gap: 3px;
      }
      .top_menu>span{
        background: #e60000;
        color:#fff;
        font-weight: bold;
        font-size:18px;
        padding-top:8px;
        cursor:pointer;
      }
      .top_menu>.on{
        background: #fff;
        color:#e60000;
        border-bottom:5px solid #e60000;
      }
      .container{
        display: none;
        width: 100%;
        height: calc(100% - 90px);
        overflow-y: scroll;
        position: relative;
      }
      .container.on{
        display:block;
      }
      .search_bar{
        position: absolute;
        margin-top: 20px;
        width: calc(100% - 165px);
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
      @media (max-width:1320px){

      }
      @media (max-width:1100px){

      }
      @media (max-width:700px){

      }
    </style>
  </head>
  <body>
    <div class="top">
      <img src="logo.png" class="logo"></img>
      <span class="logo_text"> 경북대 도서관 </span>
    </div>
    <div class="top_menu">
      <span id="book_search" class="on">도서 검색</span>
      <span id="book_select">찜한 도서</span>
      <span id="course_search">경로 탐색</span>
    </div>
    <div id="book_search_container" class="container on">
      <div class="search_bar">
        <input type="text" name="book" placeholder="소장 도서 검색">
        <div class="dropbtn">
          <span class="drop_result">전체</span>
          <span class="material-icons" style="position: absolute;transform: translateY(-50%); top: 50%; left: 50px;">
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
    </div>
    <div id="book_select_container" class="container">

    </div>
    <div id="course_search_container" class="container">

    </div>
  </body>
</html>
