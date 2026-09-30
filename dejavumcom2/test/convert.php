<?php
require_once ($_SERVER["DOCUMENT_ROOT"]."/include/common_header.php");

import("php.util.ConvertImage");

$ConvertImage = new ConvertImage();
//new dBug($_SERVER);
//exit;
$main_id = "1";
$param = array();
$param['file_name'] = "1";
//$param['label'] = iconv("euc-kr", "utf-8", "이정수");
$param['label'] = iconv("utf-8", "euc-kr", "이정수");
//$param['trim'] = "Y";
$param['background'] = "white";	// 배경색
$param['fill'] = "#f3f3f3";	// 글자색
$param['font'] = $_SERVER["DOCUMENT_ROOT"]."/convert/fonts/NanumGothic.ttf";
//$param['font'] = 'Malgun-Gothic';
$param['pointsize'] = "30";
$param['strokewidth'] = 1;	// 글자테두리 간격
$param['stroke'] = "blue";	// 테두리색
//$param['undercolor'] = "lightblue";	// 글자배경색
//$param['crop'] = "10x10";
$param['size'] = "600x30";
//$param['gravity'] = "center";	// 정렬(center:중앙정렬)
//$param['interword-spacing'] = 10;	// 단어간 간격
//$param['kerning'] = 10;	// 자간간격
$param['compose'] = "";	// 이미지 합칠때 텍스트 이미지의 배경 (Multiply: 배경색없이 생성) default 값으로
//$param['markup'] = "<span foreground=\"blue\" size=\"x-large\">Blue text</span> is <i>cool</i>!";	// pango format (참조 : http://developer.gnome.org/pango/stable/PangoMarkupFormat.html)

//new dBug($param);
$ConvertImage->convertTextExec($main_id, $param);

$param['file_name'] = "2";
$param['label'] = "test2";
$param['pointsize'] = "20";
$param['strokewidth'] = "";	// 글자테두리 간격
$param['stroke'] = "";	// 테두리색
$param['size'] = "600x30";

$ConvertImage->convertTextExec($main_id, $param);

$param1 = array();
$param1['label_file_name'] = "1";
$param1['bg_file_name'] = "2";
$param1['result_file_name'] = "3";
$param1['geometry'] = "+50+0";

$ConvertImage->compositExec($main_id, $param1);

$img_src = $conf_img_thumbnail_dir . $main_id ."/3.png";
$img_url = $conf_img_thumbnail_url . $main_id ."/3.png";

if (is_file($img_src))
	echo"<img src='".$img_url."' />";

//http://bomtvbaby.smartbom.co.kr/smartbom/text2image.php?font=fonts/yoon_360.ttf&size=100&red=38&grn=38&blu=38&text=%EC%8B%A0%EB%8F%99%EA%B7%BC%EC%9D%98%20%C2%A0

?>
