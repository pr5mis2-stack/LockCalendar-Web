<?php
#ini_set("session.cookie_domain",".dejavu-m.com") ;
#session_start();
#session_cache_limiter("none");

header("Cache-Control:no-cache");
header("Pragma:no-cache");
/**
 *  search_proc.php
 *  @Desc      : 검색결과 처리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
require_once(dirname(__DIR__) . "/conf/DejavuConf.php");
require_once(dirname(__DIR__) . "/import.php");

// 로그인 페이지 분기 설정 (일반 로그인 페이지로 분기)
$login_url = $conf_login_url;

$strImgPath = "/image" ; 			// 일반이미지 경로
$galleryPath = "/gallery_photo";	// 갤러리 이미지 저장 경로
$PageView = "FRONT";				// 페이징 처리를 위한 구분값

// 상단 메뉴 이미지
$strFileName = $_SERVER['PHP_SELF'];

$pageBlockSize = 10; 	 // 페이징 처리 (페이징 넘버 노출 사이즈)
$pageRowCnt = 10; 		 // 페이징 처리(화면 출력 row 갯수)

import("class.controller.MainCon");
import("class.controller.GalleryCon");
import("class.controller.GalleryPhotoCon");

$MainCon        	= new MainCon();
$GalleryCon			= new GalleryCon();
$GalleryPhotoCon 	= new GalleryPhotoCon();

/**
 *
 * @var pageing setting
 */
$thisPage = "/m/gallery.php";

/**
 * 
 * @var parameter setting
 */
$_m = $StringClass->getRequest('m');
$_p = $StringClass->getRequest('p');
$gallery_html = "";

if (empty($_m))
{
	$StringClass->alertMsg('초대장 정보가 없습니다.','', '', 'CLOSE');
	exit;
}

/**
 * 
 * @var Default data setting
 */
