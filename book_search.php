<?php
$url = "https://pyxis.knu.ac.kr/pyxis-api/1/collections/1/search?all=k%7Ca%7C".$_POST["name"];
$ch = curl_init();                                 //curl 초기화
curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함

$response = json_decode(curl_exec($ch),true);
curl_close($ch);

echo var_dump($response);
 ?>
