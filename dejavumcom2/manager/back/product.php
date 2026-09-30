<?php
/**
 *  product.php
 *  @Desc      : 메인 이미지 관리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */

/**
 *
 * @var parameter setting
 */
$action = $StringClass->getRequest ( 'action' );

if ($action == "insert")
	include_once ("product_form.php");
else if ($action == "update")
	include_once ("product_form.php");
else
	include_once ("product_list.php");
?>