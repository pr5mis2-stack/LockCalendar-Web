<?php
// ni_set("session.cookie_domain",".dejavu-m.com") ;
// ession_start();
// ession_cache_limiter("none");
/**
 * member_proc.php
 * @Desc : 업체정보 처리
 * @Author : suya
 * @Date :
 *
 * @param
 *        	@Return
 */
require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/common_header.php");

import ( "class.controller.ShopCon" );
import ( "class.controller.AdvertisementCon" );
import ( "class.controller.ShopMultimediaCon" );
import ( "class.controller.ShopSampleCon" );
import ( "class.controller.ImageCon" );

$ShopCon = new ShopCon ();
$AdvertisementCon = new AdvertisementCon ();
$ShopMultimediaCon = new ShopMultimediaCon ();
$ShopSampleCon = new ShopSampleCon ();
$ImageCon = new ImageCon ();

/**
 *
 * @var pageing setting
 */
$thisPage = "/manager/shop_proc.php";

/**
 *
 * @var parameter setting
 */
$_a = $StringClass->getRequest ( 'a' );

$shop_id = $StringClass->getRequest ( 'shop_id' );
$parent_shop_id = $StringClass->getRequest ( 'parent_shop_id' );
$shop_name = $StringClass->getRequest ( 'shop_name' );
$city = $StringClass->getRequest ( 'city' );
$zone = $StringClass->getRequest ( 'zone' );
$tel = $StringClass->getRequest ( 'tel' );
$fax = $StringClass->getRequest ( 'fax' );
$address = $StringClass->getRequest ( 'address' );
$address_etc = $StringClass->getRequest ( 'address_etc' );
$xlocation = $StringClass->getRequest ( 'xlocation' );
$ylocation = $StringClass->getRequest ( 'ylocation' );
$ceo_name = $StringClass->getRequest ( 'ceo_name' );
$staff_name = $StringClass->getRequest ( 'staff_name' );
$staff_tel = $StringClass->getRequest ( 'staff_tel' );
$staff_hp = $StringClass->getRequest ( 'staff_hp' );
$staff_email = $StringClass->getRequest ( 'staff_email' );
$gallery_type = $StringClass->getRequest ( 'gallery_type' );
$contract_end = $StringClass->getRequest ( 'contract_end' );
$time_week = $StringClass->getRequest ( 'time_week' );
$time_sat = $StringClass->getRequest ( 'time_sat' );
$time_sun = $StringClass->getRequest ( 'time_sun' );
$memo = $StringClass->getRequest ( 'memo' );
$is_baby = $StringClass->getRequest ( 'is_baby' );
$is_wedding = $StringClass->getRequest ( 'is_wedding' );
$is_silver = $StringClass->getRequest ( 'is_silver' );
$map_url = $StringClass->getRequest ( 'map_url' );


