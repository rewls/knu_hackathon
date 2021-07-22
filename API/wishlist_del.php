<?php
$result=array('success'=>false,'error'=>NULL,'count'=>0);
$cur_list=array();
for($i=0;$i<20;$i++){
  $temp=json_decode($_COOKIE['book_wishlist'.$i],true);
  if($temp==NULL) continue;
  array_push($cur_list,json_decode($_COOKIE['book_wishlist'.$i],true));
  $result['count']++;
}

  $notexist=1;
  for($i=0;$i<count($cur_list);$i++){
    if($cur_list[$i]['id']==$_POST['id']){
      array_splice($cur_list,$i,1);
      $notexist=0;
      $result['count']--;
      break;
    }
  }
  if($notexist){
    $result['error']="해당 id가 없습니다";
    echo json_encode($result);
    die();
  }

  for($i=0;$i<count($cur_list);$i++){
    setcookie("book_wishlist".$i,json_encode($cur_list[$i]));
  }
  setcookie("book_wishlist".count($cur_list),"", time() - 3600);
  $result['success']=true;
  echo json_encode($result);
 ?>
