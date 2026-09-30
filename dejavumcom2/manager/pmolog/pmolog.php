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

$MainCon = new MainCon();
$PromotionCon = new PromotionCon();

/**
 *
 * @var parameter setting
 */
$_a = $StringClass->getRequest('a');
if ($_a == "excel")
    include_once(__DIR__ . "/pmolog_excel.php");
else
    include_once(__DIR__ . "/pmolog_list.php");
?>