<?php 
#ini_set("session.cookie_domain",".dejavu-m.com") ;
#session_start();

/**
 *  logout.php
 *  @Desc      : 로그아웃 처리.
 *  @Author    : 
 *  @Date      : 2011. 06. 15. 오전 11:03:57
 *  @param 	 
 *  @Return
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/include/common_header.php");

$ret_url = !empty($_SERVER["HTTP_REFERER"])? $_SERVER["HTTP_REFERER"]:'/index.php';

/**
 * 
 * @var pageing setting
 */
$thisPage = "/member/logout.php";

$_SESSION["manager_id"]	= "";
$_SESSION["manager_name"] = "";
session_destroy();

$StringClass->alertMsg('','top', $ret_url, 'NONE');
?>