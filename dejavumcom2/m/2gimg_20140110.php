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

$Photo2GCon        	= new Photo2GCon();

$main_id		= $_POST["main_id"];
$sample_id		= $_POST["sample_id"];
//$img2g			= $StringClass->getRequest('img2g');
$img2g = $_POST["img2g"];

$img_dir = $conf_img_thumbnail_dir . $main_id ."/2gimg.png";
$img_url = $conf_mimg_thumbnail_url . $main_id ."/2gimg.png";

//if (!file_exists($img_dir))
//{
$img2g = str_replace("data:image/png;base64,", "", $img2g);

$data = base64_decode($img2g);

if (empty($data))
	$StringClass->alertMsg("이미지 데이터가 없습니다.", "", "", "");
	
if (!($f = @fopen($img_dir, 'wb')))
	$StringClass->alertMsg("이미지 생성에 오류가 발생했습니다.(1)", "", "", "");
		 
fwrite($f, $data);
fclose($f);
		
//file_put_contents($img_dir, $data, LOCK_EX);
	
if (!file_exists($img_dir))
	$StringClass->alertMsg("이미지 생성에 오류가 발생했습니다.(2)", "", "", "");
@chmod($img2g, FILE_PUT_CONTENTS_ATOMIC_MODE);
//}

if (file_exists($img_dir))
{
	$param = array();
	$param['main_id'] 	= $main_id;
	$param['photo_url']	= $img_url;
	$Photo2GCon->setPhoto2G($param);
}

$StringClass->alertMsg('', '', $img_url."?d=".date("his"), '');
?>