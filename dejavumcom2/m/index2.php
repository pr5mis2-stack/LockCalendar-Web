<?php
#ini_set("session.cookie_domain",".dejavu-m.com") ;
#session_start();
#session_cache_limiter("none");

#header("Cache-Control:no-cache");
#header("Pragma:no-cache");
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
import("class.controller.AdvertisementCon");

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
$AdvertisementCon	= new AdvertisementCon();

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
$_t = $StringClass->getRequest('t');
$_f = $StringClass->getRequest('f');

$default_html = "";	// css, div 등의 기본 포맷
$visual_html = "";	// 메인 html 내용
$gallery_html = "";	// 갤러리 html 내용
$write_html = "";	// 초대장 html 내용
$map_html = "";		// 지도 html 내용
$appr_html = "";	// 감사장 html 내용
$body_html = "";	// 최종 화면에 출력될 html

/**
 *
 * @var Default data setting
 */
// 초대장 아이디 없는 경우 예외처리 시작
if ($_m == "")
{
	$StringClass->alertMsg('초대장 정보가 없습니다.','', '', 'CLOSE');
	exit;
}

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

			$smparam['media_type'] = 3;
			$shop_multimedia = $ShopMultimediaCon->getShopVideoList($sparam);
			if ($shop_multimedia)
				$shop_video = $shop_multimedia[0];
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


		/**
		 *
		 * @var Data replace setting
		 */

		$_WEEK = array("1"=>"월","2"=>"화","3"=>"수","4"=>"목","5"=>"금","6"=>"토","7"=>"일");
		// 시 분 초 년 월 일
		$tmp_showday = mktime(substr($main_info['show_time'], 0, 2), substr($main_info['show_time'], 3, 2), 0, substr($main_info['show_date'], 5, 2), substr($main_info['show_date'], 8, 2), substr($main_info['show_date'], 0, 4));

		$_month = date("n", $tmp_showday);
		$_emonth = date("M", $tmp_showday);
		$_show_date = date("Y.m.d", $tmp_showday);
		$_show_edate = date("F d. Y", $tmp_showday);
		$_show_day = $_WEEK[date("N", $tmp_showday)];
		//$_show_eday = date("D", $tmp_showday);
		$_show_eday = $_WEEK[date("N", $tmp_showday)];
		$_show_time = str_replace("PM", "오후", str_replace("AM", "오전", date("A g:i", $tmp_showday)));
		$_show_etime = str_replace("pm", "오후", str_replace("am", "오전", date("a g:i", $tmp_showday)));
		//$_show_etime = date("a g:i", $tmp_showday);

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


		/**
		 *
		 * @var sample data setting
		 */
		// 종료일 지난경우 강제 처리
		if ($main_info['show_date'] < date("Y-m-d"))
			$_p = "A";

		// Default Format 추출
		$param['sample_id'] = $main_info['sample_id'];
		$param['part'] = 'D';		// 페이지별 구분자 있을경우
		$result = $SampleDetailCon->getSampleDetailList($param);
		foreach($result as $key=>$val)
		{
			$default_html = $val['detail_html']; break;
		}

		$param['part'] = (!empty($_p)) ? $_p : "";		// 페이지별 구분자 있을경우
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
		 * 데이터 문구 설정
		 */
		if ($_p == "A") {
			if ($main_info['type_value'] == "B") {	// 돌잔치
				$_m_tag = "{$main_info['baby_name']}의 첫번째 생일잔치";
				$_m_msg = "사랑으로 축하해주신 모든분들께 보답하는 마음으로 건강하게 잘 키우겠습니다. {$main_info['father_name']} {$main_info['mother_name']} 드림 ※본 초대장은 {$shop_info['shop_name']} 협력업체인 데자뷰에서 제작되었으며/n스팸 주소가 아닌 엄마,아빠의 정성이 들어간 초대장입니다^^";
			}
			else if ($main_info['type_value'] == "W") {	// 웨딩
			  if ($sample_id == "57")  //고희연 샘플3
				  $_m_tag = "{$main_info['father_name']}님의 고희연에 초대합니다";
				else if ($sample_id == "60")  //금혼식 샘플
				  $_m_tag = "신랑: {$main_info['father_name']} ♡ 신부: {$main_info['mother_name']} 금혼식";
				else if ($sample_id == "61")  //산수연 샘플
				  $_m_tag = "신랑: {$main_info['father_name']} ♡ 신부: {$main_info['mother_name']} 산수연";
				else
				  $_m_tag = "신랑: {$main_info['father_name']} ♡ 신부: {$main_info['mother_name']} 결혼식";
				$_m_msg = "사랑으로 축하해주신 모든분들께 보답하는 마음으로 행복하게 잘 살겠습니다. {$main_info['father_name']} {$main_info['mother_name']} 드림 ※본 초대장은 {$shop_info['shop_name']} 협력업체인 데자뷰에서 제작되었으며/n스팸 주소가 아닌 신랑,신부의 정성이 들어간 초대장입니다^^";
			}
			else if ($main_info['type_value'] == "S") {	// 고희연
				$_m_tag = "{$main_info['baby_name']}님의 고희연";
				$_m_msg = "소중한 자리에 참석하셔서 자리를 빛내주셔서 감사합니다. {$main_info['father_name']} {$main_info['mother_name']} 드림 ※본 초대장은 {$shop_info['shop_name']} 협력업체인 데자뷰에서 제작되었으며/n스팸 주소가 아닌 엄마,아빠의 정성이 들어간 초대장입니다^^";
			}

		} else {
			if ($main_info['type_value'] == "B") {	// 돌잔치
				$_m_tag = "{$main_info['baby_name']} 돌잔치에 초대합니다";

				if ($main_info['father_name'] != "" && $main_info['mother_name'] == "")
					$_m_msg = "아빠: {$main_info['father_name']}/n날짜: {$_show_date}/n시간: {$_show_time}/n장소: {$shop_info['shop_name']}/n홀: {$main_info['holl_name']}/n/n행복한 우리 아가의 첫번째 생일잔치에 초대합니다./n바쁘시더라도 참석해주시면/n더욱 행복한 자리가 될것입니다^^/n/n[스마트폰 초대장 보기]/n/nhttp://m.dejavu-m.com/?m={$_m}/n※본 초대장은 {$shop_info['shop_name']} 협력업체인 데자뷰에서 제작되었으며/n스팸 주소가 아닌 엄마,아빠의 정성이 들어간 초대장입니다^^";
				else if ($main_info['father_name'] == "" && $main_info['mother_name'] != "")
					$_m_msg = "엄마: {$main_info['mother_name']}/n날짜: {$_show_date}/n시간: {$_show_time}/n장소: {$shop_info['shop_name']}/n홀: {$main_info['holl_name']}/n/n행복한 우리 아가의 첫번째 생일잔치에 초대합니다./n바쁘시더라도 참석해주시면/n더욱 행복한 자리가 될것입니다^^/n/n[스마트폰 초대장 보기]/n/nhttp://m.dejavu-m.com/?m={$_m}/n※본 초대장은 {$shop_info['shop_name']} 협력업체인 데자뷰에서 제작되었으며/n스팸 주소가 아닌 엄마의 정성이 들어간 초대장입니다^^";
				else
					$_m_msg = "아빠: {$main_info['father_name']} ♡ 엄마: {$main_info['mother_name']}/n날짜: {$_show_date}/n시간: {$_show_time}/n장소: {$shop_info['shop_name']}/n홀: {$main_info['holl_name']}/n/n행복한 우리 아가의 첫번째 생일잔치에 초대합니다./n바쁘시더라도 참석해주시면/n더욱 행복한 자리가 될것입니다^^/n/n[스마트폰 초대장 보기]/n/nhttp://m.dejavu-m.com/?m={$_m}/n※본 초대장은 {$shop_info['shop_name']} 협력업체인 데자뷰에서 제작되었으며/n스팸 주소가 아닌 엄마,아빠의 정성이 들어간 초대장입니다^^";
			//}
			//else if ($main_info['type_value'] == "W") {	// 웨딩
				//$_m_tag = "신랑: {$main_info['father_name']} ♡ 신부: {$main_info['mother_name']} 결혼식에 초대합니다";
				//$_m_msg = "날짜: {$_show_date}/n시간: {$_show_time}/n장소: {$shop_info['shop_name']}/n홀: {$main_info['holl_name']}/n/n평생을 좋은 남편, 좋은 아내로 살겠습니다./n한 곳을 바라보며 첫발을 떼는 자리에 참석하시어 기쁨의 자리를 축복으로 더욱 빛내주시기 바랍니다./n/n[스마트폰 초대장 보기]/n/nhttp://m.dejavu-m.com/?m={$_m}/n※본 초대장은 {$shop_info['shop_name']} 협력업체인 데자뷰에서 제작되었으며/n스팸 주소가 아닌 신랑,신부의 정성이 들어간 초대장입니다^^";
			}
		  else if ($main_info['type_value'] == "W") {	// 웨딩
		    if ($sample_id == "57")  //고희연 샘플3
		      $_m_tag = "{$main_info['father_name']}님의 고희연에 초대합니다";
		    else if ($sample_id == "60")  //금혼식 샘플
				  $_m_tag = "신랑: {$main_info['father_name']} ♡ 신부: {$main_info['mother_name']} 금혼식에 초대합니다";
		    else if ($sample_id == "61")  //산수연 샘플
				  $_m_tag = "신랑: {$main_info['father_name']} ♡ 신부: {$main_info['mother_name']} 산수연에 초대합니다";
		    else if ($sample_id == "62")  //피로연 샘플
				  $_m_tag = "신랑: {$main_info['father_name']} ♡ 신부: {$main_info['mother_name']} 피로연에 초대합니다";
		    else if ($sample_id == "63")  //구순연 샘플
				  $_m_tag = "{$main_info['father_name']}님의 구순연에 초대합니다";
			else
				  $_m_tag = "신랑: {$main_info['father_name']} ♡ 신부: {$main_info['mother_name']} 결혼식에 초대합니다";
				$_m_msg = "날짜: {$_show_date}/n시간: {$_show_time}/n장소: {$shop_info['shop_name']}/n홀: {$main_info['holl_name']}";
			}
			else if ($main_info['type_value'] == "S") {	// 고희연
				if ($main_info['sample_id'] == 16 || $main_info['sample_id'] == 17)
					$_m_tag = "{$main_info['baby_name']}님의 회갑연에 초대합니다";
				else if ($main_info['sample_id'] == 18 || $main_info['sample_id'] == 19)
					$_m_tag = "{$main_info['baby_name']}님의 고희연에 초대합니다";
				else if ($main_info['sample_id'] == 20 || $main_info['sample_id'] == 21)
					$_m_tag = "{$main_info['baby_name']}님의 산수연에 초대합니다";
				else if ($main_info['sample_id'] == 22 || $main_info['sample_id'] == 23)
					$_m_tag = "{$main_info['baby_name']}님의 백수연에 초대합니다";
				else

					$_m_tag = "{$main_info['baby_name']}님의 생신연에 초대합니다";

				$_m_msg = "날짜: {$_show_date}/n시간: {$_show_time}/n장소: {$shop_info['shop_name']}/n홀: {$main_info['holl_name']}/n/n긴 세월동안 두터운 정을 키워오신 어르신분들과 친지분들을 모시고 소중한 자리를 마련하고자 합니다./n부디 참석하셔서 자리를 빛내주시면 더없는 기쁨이 되겠습니다./n/n[스마트폰 초대장 보기]/n/nhttp://m.dejavu-m.com/?m={$_m}/n※본 초대장은 {$shop_info['shop_name']} 협력업체인 데자뷰에서 제작되었으며/n스팸 주소가 아닌 자제분의 정성이 들어간 초대장입니다^^";
			}
		}

		// kakao image size check
		$kakao_width = 300;
		$kakao_height = 533;

		if (!empty($main_info['photo_2g_url']))
		{
			if (is_file($main_info['photo_2g_url']))
			{
				// http://m.dejavu-m.com/data/thumbnail_img/23669/2gimg.jpg
				list($width,$height,$type,$attr) = getimagesize(str_replace("http://m.dejavu-m.com/", "./", $main_info['photo_2g_url']));
				if ($width > 0 && $height > 0)
					$kakao_height = round(($height/$width) * 300);
			}
		}

		// 메인
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
			$visual_html = str_replace("@SHOW_EDATE@"		, $_show_edate, $visual_html);
			$visual_html = str_replace("@SHOW_EDAY@"		, $_show_eday, $visual_html);
			$visual_html = str_replace("@SHOW_ETIME@"		, $_show_etime, $visual_html);
			$address = (!empty($shop_info['address_etc']))? $shop_info['address']." ".$shop_info['address_etc']:$shop_info['address'];
			$visual_html = str_replace("@SHOP_ADDR@"		, $address, $visual_html);
			$visual_html = str_replace("@SHOP_NAME@"		, $shop_info['shop_name'], $visual_html);
			$visual_html = str_replace("@HOLL_NAME@"		, $main_info['holl_name'], $visual_html);
			$visual_html = str_replace("@PHOTO@"			, $main_info['main_photo_url'], $visual_html);
			if ($rpto_result)
				$visual_html = str_replace("@RAN_PHOTO@"	, $photo_list[1]['photo_url'], $visual_html);
			else
				$visual_html = str_replace("@RAN_PHOTO@"	, "", $visual_html);
		}
		// 갤러리
		if (!empty($gallery_html))
		{
			$gallery_html = str_replace("@MID@"				, $_m, $gallery_html);
			$gallery_html = str_replace("@DDAY@"			, $main_info['dday'], $gallery_html);
			$gallery_html = str_replace("@SHOW_DATE@"		, $_show_date, $gallery_html);
			$gallery_html = str_replace("@SHOW_DAY@"		, $_show_day, $gallery_html);
			$gallery_html = str_replace("@SHOW_TIME@"		, $_show_time, $gallery_html);
			$gallery_html = str_replace("@SHOW_EDATE@"		, $_show_edate, $gallery_html);
			$gallery_html = str_replace("@SHOW_EDAY@"		, $_show_eday, $gallery_html);
			$gallery_html = str_replace("@SHOW_ETIME@"		, $_show_etime, $gallery_html);
			$address = (!empty($shop_info['address_etc']))? $shop_info['address']." ".$shop_info['address_etc']:$shop_info['address'];
			$gallery_html = str_replace("@SHOP_ADDR@"		, $address, $gallery_html);
			$gallery_html = str_replace("@SHOP_NAME@"		, $shop_info['shop_name'], $gallery_html);
			$gallery_html = str_replace("@HOLL_NAME@"		, $main_info['holl_name'], $gallery_html);
			$gallery_html = str_replace("@PHOTO_01@"		, $photo_list[1]['photo_url'], $gallery_html);
			$gallery_html = str_replace("@PHOTO_MEMO_01@"	, "", $gallery_html);
			$gallery_html = str_replace("@PHOTO_02@"		, $photo_list[2]['photo_url'], $gallery_html);
			$gallery_html = str_replace("@PHOTO_MEMO_02@"	, "", $gallery_html);
			$gallery_html = str_replace("@PHOTO_03@"		, $photo_list[3]['photo_url'], $gallery_html);
			$gallery_html = str_replace("@PHOTO_MEMO_03@"	, "", $gallery_html);
			$gallery_html = str_replace("@PHOTO_04@"		, $photo_list[4]['photo_url'], $gallery_html);
			$gallery_html = str_replace("@PHOTO_MEMO_04@"	, "", $gallery_html);
			$gallery_html = str_replace("@FATHER_NAME@"		, $main_info['father_name'], $gallery_html);
			$gallery_html = str_replace("@MOTHER_NAME@"		, $main_info['mother_name'], $gallery_html);
			$gallery_html = str_replace("@BABY_NAME@"		, $main_info['baby_name'], $gallery_html);
		}
		// 초대글
		if (!empty($write_html))
		{
			$write_html = str_replace("@MID@"				, $_m, $write_html);
			if ($main_info['sample_id'] == 13)
				$write_html = str_replace("@MEMO@"			, str_replace("\n", "</span><span>", $ivt_info['memo']), $write_html);
			else
				$write_html = str_replace("@MEMO@"			, nl2br($ivt_info['memo']), $write_html);

			$write_html = str_replace("@DDAY@"				  , $main_info['dday'], $write_html);
			$write_html = str_replace("@FATHER_NAME@"		, $main_info['father_name'], $write_html);
			$write_html = str_replace("@MOTHER_NAME@"		, $main_info['mother_name'], $write_html);
			$write_html = str_replace("@BABY_NAME@"		  , $main_info['baby_name'], $write_html);
			$write_html = str_replace("@FATHER_HP@"			, $main_info['father_hp'], $write_html);
			$write_html = str_replace("@MOTHER_HP@"			, $main_info['mother_hp'], $write_html);
			$write_html = str_replace("@SHOW_DATE@"			, $_show_date, $write_html);
			$write_html = str_replace("@SHOW_DAY@"			, $_show_day, $write_html);
			$write_html = str_replace("@SHOW_TIME@"			, $_show_time, $write_html);
			$write_html = str_replace("@SHOW_EDATE@"		, $_show_edate, $write_html);
			$write_html = str_replace("@SHOW_EDAY@"			, $_show_eday, $write_html);
			$write_html = str_replace("@SHOW_ETIME@"		, $_show_etime, $write_html);
			$address = (!empty($shop_info['address_etc']))? $shop_info['address']." ".$shop_info['address_etc']:$shop_info['address'];
			$write_html = str_replace("@SHOP_ADDR@"			, $address, $write_html);
			$write_html = str_replace("@SHOP_NAME@"			, $shop_info['shop_name'], $write_html);
			$write_html = str_replace("@HOLL_NAME@"			, $main_info['holl_name'], $write_html);
			$write_html = str_replace("@PHOTO@"				, $main_info['main_photo_url'], $write_html);
		}
		if (!empty($map_html))
		{
			$map_html = str_replace("@MID@"					, $_m, $map_html);
			$map_html = str_replace("@DDAY@"				, $main_info['dday'], $map_html);
			$address = (!empty($shop_info['address_etc']))? $shop_info['address']." ".$shop_info['address_etc']:$shop_info['address'];
			$map_html = str_replace("@SHOP_ADDR@"			, $address, $map_html);
			$map_html = str_replace("@SHOP_NAME@"			, $shop_info['shop_name'], $map_html);
			$map_html = str_replace("@HOLL_NAME@"			, $main_info['holl_name'], $map_html);

		}
		// 감사장
		if (!empty($appr_html))
		{
			$appr_html = str_replace("@MID@"				, $_m, $appr_html);
			$appr_html = str_replace("@FATHER_NAME@"		, $main_info['father_name'], $appr_html);
			$appr_html = str_replace("@MOTHER_NAME@"		, $main_info['mother_name'], $appr_html);
    	//$appr_html = str_replace("@PHOTO@"				, $apr_info['app_photo_url'], $appr_html);
    	//감사장 사진없는 경우 엑박 제거
    	if (!empty($apr_info['app_photo_url'])) {
    	  $tmp_img = str_replace("@PHOTO@", $apr_info['app_photo_url'], "<img src='@PHOTO@' height='100%' alt='' />");
    	  $appr_html = str_replace("@PHOTO@"				, $tmp_img, $appr_html);
    	}
    	else
    	  $appr_html = str_replace("@PHOTO@"				, "", $appr_html);
			$appr_html = str_replace("@MEMO@"				, nl2br($apr_info['memo']), $appr_html);
		}
	}
} // 초대장 아이디 없는 경우 예외처리 끝


