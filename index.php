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
        $("#ccc").click(function(){
          console.log("a");
          $("#aff").css({background:"#ff0000"})
        });

      });
    </script>
    <style>
      #ccc{
        background: blue;
        color:#ffffff;
      }
      @media (max-width:1320px){

      }
      @media (max-width:1100px){

      }
      @media (max-width:700px){

      }
    </style>
  </head>
<?php
function table($x,$y){
  $count=1;
  for($i=0;$i<$x;$i++){
    echo '<div>';
    for($j=0;$j<$y;$j++){
      echo "<span>".$count." </span>";
      $count++;
    }
    echo '</div>';
  }
}
 ?>
  <body>
    <?php
      table(3,4);
     ?>

    <div style="border:1px solid #000">
      <span style="border:1px solid #000; font-size:large">
        asdf
      </span>
      <span>
         asdf
      </span>
    </div>
    <div class="">
      <span>
        asdf
      </span>
      <span>
         asdf
      </span>
    </div>
    <div class="">
      <span id="ccc">
        asdf
      </span>
      <span id="aff">
         asdf
      </span>
    </div>

    <?php
      table(2,7);
     ?>
  </body>
</html>
