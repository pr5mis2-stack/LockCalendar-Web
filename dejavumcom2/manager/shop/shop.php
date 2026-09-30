<?php
/**
 *  shop.php
 *  @Desc      : 업체 목록
 *  @Author    : suya
 *  @Date      :
 *  @param
 *  @Return
 */
import ( "class.controller.ShopCon" );
import ( "class.controller.ShopMultimediaCon" );
import ( "class.controller.AdvertisementCon" );
import ( "class.controller.SampleCon" );
import ( "class.controller.ShopSampleCon" );
import ( "php.util.PagingClass" );

$ShopCon = new ShopCon ();
$AdvertisementCon = new AdvertisementCon ();
$ShopMultimediaCon = new ShopMultimediaCon ();
$ShopSampleCon = new ShopSampleCon ();
$SampleCon = new SampleCon ();
/**
 *
 * @var parameter setting
 */
$_a = $StringClass->getRequest ( 'a' );

if ($_a == "insert" || $_a == "update")
	include_once ("shop_form.php");
else if ($_a == "update2")
  include_once(__DIR__ . "/shop_form2.php");
else
	include_once ("shop_list.php");
?>