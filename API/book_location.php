<?php
$url = "https://pyxis.knu.ac.kr/pyxis-api/1/biblios/".$_REQUEST['id']."/items";
$ch = curl_init();                                 //curl 초기화
curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함

$response = json_decode(curl_exec($ch),true);
curl_close($ch);

$result = array('success'=>$response['success'],
'isJungDo'=>array_key_exists('1',$response['data']),
'list'=>array()
);

if(!$result['isJungDo']){
  die(json_encode($result));
}

for($i=0;$i<count($response['data']['1']);$i++){
  array_push($result['list'],array(
    'code'=>$response['data']['1'][$i]['callNo'],
    'location'=>$response['data']['1'][$i]['location']['name'],
    'state'=>$response['data']['1'][$i]['circulationState']['name'],
    'shelf'=>$response['data']['1'][$i]['shelf']['name'],));
}

echo json_encode($result);
?>
