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

// echo json_encode($total_route);

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

    // echo "<br>".json_encode($request_data2);

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
// echo "<br><br>";
// echo json_encode($detail_route);


//디테일 루트 만들기 끝
//
//이미지 만들기

function find_xy($f,$s){
  global $conn;
  global $con;
  if($f==2&&$s=="221-1") return array("x"=>2075,"y"=>800);
  if($f==2&&$s=="221-2") return array("x"=>2115,"y"=>800);
  if($s=="베스트셀러") return array("x"=>"1-2","y"=>NULL);
  if($s=="북갤러리") return array("x"=>"1-1","y"=>NULL);
  $sql="SELECT x,y FROM dbbulgogi.xy where floor=".$f." and shelf=".$s;
  $conn=mysqli_query($con,$sql);
  if(mysqli_error($con)!="") die('{"error":"'.mysqli_error($con).'"}');
  $result=mysqli_fetch_array($conn);
  return array("x"=>$result['x'],"y"=>$result['y']);
}

//층별로 자르기
$floor_data = array();
$floor_temp = array();
$change_section = array("1-3","1-A","1-B","1-C","2-A","2-B","2-C","2-A","2-B","2-C","3-A","3-B","3-C");
$floor_start = 1;
for($i=0;$i<count($detail_route);$i++){
  if(is_array($detail_route[$i])){
    for($j=0;$j<count($detail_route[$i]['shelf']);$j++){
      $path_temp=find_xy(substr($detail_route[$i]['group'],0,1),$detail_route[$i]['shelf'][$j]);
      array_push($floor_temp,$path_temp);
    }
  }else{
    if(substr($detail_route[$i],0,2)=="do") {
      $find_f = 2;
      $find_s = "-".substr($detail_route[$i],6,1);
    }else{
      switch (substr($detail_route[$i],0,1)) {
        case 'D':
          $find_f = 1;
          $find_s = "-".substr($detail_route[$i],2,1);
          break;
        case "1":
          $find_f = 1;
          $find_s = substr($detail_route[$i],2,1);
          break;
        default:
          $find_f=2;
          $find_s = substr($detail_route[$i],2,1);
          break;
      }
      if($find_s=="A"||$find_s=="B"||$find_s=="c"){
        $find_f=2;
        $temp_arr=array("A"=>'-11',"B"=>'-12',"C"=>'-13');
        $find_s=$temp_arr[$find_s];
      }
    }
    $path_temp=find_xy($find_f,$find_s);
    array_push($floor_temp,$path_temp);
  }
  if(in_array($detail_route[$i],$change_section)){
    if($floor_start){
      array_push($floor_data,array('floor'=>substr($detail_route[$i],0,1),'path'=>$floor_temp));
      $floor_temp = array();
      $floor_start=0;
    }
    else{
      $floor_start=1;
    }
  }
}

// echo "<br><br>";
// echo json_encode($floor_data);

// echo "<br><br>";
// echo json_encode($floor_data);

$result_data=array("path"=>$detail_route,"coordinate"=>$floor_data);
echo json_encode($result_data);
?>
