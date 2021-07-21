<?php
  $result=array('success'=>false,'error'=>NULL);
  $cur_list = json_decode($_COOKIE['book_wishlist'],true);//[{},{},...,{}]

  $notexist=1;
  for($i=0;$i<count($cur_list);$i++){
    if($cur_list[$i]['id']==$_POST['id']){
      array_splice($cur_list,$i,1);
      $notexist=0;
      break;
    }
  }
  if($notexist){
    $result['error']="해당 id가 없습니다";
    echo json_encode($result);
    die();
  }

  setcookie("book_wishlist",json_encode($cur_list));
  $result['success']=true;
  echo json_encode($result);
 ?>