/* function addblank($txt, $len)
{
	if (strlen($txt) < $len)
	{
		for($i=$len-strlen($txt);$i<=$len;$i++)
			$txt .= "&nbsp;";
	}
	return $txt;
} */

// css 분기처리
if ($_f == "n") // 2G이미지 생성용 외부폰트 제거 css
{
	$default_html = str_replace("new_mobile.css", "non_font_mobile.css", $default_html);
	$default_html = str_replace("mobile09.css", "non_font_mobile09.css", $default_html);
	$default_html = str_replace("mobile11.css", "non_font_mobile11.css", $default_html);
	$default_html = str_replace("mobile12.css", "non_font_mobile12.css", $default_html);
	$default_html = str_replace("mobile13.css", "non_font_mobile13.css", $default_html);
	$default_html = str_replace("mobile14.css", "non_font_mobile14.css", $default_html);
	$default_html = str_replace("mobile15.css", "non_font_mobile15.css", $default_html);
	$default_html = str_replace("mobile16.css", "non_font_mobile16.css", $default_html);
	$default_html = str_replace("type2_1.css", "non_font_type2_1.css", $default_html);
	$default_html = str_replace("type2_2.css", "non_font_type2_2.css", $default_html);
	$default_html = str_replace("type2_5.css", "non_font_type2_5.css", $default_html);
	$default_html = str_replace("type1_1.css", "non_font_type1_1.css", $default_html);
	$default_html = str_replace("type1_2.css", "non_font_type1_2.css", $default_html);
}
else
{
	// 기간종료 감사글인 경우 기본 css이용
	if ($_p == "A")
  	{
		$default_html = str_replace("mobile08.css", "new_mobile.css", $default_html);
		$default_html = str_replace("mobile09.css", "new_mobile.css", $default_html);
		$default_html = str_replace("mobile11.css", "new_mobile.css", $default_html);
		$default_html = str_replace("mobile12.css", "new_mobile.css", $default_html);
		$default_html = str_replace("mobile13.css", "new_mobile.css", $default_html);
		$default_html = str_replace("mobile14.css", "new_mobile.css", $default_html);
		$default_html = str_replace("mobile15.css", "new_mobile.css", $default_html);
		$default_html = str_replace("mobile16.css", "new_mobile.css", $default_html);
  	}
}


