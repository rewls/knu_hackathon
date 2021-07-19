<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta property="og:image" content="http://bolgogi.gabia.io/icon.png">
    <meta name="viewport" content="width=device-width">
    <title>경북대 도서관</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="/jquery-3.2.0.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#ccc").click(function(){
          console.log("a");
          $("#aff").css({background:"#ff0000"})
        });

      });
    </script>
    <style>
      html,body{
        width:100%;
        height:100%;
        margin:0;
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

  </body>
</html>
