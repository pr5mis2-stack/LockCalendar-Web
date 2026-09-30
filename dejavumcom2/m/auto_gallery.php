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
$thisPage = "/m/auto_gallery.php";

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
  background: #fff; /* makes pngs w/ transparency fades better looking */
  margin: 0;
}
		
		
	</style>

</head>
<body class="ui-mobile-viewport ui-overlay-a">
<input type="hidden" id="m" name="m" value="<?=$_m;?>" />
<input type="hidden" id="p" name="p" value="<?=$_p;?>" />
<div data-role="page" class="jqm-demos" data-quicklinks="true" id="jqm-demos">

	<div data-role="header" role="banner" class="ui-header ui-bar-inherit">
		<h1 class="ui-title" role="heading" aria-level="1"><?=$main_info['baby_name'];?> 돌잔치 사진첩</h1>
		<a href="#" id="btnGotoDejavu" data-rel="back" class="ui-btn-left ui-btn ui-icon-back ui-btn-icon-notext ui-shadow ui-corner-all" data-role="button" role="button">이전</a>
	</div>

	<?php if ($gly_info['gallery_type'] == "1") { ?>
		<div id="slideshow"  class=slideshow>
		<?php 
        foreach($gpto_result as $key=>$val)
        	echo "<img src='{$val['photo_url']}' style='width:100%; border:0;' />";
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
		$("#slideshow").width(screen.width);
		$("#slideshow").height(screen.width*2);
	});

	$(document).resize(function(){ 
		$("#slideshow").width(screen.width);
		$("#slideshow").height(screen.width*2);
	});
	
	$('#slideshow').slideshow({
		selector: 'img',
		delay:5000,
		duration:400,
		transition: 'fadeThroughBackground'

	});
	</script>
	<?php } else { 
		foreach($gpto_result as $key=>$val)
	    echo "<img src='{$val['photo_url']}' style='width:100%; border:0;' /><br />";
	} ?>
</div>
</body>
</html>