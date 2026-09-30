<?php
// ni_set("session.cookie_domain",".dejavu-m.com") ;
// ession_start();
// ession_cache_limiter("none");
/**
 * sample_proc.php
 * @Desc : 샘플 처리
 * @Author : suya
 * @Date :
 * 
 * @param
 *        	@Return
 */
require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/common_header.php");

import ( "class.controller.SampleCon" );
import ( "class.controller.SampleDetailCon" );
import ( "class.controller.ImageCon" );

$SampleCon = new SampleCon ();
$SampleDetailCon = new SampleDetailCon ();
$ImageCon = new ImageCon ();

/**
 *
 * @var pageing setting
 */
$thisPage = "/manager/sample_proc.php";

/**
 *
 * @var parameter setting
 */
$_a = $StringClass->getRequest ( 'a' );

$sample_id = $StringClass->getRequest ( 'sample_id' );
$sample_name = $StringClass->getRequest ( 'sample_name' );
$is_use = $StringClass->getRequest ( 'is_use' );
$sample_type = $StringClass->getRequest ( 'sample_type' );

if ($_a == "update") {
	if ($sample_id) {
		$param = array ();
		$param ['sample_id'] = $sample_id;
		$param ['sample_name'] = $sample_name;
		$param ['is_use'] = $is_use;
		$param ['sample_type'] = $sample_type;
		
		$result = $SampleCon->setSample ( $param );
		
		if ($result)
			echo "100";
		else
			echo "200";
	} else
		echo "99";
	exit ();
} else if ($_a == "insert") {
	$param = array ();
	$param ['sample_name'] = $sample_name;
	$param ['is_use'] = $is_use;
	$param ['sample_type'] = $sample_type;
	
	$result = $SampleCon->addSample ( $param );
	
	if ($result)
		echo "100";
	else
		echo "200";
	exit ();
} else if ($_a == "delete") {
	if ($sample_id) {
		$result = $SampleCon->delSample ( $sample_id );
		
		if ($result) {
			$SampleDetailCon->delSampleDetailBySampleID ( $sample_id );
			echo "100";
		} else
			echo "200";
	} else
		echo "99";
	exit ();
} else if ($_a == "detail_update") {
	$sample_id = $_POST ['sample_id']; // PRODUCT
	$detail_id = $_POST ['detail_id'];
	$part = $_POST ['part'];
	$detail_name = $_POST ['detail_name'];
	$detail_html = $_POST ['detail_html'];
	$upload_dir = $_POST ['upload_dir']; // PRODUCT
	$sample_type = $_POST ['sample_type'];
	
	if ($sample_type == "B") {	// 돌잔치 (B)
		$sample_type_dir = "baby/";
		$upload_dir = $upload_dir . $sample_type_dir;
	} else if ($sample_type == "W") {	// 결혼식 (W)
		$sample_type_dir = "wedding/";
		$upload_dir = $upload_dir . $sample_type_dir;
	} else if ($sample_type == "S") {	// 고희연 (S)
		$sample_type_dir = "silver/";
		$upload_dir = $upload_dir . $sample_type_dir;
	}
	
	$parm = array ();
	$param ['upload_dir'] = $upload_dir;
	$param ['sample_id'] = $sample_id;
	
	$param_filename = array ();
	$param_filename = $ImageCon->uploadZipFile ( $param );
	// new dBug($param_filename);
	// exit;
	$oparam = array ();
	$oparam ['sample_id'] = $sample_id;
	$oparam ['detail_id'] = $detail_id;
	$oparam ['part'] = $part;
	$oparam ['detail_name'] = trim ( $detail_name );
	$oparam ['detail_html'] = str_replace ( "sample_images/", $conf_img_sample_url . $sample_type_dir . $sample_id . "/", trim ( $detail_html ) );
	if ($param_filename)
		$oparam ['img_zipfile'] = $param_filename [0];
	
	$result = $SampleDetailCon->setSampleDetail ( $oparam );
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	if ($result)
		$StringClass->alertMsg ( '수정되었습니다.', 'parent', '/manager/?m=sample&a=update&sample_id=' . $sample_id, '' );
	else
		$StringClass->alertMsg ( '수정중 오류가 발생하였습니다.', '', '', 'NONE' );
	exit ();
} else if ($_a == "detail_insert") {
	$sample_id = $_POST ['sample_id']; // PRODUCT
	$part = $_POST ['part'];
	$detail_name = $_POST ['detail_name'];
	$detail_html = $_POST ['detail_html'];
	$upload_dir = $_POST ['upload_dir']; // PRODUCT
	$sample_type = $_POST ['sample_type'];
	
	if ($sample_type == "B") {	// 돌잔치 (B)
		$sample_type_dir = "baby/";
		$upload_dir = $upload_dir . $sample_type_dir;
	} else if ($sample_type == "W") {	// 결혼식 (W)
		$sample_type_dir = "wedding/";
		$upload_dir = $upload_dir . $sample_type_dir;
	} else if ($sample_type == "S") {	// 고희연 (S)
		$sample_type_dir = "silver/";
		$upload_dir = $upload_dir . $sample_type_dir;
	}
	
	$parm = array ();
	$param ['upload_dir'] = $upload_dir;
	$param ['sample_id'] = $sample_id;
	
	$param_filename = array ();
	$param_filename = $ImageCon->uploadZipFile ( $param );
	
	$oparam = array ();
	$oparam ['sample_id'] = $sample_id;
	$oparam ['part'] = $part;
	$oparam ['detail_name'] = trim ( $detail_name );
	$oparam ['detail_html'] = str_replace ( "sample_images/", $conf_img_sample_url . $sample_type_dir . $sample_id . "/", trim ( $detail_html ) );
	
	if ($param_filename)
		$oparam ['img_zipfile'] = $param_filename [0];
		
		// new dBug($oparam);
		// exit;
	$result = $SampleDetailCon->addSampleDetail ( $oparam );
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	if ($result)
		$StringClass->alertMsg ( '등록되었습니다.', 'parent', '/manager/?m=sample&a=update&sample_id=' . $sample_id, '' );
	else
		$StringClass->alertMsg ( '등록중 오류가 발생하였습니다.', '', '', 'NONE' );
	exit ();
} else if ($_a == "detail_delete") {
	$detail_id = $StringClass->getRequest ( 'detail_id' );
	if ($detail_id) {
		$result = $SampleDetailCon->delSampleDetail ( $detail_id );
		
		if ($result)
			echo "100";
		else
			echo "200";
	} else
		echo "99";
	exit ();
}
?>