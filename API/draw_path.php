<?php
header("Content-type: image/png");
function imagelinethick($image, $x1, $y1, $x2, $y2, $color, $thick = 1){
    /* this way it works well only for orthogonal lines
    imagesetthickness($image, $thick);
    return imageline($image, $x1, $y1, $x2, $y2, $color);
    */
    if ($thick == 1) {
        return imageline($image, $x1, $y1, $x2, $y2, $color);
    }
    $t = $thick / 2 - 0.5;
    if ($x1 == $x2 || $y1 == $y2) {
        return imagefilledrectangle($image, round(min($x1, $x2) - $t), round(min($y1, $y2) - $t), round(max($x1, $x2) + $t), round(max($y1, $y2) + $t), $color);
    }
    $k = ($y2 - $y1) / ($x2 - $x1); //y = kx + q
    $a = $t / sqrt(1 + pow($k, 2));
    $points = array(
        round($x1 - (1+$k)*$a), round($y1 + (1-$k)*$a),
        round($x1 - (1-$k)*$a), round($y1 - (1+$k)*$a),
        round($x2 + (1+$k)*$a), round($y2 - (1-$k)*$a),
        round($x2 + (1-$k)*$a), round($y2 + (1+$k)*$a),
    );
    imagefilledpolygon($image, $points, 4, $color);
    return imagepolygon($image, $points, 4, $color);
}


$dst_img = ImageCreatetruecolor(4000, 2250);
imagealphablending($dst_img, true );
imagesavealpha($dst_img, true );
$white=ImageColorAllocate($dst_img,250,250,250);      //색상지정
ImageColorTransparent($dst_img,$white);
$white2=ImageColorAllocate($dst_img,255,255,255);
imagefill($dst_img,0,0,$white2);

$data=json_decode($_GET['data'],true);

$floor = array("1F_1.2","2F_1.9","3F_1.7","4F_1.1");
$floor_img = imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/img/map_make/map_shelf/".$floor[(int)$data['floor']-1].".png");
imagecopy($dst_img,$floor_img,0,0,0,0,4000,2250);
$knuColor = imagecolorallocate($dst_img, 230, 0, 0);
$blue = imagecolorallocate($dst_img, 0, 144, 255);

for($i=0;$i<count($data['path'])-1;$i++){
  $x1=$data['path'][$i]['x'];
  $y1=$data['path'][$i]['y'];
  $x2=$data['path'][$i+1]['x'];
  $y2=$data['path'][$i+1]['y'];
imagefilledellipse($dst_img, $x1,$y1 , 20, 20, $knuColor);
imagefilledellipse($dst_img, $x2, $y2, 20, 20, $knuColor);
imagelinethick($dst_img,$x1,$y1,$x2,$y2,$knuColor,10);
}
imagepng($dst_img);
imagedestroy($dst_img);
?>
