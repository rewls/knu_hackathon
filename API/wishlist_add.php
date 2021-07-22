<?php
  $result=array('success'=>false,'error'=>NULL,'count'=>0);
  $cur_list=array();
  for($i=0;$i<20;$i++){
    $temp=json_decode($_COOKIE['book_wishlist'.$i],true);
    if($temp==NULL) continue;
    array_push($cur_list,json_decode($_COOKIE['book_wishlist'.$i],true));
    $result['count']++;
  }
  if(count($cur_list)>=20){
    $result['error']="20개까지만 찜할 수 있습니다.";
    echo json_encode($result);
    die();
  }
  $new_list = json_decode($_POST['book'],true);//{}
  array_push($cur_list,$new_list);
  $result['count']++;

  for($i=0;$i<count($cur_list);$i++){
    setcookie("book_wishlist".$i,json_encode($cur_list[$i]));
  }
  $result['success']=true;
  echo json_encode($result);
 ?>
