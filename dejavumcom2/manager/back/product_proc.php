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

import ( "class.controller.ProductCon" );
import ( "class.controller.ImageCon" );

$ProductCon = new ProductCon ();
$ImageCon = new ImageCon ();

/**
 *
 * @var pageing setting
 */
$thisPage = "/manager/product_proc.php";

/**
 *
 * @var parameter setting
 */
$mode = $StringClass->getRequest ( 'mode' );
$menu = $_POST ['menu'];
$search_target = $_POST ['search_target'];
$search_keyword = $_POST ['search_keyword'];
$upload_dir = $_POST ['upload_dir']; // PRODUCT

$pid = $_POST ['pid'];
$product_name = $_POST ['product_name'];
$price = $_POST ['price'];
$sale_price = $_POST ['sale_price'];
$product_cnt = $_POST ['product_cnt'];
$is_sale = $_POST ['is_sale'];
$product_desc = $_POST ['product_desc'];

$option_id = $_POST ['option_id'];
$option_type = $_POST ['option_type'];
$option_value = $_POST ['option_value'];
$img_id = $StringClass->getRequest ( 'img_id' );

/**
 * fille add
 */
if (in_array ( $mode, array (
		"insert",
		"update" 
) )) {
	$parm = array ();
	$param ['upload_dir'] = $_POST ['upload_dir'];
	
	$param_filename = array ();
	$param_filename = $ImageCon->uploadFiles ( $param );
}

if ($mode == "delete_img") {
	if ($img_id) {
		if ($ProductCon->deleteProductImage ( $img_id ))
			echo "100";
		else
			echo "200";
	} else
		echo "99";
	exit ();
} else if ($mode == "delete_option") {
	if ($option_id) {
		if ($ProductCon->deleteProductOption ( $option_id ))
			echo "100";
		else
			echo "200";
	} else
		echo "99";
	exit ();
} else if ($mode == "delete") {
	if ($pid) {
		if ($ProductCon->deleteProduct ( $pid ))
			echo "100";
		else
			echo "200";
	} else
		echo "99";
	exit ();
} else if ($mode == "insert") {
	$param = array ();
	$param ['product_name'] = $product_name;
	$param ['product_desc'] = $product_desc;
	$param ['price'] = $price;
	$param ['sale_price'] = $sale_price;
	$param ['is_sale'] = $is_sale;
	$param ['product_cnt'] = $product_cnt;
	/**
	 * product insert
	 */
	$product_id = $ProductCon->insertProduct ( $param );
	
	if (! empty ( $product_id )) {
		if (! empty ( $option_type )) {
			for($i = 0; $i < count ( $option_type ); $i ++) {
				if ((count ( $option_type ) >= $i && count ( $option_value ) >= $i) && (! empty ( $option_type [$i] ) && ! empty ( $option_value [$i] ))) {
					$oparam = array ();
					$oparam ['product_id'] = $product_id;
					$oparam ['option_type'] = $option_type [$i];
					$oparam ['option_value'] = $option_value [$i];
					$ProductCon->insertProductOption ( $oparam );
				}
			}
		}
		
		if (! empty ( $param_filename )) {
			
			for($i = 0; $i < count ( $param_filename ); $i ++) {
				if ((count ( $param_filename ) >= $i && count ( $_FILES ["user_file"] ["name"] ) >= $i) && (! empty ( $param_filename [$i] ) && ! empty ( $_FILES ["user_file"] ["name"] [$i] ))) {
					$oparam = array ();
					$oparam ['product_id'] = $product_id;
					$oparam ['file_name'] = $_FILES ["user_file"] ["name"] [$i];
					$oparam ['file_type'] = $_FILES ["user_file"] ["type"] [$i];
					$oparam ['file_size'] = $_FILES ["user_file"] ["size"] [$i];
					$oparam ['file_url'] = $param_filename [$i];
					$ProductCon->insertProductImage ( $oparam );
				}
			}
		}
	}
	
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	if (! empty ( $product_id ))
		$StringClass->alertMsg ( '등록되었습니다.', 'parent', '/manager/index.php?menu=' . $menu . '&search_target=' . $search_target . '&search_keyword=' . $search_keyword, '' );
	else
		$StringClass->alertMsg ( '등록중 오류가 발생하였습니다.', '', '', 'NONE' );
} else if ($mode == "update") {
	$param = array ();
	$param ['product_id'] = $pid;
	$param ['product_name'] = $product_name;
	$param ['product_desc'] = $product_desc;
	$param ['price'] = $price;
	$param ['sale_price'] = $sale_price;
	$param ['is_sale'] = $is_sale;
	$param ['product_cnt'] = $product_cnt;
	/**
	 * product insert
	 */
	$result = $ProductCon->updateProduct ( $param );
	
	if (! empty ( $result )) {
		if (! empty ( $option_type )) {
			// new dBug($option_type);
			// new dBug($option_value);
			for($i = 0; $i < sizeof ( $option_type ); $i ++) {
				if ((sizeof ( $option_type ) >= $i && sizeof ( $option_value ) >= $i) && (! empty ( $option_type [$i] ) && ! empty ( $option_value [$i] ))) {
					if (! empty ( $option_id [$i] )) {
						$oparam = array ();
						$oparam ['product_id'] = $pid;
						$oparam ['option_id'] = $option_id [$i];
						$oparam ['option_type'] = $option_type [$i];
						$oparam ['option_value'] = $option_value [$i];
						// new dBug($oparam);
						$ProductCon->updateProductOption ( $oparam );
					} else {
						$oparam = array ();
						$oparam ['product_id'] = $pid;
						$oparam ['option_type'] = $option_type [$i];
						$oparam ['option_value'] = $option_value [$i];
						$ProductCon->insertProductOption ( $oparam );
					}
				}
			}
		}
		
		if (! empty ( $param_filename )) {
			
			for($i = 0; $i < count ( $param_filename ); $i ++) {
				if ((count ( $param_filename ) >= $i && count ( $_FILES ["user_file"] ["name"] ) >= $i) && (! empty ( $param_filename [$i] ) && ! empty ( $_FILES ["user_file"] ["name"] [$i] ))) {
					$oparam = array ();
					$oparam ['product_id'] = $pid;
					$oparam ['file_name'] = $_FILES ["user_file"] ["name"] [$i];
					$oparam ['file_type'] = $_FILES ["user_file"] ["type"] [$i];
					$oparam ['file_size'] = $_FILES ["user_file"] ["size"] [$i];
					$oparam ['file_url'] = $param_filename [$i];
					$ProductCon->insertProductImage ( $oparam );
				}
			}
		}
	}
	// exit;
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	if (! empty ( $result ))
		$StringClass->alertMsg ( '수정되었습니다.', 'parent', '/manager/index.php?menu=' . $menu . '&search_target=' . $search_target . '&search_keyword=' . $search_keyword, '' );
	else
		$StringClass->alertMsg ( '수정중 오류가 발생하였습니다.', '', '', 'NONE' );
}
?>