<?php 
/**
 *  login_proc.php
 *  @Desc      : 로그인 처리.
 *  @Author    : uno 
 *  @Date      : 2011. 06. 15. 오전 11:03:57
 *  @param 	 
 *  @Return
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/include/common_header.php");
/**
 * 
 * @var pageing setting
 */
$thisPage = "/admin/goto_maker.php";

/**
 * 
 * @var parameter setting
 */
$dejavu_id = isset($_POST['did']) ? trim($_POST['did']) : (isset($_GET['did']) ? trim($_GET['did']) : '');

/**
 * info check
 */
if (!empty($dejavu_id))
{
	$_SESSION["dejavu_id"]		= $dejavu_id;
	$url = "http://fph.dejavu-m.com/maker/main.php";
	
	$StringClass->alertMsg("", "", $url, "");
}
else
	$StringClass->alertMsg("초대장 정보가 없습니다.", "", "", "CLOSE");
?>