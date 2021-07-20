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
    var count=1;
    function setColor(btn){
      var property = document.getElementById(btn);
      if (count == 0){
          property.style.backgroundColor = "#fff"
          property.style.Color = "#e60000"
          /*property.style.border = "1px solid #fff"*/
          count=1;
      }
      else{
          property.style.backgroundColor = "#e60000"
          property.style.Color = "#fff"
          /*property.style.border = "1px solid #e60000"*/
          count=0;
      }
    }
  </script>
  <style>
    #grid {
      margin-top: 50px;
      margin-left: 50px;
      border: 1px solid gray;
      width: 550px;
      display: grid;
      grid-template-columns: 150px 1fr;
    }
    .subject{
      /*border: 1px solid gray;*/
      padding-left: 30px;
      margin-bottom: 10px;
      width: 300px;
      /* display: inline; */
    }
    .info{
      padding-left: 30px;
      margin-top: 0px;
    }
    .info>input{
      background-color: #fff;

    }
  </style>
</head>
  <body>
    <div id="grid">
      <span>
<<<<<<< HEAD
        <img src="example.jpg" style="border:1px solid gray;margin:10px;padding:10px;" width="80%">
=======
        <img src="book_info2_examp.jpg" style="border:1px solid gray;margin:10px;padding:10px;" width="80%">
>>>>>>> 1f6e4f707c78e593025f1f6ac45257ad1d246af9
      </span>
      <span>
        <h1 class="subject">리버싱 핵심원리</h1>
        <div class="info">
          이승원
          <p style="font-size: 12px; margin:5px;">서울:인사이트,2012</p>
          <strong>중앙도서관 </strong>[005.8 이581ㄹ]
          <a style="color:red;" href=""><strong>  대출가능</strong></a> <input type="button" id="button" value="찜" style="margin-left: 20px;" onclick="setColor('button')">
        </div>
      </span>
    </div>
  </body>
</html>
