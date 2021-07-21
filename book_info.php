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
  </script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Nanum+Gothic:wght@400;700;800&display=swap');
    .info-box { border:1px solid silver; padding: 20px; overflow:hidden; position: relative; text-overflow:ellipsis; white-space:nowrap;}
    .book-img { border:1px solid; width:80px; height:110.19px; float: left; margin: 5px; position:static}
    .book-title { vertical-align: top; text-align: center; padding: 5px; font-family:Nanum Gothic; font-size: 170%; font-weight: bolder;}
    .book-author { vertical-align: top; text-align: center; padding: 5px; font-family:Nanum Gothic; font-size: 80%; font-weight: 100; }
    .book-status { vertical-align: top; text-align: center; font-family:Nanum Gothic; font-size: 110%;}
    .book-detail { vertical-align: top; text-align: center; padding: 5px; font-family:Nanum Gothic; font-size: 120%; color: blue;}
    .check-icon { animation-name: HeartAni; animation-duration:0.3s; animation-iteration-count:1;padding:15px; position: absolute; bottom: 0px; right:0px; height:40px; width:40px;}
    @keyframes HeartAni{0%, 100%{width:40px; height:40px;} 50%{width:60px; height:60px;}}
  </style>
</head>
  <body>
    <div class="info-box">
      <img class="book-img" src="example.jpg" alt="버번 위스키의 모든 것">
      <div>
        <img src="img/heart_1.png" class="check-icon", alt="Heart">
        <span class="book-title"> 버번 위스키의 모든 것 버번 위스키의 모든 것 버번 위스키의 모든 것 </span><br>
        <span class="book-author"> 조승원 / 파주: 싱긋, 2020 </span><br><br>
        <span class="material-icons">room</span>
        <span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span><br>
        <span class="book-detail"> [ 상세 정보 ] </span>
      </div>
    </div>
    <div class="info-box">
      <img class="book-img" src="example.jpg" alt="버번 위스키의 모든 것">
      <div>
        <img src="img/heart_1.png" class="check-icon", alt="Heart">
        <span class="book-title"> 버번 위스키의 모든 것 </span><br>
        <span class="book-author"> 조승원 / 파주: 싱긋, 2020 </span><br><br>
        <span class="material-icons">room</span>
        <span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span><br>
        <span class="book-detail"> [ 상세 정보 ] </span>
      </div>
    </div>
  </body>
</html>
