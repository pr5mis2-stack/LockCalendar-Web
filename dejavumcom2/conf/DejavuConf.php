<?php
/**
 * default Scheduled Maintenance info
 * ※ $SMInfo는 cafe24 자체 유지보수 공지 시스템이 주입하는 변수로, 없을 수도 있어
 *   안전하게 기본값을 넣어준다 (PHP 8부터 미정의 변수 접근이 Warning으로 격상됨).
 */
$notiException = "N";
$sm_exception_nick = isset($SMInfo['expNick']) ? $SMInfo['expNick'] : '';
$sm_exception_nick_str = isset($SMInfo['expNickStr']) ? $SMInfo['expNickStr'] : '';
$arrSmExpNick = explode(",", $sm_exception_nick);
$arrSmExpNickStr = explode(",", $sm_exception_nick_str);


define("DEBUG_MODE", "OFF");										// 디버그 모드 ON / OFF

/**
	 *  서비스 환경 설정
	 *
	 *  @Desc      : 도메인(or IP), 접속포트, 접속계정, 디렉토리 경로, 서비스아이디, 이미지 파일 관련 규칙 등 공통 환경 설정
	 *  @Author    : 손명석
	 *  @Date      : 2010. 11. 16. 오후 6:50:08
 */

// 서비스 도메인
$conf_web_server	= "www.dejavu-m.com";
$conf_m_server = "m.dejavu-m.com";
// Global DB Connection link
$conf_db_conn			= null;										// 시스템 전체에서 Connection link 공유
$conf_dejavu_logger	= null;										// 시스템 전체에서 Logger 공유

define("FILE_PUT_CONTENTS_ATOMIC_MODE", 0777);

/**********************************************************************
 * 서비스 기본정보 설정
 *********************************************************************/
date_default_timezone_set('Asia/Seoul');							// 디폴트 타임존 설정

// 서비스 디렉토리 경로 (DOCUMENT_ROOT 기준 동적 계산)
// ※ 2026-09 서버 이전(PHP 8.4)을 계기로, 특정 서버의 절대경로를 하드코딩하던 방식에서
//   DOCUMENT_ROOT 기준 상대 계산 방식으로 변경함. conf/lib/cron_scripts 폴더는
//   이제 www 폴더 "안"에 위치한다고 가정한다 (호스팅사 FTP 계정이 www 바깥에는
//   폴더를 만들 수 없는 경우가 많아, 향후 서버 이전 시에도 안전하도록 하기 위함).
$conf_www_dir			= rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/';		// www 폴더 자체 (DOCUMENT_ROOT)
$conf_home_dir			= rtrim($_SERVER['DOCUMENT_ROOT'], '/');			// conf/lib가 위치한 기준 폴더 (= www)
$conf_config_dir		= $conf_home_dir . "/conf";
$conf_lib_dir			= $conf_home_dir . "/lib/";
$conf_login_url			= "/member/login.php";	// 로그인 페이지 경로 (원본 코드에 누락되어 있던 값)
$conf_data_dir			= $conf_www_dir . "m/data";

$naver_map_key 			= "84deba922b74f2a0a7e57409bf7bb578";
$naver_wmap_key 		= "e3e2af19ab6c45119941b5a24c52a810";
$naver_map_key_v3		= "uyazy7btzy"; //"9q44ZB2Hd58RqlZtYwez";
/**********************************************************************
 * 파일경로 설정
*********************************************************************/

// 로그파일 경로 (절대 경로) - log4php 설정
$conf_log_dir				= $conf_home_dir . "/log/";

// 이미지파일 디렉토리 경로 (절대 경로)
$conf_img_gallery_dir			= $conf_data_dir . "/gallery_img/";				// 콘텐츠 이미지파일 저장 경로 (FTP) - 미디어서버 (web)
$conf_img_shop_dir				= $conf_data_dir . "/shop_img/";				// 콘텐츠 이미지파일 저장 경로 (FTP) - 미디어서버 (web)
$conf_img_thumbnail_dir   = $conf_data_dir . "/thumbnail_img/";			// 썸네일이미지파일 저장 경로 (HTTP) - 미디어서버 (web)
$conf_img_banner_dir			= $conf_data_dir . "/banner_img/";				// 화면노출등 배너 이미지 파일 저장경로 (HTTP) - 미디어서버 (web)
$conf_temp_file_dir				= $conf_data_dir . "/temp/";					// 기타 파일 임시저장 경로
$conf_img_sample_dir			= $conf_data_dir . "/sample_img";
$conf_bgm_shop_dir				= $conf_data_dir . "/shop_bgm/";				// 업체별 bgm 저장 경로 (FTP) - 미디어서버 (web)


// 수정 전: $conf_mimg_sample_url = "http://" . $conf_m_server . "/m/data/sample_img/";

$conf_img_gallery_url       = "//" . $conf_web_server . "/data/gallery_img/";
$conf_img_shop_url          = "//" . $conf_web_server . "/data/shop_img/";
$conf_img_thumbnail_url     = "//" . $conf_web_server . "/data/thumbnail_img/";
$conf_img_banner_url        = "//" . $conf_web_server . "/data/banner_img/";
$conf_img_sample_url        = "//" . $conf_web_server . "/data/sample_img/";
$conf_bgm_shop_url          = "//" . $conf_web_server . "/data/shop_bgm/";

$conf_mimg_gallery_url      = "//" . $conf_m_server . "/data/gallery_img/";
$conf_mimg_shop_url         = "//" . $conf_m_server . "/data/shop_img/";
$conf_mimg_thumbnail_url    = "//" . $conf_m_server . "/data/thumbnail_img/";
$conf_mimg_banner_url       = "//" . $conf_m_server . "/data/banner_img/";
$conf_mimg_sample_url       = "//" . $conf_m_server . "/data/sample_img/";