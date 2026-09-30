<?php
#ini_set("session.cookie_domain",".dejavu-m.com") ;
#session_start();

/**
 *  common_top.php
 *  @Desc      : Front에서 공통으로 사용되는 파일-상단메뉴
 *  @Author    : suya
 *  @Date      : 2012. 04. 27
 *  @param 	 
 *  @Return
 */

require_once ($_SERVER["DOCUMENT_ROOT"]."/include/common_header.php");

import("php.util.StringClass");
import("class.controller.ServiceLogCon");    // 서비스 로그 저장

$StringClass        = new StringClass();
$ServiceLogCon 		= new ServiceLogCon();
session_cache_limiter("none");
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-store" />
<meta http-equiv="Pragma" content="no-cache" />
<title>플로렌스 스마트 초대장</title>
<link href="http://fonts.googleapis.com/earlyaccess/nanumgothiccoding.css"  rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/css/common.css" />
<link rel="stylesheet" type="text/css" href="/css/jquery-ui.css" />
<script type="text/javascript">
<!--
try{document.domain = 'dejavu-m.com';}catch(e){};
//-->
</script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
</head>
<body>
<div id="wrap">
	<!-- skip -->
	<div id="skip">
		<h2>본문 바로가기</h2>
		<ul>
			<li><a href="#quick_gnb">메뉴 바로가기</a></li>
			<li><a href="#com_content">내용 바로가기</a></li>
			<li><a href="#footer">하단으로 바로가기</a></li>
		</ul>
	</div>
<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/include/modal.php");

if (!empty($_SESSION['dejavu_id']))
	include_once($_SERVER["DOCUMENT_ROOT"]."/include/gnb_logout.php");
else
	include_once($_SERVER["DOCUMENT_ROOT"]."/include/gnb_login.php");
	
$ServiceLogCon->InsertServiceLog();
?>