<?php
  $result=array('success'=>false,'error'=>NULL);
  for($i=0;$i<20;$i++){
    setcookie("book_wishlist".$i, "", time() - 3600);
  }
  $result['success']=true;
  echo json_encode($result);
 ?>
