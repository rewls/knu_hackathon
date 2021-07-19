<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <?php
    include $_SERVER['DOCUMENT_ROOT'].'/broswertest.php';
  ?>
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
  </script>
  <style>@font-face{
    font-family: Helvetica;
    src: url("/CSS/Helvetica.ttf");
  }
  @font-face{
    font-family: Helvetica;
    src: url("/CSS/Helvetica Bold.ttf");
    font-weight: bold;
  }
    html,body{
      margin: 0;
      width:100%;
      height:100%;
    }
    .category{
      margin-bottom: 5px;
    }
    .category>span{
      margin: 5px;
      padding: 5px;
      border-radius: 1em;
      border: 2px solid #dadada;
      cursor: pointer;
      font-size: 17px;
      font-weight: bold;
      font-family: 'Helvetica','D2Coding';
    }
    #wholecommand{border-color: #96cfff;}
    .maple>div,#maplecommand{border-color: #ff9696;}
    .kakao>div,#kakaocommand{border-color: #bdbdfb;}
    .guitar>div,#guitarcommand{border-color: #86ea79;}
    .farm>div,#farmcommand{border-color: #a6dd47;}
    #wholecommand.on{background-color: #96cfff;}
    .maple>.command,#maplecommand.on{background-color: #ff9696;}
    .kakao>.command,#kakaocommand.on{background-color: #bdbdfb;}
    .guitar>.command,#guitarcommand.on{background-color: #86ea79;}
    .farm>.command,#farmcommand.on{background-color: #a6dd47;}
    .detail{border-width: 2px;border-style: solid;}
    .detail{border-top-style:none;}

    .table{
      width:800px;
    }
    .table>.command{
      border-radius: 1em 1em 0 0;
      padding: 5px 5px;
      font-size: 22px;
      font-family: 'Helvetica','D2Coding';
      font-weight: bold;
    }
    .table>.detail{
      display: grid;
      grid-template-columns: 150px 635px;
      background-color: #fafafa;
      font-size: 15px;
      text-align: left;
      padding: 5px 5px;
      line-height: 150%;
      border-radius: 0 0 1em 1em;
    }
    .table{
      padding-top: 10px;
      margin: 0 10px;
    }
    .table.off{
      display:none;
    }
    .detail span{
      padding-left: 5px;
    }
    .detail>*~*{
      border-top: 1px solid #bbb;
    }
    .detail>*:nth-child(2){
      border-top-style: none;
    }
    .req{
      display: grid;
      grid-template-columns: 100px 70px auto 100px;
    }
    .reqtitle{
      background-color: #aaa;
      font-weight: bold;
    }
    .res{
      display: grid;
      grid-template-columns: 150px 70px auto;
    }
    .restitle{
      background-color: #aaa;
      font-weight: bold;
    }
    .err{
      display: grid;
      grid-template-columns: auto auto auto;
    }
    .req>span,.res>span,.err>span{
      border-left: 1px solid #aaa;
      border-top:1px solid #aaa;
    }
    .req>span:nth-child(4n+1){
      border-left-style: none;
    }
    .res>span:nth-child(3n+1){
      border-left-style: none;
    }
    .err>span:nth-child(3n+1){
      border-left-style: none;
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
    <div id="main_container">
      <div class="table maple">
              <div class="command">
                <span>도서 검색 API</span>
              </div>
              <div class="detail">
                <span>요청 URL</span><span>https://bulgogi.gabia.io/book_search.php</span>
                <span>메서드</span><span> POST</span>
                <span>출력 포맷</span><span>JSON</span>
                <span>요청 변수</span>
                <div class="req">
                  <span class="reqtitle">Key</span><span class="reqtitle">Type</span><span class="reqtitle">Description</span><span class="reqtitle">Required</span>
                  <span>type</span><span>string</span><span>전체:"all",제목:"title",저자:"author",출판사:"publisher"<br>영어로 넘길 것</span><span>O</span>
                  <span>name</span><span>string</span><span>검색어</span><span>O</span>
                  <span>max</span><span>int</span><span>한번에 받아올 검색 결과 개수</span><span>O</span>
                  <span>offset</span><span>int</span><span>n번째 검색 결과부터 검색</span><span>O</span>
                </div>
                <span>출력 결과</span>
                <div style="display: grid;grid-template-columns: 90px auto;">
                  <div class="res" style="grid-column:1/3">
                    <span class="restitle">Key</span><span class="restitle">Type</span><span class="restitle">Description</span>
                    <span>success</span><span>boolean</span><span>성공여부</span>
                    <span>isFuzzy</span><span>boolean</span><span>검색된 결과는 없으나 유사어로 검색한 결과가 있는 경우 true, 보통은 false</span>
                    <span>totalCount</span><span>int</span><span>총 검색 결과</span>
                  </div>
                  <span>list</span>
                  <span>검색된 도서 정보</span>
                  <span></span>
                  <div class="err">
                    <span class="restitle">Key</span><span class="restitle">Type</span><span class="reqtitle">Description</span>
                    <span>id</span><span>int</span><span>서고 위치 검색용 코드</span>
                    <span>imgUrl</span><span>string</span><span>책 썸네일</span>
                    <span>title</span><span>string</span><span>책 제목</span>
                    <span>author</span><span>string</span><span>저자</span>
                    <span>publication</span><span>string</span><span>출판사</span>
                    <span>code</span><span>string</span><span>도서 분류 번호</span>
                  </div>
                </div>
              </div>
            </div><!--end of table -->
    </div><!-- end of main_container -->
  </body>
</html>
