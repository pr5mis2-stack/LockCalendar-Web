<?php
/**
 *  search_proc.php
 *  @Desc      : 검색결과 처리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
set_time_limit(0);
require_once(dirname(__DIR__) . "/conf/DejavuConf.php");
require_once(dirname(__DIR__) . "/import.php");

import("class.controller.Photo2GCon");
import("class.controller.MainCon");

$Photo2GCon        	= new Photo2GCon();
$MainCon        	= new MainCon();

$main_id		= $_GET["main_id"];

if ($main_id == "")
    $StringClass->alertMsg("이미지 정보가 없습니다.", "", "", "");

/**
 * main info
 */
$param = array();
$param['main_id'] = $main_id;
$result = $MainCon->getMainList($param);
if ($result)
{
	$main_info = $result[0];
	$sample_id = $main_info['sample_id'];
}

/**
 * set making image info
 */
// The URL to get your HTML
$url = "http://m.dejavu-m.com/?m=".$main_id."\&p=m\&t=p\&f=n";

// Command to execute
//$command = "/home/bin/wkhtmltoimage-i386 --load-error-handling ignore";
$command = "/home/bin/wkhtmltoimage-i386 --load-error-handling ignore --disable-javascript --width 720 --height 1280 --quality 90";
if ($main_info['sample_id'] == "13")
	$command = "/home/bin/wkhtmltoimage-i386 --load-error-handling ignore --disable-javascript --width 720 --height 1180 --quality 90";
else if ($main_info['sample_id'] == "15")
	$command = "/home/bin/wkhtmltoimage-i386 --load-error-handling ignore --disable-javascript --width 720 --height 1050 --quality 90";

// Directory for the image to be saved
$img_dir = $conf_img_thumbnail_dir . substr($main_id, 0, 3) . "/" . $main_id ."/2gimg.jpg";
$img_url = $conf_mimg_thumbnail_url . substr($main_id, 0, 3) . "/" . $main_id ."/2gimg.jpg";

// 디렉토리 없으면 생성
if (!is_dir($conf_img_thumbnail_dir . substr($main_id, 0, 3)))
{
	mkdir($conf_img_thumbnail_dir . substr($main_id, 0, 3));
	@chmod($conf_img_thumbnail_dir . substr($main_id, 0, 3), FILE_PUT_CONTENTS_ATOMIC_MODE);
}

if (!is_dir($conf_img_thumbnail_dir . substr($main_id, 0, 3) . "/" . $main_id))
{
	mkdir($conf_img_thumbnail_dir . substr($main_id, 0, 3) . "/" . $main_id);
	@chmod($conf_img_thumbnail_dir . substr($main_id, 0, 3) . "/" . $main_id, FILE_PUT_CONTENTS_ATOMIC_MODE);
}

// Putting together the command for `shell_exec()`
$ex = "$command $url " . $img_dir;

// The full command is: "/usr/bin/wkhtmltoimage-i386 --load-error-handling ignore --width 1024 --height 500 --quality 100 --encoding "utf-8" --zoom 1.0 http://www.google.com/ /var/www/images/example.jpg"
// If we were to run this command via SSH, it would take a picture of google.com, and save it to /vaw/www/images/example.jpg

// Generate the image
// NOTE: Don't forget to `escapeshellarg()` any user input!
$output = shell_exec($ex);
/*
if ($main_id == 106531)
{
	echo $ex;
	echo $output;
	exit;
}
*/
if (file_exists($img_dir))
{
	@chmod($img_dir, FILE_PUT_CONTENTS_ATOMIC_MODE);
	
	$param = array();
	$param['main_id'] 	= $main_id;
	$param['photo_url']	= $img_url;
	$Photo2GCon->setPhoto2G($param);
}
else
	$StringClass->alertMsg("이미지 생성에 오류가 발생했습니다.(2)", "", "", "");

$StringClass->alertMsg('', '', $img_url."?d=".date("his"), '');
?>