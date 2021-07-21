<?php
$title=str_replace(" ","%20",$_POST["name"]);
$url = "https://pyxis.knu.ac.kr/pyxis-api/1/collections/1/search?".$_POST['type']."=k%7Ca%7C".$title."&max=".$_POST["max"]."&offset=".$_POST["offset"];
$ch = curl_init();                                 //curl 초기화
curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함

$response = json_decode(curl_exec($ch),true);
curl_close($ch);

$result = array('success'=>$response['success'],
'isFuzzy'=>$response['data']['isFuzzy'],
'totalCount'=>$response['data']['totalCount'],
'list'=>array()
);

$count= $result['totalCount'];
$max=(int)$_POST["max"];
$offset=(int)$_POST["offset"];
$count = ($count - $offset) > $max ? $max : ($count - $offset) % $max;

for($i=0;$i<$count;$i++){
  array_push($result['list'],array(
    'id'=>$response['data']['list'][$i]['id'],
    'imgUrl'=>$response['data']['list'][$i]['thumbnailUrl'],
    'title'=>$response['data']['list'][$i]['titleStatement'],
    'author'=>$response['data']['list'][$i]['author'],
    'publication'=>$response['data']['list'][$i]['publication'],
    'code'=>$response['data']['list'][$i]['branchVolumes'][0]['volume'],
    'location'=>$response['data']['list'][$i]['branchVolumes'][0]['name'],
    'state'=>$response['data']['list'][$i]['branchVolumes'][0]['cState']));
}

echo json_encode($result);
?>
