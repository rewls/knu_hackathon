<?php
  $cur_list = json_decode($_COOKIE['wishlist'],true);//[{},{},...,{}]
  $new_list = json_decode($_POST['book'],true);//{}
  if($cur_list=NULL){
    $cur_list=array($new_list);
  }
  else{
    array_push($cur_list,$new_list);
  }

  setcookie("wishlist",$cur_list);
  echo var_dump(json_decode($_COOKIE['wishlist'],true));
 ?>