// metatag 적용
$metatag_html = "";
if ($_f != "n") // 2G이미지 생성용 script 제거
{
	$metatag_html .= "<meta property=\"og:site_name\" content=\"데자뷰 스마트 초대장\"/>\n";
	$metatag_html .= "<meta property=\"og:type\" content=\"invitation\"/>\n";
	$metatag_html .= "<meta property=\"og:url\" content=\"http://m.dejavu-m.com/?m={$_m}\"/>\n";
	$metatag_html .= "<meta property=\"og:image\" content=\"{$main_info['main_photo_url']}\" />\n";
	$metatag_html .= "<meta property=\"og:title\" content=\"". str_replace("/n", "", $_m_tag) ."\"/>\n";
	$metatag_html .= "<meta property=\"og:description\" content=\"". str_replace("/n", "", $_m_msg) ."\"/>\n";
}
$default_html = str_replace("<!--@METATAG@-->", $metatag_html, $default_html);

// script 적용
$script_html = "";
if ($_f != "n") // 2G이미지 생성용 script 제거
{
	#$script_html .= "<script src=\"http://m.dejavu-m.com/js/kakao.link.js\"></script>";
	$script_html .= "<script src=\"https://developers.kakao.com/sdk/js/kakao.min.js\"></script>";

	$script_html .= "<script>\n";
	$script_html .= "<!--\n";
	$script_html .= "var s_xloc = \"{$shop_info['xlocation']}\";\n";
	$script_html .= "var s_yloc = \"{$shop_info['ylocation']}\";\n";
	$script_html .= "var s_addr = \"{$shop_info['address']} {$shop_info['shop_name']}\";\n";
	$script_html .= "var father_hp = \"{$main_info['father_hp']}\";\n";
	$script_html .= "var mother_hp = \"{$main_info['mother_hp']}\";\n";
	$script_html .= "var m_tag = \"{$_m_tag}\";\n";
	$script_html .= "var m_msg = \"{$_m_msg}\";\n";
	$script_html .= "var m_url = \"http://m.dejavu-m.com/?m={$_m}\";\n";
	$script_html .= "var board_url = \"http://m.dejavu-m.com/guestbook.php?m={$_m}\";\n";
	$script_html .= "var gallery_url = \"http://m.dejavu-m.com/gallery.php?m={$_m}\";\n";
	$script_html .= "var photo_2g_url = \"{$main_info['photo_2g_url']}\";\n";
	$script_html .= "//-->\n";
	$script_html .= "</script>";

	if (!empty($shop_map) && !empty($shop_map["file_url"])) {
		$script_html .= "<script>\n";
		$script_html .= "$(document).ready(function () {\n";
		$script_html .= "	$(\"#nmap\").append(\"<img src='{$conf_mimg_shop_url}{$shop_map["file_url"]}' style='width:100%; border:0;' />\");\n";
		$script_html .= "});\n";
		$script_html .= "</script>\n";
	} else {
		$script_html .= "<script type=\"text/javascript\" src=\"http://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId={$naver_map_key_v3}\"></script>\n";
		$script_html .= "<script>\n";
		$script_html .= "try {document.execCommand('BackgroundImageCache', false, true);} catch(e) {}\n";
		$script_html .= "$(document).ready(function () {\n";
		$script_html .= "	if ($(\"#nmap\")) {\n";
		$script_html .= "		$(\".map_area\").attr(\"style\", \"margin-bottom:0px;\");\n";
		$script_html .= "		$(\"#nmap\").html(\"<iframe src='./map.php?shop_id={$shop_info["shop_id"]}' width='100%' height='300' scrolling='no' frameborder='0' allowtransparency='true'></iframe>\");\n";
		$script_html .= "	}\n";
		$script_html .= "});\n";
		$script_html .= "</script>\n";
	}
}