if ($_a == "update" || $_a == "update2" ) {
	if ($shop_id) {
		$param = array ();
		$param ['shop_id'] = $shop_id;
		$param ['parent_shop_id'] = $parent_shop_id;
		$param ['shop_name'] = $shop_name;
		$param ['city'] = $city;
		$param ['zone'] = $zone;
		$param ['tel'] = $tel;
		$param ['fax'] = $fax;
		$param ['address'] = $address;
		$param ['address_etc'] = $address_etc;
		$param ['xlocation'] = $xlocation;
		$param ['ylocation'] = $ylocation;
		$param ['ceo_name'] = $ceo_name;
		$param ['staff_name'] = $staff_name;
		$param ['staff_tel'] = $staff_tel;
		$param ['staff_hp'] = $staff_hp;
		$param ['staff_email'] = $staff_email;
		$param ['gallery_type'] = $gallery_type;
		$param ['contract_end'] = $contract_end;
		$param ['time_week'] = $time_week;
		$param ['time_sat'] = $time_sat;
		$param ['time_sun'] = $time_sun;
		$param ['memo'] = $memo;
		$param ['is_baby'] = $is_baby;
		$param ['is_wedding'] = $is_wedding;
		$param ['is_silver'] = $is_silver;
		$param ['map_url'] = $map_url;

		$result = $ShopCon->setShop ( $param );

		if ($result)
			echo "100";
		else
			echo "200";
	} else
		echo "99";
	exit ();
} else if ($_a == "insert") {
	$param = array ();
	// $param['shop_id'] = $shop_id;
	$param ['parent_shop_id'] = $parent_shop_id;
	$param ['shop_name'] = $shop_name;
	$param ['city'] = $city;
	$param ['zone'] = $zone;
	$param ['tel'] = $tel;
	$param ['fax'] = $fax;
	$param ['address'] = $address;
	$param ['address_etc'] = $address_etc;
	$param ['xlocation'] = $xlocation;
	$param ['ylocation'] = $ylocation;
	$param ['ceo_name'] = $ceo_name;
	$param ['staff_name'] = $staff_name;
	$param ['staff_tel'] = $staff_tel;
	$param ['staff_hp'] = $staff_hp;
	$param ['staff_email'] = $staff_email;
	$param ['gallery_type'] = $gallery_type;
	$param ['contract_end'] = $contract_end;
	$param ['time_week'] = $time_week;
	$param ['time_sat'] = $time_sat;
	$param ['time_sun'] = $time_sun;
	$param ['memo'] = $memo;
	$param ['is_baby'] = $is_baby;
	$param ['is_wedding'] = $is_wedding;
	$param ['is_silver'] = $is_silver;
	$param ['map_url'] = $map_url;

	$result = $ShopCon->addShop ( $param );

	if ($result)
		echo "100";
	else
		echo "200";
	exit ();
} else if ($_a == "delete") {
	if ($shop_id) {
		$result = $ShopCon->delShop ( $shop_id );

		if ($result) {
			$ShopMultimediaCon->delShopMultimediaByShopID ( $shop_id );
			echo "100";
		} else
			echo "200";
	} else
		echo "99";
	exit ();
} else if ($_a == "file_insert") {
	$shop_id = $_POST ['shop_id']; // PRODUCT
	$media_type = $_POST ['media_type']; // PRODUCT
	$upload_dir = $_POST ['upload_dir']; // PRODUCT

	$parm = array ();
	$param ['upload_dir'] = $upload_dir;

	$param_filename = array ();
	$param_filename = $ImageCon->uploadFiles ( $param );

	if (! empty ( $param_filename )) {
		for($i = 0; $i < count ( $param_filename ); $i ++) {
			if ((count ( $param_filename ) >= $i && count ( $_FILES ["user_file"] ["name"] ) >= $i) && (! empty ( $param_filename [$i] ) && ! empty ( $_FILES ["user_file"] ["name"] [$i] ))) {
				$oparam = array ();
				$oparam ['shop_id'] = $shop_id;
				$oparam ['media_type'] = $media_type;
				$oparam ['file_name'] = $_FILES ["user_file"] ["name"] [$i];
				$oparam ['file_ext'] = $_FILES ["user_file"] ["type"] [$i];
				$oparam ['file_url'] = $param_filename [$i];
				$oparam ['file_size'] = $_FILES ["user_file"] ["size"] [$i];
				$oparam ['photo_width'] = 0;
				$oparam ['photo_height'] = 0;

				// new dBug($oparam);
				// exit;
				$ShopMultimediaCon->addShopMultimedia ( $oparam );
			}
		}
	}
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	if (! empty ( $param_filename ))
		$StringClass->alertMsg ( '등록되었습니다.', 'parent', '/manager/?m=shop&a=update&shop_id=' . $shop_id, '' );
	else
		$StringClass->alertMsg ( '등록중 오류가 발생하였습니다.', '', '', 'NONE' );
	exit ();
} else if ($_a == "video_insert") {
	$shop_id = $_POST ['shop_id']; // PRODUCT
	$media_type = $_POST ['media_type']; // PRODUCT
	$file_url = $_POST ['file_url'];

	$oparam = array ();
	$oparam ['shop_id'] = $shop_id;
	$oparam ['media_type'] = $media_type;
	$oparam ['file_url'] = $file_url;
	$oparam ['photo_width'] = 0;
	$oparam ['photo_height'] = 0;

	// new dBug($oparam);
	// exit;
	$result = $ShopMultimediaCon->addShopMultimedia ( $oparam );

	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	if ($result)
		$StringClass->alertMsg ( '등록되었습니다.', 'parent', '/manager/?m=shop&a=update&shop_id=' . $shop_id, '' );
	else
		$StringClass->alertMsg ( '등록중 오류가 발생하였습니다.', '', '', 'NONE' );
	exit ();
} else if ($_a == "file_delete") {
	$media_id = $StringClass->getRequest ( 'media_id' );
	if ($media_id) {
		$result = $ShopMultimediaCon->delShopMultimedia ( $media_id );

		if ($result)
			echo "100";
		else
			echo "200";
	} else
		echo "99";
	exit ();
} else if ($_a == "adver_insert") {
	$shop_id = $_POST ['shop_id'];
	$upload_dir = $_POST ['upload_dir'];
	$view_flag = $_POST ['view_flag'];
	$st_date = $_POST ['st_date'];
	$ed_date = $_POST ['ed_date']; // PRODUCT
	$site_url = $_POST ['site_url'];

	$parm = array ();
	$param ['upload_dir'] = $upload_dir;

	$param_filename = array ();
	$param_filename = $ImageCon->uploadFiles ( $param );

	if (! empty ( $param_filename )) {
		$oparam = array ();
		$oparam ['shop_id'] = $shop_id;
		$oparam ['view_flag'] = $view_flag;
		$oparam ['site_url'] = $site_url;
		$oparam ['st_date'] = $st_date;
		$oparam ['ed_date'] = $ed_date;
		$oparam ['file_url'] = $param_filename [0];

		$result = $AdvertisementCon->addAdvertisement ( $oparam );
	}

	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	if ($result)
		$StringClass->alertMsg ( '등록되었습니다.', 'parent', '/manager/?m=shop&a=update&shop_id=' . $shop_id, '' );
	else
		$StringClass->alertMsg ( '등록중 오류가 발생하였습니다.', '', '', 'NONE' );

	exit ();
} else if ($_a == "adver_delete") {
	$adver_id = $StringClass->getRequest ( 'adver_id' );
	if ($adver_id) {
		$result = $AdvertisementCon->delAdvertisement ( $adver_id );

		if ($result)
			echo "100";
		else
			echo "200";
	} else
		echo "99";
	exit ();
} else if ($_a == "sample_insert") {
	$cnt = 0;
	$shop_id = $_POST ['shop_id'];
	$sample_id = $_POST ['sample_id'];

	$parm = array ();
	$param ['shop_id'] = $shop_id;
	$param ['sample_id'] = $sample_id;
	// new dBug($param);
	// exit;

	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";

	if ($shop_id && $sample_id) {
		$cnt = $ShopSampleCon->getShopSampleCnt ( $param );
		if ($cnt == 0)
			$result = $ShopSampleCon->addShopSample ( $param );

		if ($cnt > 0)
			$StringClass->alertMsg ( '이미 등록된 자료입니다.', '', '', 'NONE' );
		else {
			if (! empty ( $result ))
				$StringClass->alertMsg ( '등록되었습니다.', 'parent', '/manager/?m=shop&a=update&shop_id=' . $shop_id, '' );
			else
				$StringClass->alertMsg ( '등록중 오류가 발생하였습니다.', '', '', 'NONE' );
		}
	} else
		$StringClass->alertMsg ( '등록 정보가 없습니다.', '', '', 'NONE' );
	exit ();
} else if ($_a == "sample_delete") {
	$sample_id = $StringClass->getRequest ( 'sample_id' );
	if ($sample_id) {
		$param = array ();
		$param ['shop_id'] = $shop_id;
		$param ['sample_id'] = $sample_id;

		$result = $ShopSampleCon->delShopSample ( $param );

		if ($result)
			echo "100";
		else
			echo "200";
	} else
		echo "99";
	exit ();
}

?>