$param = array();
$param['main_id'] = $_m;
$result = $MainCon->getMainList($param);
if ($result)
{
	$main_info = $result[0];

	if ($main_info)
	{
		$gly_result = $GalleryCon->getGalleryList($param);
		if ($gly_result)
			$gly_info = $gly_result[0];

		$param["order_by"] = "30";
		$gpto_result = $GalleryPhotoCon->getGalleryPhotoList($param);
	}
}
else
{
	$StringClass->alertMsg('초대장 정보가 없습니다.','', '', 'CLOSE');
	exit;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>데자뷰 - 스마트초대장</title>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
<link rel="stylesheet" href="http://view.jquerymobile.com/master/css/themes/default/jquery.mobile.css">
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script> 
<script type="text/javascript">
document.domain = 'dejavu-m.com';

$(document).ready(function () {
	$("#btnGotoDejavu").click(function () {
		gotoDejavu();
	});
});


gotoDejavu = function () {
	var m = $("#m").val();
	var p = $("#p").val();
	location.href="/?m="+m+"&p="+p;
}
</script>
	<style type="text/css">
		/* reset */
		*{line-height:normal;margin:0;padding:0}
		li{list-style:none;}
		img{vertical-align:top;border:0;}

		#cdIncWrap{width:100%;min-width:320px;}
		#cdIncWrap p{text-align:center;}
		#cdIncWrap #cdIncHeader{}
		#cdIncWrap #cdIncHeader img{width:100%; }
		#cdIncWrap #cdIncCntArea{}
		#cdIncWrap #cdIncCntArea img{width:100%;}

		#cdIncWrap .benefitArea{position:relative}
		#cdIncWrap .benefitArea .btnDown{position:absolute; top:73%; left:50%; width:47%; height:20%;}
		#cdIncWrap .benefitArea .btnDown img{width:100%;}

		/* 슬라이더 */
		#banner-slider {
			position: relative;
			display: none;
			text-align: center;
			overflow: hidden;
		}
		#banner-slider img { 
			vertical-align: middle;
		}
		.slidesjs-navigation {
			position:absolute;
			width: 40px;
			height: 100%;
			position: absolute;
			z-index: 100;
			top:0;
		}
		.slidesjs-previous {
			left:0;
		}
		.next-icon,
		.slidesjs-next {
			right:0;
		}
		.previous-icon,
		.next-icon{
			position:absolute;
			display: block;
			width: 28px;
			height: 37px;
			background-color: rgba(0,0,0,0.15);
			z-index :101;
			text-indent:-9999px;
			overflow: hidden;
			top: 50%;
			margin-top:-18px;
		}
		.previous-icon:after,
		.next-icon:after{
			content:"";
			position:absolute;
			display:block;
			width: 28px;
			height:37px;
			background: url(http://eventimg.auction.co.kr/md/auction/06716612C2/icons@2x.png) left top no-repeat;
			background-size:56px auto;
			left: 0;
			top: 0;
		}
		.previous-icon:after {
			background-position: left bottom;
		}
		.next-icon:after {
			background-position: right bottom;
		}
		.slidesjs-pagination {
			position:absolute;
			z-index: 100;
			padding:0;
			margin: 0;
			list-style: none;
			overflow:hidden;
			bottom:30px;left:0; right:0;
		}
		.slidesjs-pagination-item {
		  display: inline-block;
		  margin: 0 3px 0 0;
		}
		.slidesjs-pagination-item a {
			display: inline-block;
			border:1px #e1e5e6 solid;
			width: 7px;
			height: 7px;
			text-indent: 100%;
			overflow: hidden;
			background:#ffffff;
			border-radius:8px;
			-moz-border-radius:8px;
			-webkit-border-radius:8px;
		}
		.slidesjs-pagination-item a.active,
		.slidesjs-pagination-item a:hover,
		.slidesjs-pagination-item a:hover.active {
			width: 7px;
			height: 7px;
			border:1px #ed353e solid;
			background:#ff5e6a;
		}
		
		/* slide show */
		.slideshow {
		  /* important stuff for slideshow */
		  width: 500px;
		  height: 500px;
		
		}
		
		.no-js .slideshow {
		  /* a sane no-js solution */
		  overflow-y: auto;
		  overflow-x: hidden;
		}
		
		.no-js .slideshow img {
		  margin: 0;
		  width: 100%;
		}
		
		/* nothing to do with implementing slideshow */
		.slideshow img {
		  width: 100%;
		  vertical-align:middle;
		  background: #fff; /* makes pngs w/ transparency fades better looking */
		  margin: 0;
		}

		/* 겔러리 타이틀 : 아기이름부분 */
		.ui-title{color:#fff !important}
	</style>

</head>
<body class="ui-mobile-viewport ui-overlay-a">
<input type="hidden" id="m" name="m" value="<?=$_m;?>" />
<input type="hidden" id="p" name="p" value="<?=$_p;?>" />
<div data-role="page" class="jqm-demos" data-quicklinks="true" id="jqm-demos">

	<div data-role="header" role="banner" class="ui-header ui-bar-inherit">
		<h1 class="ui-title" role="heading" aria-level="1"><?=$main_info['baby_name'];?> 사진첩</h1>
		<!--<a href="#" id="btnGotoDejavu" data-rel="back" class="ui-btn-left ui-btn ui-icon-back ui-btn-icon-notext ui-shadow ui-corner-all" data-role="button" role="button">이전</a>-->
		<a href="#" id="btnGotoDejavu" data-rel="back" class="ui-btn-left ui-corner-all" data-role="button" role="button">이전</a>
	</div>
	<?php if ($gly_info['gallery_type'] == "1") { ?>
	<div id="slideshow"  class=slideshow>
	<?php 
    foreach($gpto_result as $key=>$val)
    	echo "<img src='{$val['photo_url']}' width='100%' />";
	?>
	</div>
	<!-- jQuery UI -->
	<script src="js/jquery.js"></script>
	<script src="js/jquery.ui.core.js"></script>
	<script src="js/jquery.ui.widget.js"></script>
	<!-- slideshow -->
	<script src="js/jquery.rf.slideshow.js"></script>
	<script>
	$(document).ready(function(){ 
    	wd = $( window ).width();
		$("#slideshow").width(wd);
		$("#slideshow").height(wd*1.5);
	});
	
	$(window).resize(function(){
	    wd = $( window ).width();
		$("#slideshow").width(wd);
		$("#slideshow").height(wd*1.5);
	});
	
	$('#slideshow').slideshow({
		selector: 'img',
		delay:2000,
		duration:400,
		transition: 'fadeThroughBackground'

	});
	</script>
	<?php } else if ($gly_info['gallery_type'] == "2") { ?>
		<div id="cdIncWrap">
			<header id="cdIncHeader">
				<!-- slides-menu -->
				<section id="banner-slider">
					<a href="#" class="slidesjs-previous slidesjs-navigation">
						<span class="previous-icon">이전</span>
					</a>
	                <?php 
	                foreach($gpto_result as $key=>$val)
	                	echo "<img src='{$val['photo_url']}' style='width:100%; border:0;' />";
	                ?>
					<a href="#" class="slidesjs-next slidesjs-navigation">
						<span class="next-icon">다음</span>
					</a>
				</section>
			</header>
		</div>
		<!-- Scripts -->
		<script src="http://m.dejavu-m.com/js/jquery.slides.js"></script>
		<script type="text/javascript">
		    $(document).ready(function () {
		        $('#banner-slider').slidesjs({
		            width: 320,
		            height: 480,
		            navigation: true
		        });
		    });
		</script>
	<?php } else { 
		foreach($gpto_result as $key=>$val)
	    echo "<img src='{$val['photo_url']}' style='width:100%; border:0;' /><br />";
	} ?>
</div>
</body>
</html>
