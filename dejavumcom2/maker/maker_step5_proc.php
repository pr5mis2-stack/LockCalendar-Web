<?php
set_time_limit(0);
/**
 *  maker_step2_proc.php
 *  @Desc      : 상품등록 처리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/include/common_header.php");

import("class.controller.MainCon");
import("class.controller.AppreciationCon");
import("class.controller.ImageCon");
import("php.util.ConvertImage");
import("php.util.ResizeImage");
import("php.util.JSON");

$MainCon 			= new MainCon();
$ImageCon			= new ImageCon();
$ConvertImage 		= new ConvertImage();
$AppreciationCon	= new AppreciationCon();
$JSON 			= new Services_JSON();

/**
 *
 * @var pageing setting
 */
$thisPage = "/manager/maker_step5_proc.php";

/**
 *
 * @var parameter setting
 */
$_s				= $StringClass->getRequest('s');
$main_id		= $StringClass->getRequest('main_id');
if (!empty($main_id) && !ctype_digit((string)$main_id)) { $main_id = ''; } // 보안: main_id는 숫자만 허용 (경로/쿼리 조작 방지)
$memo			= $StringClass->getRequest('memo');

$param = array();
$arrXml = array(
		"header"=>array("result_code"=>"100", "result_msg"=>"FAIL")
		, "body"=>array()
);

if (!empty($main_id))	{
	
	if (count($_FILES["user_file"]["name"]) > 0)
	{
		$parm = array();
		$param['upload_dir'] = "THUMBNAIL";
		$param['first_dir'] = substr($main_id, 0, 3) . "/";
		$param['middle_dir'] = $main_id . "/";
		
		$param_filename = array();
		$param_filename = $ImageCon->uploadFiles($param);
	}

	// 이미지 비율에 맞게 큰부분을 1280 사이즈로 조정
	if(!empty($param_filename))
	{
		foreach($param_filename as $key=>$val)
		{
			$save_dir = $conf_img_thumbnail_dir.$param['first_dir'].$param['middle_dir'].$val;
			$save_url = $conf_mimg_thumbnail_url.$param['first_dir'].$param['middle_dir'].$val;

			dejavu_fix_exif_orientation($save_dir); // EXIF 회전 보정 (리사이즈 전 적용)
			$Image = new Image($save_dir);
			$Image->ratioresize(1024, 1024);
			$Image->save();
		}
	}
		
	$param['main_id'] 	= $main_id;
	$result = $AppreciationCon->getAppreciationCnt($param);

	$param['memo']		= $memo;

	if ($save_url)
		$param['app_photo_url'] = $save_url;
	
	if ($result)
		$result2 = $AppreciationCon->setAppreciation($param);
	else
		$result2 = $AppreciationCon->addAppreciation($param);

	if ($result2)
	{
		$param = array();
		$param['main_id'] = $main_id;
		$param['end_flag'] = "1";
		$result = $MainCon->setMain($param);

		echo "<script>try{document.domain = 'dejavu-m.com';}catch(e){};</script>";
		
		if ($_s == "E")
			echo"<script>try{document.domain = 'dejavu-m.com';}catch(e){}; parent.gotoDone({$main_id});</script>";		
		else if ($_s == "M")
			echo "<script>parent.fileReset();parent.modalPreViewerPop();</script>";
		else
			$StringClass->alertMsg('저장되었습니다.','parent', 'main.php?step=5', '');
	}
	else
		$StringClass->alertMsg('저장중 오류가 발생하였습니다.','', '', 'NONE');		
}
else
	$StringClass->alertMsg('초대장 정보가 없습니다.','', '', 'NONE');
?>