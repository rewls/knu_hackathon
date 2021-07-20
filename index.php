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
      $(document).ready(function() {
        $(".menu_top").click(function(){
          $(".menu_top").removeClass("on");
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
          if($(".search_bar>input").val()==""){
            alert("검색어를 입력해주세요");
            return;
          }
          var type = $(".drop_result").text();
          var type_arr={전체:"all",제목:"title",저자:"author",출판사:"publisher"};
          $.ajax({
            url:'/book_search.php',
            type:'POST',
            data:{type:type_arr[type],
              name:$(".search_bar>input").val(),
              max:30,
              offset:450},
            success:function(data){
              data = JSON.parse(data);
              // var result = JSON.parse(data);
              // console.log(result);
            }
          })
        });

      });
    </script>
    <style>
      .search_bar{
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
      <span class="logo_text"> 경북대 도서관 </span>
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
