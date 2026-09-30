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
import("class.controller.SampleCon");
import("class.controller.SampleDetailCon");
import("class.controller.ShopCon");
import("class.controller.ShopSampleCon");
import("class.controller.ShopMultimediaCon");
import("class.controller.GalleryCon");
import("class.controller.GalleryPhotoCon");
import("class.controller.InvitationCon");
import("class.controller.AppreciationCon");
import("class.controller.CommonCodeCon");

$MainCon        	= new MainCon();
$SampleCon			= new SampleCon();
$SampleDetailCon	= new SampleDetailCon();
$ShopCon			= new ShopCon();
$ShopSampleCon		= new ShopSampleCon();
$ShopMultimediaCon	= new ShopMultimediaCon();
$GalleryCon			= new GalleryCon();
$GalleryPhotoCon 	= new GalleryPhotoCon();
$InvitationCon		= new InvitationCon();
$AppreciationCon	= new AppreciationCon();
$CommonCodeCon		= new CommonCodeCon();

/**
 *
 * @var pageing setting
 */
$thisPage = "/m/index.php";

/**
 * 
 * @var parameter setting
 */
$_m = $StringClass->getRequest('m');
$_p = $StringClass->getRequest('p');
$visual_html = "";
$gallery_html = "";
$write_html = "";
$map_html = "";
$appr_html = "";

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
		$sample_id = $main_info['sample_id'];
		$sparam = array();
		$sparam['shop_id'] = $main_info['shop_id'];
		$shop_result = $ShopCon->getShopList($sparam);
		if ($shop_result)
			$shop_info = $shop_result[0];
		// shop multimedia
		if ($main_info['shop_id'])
		{
			// 직접 등록한 맵
			$smparam = $sparam;
			$smparam['media_type'] = 1;
			$shop_multimedia = $ShopMultimediaCon->getShopMultimediaList($sparam);
			if ($shop_multimedia)
				$shop_map = $shop_multimedia[0];
		}
		
		$gly_result = $GalleryCon->getGalleryList($param);
		if ($gly_result)
			$gly_info = $gly_result[0];

		$ivt_result = $InvitationCon->getInvitationList($param);
		if ($ivt_result)
			$ivt_info = $ivt_result[0];
		
		$apr_result = $AppreciationCon->getAppreciationList($param);
		if ($apr_result)
			$apr_info = $apr_result[0];
		//$param["order_by"] = "30";

		$gpto_result = $GalleryPhotoCon->getGalleryPhotoList($param);

		// get gallery photo list
		$photo_list = array("1"=>array("photo_id"=>"", "photo_url"=>"", "order_no"=>"1")
				,"2"=>array("photo_id"=>"", "photo_url"=>"", "order_no"=>"2")
				,"3"=>array("photo_id"=>"", "photo_url"=>"", "order_no"=>"3"));
		
		foreach($gpto_result as $key=>$val)
		{
			$photo_list[$val["order_no"]]["photo_id"] = $val["photo_id"];
			$photo_list[$val["order_no"]]["photo_url"] = $val["photo_url"];
			$photo_list[$val["order_no"]]["order_no"] = $val["order_no"];
		}
		
		$MainCon->setCountMain($_m);
	}
}
else
{
	$StringClass->alertMsg('초대장 정보가 없습니다.','', '', 'CLOSE');
	exit;
}
//new dBug($shop_map);
/**
 * 
 * @var sample data setting
 */
// 종료일 지난경우 강제 처리
if ($main_info['show_date'] < date("Y-m-d"))
	$_p = "A";
	
$param['sample_id'] = $main_info['sample_id'];
if (!empty($_p)) $param['part'] = $_p;		// 페이지별 구분자 있을경우
$result = $SampleDetailCon->getSampleDetailList($param);
foreach($result as $key=>$val)
{
	switch ($val['part'])
	{
		case "M": $visual_html = $val['detail_html']; break;	// main
		case "I": $write_html = $val['detail_html']; break;	// invitation
		case "G": $gallery_html = $val['detail_html']; break;	// gallery
		case "Q": $map_html = $val['detail_html']; break;		// quickmenu
		case "A": $appr_html = $val['detail_html']; break;		// appreciation
	}
}

/**
 *
 * @var Data replace setting
 */

$_WEEK = array("1"=>"월","2"=>"화","3"=>"수","4"=>"목","5"=>"금","6"=>"토","7"=>"일");
// 시 분 초 년 월 일
$tmp_showday = mktime(substr($main_info['show_time'], 0, 2), substr($main_info['show_time'], 3, 2), 0, substr($main_info['show_date'], 5, 2), substr($main_info['show_date'], 8, 2), substr($main_info['show_date'], 0, 4));

