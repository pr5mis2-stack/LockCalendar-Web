<?php
/**
 *  main.php
 *  @Desc      : 초대장 목록
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
import("class.controller.MainCon");
import("class.controller.PromotionCon");
import ( "php.util.PagingClass" );

$MainCon = new MainCon();
$PromotionCon = new PromotionCon();

/**
 *
 * @var parameter setting
 */
$_a = $StringClass->getRequest('a');

if ($_a == "insert" || $_a == "update")
	include_once(__DIR__ . "/promotion_form.php");
else
	include_once(__DIR__ . "/promotion_list.php");
?>