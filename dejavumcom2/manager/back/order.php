<?php
/**
 *  order.php
 *  @Desc      : 주문 관리
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

if ($action == "view")
	include_once ("order_form.php");
else
	include_once ("order_list.php");
?>