$_month = date("n", $tmp_showday);
$_show_date = date("Y.m.d", $tmp_showday);
$_show_day = $_WEEK[date("N", $tmp_showday)];
$_show_time = date("A h:i", $tmp_showday);

/**
 * main page setting
 */
$main_info['father_hp'] = preg_replace("/[^0-9]*/s", "", $main_info['father_hp']);
$main_info['mother_hp'] = preg_replace("/[^0-9]*/s", "", $main_info['mother_hp']);

if (!strstr($main_info['father_hp'], "-") && !empty($main_info['father_hp']))
{
	$tmp_hp = $main_info['father_hp'];
	$main_info['father_hp'] = substr($tmp_hp, 0, 3)."-".substr($tmp_hp, 3, 4). "-".substr($tmp_hp, 7, 4);
}

if (!strstr($main_info['mother_hp'], "-") && !empty($main_info['mother_hp']))
{
	$tmp_hp = $main_info['mother_hp'];
	$main_info['mother_hp'] = substr($tmp_hp, 0, 3)."-".substr($tmp_hp, 3, 4). "-".substr($tmp_hp, 7, 4);
}

if (!empty($visual_html))
{	
	$visual_html = str_replace("@MID@"				, $_m, $visual_html);
	$visual_html = str_replace("@MONTH@"			, $_month, $visual_html);
	$visual_html = str_replace("@DDAY@"				, $main_info['dday'], $visual_html);
	$visual_html = str_replace("@BABY_NAME@"		, $main_info['baby_name'], $visual_html);
	$visual_html = str_replace("@FATHER_NAME@"		, $main_info['father_name'], $visual_html);
	$visual_html = str_replace("@MOTHER_NAME@"		, $main_info['mother_name'], $visual_html);
	$visual_html = str_replace("@BABY_NAME_LEN@"	, $main_info['baby_name'], $visual_html);
	$visual_html = str_replace("@FATHER_NAME_LEN@"	, $main_info['father_name'], $visual_html);
	$visual_html = str_replace("@MOTHER_NAME_LEN@"	, $main_info['mother_name'], $visual_html);
	$visual_html = str_replace("@FATHER_HP@"		, $main_info['father_hp'], $visual_html);
	$visual_html = str_replace("@MOTHER_HP@"		, $main_info['mother_hp'], $visual_html);
	$visual_html = str_replace("@SHOW_DATE@"		, $_show_date, $visual_html);
	$visual_html = str_replace("@SHOW_DAY@"			, $_show_day, $visual_html);
	$visual_html = str_replace("@SHOW_TIME@"		, $_show_time, $visual_html);
	$visual_html = str_replace("@SHOP_ADDR@"		, $shop_info['address'], $visual_html);
	$visual_html = str_replace("@SHOP_NAME@"		, $shop_info['shop_name'], $visual_html);
	$visual_html = str_replace("@HOLL_NAME@"		, $main_info['holl_name'], $visual_html);
	$visual_html = str_replace("@PHOTO@"			, $main_info['main_photo_url'], $visual_html);
	if ($rpto_result)
		$visual_html = str_replace("@RAN_PHOTO@"	, $photo_list[1]['photo_url'], $visual_html);
	else
		$visual_html = str_replace("@RAN_PHOTO@"	, "", $visual_html);
}
if (!empty($gallery_html))
{
	$gallery_html = str_replace("@MID@"				, $_m, $gallery_html);	
	$gallery_html = str_replace("@DDAY@"			, $main_info['dday'], $gallery_html);
	$gallery_html = str_replace("@SHOW_DATE@"		, $_show_date, $gallery_html);
	$gallery_html = str_replace("@SHOW_DAY@"		, $_show_day, $gallery_html);
	$gallery_html = str_replace("@SHOW_TIME@"		, $_show_time, $gallery_html);
	$gallery_html = str_replace("@SHOP_ADDR@"		, $shop_info['address'], $gallery_html);
	$gallery_html = str_replace("@SHOP_NAME@"		, $shop_info['shop_name'], $gallery_html);
	$gallery_html = str_replace("@HOLL_NAME@"		, $main_info['holl_name'], $gallery_html);
	$gallery_html = str_replace("@PHOTO_01@"		, $photo_list[1]['photo_url'], $gallery_html);
	$gallery_html = str_replace("@PHOTO_MEMO_01@"	, "", $gallery_html);
	$gallery_html = str_replace("@PHOTO_02@"		, $photo_list[2]['photo_url'], $gallery_html);
	$gallery_html = str_replace("@PHOTO_MEMO_02@"	, "", $gallery_html);
	$gallery_html = str_replace("@PHOTO_03@"		, $photo_list[3]['photo_url'], $gallery_html);
	$gallery_html = str_replace("@PHOTO_MEMO_03@"	, "", $gallery_html);
}
if (!empty($write_html))
{
	$write_html = str_replace("@MID@"				, $_m, $write_html);
	$write_html = str_replace("@MEMO@"				, nl2br($ivt_info['memo']), $write_html);
	$write_html = str_replace("@FATHER_NAME@"		, $main_info['father_name'], $write_html);
	$write_html = str_replace("@MOTHER_NAME@"		, $main_info['mother_name'], $write_html);
	$write_html = str_replace("@FATHER_HP@"			, $main_info['father_hp'], $write_html);
	$write_html = str_replace("@MOTHER_HP@"			, $main_info['mother_hp'], $write_html);
	$write_html = str_replace("@SHOW_DATE@"			, $_show_date, $write_html);
	$write_html = str_replace("@SHOW_DAY@"			, $_show_day, $write_html);
	$write_html = str_replace("@SHOW_TIME@"			, $_show_time, $write_html);
	$write_html = str_replace("@SHOP_ADDR@"			, $shop_info['address'], $write_html);
	$write_html = str_replace("@SHOP_NAME@"			, $shop_info['shop_name'], $write_html);	
	$write_html = str_replace("@HOLL_NAME@"			, $main_info['holl_name'], $write_html);
	$write_html = str_replace("@PHOTO@"				, $main_info['main_photo_url'], $write_html);
}
if (!empty($appr_html))
{
	$appr_html = str_replace("@MID@"				, $_m, $appr_html);	
	$appr_html = str_replace("@FATHER_NAME@"		, $main_info['father_name'], $appr_html);
	$appr_html = str_replace("@MOTHER_NAME@"		, $main_info['mother_name'], $appr_html);
	$appr_html = str_replace("@PHOTO@"				, $apr_info['app_photo_url'], $appr_html);
	$appr_html = str_replace("@MEMO@"				, nl2br($apr_info['memo']), $appr_html);
}

