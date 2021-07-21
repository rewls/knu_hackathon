<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta property="og:image" content="http://bolgogi.gabia.io/icon.png">
  <meta name="viewport" content="width=device-width">
  <title>경북대 도서관</title>
  <link rel="stylesheet" href="/top_bar.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="/jquery-3.2.0.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {

    });
    $(".check-icon").on('click',function() {
          $(this).toggleClass("checked");
          if $(this).hasClass("checked"){
            $(this).setAttribute('src', 'img/heart.png');
          }
          else{
            $(this).setAttribute('src', 'img/heart_1.png');
          }
      });
  </script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Nanum+Gothic:wght@400;700;800&display=swap');
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
      .check-icon { 

        padding:10px; 
        position: absolute;
        bottom: 0px;
        right:0px;
        height:30px;
        width:30px;
      }
      .check-icon.checked{
        animation-name: HeartAni;
        animation-duration:0.3s;
        animation-iteration-count:1;
      }
    @keyframes HeartAni{0%, 100%{width:30px; height:30px;} 50%{width:40px; height:40px;}}
  </style>
</head>
  <body>
    <div class="info-box">
      <img class="book-img" src="example.jpg" alt="버번 위스키의 모든 것">
      <div>
        <img src="img/heart_1.png" class="check-icon", alt="Heart">
        <span class="book-title"> 버번 위스키의 모든 것 버번 위스키의 모든 것 버번 위스키의 모든 것 </span>
        <span class="book-author"> 조승원 / 파주: 싱긋, 2020 </span>
        <span class="material-icons">room</span>
        <span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
        <span class="book-detail"> [ 상세 정보 ] </span>
      </div>
    </div>
    <div class="info-box">
      <img class="book-img" src="example.jpg" alt="버번 위스키의 모든 것">
      <div>
        <img src="img/heart_1.png" class="check-icon", alt="Heart">
        <span class="book-title"> 버번 위스키의 모든 것 </span>
        <span class="book-author"> 조승원 / 파주: 싱긋, 2020 </span>
        <span class="material-icons">room</span>
        <span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
        <span class="book-detail"> [ 상세 정보 ] </span>
      </div>
    </div>
  </body>
</html>
