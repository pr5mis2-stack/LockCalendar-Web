<?php 
#ini_set("session.cookie_domain",".dejavu-m.com") ;
#session_start();

/**
 *  login_proc.php
 *  @Desc      : 로그인 처리.
 *  @Author    : uno 
 *  @Date      : 2011. 06. 15. 오전 11:03:57
 *  @param 	 
 *  @Return
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/include/common_header.php");
import("class.controller.MainCon");

$MainCon 			= new MainCon();

$ret_url = !empty($_SERVER["HTTP_REFERER"])? $_SERVER["HTTP_REFERER"]:'/main/main.php';
if (strstr($ret_url, "/member/mypage.php"))
	$ret_url = '/main/main.php';
$ret_url = '/main/main.php';
/**
 * 
 * @var pageing setting
 */
$thisPage = "/member/logout.php";

$_SESSION["main_id"]	= "";
$_SESSION["user_email"]	= "";
$_SESSION["dejavu_id"]	= "";
$_SESSION["user_email"]	= "";
session_destroy();

$StringClass->alertMsg('','top', $ret_url, 'NONE');
?>