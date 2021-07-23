<?php
$data=json_decode($_REQUEST['data'],true);
$result_data=array();
//echo var_dump($data);
array_push($result_data,$data['start_section']);
for($i=0;$i<count($data['shelf_group']);$i++){
  //echo "<br>".var_dump($data['shelf_group']);
  array_push($result_data,$data['shelf_group'][$i]);
}
array_push($result_data,$data['end_section']);
echo json_encode($result_data);
?>
