<?php
  $result=array('success'=>false,'error'=>NULL,'list'=>array());
  $cur_list = json_decode($_COOKIE['book_wishlist'],true);//[{},{},...,{}]
  if($cur_list==NULL) $cur_list=array();
  $result['list']=$cur_list;
  $result['success']=true;
  echo json_encode($result);
 ?>
