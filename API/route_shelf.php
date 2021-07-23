<?php
$request_data = json_decode($_REQUEST['data'],true);
//request_data = {'search_section':"2-2", 'start_section':"2-1", 'end_section':"2-3", 'shelf_group': [{"group":"2A","shelf":["85"]},{"group":"2C","shelf":["156","172"]}]}
$search_section = $request_data['search_section'];
$start_section = $request_data['start_section'];
$end_section = $request_data['end_section'];
$shelf_group = $request_data['shelf_group'];
//echo $search_section, $start_section, $end_section, $shelf_group;
//echo (array_diff(array(2,1),array(1,2)) == array());

$sections = array('2-1', '2-2', '2-3', '2-4', '2-A', '2-B', '2-C');
$sections_dir = array('2-A', '2-1', '2-2', '2-B', '2-3', '2-C', '2-4');
$comb_sections = array(array('1','2'), array('2','3'), array('3','4'), array('A','B'), array('1','A'), array('1','B'), array('2','A'), array('2','B'), array('3','B'), array('3','A'), array('4','A'), array('4','B'), array('2','C'), array('3','C'), array('4','C'), array('1','3'), array('1','4'), array('2','4'), array('B','C'), array('A','C'), array('1','C'));
$cur_section = $start_section;
$start2search = array(substr($start_section,2,1), substr($search_section,2,1));
$search2end = array(substr($search_section,2,1), substr($end_section,2,1));
$route = array($start_section, $search_section, $end_section);
$shelf_groups = array(array('2E', '2F', '2G', '2H', '2I', '2J', '2K', '2L', '2M'), array('2A', '2B', '2C', '2D', '2N'), array('2T', '2U', '2O'), array('2P', '2Q', '2R', '2S'));
$shelf_groups_dir = array(array('2L', '2M', '2K', '2J', '2I', '2F', '2H', '2G', '2E'), array('2D', '2C', '2B', '2A', '2N'), array('2O', '2U', '2T'), array('2R', '2S', '2Q', '2P'));
$door_case = array(2, 3, 4, 5, 6, 7, array(2, 5), array(3, 5), array(4, 6), array(5, 7), array(2, 5, 7));
$pass_doors = array();
$shelf = array();
$shelf_num = array();
$result_api2_2 = array();

function clockwize(){
    global $section_dir;
    global $route;
    global $section_dir;
    global $sections_dir;
    $section_dir = array();
    if ($route[0] == $route[2])
        $section_dir = $route;
    else{
        for($i=0;$i<count($sections_dir);$i++){
            for($j=0;$j<count($route);$j++){
                if ($route[$j] == $sections_dir[$i])
                    array_push($section_dir, $sections_dir[$i]);
            }
        }
    }
    return $section_dir;
}
function fix_order(){
    global $cur_section;
    global $route;
    global $temp;
    global $shelf_groups_dir;
    global $shelf;
    global $shelf_num;
    global $shelf_group;
    global $result_api2_2;
    if (in_array($cur_section, array('2-1','2-2','2-3','2-4'))){
        if ($route == clockwize()){
            $temp = $shelf_groups_dir[intval($cur_section[strlen($cur_section)-1])-1];
            for($j=0; $j<count($temp); $j++){
                for($i=0; $i<count($shelf); $i++){
                    $temp2 = array();
                    if (in_array($shelf[$i], $temp) && ($shelf[$i] == $temp[$j])){
                        $temp2['group'] = $shelf[$i];
                        $temp2['shelf'] = $shelf_num[$shelf[$i]];
                        array_push($shelf_group, $temp2);
                    }
                }
            }
        }
        else{
            $temp = $shelf_groups_dir[intvar($cur_section[strlen($cur_section)-1])-1];
            for($j=count($temp)-1;$j>-1;$j--){
                for($i=0;$i<count($shelf);$i++){
                    $temp2 = array();
                    if (in_array($shelf[$i], $temp) && ($shelf[$i] == $temp[$j])){
                        $temp2['group'] = $shelf[$i];
                        $temp2['shelf'] = $shelf_num[$shelf[$i]];
                        array_push($shelf_group, $temp2);
                    }
                }
            }
        }
        for($i=0;$i<count($shelf_group);$i++){
            array_push($result_api2_2, $shelf_group[$i]);
        }
    }
}

function result($route_portion){
    //console.log(var_dump($route_portion));
    //console.log(count($comb_sections));
    //echo var_dump($comb_sections);
    global $comb_sections;
    global $pass_doors;
    global $result_api2_2;

    $pass_doors = array();
    for($i=0;$i<21;$i++){
        if (array_diff($route_portion, $comb_sections[$i]) == array()){
            if (0 <= $i && $i < 4) $pass_doors = array();
            elseif (4 <= $i && $i < 6) $pass_doors = array(2);
            elseif (6 <= $i && $i < 8) $pass_doors = array(3);
            elseif (8 <= $i && $i < 9) $pass_doors = array(4);
            elseif (9 <= $i && $i < 12) $pass_doors = array(5);
            elseif (12 <= $i && $i < 14) $pass_doors = array(6);
            elseif (14 <= $i && $i < 15) $pass_doors = array(7);
            elseif (15 <= $i && $i < 17) $pass_doors = array(2,5);
            elseif (17 <= $i && $i < 18) $pass_doors = array(3,5);
            elseif (18 <= $i && $i < 19) $pass_doors = array(4,6);
            elseif (19 <= $i && $i < 20) $pass_doors = array(5,7);
            elseif (20 <= $i && $i < 21) $pass_doors = array(2,5,7);
            //echo var_dump($pass_doors);
        }
    }
    for ($i=0; $i<count($pass_doors); $i++){
        $pass_doors[$i] = "door2-".strval($pass_doors[$i]);
    }
    fix_order();
    for($i=0; $i<count($pass_doors); $i++){
        array_push($result_api2_2,$pass_doors[$i]);
    }
}
for($i=0; $i<count($shelf_group); $i++){
    array_push($shelf, $shelf_group[$i]['group']);
    $shelf_num[$shelf[$i]] = $shelf_group[$i]['shelf'];
}

$shelf_group = array();

array_push($result_api2_2, $start_section);

result($start2search);
$cur_section = $search_section;

result($search2end);
$cur_section = $end_section;

array_push($result_api2_2, $end_section);

//console.log(var_dump($result_api2_2));

echo json_encode($result_api2_2);

?>
