<?php
//公用函数文件

function truncate($str)
{
	$len = mb_strlen($str,"utf-8");
	if($len > 15)
	{
		$str = mb_substr($str,0,15,"utf-8");
	}
	return $str;
}

function dateformat($t)
{
	$result = date("Y-m-d H:i:s",$t);
	return $result;
}


function showImg($url,$width='',$height=''){
    $ic=C("IMG_CONFIG");
    $width="width='$width'";
    $height="height='$height'";
    echo"<img $width $height src={$ic['viewPath']}$url>";
}

















