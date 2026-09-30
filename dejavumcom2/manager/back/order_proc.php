<?php
ini_set ( "session.cookie_domain", ".guiguiland.com" );
session_start ();
session_cache_limiter ( "none" );
/**
 * product_proc.php
 * @Desc : 상품등록 처리
 * @Author : suya
 * @Date :
 * 
 * @param
 *        	@Return
 */
require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/common_header.php");

import ( "class.controller.OrderCon" );
import ( "class.controller.PaymentCon" );

$OrderCon = new OrderCon ();
$PaymentCon = new PaymentCon ();

/**
 *
 * @var pageing setting
 */
$thisPage = "/manager/order_proc.php";

/**
 *
 * @var parameter setting
 */
$mode = $StringClass->getRequest ( 'mode' );
$order_code = $StringClass->getRequest ( 'order_code' );
$payment_id = $StringClass->getRequest ( 'payment_id' );
$payment_result = $StringClass->getRequest ( 'payment_result' );
$order_status = $StringClass->getRequest ( 'order_status' );
$logistics_status = $StringClass->getRequest ( 'logistics_status' );
$logistics_name = $StringClass->getRequest ( 'logistics_name' );
$logistics_code = $StringClass->getRequest ( 'logistics_code' );

if ($mode == "update") {
	if ($order_code) {
		$oparam = array ();
		$oparam ['order_code'] = $order_code;
		$oparam ['logistics_name'] = $logistics_name;
		$oparam ['logistics_code'] = $logistics_code;
		$oparam ['logistics_status'] = $logistics_status;
		$result1 = $OrderCon->updateOrder ( $oparam );
		
		$pparam = array ();
		$pparam ['payment_id'] = $payment_id;
		$pparam ['payment_result'] = $payment_result;
		$pparam ['order_status'] = $order_status;
		$result2 = $PaymentCon->updateOrderPayment ( $pparam );
		
		if ($result1 && $result2)
			echo "100";
		else
			echo "200";
	} else
		echo "99";
	exit ();
}
?>