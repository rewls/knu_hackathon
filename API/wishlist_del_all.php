<?php
  $result=array('success'=>false,'error'=>NULL);
  setcookie("book_wishlist", "", time() - 3600);
  $result['success']=true;
  echo json_encode($result);
 ?>
