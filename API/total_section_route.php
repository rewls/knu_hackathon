<?php
$Path_Score = array(array(6,5,4,6), array(5,5,4,5), array(4,4,6,5), array(6,5,5,6));
$Recommand_Path = array(array('A','A','A','A'), array('A','B','B','A'), array('A','B','C','C'), array('A','A','C','A'));
$Path_Score_1F = array(array(6,5,5,6), array(6,6,4,6));
$Recommand_Path_1F = array(array('A','A','C','A'), array('A','A','B','A'));
$Input_Place = array(array(0,0,0,0), array(0,0,0,0), array(0,0,0,0), array(0,0,0,0));
$Current_Score = array(array(0,0,0,0), array(0,0,0,0), array(0,0,0,0), array(0,0,0,0));
$Current_Floor = -1;
$Current_Section = -1;
$Best_Path = array(0, 0);
$Output_Route = array();
$Input_Original = $_REQUEST['data'];
$k = 0;
$l = 0;
foreach($Input_Original as $value){
   $Input_Place[(int)$value[0]-1][(int)$value[2]-1] = 1;
}
if ($Input_Place[0][0])
    array_push($Output_Route, 'D-2', '1-1');
else
    array_push($Output_Route, "D-1");
if ($Input_Place[0][1])
    array_push($Output_Route, "1-2");
$Current_Floor = 0;
$Current_Section = (!$Input_Place[0][0])?1:$Input_Place[0][1];

$Input_Place[0][0] = 0;
$Input_Place[0][1] = 0;
$Best_Path_Score = 0;
for($k=0;$k<4;$k++){
    for($l=0;$l<4;$l++){
        if(!$Input_Place[$k][$l])
            continue;
        $Current_Score[$k][$l] = $Path_Score_1F[$Current_Section][$l]-($k-$Current_Floor);
        if($Current_Score[$k][$l] > $Best_Path_Score){
                $Best_Path_Score = $Current_Score[$k][$l];
                $Best_Path[0] = $k;
                $Best_Path[1] = $l;
        }
    }
}
$Current_Score = array(array(0,0,0,0), array(0,0,0,0), array(0,0,0,0), array(0,0,0,0));
array_push($Output_Route, strval($Current_Floor[0]+1).'-'.$Recommand_Path_1F[$Current_Section][$Best_Path[1]]);
array_push($Output_Route, strval($Best_Path[0]+1).'-'.strval($Best_Path[1]+1));
$Input_Place[$Best_Path[0]][$Best_Path[1]] = 0;
$Current_Floor = $Best_Path[0];
$Current_Section = $Best_Path[1];
while(true){
    $Best_Path_Score = 0;
    for($k=0; $k<4; $k++){
        for($l=0; $l<4; $l++){
            if(!$Input_Place[$k][$l])
                continue;
            $Current_Score[$k][$l] = ($Current_Floor==$k)?10+abs($Current_Section-$l)%2:$Path_Score[$Current_Section][$l]-($k-$Current_Floor);
            if($Current_Score[$k][$l] > $Best_Path_Score){
                $Best_Path_Score = $Current_Score[$k][$l];
                $Best_Path[0] = $k;
                $Best_Path[1] = $l;
            }
        }
    }
    $Current_Score = array(array(0,0,0,0), array(0,0,0,0), array(0,0,0,0), array(0,0,0,0));
    if ($Best_Path[0] != $Current_Floor)
        array_push($Output_Route, strval($Current_Floor+1).'-'.$Recommand_Path[$Current_Section][$Best_Path[1]], strval($Best_Path[0]+1).'-'.$Recommand_Path[$Current_Section][$Best_Path[1]]);
    if ($Best_Path[0] == $Current_Floor && $Best_Path[1] == $Current_Section)
        break;
    array_push($Output_Route, strval($Best_Path[0]+1).'-'.strval($Best_Path[1]+1));
    $Input_Place[$Best_Path[0]][$Best_Path[1]] = 0;
    $Current_Floor = $Best_Path[0];
    $Current_Section = $Best_Path[1];
}
if ($Current_Floor != 0){
    array_push($Output_Route, strval($Current_Floor+1).'-'.$Recommand_Path[$Current_Section][2], strval(1).'-'.$Recommand_Path[$Current_Section][2]);
}
array_push($Output_Route, "1-3");
echo var_dump($Output_Route);
?>