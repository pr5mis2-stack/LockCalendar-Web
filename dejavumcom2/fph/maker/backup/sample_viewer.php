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
require_once($_SERVER["DOCUMENT_ROOT"]."/include/common_header.php");

import("class.controller.SampleDetailCon");

$SampleDetailCon    = new SampleDetailCon();

/**
 * 
 * @var pageing setting
 */
$thisPage = "/maker/sample_viewer.php";

/**
 * 
 * @var parameter setting
 */
$sample_id = $StringClass->getRequest('sample_id');
$part = $StringClass->getRequest('part');
$visual_html = "";
$gallery_html = "";
$write_html = "";
$map_html = "";
$appr_html = "";

$_WEEK = array("1"=>"월","2"=>"화","3"=>"수","4"=>"목","5"=>"금","6"=>"토","7"=>"일");

$param['sample_id'] = $sample_id;
if (!empty($part)) $param['part'] = $part;;		// 페이지별 구분자 있을경우
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
 * main page setting
 */
$dump_data = array();
$dump_data['MID'] = "1";
$dump_data['MONTH'] = "10";
$dump_data['DDAY'] = "100";
$dump_data['BABY_NAME'] = "홍길동";
$dump_data['FATHER_NAME'] = "홍아빠";
$dump_data['MOTHER_NAME'] = "이엄마";
$dump_data['FATHER_HP'] = "010-2345-6789";
$dump_data['MOTHER_HP'] = "010-2345-6789";
$dump_data['SHOW_DATE'] = "2013.09.01";
$dump_data['SHOW_DAY'] = "일";
$dump_data['SHOW_TIME'] = "오후 5:00";
$dump_data['SHOP_ADDR'] = "서울 금천구 가산동 550-1 IT캐슬 1동 905호";
$dump_data['SHOP_NAME'] = "데자뷰파티하우스";
$dump_data['HOLL_NAME'] = "러블리홀";
$dump_data['I_MEMO'] = "부모라는 이름을 선물하고\n큰 사랑과 감사를 가르쳐준 우리 아이가\n드디어 첫 생일을 맞이하였습니다.\n그동안 사랑을 베풀어 주신 모든 분들께\n감사의 마음을 전하기 위해\n조촐한 자리를 마련하였습니다.\n바쁘시더라도 참석해 주시면\n큰 기쁨이 되겠습니다.";
$dump_data['I_PHOTO'] = "";
$dump_data['A_MEMO'] = "사랑으로 축하해주신 모든분들께 보답하는 \n마음으로 건강하게 잘 키우겠습니다.";
$dump_data['A_PHOTO'] = "http://m.dejavu-m.com/data/sample_img/1/skin1_guide2.png";


if ($sample_id == "1")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/1/skin1_guide1.png";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/1/skin1_guide2.png";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/1/skin1_guide3.png";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/1/skin1_guide4.png";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "2")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/2/skin2_guide1.png";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/2/skin2_guide2.png";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/2/skin2_guide3.png";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/2/skin2_guide4.png";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "3")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/3/skin3_guide1.png";
	$dump_data['RAN_PHOTO'] = "http://m.dejavu-m.com/data/sample_img/3/skin3_guide2.png";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/3/skin3_guide3.png";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/3/skin3_guide4.png";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "4")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/4/sample_card_t1_01.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/4/sample_card_t1_02_1.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/4/sample_card_t1_02_2.jpg";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/4/sample_card_t1_02_3.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "5")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/5/sample_card_t2_01.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/5/sample_card_t2_02_1.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/5/sample_card_t2_02_2.jpg";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/5/sample_card_t2_02_3.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "6")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/6/sample_card_t3_01.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/6/sample_card_t3_02_1.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/6/sample_card_t3_02_2.jpg";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/6/sample_card_t3_02_3.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "7")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/7/sample_card_t3_01.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01'] = "http://m.dejavu-m.com/data/sample_img/7/sample_card_t3_02_1.jpg";
	$dump_data['PHOTO_MEMO_01'] = "";
	$dump_data['PHOTO_02'] = "http://m.dejavu-m.com/data/sample_img/7/sample_card_t3_02_2.jpg";
	$dump_data['PHOTO_MEMO_02'] = "";
	$dump_data['PHOTO_03'] = "http://m.dejavu-m.com/data/sample_img/7/sample_card_t3_02_3.jpg";
	$dump_data['PHOTO_MEMO_03'] = "";
}
else if ($sample_id == "8")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/6/sample_card_t3_01.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/6/sample_card_t3_02_1.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/6/sample_card_t3_02_2.jpg";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/6/sample_card_t3_02_3.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "9")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/6/sample_card_t3_01.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/6/sample_card_t2_02_1.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/1/skin1_guide3.png";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/6/sample_card_t2_02_3.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/1/skin1_guide1.png";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/1/skin1_guide2.png";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/1/skin1_guide3.png";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/1/skin1_guide4.png";
	$dump_data['PHOTO_MEMO_03']	= "";
}