$default_html = str_replace("<!--@SCRIPT@-->", $script_html, $default_html);

if ($_t != "p") { include_once(__DIR__ . "/video.php"); }

if ($_p == "A") {
	$body_html .= $appr_html;		// 감사장
} else {
	if ($main_info['type_value'] == "B") {
		$body_html .= $visual_html;		// 메인
		$body_html .= $gallery_html;	// 겔러리
    if ($main_info['is_invitation'] == "1")
		  $body_html .= $write_html;		// 초대글
		$body_html .= $map_html;		// 퀵메뉴
	} else {
		$body_html .= $visual_html;		// 메인
		if ($main_info['is_invitation'] == "1")
		  $body_html .= $write_html;		// 초대글
		$body_html .= $gallery_html;	// 겔러리
		$body_html .= $map_html;		// 퀵메뉴
	}
}

// 기본 html 내용이 있는 경우
if ($default_html != "")
	$body_html = str_replace("@BODY@", $body_html, $default_html);

$body_html = str_replace("/n", "\\n", stripslashes($body_html));

// navermap 직접 호출
$from_map1 = 'href="#" class="btn-naver-map" onclick="return false;" id="btn_nmap"';
$to_map1 = 'href="http://m.map.naver.com/map.nhn?lat='. $shop_info['xlocation'] .'&lng='. $shop_info['ylocation'] .'&dlevel=11&title='. $shop_info['address'] .' '. $shop_info['shop_name'] .'&isShowPolygon=true&isDetailAddress=true" target="_blank" class="btn-naver-map map_link_new"';
$body_html = str_replace($from_map1, $to_map1, $body_html);

