<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <?php
    include $_SERVER['DOCUMENT_ROOT'].'/API/broswertest.php';
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
      $("#btn").click(function(){
        $.ajax({
          url:'/API/detail_path.php',
          type:'POST',
          data:{name:["박지원","김다진","심준성","김유준"]},
          success:function(data){
            console.log(data);
          }
        });
      });
    });
  </script>
  <style>
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
      <span id="btn">테스트</span>
    </div><!-- end of main_container -->
  </body>
</html>
