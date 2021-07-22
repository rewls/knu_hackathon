<?php
  $result=array('success'=>false,'error'=>NULL,'count'=>0,'list'=>array());
  $cur_list=array();
  for($i=0;$i<20;$i++){
    $temp=json_decode($_COOKIE['book_wishlist'.$i],true);
    if($temp==NULL) continue;
    array_push($cur_list,json_decode($_COOKIE['book_wishlist'.$i],true));
    $result['count']++;
  }
  $result['list']=$cur_list;
  $result['success']=true;
  echo json_encode($result);
 ?>