/**
 * main page setting
 */
if (!empty($visual_html))
{
	$visual_html = str_replace("@MID@"				, $dump_data['MID'], $visual_html);
	$visual_html = str_replace("@MONTH@"			, $dump_data['MONTH'], $visual_html);
	$visual_html = str_replace("@DDAY@"				, $dump_data['DDAY'], $visual_html);
	$visual_html = str_replace("@BABY_NAME@"		, $dump_data['BABY_NAME'], $visual_html);
	$visual_html = str_replace("@FATHER_NAME@"		, $dump_data['FATHER_NAME'], $visual_html);
	$visual_html = str_replace("@MOTHER_NAME@"		, $dump_data['MOTHER_NAME'], $visual_html);
	$visual_html = str_replace("@BABY_NAME_LEN@"	, $dump_data['BABY_NAME'], $visual_html);
	$visual_html = str_replace("@FATHER_NAME_LEN@"	, $dump_data['FATHER_NAME'], $visual_html);
	$visual_html = str_replace("@MOTHER_NAME_LEN@"	, $dump_data['MOTHER_NAME'], $visual_html);
	$visual_html = str_replace("@FATHER_HP@"		, $dump_data['FATHER_HP'], $visual_html);
	$visual_html = str_replace("@MOTHER_HP@"		, $dump_data['MOTHER_HP'], $visual_html);
	$visual_html = str_replace("@SHOW_DATE@"		, $dump_data['SHOW_DATE'], $visual_html);
	$visual_html = str_replace("@SHOW_DAY@"			, $dump_data['SHOW_DAY'], $visual_html);
	$visual_html = str_replace("@SHOW_TIME@"		, $dump_data['SHOW_TIME'], $visual_html);
	$visual_html = str_replace("@SHOP_ADDR@"		, $dump_data['SHOP_ADDR'], $visual_html);
	$visual_html = str_replace("@SHOP_NAME@"		, $dump_data['SHOP_NAME'], $visual_html);
	$visual_html = str_replace("@HOLL_NAME@"		, $dump_data['HOLL_NAME'], $visual_html);
	$visual_html = str_replace("@PHOTO@"			, $dump_data['MAIN_PHOTO_URL'], $visual_html);
	$visual_html = str_replace("@RAN_PHOTO@"		, $dump_data['RAN_PHOTO'], $visual_html);
}
if (!empty($gallery_html))
{
	$gallery_html = str_replace("@MID@"				, $dump_data['MID'], $gallery_html);
	$gallery_html = str_replace("@DDAY@"			, $dump_data['DDAY'], $gallery_html);
	$gallery_html = str_replace("@SHOW_DATE@"		, $dump_data['SHOW_DATE'], $gallery_html);
	$gallery_html = str_replace("@SHOW_DAY@"		, $dump_data['SHOW_DAY'], $gallery_html);
	$gallery_html = str_replace("@SHOW_TIME@"		, $dump_data['SHOW_TIME'], $gallery_html);
	$gallery_html = str_replace("@SHOP_ADDR@"		, $dump_data['SHOP_ADDR'], $gallery_html);
	$gallery_html = str_replace("@SHOP_NAME@"		, $dump_data['SHOP_NAME'], $gallery_html);
	$gallery_html = str_replace("@HOLL_NAME@"		, $dump_data['HOLL_NAME'], $gallery_html);
	$gallery_html = str_replace("@PHOTO_01@"		, $dump_data['PHOTO_01'], $gallery_html);
	$gallery_html = str_replace("@PHOTO_MEMO_01@"	, $dump_data['PHOTO_MEMO_01'], $gallery_html);
	$gallery_html = str_replace("@PHOTO_02@"		, $dump_data['PHOTO_02'], $gallery_html);
	$gallery_html = str_replace("@PHOTO_MEMO_02@"	, $dump_data['PHOTO_MEMO_02'], $gallery_html);
	$gallery_html = str_replace("@PHOTO_03@"		, $dump_data['PHOTO_03'], $gallery_html);
	$gallery_html = str_replace("@PHOTO_MEMO_03@"	, $dump_data['PHOTO_MEMO_03'], $gallery_html);
}
if (!empty($write_html))
{
	$write_html = str_replace("@MID@"				, $dump_data['MID'], $write_html);
	$write_html = str_replace("@MEMO@"				, nl2br($dump_data['I_MEMO']), $write_html);
	$write_html = str_replace("@FATHER_NAME@"		, $dump_data['FATHER_NAME'], $write_html);
	$write_html = str_replace("@MOTHER_NAME@"		, $dump_data['MOTHER_NAME'], $write_html);
	$write_html = str_replace("@FATHER_HP@"			, $dump_data['FATHER_HP'], $write_html);
	$write_html = str_replace("@MOTHER_HP@"			, $dump_data['MOTHER_HP'], $write_html);
	$write_html = str_replace("@SHOW_DATE@"			, $dump_data['SHOW_DATE'], $write_html);
	$write_html = str_replace("@SHOW_DAY@"			, $dump_data['SHOW_DAY'], $write_html);
	$write_html = str_replace("@SHOW_TIME@"			, $dump_data['SHOW_TIME'], $write_html);
	$write_html = str_replace("@SHOP_ADDR@"			, $dump_data['SHOP_ADDR'], $write_html);
	$write_html = str_replace("@SHOP_NAME@"			, $dump_data['SHOP_NAME'], $write_html);
	$write_html = str_replace("@HOLL_NAME@"			, $dump_data['HOLL_NAME'], $write_html);
	$write_html = str_replace("@PHOTO@"				, $dump_data['MAIN_PHOTO_URL'], $write_html);
}
if (!empty($appr_html))
{
	$appr_html = str_replace("@MID@"				, $dump_data['MID'], $appr_html);
	$appr_html = str_replace("@FATHER_NAME@"		, $dump_data['FATHER_NAME'], $appr_html);
	$appr_html = str_replace("@MOTHER_NAME@"		, $dump_data['MOTHER_NAME'], $appr_html);
	$appr_html = str_replace("@PHOTO@"				, $dump_data['A_PHOTO'], $appr_html);
	$appr_html = str_replace("@MEMO@"				, nl2br($dump_data['A_MEMO']), $appr_html);
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
switch ($sample_id)
{
  case "8": $mobile_css = "mobile08.css";break;	// 샘플8
  case "9": $mobile_css = "mobile09.css";break;	// 샘플9
  default : $mobile_css = "new_mobile.css"; break;		// 기본
}
  if (!empty($appr_html))
    $mobile_css = "new_mobile.css";
?>
<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7" lang="ko"><![endif]-->
<!--[if IE 8]><html class="ie ie8" lang="ko"><![endif]-->
<!--[if gt IE 8]><!--><html lang="ko"><!--<![endif]-->
<head>
	<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" /><![endif]-->
	<meta charset="UTF-8" />
	<?php if ($main_info['sample_id'] >= "8" && empty($appr_html)) { ?>
	<meta name="viewport" content="width=device-width">
	<?php } else { ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-dnsitydpi=medum-dpi">
	<?php } ?>
<title>데자뷰 스마트 초대장</title>
<link rel="stylesheet" href="http://m.dejavu-m.com/css/<?=$mobile_css;?>">
<script type="text/javascript">
<!--
document.domain = 'dejavu-m.com';
//-->
</script>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<!--[if lt IE 9]>
<script src="http://m.dejavu-m.com/js/html5shiv.js"></script>
<![endif]-->
<script src="http://m.dejavu-m.com/js/flowtype.js"></script>
<script src="http://m.dejavu-m.com/js/scripts.js"></script>
<script src="http://m.dejavu-m.com/js/kakao.link.js"></script>
<script>
<!--
var s_xloc = "127.0641468";
var s_yloc = "37.0707467";
var s_addr = "경기도 평택시 서정동 779-1 플로랜스 파티하우스";
var father_hp = "010-2345-6789";
var mother_hp = "010-2345-6789";
var board_url ="http://m.dejavu-m.com/board.php?m=1";
var gallery_url = "http://m.dejavu-m.com/gallery.php?m=1";
var m_msg = "<?=$dump_data['BABY_NAME'];?>초대장";
var m_url = "http://m.dejavu-m.com/?m=1";
var m_tag = m_msg;
var photo_2g_url = "";
//-->
</script>
<script src="http://m.dejavu-m.com/js/common.js"></script>
<?php if (!empty($map_html)) { ?>
<script src="http://openapi.map.naver.com/openapi/naverMap.naver?ver=2.0&key=<?=$naver_wmap_key;?>"></script>
<script>
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
		   
		var oMarker = new nhn.api.map.Marker(oIcon, { title : '<?=$dump_data['SHOP_NAME'];?>' });  //마커를 생성한다 
		oMarker.setPoint(oPoint); //마커의 좌표를 oPoint 에 저장된 좌표로 지정한다
		oMap.addOverlay(oMarker); //마커를 네이버 지도위에 표시한다
		 
		var oLabel = new nhn.api.map.MarkerLabel(); // 마커 라벨를 선언한다. 
		oMap.addOverlay(oLabel); // - 마커의 라벨을 지도에 추가한다. 
		oLabel.setVisible(true, oMarker); // 마커의 라벨을 보이게 설정한다.
	}

});
</script>
<?php } ?>
</head>
<body id="skin<?=$sample_id;?>">
<?php
// 샘플8,9 에 html5형식 적용으로 인해 분기
if ($main_info['sample_id'] >= "8")
{
  echo "<div id='page'>";
	if ($main_info['view_type'] == 1)	// pageing 타입
	{
		echo stripslashes($visual_html);
		if (!empty($gallery_html) || !empty($write_html))
		  echo "<div id='main' class='site-main'><div id='content' class='page-content'>";
		echo stripslashes($gallery_html);
		echo stripslashes($write_html);
		if (!empty($gallery_html) || !empty($write_html))
		  echo "</div></div>";
		echo stripslashes($map_html);
		echo stripslashes($appr_html);
	} else {
		echo stripslashes($visual_html);
		if (!empty($gallery_html) || !empty($write_html))
		  echo "<div id='main' class='site-main'><div id='content' class='page-content'>";
		echo stripslashes($gallery_html);
		echo stripslashes($write_html);
		if (!empty($gallery_html) || !empty($write_html))
		  echo "</div></div>";
		echo stripslashes($map_html);
		echo stripslashes($appr_html);		
	}
  echo "</div>";
}
else
{
	if ($main_info['view_type'] == 1)	// pageing 타입
	{
		echo stripslashes($visual_html);
		echo stripslashes($gallery_html);
		echo stripslashes($write_html);
		echo stripslashes($map_html);
		echo stripslashes($appr_html);
	} else {
		echo stripslashes($visual_html);
		echo stripslashes($gallery_html);
		echo stripslashes($write_html);
		echo stripslashes($map_html);
		echo stripslashes($appr_html);		
	}  
}
?>
</body>
</html>