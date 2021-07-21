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
    <script charset="utf-8" src="/js/book_search_display.js"></script>
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

        $("#search_commit").on('click',function(){
          FirstSearch();

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
        <div class="info-box">
          <img class="book-img" src="https://image.aladin.co.kr/product/27138/61/cover/8969524584_1.jpg" alt="(누구나 쉽게 따라 할 수 있는) 블렌디드 수업 =Blended learning"><span class="material-icons check-icon">star_border</span>
          <div>
            <span class="book-title"> (누구나 쉽게 따라 할 수 있는) 블렌디드 수업 =Blended learning </span>
            <span class="book-author"> 박재찬 / 서울 :경향BP :경향비피,2021 </span>
            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="https://image.aladin.co.kr/product/24271/84/cover/8971994703_1.jpg" alt="열하일기 첫걸음 :조선 최고의 고전을 만나는 법"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> 열하일기 첫걸음 :조선 최고의 고전을 만나는 법 </span>
            <span class="book-author"> 박수밀 / 파주 :돌베개,2020 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="img/NoUrl.jpg" alt="2019 회계연도 총수입 결산 분석"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> 2019 회계연도 총수입 결산 분석 </span>
            <span class="book-author"> 한국 / 서울 :국회예산정책처,2020 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="https://image.aladin.co.kr/product/25869/7/cover/k802737460_1.jpg" alt="오늘 아침, 나는 책을 읽었다 :선비의 독서법, 연암의 산문 미학"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> 오늘 아침, 나는 책을 읽었다 :선비의 독서법, 연암의 산문 미학 </span>
            <span class="book-author"> 정민 / 파주 :태학사,2020 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="https://image.aladin.co.kr/product/25871/37/cover/k232737463_1.jpg" alt="비슷한 것은 가짜다 :연암 박지원의 예술론과 인생론"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> 비슷한 것은 가짜다 :연암 박지원의 예술론과 인생론 </span>
            <span class="book-author"> 정민 / 파주 :태학사,2020 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="https://image.aladin.co.kr/product/25636/30/cover/k032735310_1.jpg" alt="청년, 연암을 만나다 :함께 읽고 쓴 연암 그리고 공동체 청년 이야기"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> 청년, 연암을 만나다 :함께 읽고 쓴 연암 그리고 공동체 청년 이야기 </span>
            <span class="book-author"> 남다영 / 서울 :북드라망,2020 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="img/NoUrl.jpg" alt="제당 산업 실태와 발전 방안"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> 제당 산업 실태와 발전 방안 </span>
            <span class="book-author"> 한국농촌경제연구원 / 나주 :한국농촌경제연구원,2020 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="https://image.aladin.co.kr/product/27290/30/cover/k862732022_1.jpg" alt="국내 엔지니어링 기업의 재무구조 영향분석 :글로벌 경기침체 전후 변화 비교"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> 국내 엔지니어링 기업의 재무구조 영향분석 :글로벌 경기침체 전후 변화 비교 </span>
            <span class="book-author"> 산업연구원 / 세종 :산업연구원,2020 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="https://image.aladin.co.kr/product/23991/42/cover/8932217351_1.jpg" alt="남북러 지역개발 정책과 산업 정책 연계 방안 =A study on linking regional development policies and industrial polices of South Korea, North Korea and Russia"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> 남북러 지역개발 정책과 산업 정책 연계 방안 =A study on linking regional development policies and industrial polices of South Korea, North Korea and Russia </span>
            <span class="book-author"> 대외경제정책연구원 / 세종 :KIEP(대외경제정책연구원),2019 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="https://image.aladin.co.kr/product/18708/36/cover/k402635875_1.jpg" alt="인체 구조와 기능"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> 인체 구조와 기능 </span>
            <span class="book-author"> Scanlon, Valerie C / 서울 :메디컬사이언스,2019 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="img/NoUrl.jpg" alt="전신질환자 및 노인, 장애환자의 치과치료"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> 전신질환자 및 노인, 장애환자의 치과치료 </span>
            <span class="book-author"> 박문수 / 서울 :Dental Wisdom,2019 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="https://image.aladin.co.kr/product/19521/14/cover/k372635922_1.jpg" alt="연암 평전 =Critical biography of Yeon-am Park Ji-won"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> 연암 평전 =Critical biography of Yeon-am Park Ji-won </span>
            <span class="book-author"> 간호윤 / 서울 :소명,2019 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="https://image.aladin.co.kr/product/19598/94/cover/8946071648_1.jpg" alt="푸틴 4.0 :강한 러시아"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> 푸틴 4.0 :강한 러시아 </span>
            <span class="book-author"> 김선래 / 파주 :한울아카데미 :한울엠플러스,2019 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="https://image.aladin.co.kr/product/22132/3/cover/k222636219_1.jpg" alt="내내 읽다가 늙었습니다 :무리 짓지 않는 삶의 아름다움 :고독한 독서인 박홍규와의 대화"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> 내내 읽다가 늙었습니다 :무리 짓지 않는 삶의 아름다움 :고독한 독서인 박홍규와의 대화 </span>
            <span class="book-author"> 박홍규 / 파주 :SIDEWAYS :사이드웨이,2019 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="img/NoUrl.jpg" alt="좌심실 보조장치 이식 환자의 심장눌림증 수술마취 1례"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> 좌심실 보조장치 이식 환자의 심장눌림증 수술마취 1례 </span>
            <span class="book-author"> 이수현 / 계명대학교 의과대학, 2019-12-15 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="https://image.aladin.co.kr/product/22629/64/cover/8946072024_1.jpg" alt="유라시아와 일대일로 :통합, 협력, 갈등 =Development of Eurasia and China's belt and road initiative integration, cooperation, and conflict"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> 유라시아와 일대일로 :통합, 협력, 갈등 =Development of Eurasia and China's belt and road initiative integration, cooperation, and conflict </span>
            <span class="book-author"> 강명구 / 파주 :한울아카데미 :한울엠플러스,2019 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="https://image.aladin.co.kr/product/23375/21/cover/8957416420_1.jpg" alt="구강악안면영상학 =Oral and maxillofacial radiology"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> 구강악안면영상학 =Oral and maxillofacial radiology </span>
            <span class="book-author"> 배현숙 / 서울 :대한나래,2019 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="img/NoUrl.jpg" alt="(2020년도) 총수입 예산안 분석"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> (2020년도) 총수입 예산안 분석 </span>
            <span class="book-author"> 한국 / 서울 :국회예산정책처,2019 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="img/NoUrl.jpg" alt="2018 회계연도 총수입 결산 분석"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> 2018 회계연도 총수입 결산 분석 </span>
            <span class="book-author"> 한국 / 서울 :국회예산정책처,2019 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <div class="info-box">
          <img class="book-img" src="img/NoUrl.jpg" alt="(2019~2028년) NABO 중기 재정전망"><span class="material-icons check-icon">star_border</span>
          <div><span class="book-title"> (2019~2028년) NABO 중기 재정전망 </span>
            <span class="book-author"> 한국 / 서울 :국회예산정책처,2019 </span>

            <span class="material-icons">room</span><span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>
            <span class="book-detail"> [ 상세 정보 ] </span>
          </div>
        </div>
        <p style="margin-top: 20px;"></p>
        <div id="more" style="text-align:center;"><strong onclick="SearchMore(20)" style="cursor:pointer">더보기</strong>
        </div>
        <p></p>
      </article>
    </div>
    <div id="book_select_container" class="container">

    </div>
    <div id="course_search_container" class="container">

    </div>
  </body>
</html>
