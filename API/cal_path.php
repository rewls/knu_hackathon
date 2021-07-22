<?php
{
  $con=mysqli_connect("db.bulgogi.gabia.io","bulgogi","bulgogi4321","dbbulgogi");}
if(mysqli_connect_errno()){
  die('{"error":"'. mysqli_connect_error().'"}');
}
$conn=mysqli_query($con,"USE dbbulgogi");

//
//섹션데이터만들기 시작
function find_shelf_group($f,$s){
  global $conn;
  global $con;
  if($f==2&&($s=="221-1"||$s=="221-2")) return array("section"=>"2-4","shelf_group"=>"2P");
  if($s=="베스트셀러") return array("section"=>"1-2","shelf_group"=>NULL);
  if($s=="북갤러리") return array("section"=>"1-1","shelf_group"=>NULL);
  $sql="SELECT a.shelf_group,floor,section FROM dbbulgogi.shelf_group as a join dbbulgogi.section as b on a.shelf_group=b.shelf_group where floor=".$f." and start<=".$s." and end>=".$s.";";
  $conn=mysqli_query($con,$sql);
  if(mysqli_error($con)!="") die('{"error":"'.mysqli_error($con).'"}');
  $result=mysqli_fetch_array($conn);
  return array("section"=>$result['section'],"shelf_group"=>$result['shelf_group']);
}

//$data = json_decode($_REQUEST['shelf_list'],true);
$json_data='[{"floor":1,"shelf":"베스트셀러"},{"floor":2,"shelf": "5"}, {"floor":2,"shelf":"51"}, {"floor":2,"shelf":"104"}, {"floor":2,"shelf":"145"}, {"floor":2,"shelf":"147"}]';
$data=json_decode($json_data,true);

$section_data=array();
for($i=0;$i<count($data);$i++){
  $section_temp=find_shelf_group($data[$i]['floor'],$data[$i]['shelf']);
  $exist_section=0;
  $exist_group=0;
  $exist_shelf=0;
  for($j=0;$j<count($section_data);$j++){
    if($section_data[$j]['section']==$section_temp['section']){
      $exist_section=1;
      for($k=0;$k<count($section_data[$j]['shelf_group']);$k++){
        if($section_data[$j]['shelf_group'][$k]['group']==$section_temp['shelf_group']){
          $exist_group=1;
          for($l=0;$l<count($section_data[$j]['shelf_group'][$k]['shelf']);$l++){
            if($section_data[$j]['shelf_group'][$k]['shelf'][$l]==$data[$i]['shelf']){
              $exist_shelf=1;
              break;
            }
          }
          if(!$exist_shelf){
            array_push($section_data[$j]['shelf_group'][$k]['shelf'],$data[$i]['shelf']);
          }
          break;
        }
      }
      if(!$exist_group){
        array_push($section_data[$j]['shelf_group'],array("group"=>$section_temp['shelf_group'],"shelf"=>array($data[$i]['shelf'])));
      }
      break;
    }
  }
  if(!$exist_section){
      array_push($section_data,array("section"=>$section_temp['section'],"shelf_group"=>array(array("group"=>$section_temp['shelf_group'],"shelf"=>array($data[$i]['shelf'])))));
  }
}
//$section_data=[{"section": "2-1", "shelf_group": [{"group":"2A","shelf":["5"]},{"group":"2C","shelf":["51"]}]}, {"section":"2-2","shelf_group":[{"group":"2H","shelf":["104"]},{"group":"2L","shelf":["145","147"]}]}];

//섹션 데이터 만들기 끝
//
//토탈 루트 만들기 시작

$request_data=array();
for($i=0;$i<count($section_data);$i++){
  array_push($request_data,$section_data[$i]['section']);
}
$url = "https://bulgogi.gabia.io/API/total_section_route.php?data=".json_encode($request_data);
$ch = curl_init();                                 //curl 초기화
curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함

$total_route = json_decode(curl_exec($ch),true);
curl_close($ch);

echo json_encode($total_route);

//토탈 루트 만들기 끝
//
//디테일 루트 만들기 시작


$shelf_exist = json_decode('["2-1","2-2","2-3","2-4","3-1","3-2","3-3","4-1","4-2","4-3","4-4"]',true);
$detail_route = array();
$temp1 = '["2-A","door2-1",{"group":"2L","shelf":["145","147"]},{"group":"2H","shelf":["104"]},"2-2"]';
$temp2 = '["2-1",{"group":"2C","shelf":["51"]},{"group":"2A","shelf":["5"]},"door2-3","2-B"]';
$temp3 = 0;
for($i=0; $i<count($total_route); $i++){
  if(in_array($total_route[$i],$shelf_exist)){

    $request_data2=array("search_section"=>$total_route[$i],"start_section"=>$total_route[$i-1],"end_section"=>$total_route[$i+1],"shelf_group"=>array());
    for($j=0;$j<count($section_data);$j++){
      if($section_data[$j]['section']==$total_route[$i]){
        $request_data2['shelf_group']=$section_data[$j]["shelf_group"];
        break;
      }
    }

    echo "<br>".json_encode($request_data2);
    // $url = "https://bulgogi.gabia.io/API/detail_path.php?data=".json_encode($request_data2);
    // $ch = curl_init();                                 //curl 초기화
    // curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
    // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
    //
    // $temp = json_decode(curl_exec($ch),true);
    // curl_close($ch);
    $temp = $temp3==0? json_decode($temp1,true) : json_decode($temp2,true);
    $temp3++;
    for($j=1;$j<count($temp)-1;$j++){
      array_push($detail_route,$temp[$j]);
    }

  }else{
    array_push($detail_route,$total_route[$i]);
  }
}
echo "<br><br>";
echo json_encode($detail_route);


//디테일 루트 만들기 끝
//
//이미지 만들기






?>
