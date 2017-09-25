<?php
/*
2015-10-27
by:lishihao
img cai jian
*/
function xx_img($path,$img_name,$x,$y,$w,$h,$fina_w='',$fina_h=''){
	$img = imagecreatefromstring(file_get_contents($path.$img_name));
		if($fina_w==''){$fina_w = $w;}
		if($fina_h==''){$fina_h = $h;}
		$new_img = imagecreatetruecolor($fina_w,$fina_h);
	imagecopyresampled($new_img,$img,0,0,$x,$y,$w,$h,$fina_w,$fina_h);
	unlink($path.$img_name);
	imagepng($new_img,$path.$img_name);
	return true;
}
?>