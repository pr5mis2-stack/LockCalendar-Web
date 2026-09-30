<?php
// ni_set("session.cookie_domain",".dejavu-m.com") ;
// ession_start();
// ession_cache_limiter("none");
/**
 * advertisement_proc.php
 * @Desc : 업체정보 처리
 * @Author : suya
 * @Date :
 * 
 * @param
 *        	@Return
 */
require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/common_header.php");

import ( "class.controller.AdvertisementCon" );
import ( "class.controller.ImageCon" );

$AdvertisementCon = new AdvertisementCon ();
$ImageCon = new ImageCon ();

/**
 *
 * @var pageing setting
 */
$thisPage = "/manager/advertisement_proc.php";

/**
 *
 * @var parameter setting
 */
$_a = $StringClass->getRequest ( 'a' );

$adver_id = $StringClass->getRequest ( 'adver_id' );
$upload_dir = $StringClass->getRequest ( 'upload_dir' );

if ($_a == "update") {
	$company_name = $_POST ['company_name'];
	$st_date = $_POST ['st_date'];
	$ed_date = $_POST ['ed_date']; // PRODUCT
	
	$parm = array ();
	$param ['upload_dir'] = $upload_dir;
	
	$param_filename = array ();
	$param_filename = $ImageCon->uploadFiles ( $param );
	
	if (! empty ( $param_filename )) {
		for($i = 0; $i < count ( $param_filename ); $i ++) {
			if ((count ( $param_filename ) >= $i && count ( $_FILES ["user_file"] ["name"] ) >= $i) && (! empty ( $param_filename [$i] ) && ! empty ( $_FILES ["user_file"] ["name"] [$i] ))) {
				$oparam = array ();
				$oparam ['adver_id'] = $adver_id;
				$oparam ['company_name'] = $company_name;
				$oparam ['st_date'] = $st_date;
				$oparam ['ed_date'] = $ed_date;
				$oparam ['file_url'] = $param_filename [$i];
				
				// new dBug($oparam);
				// exit;
				$result = $AdvertisementCon->setAdvertisement ( $oparam );
			}
		}
	}
	
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	if ($result)
		$StringClass->alertMsg ( '수정되었습니다.', 'parent', '/manager/?m=advertisement&a=update&adver_id=' . $adver_id, '' );
	else
		$StringClass->alertMsg ( '수정중 오류가 발생하였습니다.', '', '', 'NONE' );
	exit ();
} else if ($_a == "insert") {
	$company_name = $_POST ['company_name'];
	$st_date = $_POST ['st_date'];
	$ed_date = $_POST ['ed_date']; // PRODUCT
	
	$parm = array ();
	$param ['upload_dir'] = $upload_dir;
	
	$param_filename = array ();
	$param_filename = $ImageCon->uploadFiles ( $param );
	
	if (! empty ( $param_filename )) {
		for($i = 0; $i < count ( $param_filename ); $i ++) {
			if ((count ( $param_filename ) >= $i && count ( $_FILES ["user_file"] ["name"] ) >= $i) && (! empty ( $param_filename [$i] ) && ! empty ( $_FILES ["user_file"] ["name"] [$i] ))) {
				$oparam = array ();
				$oparam ['company_name'] = $company_name;
				$oparam ['st_date'] = $st_date;
				$oparam ['ed_date'] = $ed_date;
				$oparam ['file_url'] = $param_filename [$i];
				
				// new dBug($oparam);
				// exit;
				$result = $AdvertisementCon->addAdvertisement ( $oparam );
			}
		}
	}
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	if ($result)
		$StringClass->alertMsg ( '등록되었습니다.', 'parent', '/manager/?m=advertisement', '' );
	else
		$StringClass->alertMsg ( '등록중 오류가 발생하였습니다.', '', '', 'NONE' );
	exit ();
} else if ($_a == "delete") {
	if ($adver_id) {
		$result = $AdvertisementCon->delAdvertisement ( $adver_id );
		
		if ($result)
			echo "100";
		else
			echo "200";
	} else
		echo "99";
	exit ();
}
?>