<?php
ini_set("session.cookie_domain", (strpos($_SERVER["HTTP_HOST"], "dejavu-m.com") !== false) ? ".dejavu-m.com" : "");
ini_set('register_globals','1');
ini_set('session.bug_compat_42','1');
ini_set('session.bug_compat_warn','0');
ini_set('session.auto_start','1');
header("p3p: CP='CAO DSP AND SO ON' policyref='/w3c/p3p.xml'");
session_start();

/**
 *  common_cheader.php
 *  @Desc      : Front 에서 공통으로 사용되는 파일
 *  공통 함수 include , 공통 파라미터 선언 등
 *  @Author    : suya
 *  @Date      : 2012. 04. 27
 *  @param 	 
 *  @Return
 */
require_once(dirname(dirname(__DIR__)) . "/conf/DejavuConf.php");
require_once(dirname(dirname(__DIR__)) . "/import.php");

// 로그인 페이지 분기 설정 (일반 로그인 페이지로 분기)
$login_url = $conf_login_url;

$strImgPath = "/image" ; 			// 일반이미지 경로
$galleryPath = "/gallery_photo";	// 갤러리 이미지 저장 경로
$PageView = "FRONT";				// 페이징 처리를 위한 구분값

// 상단 메뉴 이미지
$strFileName = $_SERVER['PHP_SELF'];

$pageBlockSize = 10; 	 // 페이징 처리 (페이징 넘버 노출 사이즈)
$pageRowCnt = 10; 		 // 페이징 처리(화면 출력 row 갯수)

$link_css = "<link rel='stylesheet' type='text/css' media='all' href='/css/default.css' charset='utf-8' />\n";
?>