$from_map2 = 'href="#" onclick="return false;" id="btn_nmap"';
$to_map2 = 'href="http://m.map.naver.com/map.nhn?lat='. $shop_info['xlocation'] .'&lng='. $shop_info['ylocation'] .'&dlevel=11&title='. $shop_info['address'] .' '. $shop_info['shop_name'] .'&isShowPolygon=true&isDetailAddress=true" target="_blank" class="btn1 map_link_new"';
$body_html = str_replace($from_map2, $to_map2, $body_html);

echo $body_html;

//if ($_t != "p" && $_p != "A" && $sample_id != "43" &&  $sample_id != "44") { include_once(__DIR__ . "/banner.php"); }
//계좌번호 정보 노출
if ($_p != "A" && $main_info['is_bank'] == "1")
	include_once(__DIR__ . "/bank.php");

if ($_t != "p" && $_p != "A") { include_once(__DIR__ . "/banner.php"); }
?>
<form id="frm2G" name="frm2G" action="2gimg.php" style="display:none;">
<input type="hidden" id="t" name="t" value="p" />
<input type="hidden" id="main_id" name="main_id" value="<?=$_m;?>" />
</form>
<?php
if ($_f != "n") // 2G이미지 생성용 script 제거
{
?>
<script>
  //<![CDATA[
    Kakao.init('1b9abb71fd6d5a09de64f5d80218542c');
    Kakao.Link.createDefaultButton({
      container: '#btn_kakao',
      objectType: 'feed',
      content: {
        title: m_tag,
        description: m_msg,
        imageUrl: '<?=$main_info['main_photo_url'];?>',
        link: {
            mobileWebUrl: m_url,
            webUrl: m_url
        }
      },
      buttons: [
        {
          title: '초대장 바로가기',
          link: {
            mobileWebUrl: m_url,
            webUrl: m_url
          }
        }
      ]
    });
		KakaoStorySend = function(url, msg, cont, img)
		{
		    Kakao.Story.share({
		      url: url,
		      text: msg +'\n\n' + cont
		    });
		}

  //]]>
</script>
<?php
}
?>
<?php
//업체별 신규 네이버지도, BGM
include_once(__DIR__ . "/shop_bgm.php");
include_once(__DIR__ . "/layer.php");
?>