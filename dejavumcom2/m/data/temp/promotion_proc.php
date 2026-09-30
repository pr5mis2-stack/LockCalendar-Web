<?php
/**
 * promotion_proc.php
 * @Desc : 프로모션 처리
 * @Author : suya
 * @Date :
 * 
 * @param
 *        	@Return
 */
require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/common_header.php");

import("class.controller.MainCon");
import("class.controller.PromotionCon");
import ( "class.controller.ImageCon" );

$MainCon = new MainCon();
$PromotionCon = new PromotionCon();
$ImageCon = new ImageCon ();

/**
 *
 * @var pageing setting
 */
$thisPage = "/promotion/promotion_proc.php";

/**
 *
 * @var parameter setting
 */
$_a = $StringClass->getRequest('a');
$shop_id = $StringClass->getRequest('shop_id');
$upload_dir = $StringClass->getRequest('upload_dir');

$return = "99";

if ($_a == "insert") {
	$shop_id = $_POST['shop_id']; // PRODUCT

	if (!$shop_id)
	{
		$StringClass->alertMsg('업체정보가 없습니다.', '', '', 'NONE');
		exit();
	}

	// DB 저장정보
	$db_param = array ();
	$db_param['shop_id'] = $shop_id;
	$db_param['is_popup'] = $_POST['is_popup'];
	$db_param['img_width'] = $_POST['img_width'];
	$db_param['img_height'] = $_POST['img_height'];

	// 파일 존재할 경우 파일 업로드
	if (count($_FILES["user_file"]["name"]) > 0)
	{
		$parm = array ();
		$param ['upload_dir'] = $upload_dir;
		
		$param_filename = array ();
		$param_filename = $ImageCon->uploadFiles($param);

		if (count($param_filename) > 0 && count($_FILES["user_file"]["name"]) > 0) {
			$db_param['file_name'] = $_FILES["user_file"]["name"][0];
			$db_param['file_ext'] = $_FILES["user_file"]["type"][0];
			$db_param['file_url'] = $param_filename[0];
			$db_param['file_size'] = $_FILES["user_file"]["size"][0];
		}
	}
	else
	{
		$db_param['file_name'] = "";
		$db_param['file_ext'] = "";
		$db_param['file_url'] = "";
		$db_param['file_size'] = 0;
	}
	new dBug($_FILES);
	new dBug($param);
	new dBug($param_filename);
	new dBug($db_param);
	exit;
	$result = $PromotionCon->addPromotion($db_param);

	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	if ($result)
		$StringClass->alertMsg ( '등록되었습니다.', 'parent', '/manager/?m=promotion&a=update&shop_id=' . $shop_id, '' );
	else
		$StringClass->alertMsg ( '등록중 오류가 발생하였습니다.', '', '', 'NONE' );
	exit ();
} else if ($_a == "update") {
	$shop_id = $_POST['shop_id']; // PRODUCT

	if (!$shop_id)
	{
		$StringClass->alertMsg('업체정보가 없습니다.', '', '', 'NONE');
		exit();
	}

	// DB 저장정보
	$db_param = array ();
	$db_param['shop_id'] = $shop_id;
	$db_param['is_popup'] = $_POST['is_popup'];
	$db_param['img_width'] = $_POST['img_width'];
	$db_param['img_height'] = $_POST['img_height'];

	// 파일 존재할 경우 파일 업로드
	if (!$_FILES["user_file"]["name"][0])
	{
		$parm = array ();
		$param ['upload_dir'] = $upload_dir;
		
		$param_filename = array ();
		$param_filename = $ImageCon->uploadFiles($param);

		if (count($param_filename) > 0 && count($_FILES["user_file"]["name"]) > 0) {
			$db_param['file_name'] = $_FILES["user_file"]["name"][0];
			$db_param['file_ext'] = $_FILES["user_file"]["type"][0];
			$db_param['file_url'] = $param_filename[0];
			$db_param['file_size'] = $_FILES["user_file"]["size"][0];
		}
	}
	else
	{
		$db_param['file_name'] = "";
		$db_param['file_ext'] = "";
		$db_param['file_url'] = "";
		$db_param['file_size'] = 0;
	}
	
	$result = $PromotionCon->setPromotion($db_param);

	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	if ($result)
		$StringClass->alertMsg ( '수정되었습니다.', 'parent', '/manager/?m=promotion&a=update&shop_id=' . $shop_id, '' );
	else
		$StringClass->alertMsg ( '수정중 오류가 발생하였습니다.', '', '', 'NONE' );
	exit ();
} else if ($_a == "delete") {
	if ($shop_id) {
		$result = $PromotionCon->delPromotion($shop_id);
		
		if ($result)
			$return = "100";
		else
			$return = "200";
	}
}
echo $return;
?>