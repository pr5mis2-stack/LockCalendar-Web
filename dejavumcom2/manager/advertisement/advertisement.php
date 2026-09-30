<?php
/**
 *  shop.php
 *  @Desc      : 업체 목록
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
import ( "class.controller.AdvertisementCon" );
import ( "php.util.PagingClass" );

$AdvertisementCon = new AdvertisementCon ();
/**
 *
 * @var parameter setting
 */
$_a = $StringClass->getRequest ( 'a' );

if ($_a == "insert" || $_a == "update")
	include_once ("advertisement_form.php");
else
	include_once ("advertisement_list.php");
?>