function addblank($txt, $len)
{
	if (strlen($txt) < $len)
	{
		for($i=$len-strlen($txt);$i<=$len;$i++)
			$txt .= "&nbsp;";
	}
	return $txt;
}

// css 분기처리
if ($sample_id == 3)
	$mobile_css = "mobile.css";
else
	$mobile_css = "new_mobile.css";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<title>데자뷰 스마트 초대장</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0, user-scalable=yes, target-dnsitydpi=medum-dpi">
<?php#<link href="http://fonts.googleapis.com/earlyaccess/nanumgothiccoding.css"  rel="stylesheet" type="text/css" />?>
<link rel="stylesheet" type="text/css" href="http://m.dejavu-m.com/css/<?=$mobile_css;?>">
<script type="text/javascript">
<!--
document.domain = 'dejavu-m.com';
//-->
</script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="http://m.dejavu-m.com/js/kakao.link.js"></script>
<script type="text/javascript">
<!--
var s_xloc = "<?=$shop_info['xlocation'];?>";
var s_yloc = "<?=$shop_info['ylocation'];?>";
var s_addr = "<?=$shop_info['address'];?> <?=$shop_info['shop_name'];?>";
var father_hp = "<?=$main_info['father_hp'];?>";
var mother_hp = "<?=$main_info['mother_hp'];?>";
var board_url ="http://m.dejavu-m.com/guestbook.php?m=<?=$_m;?>";
var gallery_url = "http://m.dejavu-m.com/gallery.php?m=<?=$_m;?>";
//var m_msg = "<?=$main_info['baby_name'];?> 돌잔치에 초대합니다";
var m_msg = "<?=$main_info['baby_name'];?> 돌잔치에 초대합니다\n\n아빠: <?=$main_info['father_name'];?> ♡ 엄마: <?=$main_info['mother_name'];?>\n날짜: <?=$_show_date;?>\n시간: <?=$_show_time;?>\n장소: <?=$shop_info['shop_name'];?>\n홀: <?=$main_info['holl_name'];?>\n\n행복한 우리 아가의 첫번째 생일잔치에 초대합니다.\n바쁘시더라도 참석해주시면\n더욱 행복한 자리가 될것입니다^^\n\n[스마트폰 초대장 보기]\n\nhttp://m.dejavu-m.com/?m=<?=$_m;?>\n※본 초대장은 <?=$shop_info['shop_name'];?> 협력업체인 데자뷰에서 제작되었으며\n스팸 주소가 아닌 엄마,아빠의 정성이 들어간 초대장입니다^^";
var m_url = "http://m.dejavu-m.com/?m=<?=$_m;?>";
var m_tag = "<?=$main_info['baby_name'];?> 돌잔치에 초대합니다";
var photo_2g_url = "<?=$main_info['photo_2g_url'];?>";
//-->
</script>
<script type="text/javascript" src="http://m.dejavu-m.com/js/common.js"></script>
<?php if (!empty($shop_map) && !empty($shop_map["file_url"])) { ?>
<script type="text/javascript">
$(document).ready(function () {
	$("#nmap").append("<img src='<?=$conf_mimg_shop_url.$shop_map["file_url"];?>' style='width:100%; border:0;' />");
});
</script>
<?php } else { ?>
<script type="text/javascript" src="http://openapi.map.naver.com/openapi/naverMap.naver?ver=2.0&key=<?=$naver_map_key;?>"></script>
<script type="text/javascript">
try {document.execCommand('BackgroundImageCache', false, true);} catch(e) {}

$(document).ready(function () {
	if ($("#nmap"))
	{
		var oPoint = new nhn.api.map.LatLng(s_xloc, s_yloc);
		nhn.api.map.setDefaultPoint('LatLng');
		oMap = new nhn.api.map.Map('nmap' ,{
					point : oPoint,
					zoom : 10,
					enableWheelZoom : true,
					enableDragPan : true,
					enableDblClickZoom : false,
					mapMode : 0,
					activateTrafficMap : false,
					activateBicycleMap : false,
					minMaxLevel : [ 1, 14 ],
					size : new nhn.api.map.Size($("#nmap").prop('offsetWidth'), $("#nmap").prop('offsetHeight'))
				});
		//줌 컨트롤을 생성합니다.
		var mapZoom=new	nhn.api.map.ZoomControl();
		mapZoom.setPosition({left:20,top:20});
		
		//지도 타입 버튼을 생성합니다.
		var mapType=new nhn.api.map.MapTypeBtn();
		mapType.setPosition({left:50,top:20});

		oMap.addControl(mapZoom);
		oMap.addControl(mapType);


		var oSize = new nhn.api.map.Size(28, 37);
		var oOffset = new nhn.api.map.Size(14, 37);
		var oIcon = new nhn.api.map.Icon('http://static.naver.com/maps2/icons/pin_spot2.png', oSize, oOffset);
		   
		var oMarker = new nhn.api.map.Marker(oIcon, { title : '<?=$shop_info['shop_name'];?>' });  //마커를 생성한다 
		oMarker.setPoint(oPoint); //마커의 좌표를 oPoint 에 저장된 좌표로 지정한다
		oMap.addOverlay(oMarker); //마커를 네이버 지도위에 표시한다
		 
		var oLabel = new nhn.api.map.MarkerLabel(); // 마커 라벨를 선언한다. 
		oMap.addOverlay(oLabel); // - 마커의 라벨을 지도에 추가한다. 
		oLabel.setVisible(true, oMarker); // 마커의 라벨을 보이게 설정한다.
	}

});
</script>
<?php } ?>
<script type="text/javascript" src="/js/html2canvas.js"></script>
<script type="text/javascript" src="/js/base64.js"></script>
<script type="text/javascript" src="/js/canvas2image.js"></script>
</head>
<body id="skin<?=$sample_id;?>">
	<?php 
	if ($main_info['view_type'] == 1)	// pageing 타입
	{
		echo stripslashes($visual_html);
		echo stripslashes($gallery_html);
		echo stripslashes($write_html);
		echo stripslashes($map_html);
		if ($_p == "A")
			echo stripslashes($appr_html);
	} else {
		echo stripslashes($visual_html);
		echo stripslashes($gallery_html);
		echo stripslashes($write_html);
		echo stripslashes($map_html);
		if ($_p == "A")
			echo stripslashes($appr_html);
	}
	?>
	<form id="frm2G" name="frm2G" method="post" action="2gimg.php" enctype="multipart/form-data" style="display:none;">
	<input type="hidden" id="main_id" name="main_id" value="<?=$_m;?>" />
	<input type="hidden" id="sample_id" name="sample_id" value="<?=$sample_id;?>" />
	<input type="hidden" id="img2g" name="img2g" value="" />
	</form>
</body>
</html>