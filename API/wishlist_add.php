<?php
  $result=array('success'=>false,'error'=>NULL);
  $cur_list = json_decode($_COOKIE['book_wishlist'],true);//[{},{},...,{}]
  if($cur_list!=NULL&&count($cur_list)>=20){
    $result['error']="20개까지만 찜할 수 있습니다.";
    echo json_encode($result);
    die();
  }
  $new_list = json_decode($_POST['book'],true);//{}
  if($cur_list==NULL){
    $cur_list=array($new_list);
  }
  else{
    array_push($cur_list,$new_list);
  }

  setcookie("book_wishlist",json_encode($cur_list));
  $result['success']=true;
  echo json_encode($result);
 ?>
