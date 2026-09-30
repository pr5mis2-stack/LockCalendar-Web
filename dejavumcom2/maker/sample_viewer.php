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

import("class.controller.SampleCon");
import("class.controller.SampleDetailCon");

$SampleCon			= new SampleCon();
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

$default_html = "";	// css, div 등의 기본 포맷
$visual_html = "";	// 메인 html 내용
$gallery_html = "";	// 갤러리 html 내용
$write_html = "";	// 초대장 html 내용
$map_html = "";		// 지도 html 내용
$appr_html = "";	// 감사장 html 내용
$body_html = "";	// 최종 화면에 출력될 html

$_WEEK = array("1"=>"월","2"=>"화","3"=>"수","4"=>"목","5"=>"금","6"=>"토","7"=>"일");

// Sample 기본정보 추출
$param['sample_id'] = $sample_id;
$result = $SampleCon->getSampleList($param);
if ($result)
	$sample_info = $result[0];


// Default Format 추출
$param['part'] = 'D';		// 페이지별 구분자 있을경우
$result = $SampleDetailCon->getSampleDetailList($param);
foreach($result as $key=>$val)
{
	$default_html = $val['detail_html']; break;
}

// 기타 내용 추출
$param['part'] = (!empty($part)) ? $part : "";		// 페이지별 구분자 있을경우
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
if ($sample_info['sample_type'] == 'B') {
	$dump_data['BABY_NAME'] = "홍길동";
	$dump_data['FATHER_NAME'] = "홍아빠";
	$dump_data['MOTHER_NAME'] = "이엄마";
	$dump_data['I_MEMO'] = "부모라는 이름을 선물하고\n큰 사랑과 감사를 가르쳐준 우리 아이가\n드디어 첫 생일을 맞이하였습니다.\n그동안 사랑을 베풀어 주신 모든 분들께\n감사의 마음을 전하기 위해\n조촐한 자리를 마련하였습니다.\n바쁘시더라도 참석해 주시면\n큰 기쁨이 되겠습니다.";
	$dump_data['A_MEMO'] = "사랑으로 축하해주신 모든분들께 보답하는 \n마음으로 건강하게 잘 키우겠습니다.";
	$dump_data['A_PHOTO'] = "//www.dejavu-m.com/data/sample_img/1/skin1_guide2.png";
} else if ($sample_info['sample_type'] == 'W') {
	$dump_data['BABY_NAME'] = "";
	$dump_data['FATHER_NAME'] = "유국판";
	$dump_data['MOTHER_NAME'] = "이재영";
	if ($sample_info['sample_id'] == 13)
		$dump_data['I_MEMO'] = "<span>각자 서로 다른길을 걸어온 저희가</span><span>이제 부부의 연으로</span><span>한 길을 걸어가고자 합니다</span><span>평생을 좋은 남편, 좋은 아내로 살겠습니다</span><span>한 곳을 바라보며</span><span>첫발을 떼는 자리에 참석하시어</span><span>기쁨의 자리를</span><span>축복으로 더욱 빛내주시기 바랍니다</span>";
	else
		$dump_data['I_MEMO'] = "서로의 이름을 부르는 것만으로도\n사랑의 깊이를 확인 할 수 있는 두 사람이\n꽃과 나무처럼 걸어와서\n서로의 모든것이 되기위해\n오랜 기다림 끝에 혼례식을 치르는 날\n세상은 더욱 아름다워라.\n\n<이혜인 - 사랑의 사람들이여>";

	$dump_data['A_MEMO'] = "바쁘신 와중에도<br/>저희 결혼식에 참석하셔서<br/>축하와 호의를 베풀어 주신데 대하여<br/>진심으로 감사의 말씀을 전합니다.<br/>서로 아끼고 사랑하며 진실 된 마음으로<br/>함께 할 것을 약속드립니다.<br/>감사합니다.";
	$dump_data['A_PHOTO'] = "//www.dejavu-m.com/data/sample_img/1/skin1_guide2.png";
} else if ($sample_info['sample_type'] == 'S') {
	$dump_data['BABY_NAME'] = "고희연";
	$dump_data['FATHER_NAME'] = "홍길동";
	$dump_data['MOTHER_NAME'] = "";
	$dump_data['I_MEMO'] = "긴 세월동안 두터운 정을 키워오신<br/>어르신들과 친지분들을 모시고<br/>소중한 자리를 마련하고자 합니다.<br/>부디 참석하셔서 자리를 빛내주시면<br/>더없는 기쁨이 되겠습니다.";
	$dump_data['A_MEMO'] = "귀한시간 내주시어<br/>저희 부모님의 생신연을 함께 해 주시어<br/>진심으로 감사드립니다.";
	$dump_data['A_PHOTO'] = "";
}
$dump_data['FATHER_HP'] = "010-2345-6789";
$dump_data['MOTHER_HP'] = "010-2345-6789";
$dump_data['SHOW_DATE'] = "2017.12.17";
$dump_data['SHOW_EDATE'] = "DECEMBER 17. 2016";
$dump_data['SHOW_DAY'] = "일";
$dump_data['SHOW_TIME'] = "오후 5:00";
$dump_data['SHOW_EDAY'] = "일";
$dump_data['SHOW_ETIME'] = "오후 5:00";
$dump_data['SHOP_ADDR'] = "서울 금천구 가산동 550-1 IT캐슬 1동 905호";
$dump_data['SHOP_NAME'] = "데자뷰파티하우스";
$dump_data['HOLL_NAME'] = "러블리홀";
$dump_data['I_PHOTO'] = "";

if ($sample_id == "1")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/baby/1/skin1_guide1.png";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/baby/1/skin1_guide2.png";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/baby/1/skin1_guide3.png";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/baby/1/skin1_guide4.png";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "2")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/baby/2/skin2_guide1.png";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/baby/2/skin2_guide2.png";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/baby/2/skin2_guide3.png";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/baby/2/skin2_guide4.png";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "3")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/baby/3/skin3_guide1.png";
	$dump_data['RAN_PHOTO'] = "http://m.dejavu-m.com/data/sample_img/baby/3/skin3_guide2.png";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/baby/3/skin3_guide3.png";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/baby/3/skin3_guide4.png";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "4")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/baby/4/sample_card_t1_01.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/baby/4/sample_card_t1_02_1.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/baby/4/sample_card_t1_02_2.jpg";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/baby/4/sample_card_t1_02_3.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "5")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/baby/5/sample_card_t2_01.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/baby/5/sample_card_t2_02_1.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/baby/5/sample_card_t2_02_2.jpg";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/baby/5/sample_card_t2_02_3.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "6")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t3_01.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t3_02_1.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t3_02_2.jpg";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t3_02_3.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "7")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/baby/7/sample_card_t3_01.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01'] = "http://m.dejavu-m.com/data/sample_img/baby/7/sample_card_t3_02_1.jpg";
	$dump_data['PHOTO_MEMO_01'] = "";
	$dump_data['PHOTO_02'] = "http://m.dejavu-m.com/data/sample_img/baby/7/sample_card_t3_02_2.jpg";
	$dump_data['PHOTO_MEMO_02'] = "";
	$dump_data['PHOTO_03'] = "http://m.dejavu-m.com/data/sample_img/baby/7/sample_card_t3_02_3.jpg";
	$dump_data['PHOTO_MEMO_03'] = "";
}
else if ($sample_id == "8")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t3_01.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t3_02_1.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t3_02_2.jpg";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t3_02_3.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "9")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t3_01.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t2_02_1.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/baby/1/skin1_guide3.png";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t2_02_3.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "10")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t3_01.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t3_02_1.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t3_02_2.jpg";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t3_02_3.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "11")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t3_01.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t1_02_1.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t1_02_2.jpg";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t1_02_3.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "12")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t1_03.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t1_02_1.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t1_02_2.jpg";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/baby/6/sample_card_t1_02_3.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "13")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/wedding/13/header_img.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/wedding/13/section02_img1.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/wedding/13/section02_img2.jpg";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/wedding/13/section02_img3.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
	$dump_data['PHOTO_04']	= "http://m.dejavu-m.com/data/sample_img/wedding/13/section02_img4.jpg";
	$dump_data['PHOTO_MEMO_04']	= "";
	$dump_data['A_PHOTO']	= "http://m.dejavu-m.com/data/sample_img/wedding/13/thanks_img.jpg";
}
else if ($sample_id == "14")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/wedding/14/header_img.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/wedding/14/section02_img1.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/wedding/14/section02_img2.jpg";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/wedding/14/section02_img3.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
	$dump_data['PHOTO_04']	= "http://m.dejavu-m.com/data/sample_img/wedding/14/section02_img4.jpg";
	$dump_data['PHOTO_MEMO_04']	= "";
	$dump_data['A_PHOTO']	= "http://m.dejavu-m.com/data/sample_img/wedding/14/thanks_img.jpg";
}
else if ($sample_id == "15")
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/wedding/15/header_img.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/wedding/15/section02_img1.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/wedding/15/section02_img2.jpg";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/wedding/15/section02_img3.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
	$dump_data['PHOTO_04']	= "http://m.dejavu-m.com/data/sample_img/wedding/15/section02_img4.jpg";
	$dump_data['PHOTO_MEMO_04']	= "";
	$dump_data['A_PHOTO']	= "http://m.dejavu-m.com/data/sample_img/wedding/15/thanks_img.jpg";
}
else if ($sample_id == "41")  // sample11
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/baby/13/img_demo_1.png";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/baby/13/img_demo_2.png";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/baby/13/img_demo_3.png";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/baby/13/img_demo_4.png";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "42")  // sample12
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/baby/14/img_demo_1.png";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/baby/14/img_demo_2.png";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/baby/14/img_demo_3.png";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/baby/14/img_demo_4.png";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "43")  // sample13
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/baby/15/img_demo_1.png";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/baby/15/img_demo_2.png";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/baby/15/img_demo_3.png";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "44")  // sample14
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/baby/16/img_demo_1.png";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/baby/16/img_demo_2.png";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/baby/16/img_demo_3.png";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/baby/16/img_demo_4.png";
	$dump_data['PHOTO_MEMO_03']	= "";
}
else if ($sample_id == "55")  //웨딩 샘플44
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/wedding/55/images/img2.jpg";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/wedding/55/images/gallery_img1.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/wedding/55/images/gallery_img2.jpg";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/wedding/55/images/gallery_img3.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
	$dump_data['PHOTO_04']	= "http://m.dejavu-m.com/data/sample_img/wedding/55/images/gallery_img4.jpg";
	$dump_data['PHOTO_MEMO_04']	= "";
	$dump_data['A_PHOTO']	= "http://m.dejavu-m.com/data/sample_img/wedding/15/thanks_img.jpg";
}
else if ($sample_id == "56")  //웨딩 샘플5
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/wedding/56/images/img2.png";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/wedding/56/images/gallery_img1.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/wedding/56/images/gallery_img2.jpg";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/wedding/56/images/gallery_img3.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
	$dump_data['PHOTO_04']	= "http://m.dejavu-m.com/data/sample_img/wedding/56/images/gallery_img4.jpg";
	$dump_data['PHOTO_MEMO_04']	= "";
	$dump_data['A_PHOTO']	= "http://m.dejavu-m.com/data/sample_img/wedding/15/thanks_img.jpg";
}
else if ($sample_id == "57")  //고희연 샘플3
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/silver/57/images/img1.png";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/silver/57/images/img01.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/silver/57/images/img02.jpg";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/silver/57/images/img03.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
	$dump_data['PHOTO_04']	= "http://m.dejavu-m.com/data/sample_img/silver/57/images/img04.jpg";
	$dump_data['PHOTO_MEMO_04']	= "";
	$dump_data['A_PHOTO']	= "http://m.dejavu-m.com/data/sample_img/wedding/15/thanks_img.jpg";
}
else if ($sample_id == "66")  //돌잔치 샘플15
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/baby/66/images/img.png";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/baby/66/images/img02.jpg";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/baby/66/images/img03.jpg";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/baby/66/images/img04.jpg";
	$dump_data['PHOTO_MEMO_03']	= "";
	$dump_data['PHOTO_04']	= "http://m.dejavu-m.com/data/sample_img/baby/66/images/img05.jpg";
	$dump_data['PHOTO_MEMO_04']	= "";
	$dump_data['A_PHOTO']	= "http://m.dejavu-m.com/data/sample_img/baby/66/images/img.png";
}
else
{
	$dump_data['MAIN_PHOTO_URL'] = "http://m.dejavu-m.com/data/sample_img/baby/1/skin1_guide1.png";
	$dump_data['RAN_PHOTO'] = "";
	$dump_data['PHOTO_01']	= "http://m.dejavu-m.com/data/sample_img/baby/1/skin1_guide2.png";
	$dump_data['PHOTO_MEMO_01']	= "";
	$dump_data['PHOTO_02']	= "http://m.dejavu-m.com/data/sample_img/baby/1/skin1_guide3.png";
	$dump_data['PHOTO_MEMO_02']	= "";
	$dump_data['PHOTO_03']	= "http://m.dejavu-m.com/data/sample_img/baby/1/skin1_guide4.png";
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
	$visual_html = str_replace("@SHOW_EDATE@"		, $dump_data['SHOW_EDATE'], $visual_html);
	$visual_html = str_replace("@SHOW_EDAY@"		, $dump_data['SHOW_EDAY'], $visual_html);
	$visual_html = str_replace("@SHOW_ETIME@"		, $dump_data['SHOW_ETIME'], $visual_html);
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
	$gallery_html = str_replace("@SHOW_EDATE@"		, $dump_data['SHOW_EDATE'], $gallery_html);
	$gallery_html = str_replace("@SHOW_EDAY@"		, $dump_data['SHOW_EDAY'], $gallery_html);
	$gallery_html = str_replace("@SHOW_ETIME@"		, $dump_data['SHOW_ETIME'], $gallery_html);
	$gallery_html = str_replace("@SHOP_ADDR@"		, $dump_data['SHOP_ADDR'], $gallery_html);
	$gallery_html = str_replace("@SHOP_NAME@"		, $dump_data['SHOP_NAME'], $gallery_html);
	$gallery_html = str_replace("@HOLL_NAME@"		, $dump_data['HOLL_NAME'], $gallery_html);
	$gallery_html = str_replace("@PHOTO_01@"		, $dump_data['PHOTO_01'], $gallery_html);
	$gallery_html = str_replace("@PHOTO_MEMO_01@"	, $dump_data['PHOTO_MEMO_01'], $gallery_html);
	$gallery_html = str_replace("@PHOTO_02@"		, $dump_data['PHOTO_02'], $gallery_html);
	$gallery_html = str_replace("@PHOTO_MEMO_02@"	, $dump_data['PHOTO_MEMO_02'], $gallery_html);
	$gallery_html = str_replace("@PHOTO_03@"		, $dump_data['PHOTO_03'], $gallery_html);
	$gallery_html = str_replace("@PHOTO_MEMO_03@"	, $dump_data['PHOTO_MEMO_03'], $gallery_html);
	$gallery_html = str_replace("@PHOTO_04@"		, $dump_data['PHOTO_04'], $gallery_html);
	$gallery_html = str_replace("@PHOTO_MEMO_04@"	, $dump_data['PHOTO_MEMO_04'], $gallery_html);
	$gallery_html = str_replace("@FATHER_NAME@"		, $dump_data['FATHER_NAME'], $gallery_html);
	$gallery_html = str_replace("@MOTHER_NAME@"		, $dump_data['MOTHER_NAME'], $gallery_html);
	$gallery_html = str_replace("@BABY_NAME@"		, $dump_data['BABY_NAME'], $gallery_html);
}
if (!empty($map_html))
{
	$map_html = str_replace("@MID@"					, $dump_data['MID'], $map_html);
	$map_html = str_replace("@DDAY@"				, $dump_data['DDAY'], $map_html);
}
if (!empty($write_html))
{
	$write_html = str_replace("@MID@"				, $dump_data['MID'], $write_html);
	$write_html = str_replace("@DDAY@"				, $dump_data['DDAY'], $write_html);
	$write_html = str_replace("@MEMO@"				, nl2br($dump_data['I_MEMO']), $write_html);
	$write_html = str_replace("@FATHER_NAME@"		, $dump_data['FATHER_NAME'], $write_html);
	$write_html = str_replace("@MOTHER_NAME@"		, $dump_data['MOTHER_NAME'], $write_html);
	$write_html = str_replace("@BABY_NAME@"		  , $dump_data['BABY_NAME'], $write_html);
	$write_html = str_replace("@FATHER_HP@"			, $dump_data['FATHER_HP'], $write_html);
	$write_html = str_replace("@MOTHER_HP@"			, $dump_data['MOTHER_HP'], $write_html);
	$write_html = str_replace("@SHOW_DATE@"			, $dump_data['SHOW_DATE'], $write_html);
	$write_html = str_replace("@SHOW_DAY@"			, $dump_data['SHOW_DAY'], $write_html);
	$write_html = str_replace("@SHOW_TIME@"			, $dump_data['SHOW_TIME'], $write_html);
	$write_html = str_replace("@SHOW_EDATE@"		, $dump_data['SHOW_EDATE'], $write_html);
	$write_html = str_replace("@SHOW_EDAY@"			, $dump_data['SHOW_EDAY'], $write_html);
	$write_html = str_replace("@SHOW_ETIME@"		, $dump_data['SHOW_ETIME'], $write_html);
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
	//$appr_html = str_replace("@PHOTO@"				, $dump_data['A_PHOTO'], $appr_html);
	//감사장 사진없는 경우 엑박 제거
	if (!empty($dump_data['A_PHOTO'])) {
	  $tmp_img = str_replace("@PHOTO@", $dump_data['A_PHOTO'], "<img src='@PHOTO@' height='100%' alt='' />");
	  $appr_html = str_replace("@PHOTO@"				, $tmp_img, $appr_html);
	}
	else
	  $appr_html = str_replace("@PHOTO@"				, "", $appr_html);
	$appr_html = str_replace("@MEMO@"				, nl2br($dump_data['A_MEMO']), $appr_html);
}

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
if (!empty($appr_html))
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

// script 적용
$script_html = "";
$script_html .= "<script>";
$script_html .= "<!--";
$script_html .= "var s_xloc = \"127.0641468\";";
$script_html .= "var s_yloc = \"37.0707467\";";
$script_html .= "var s_addr = \"경기도 평택시 서정동 779-1 플로랜스 파티하우스\";";
$script_html .= "var father_hp = \"010-2345-6789\";";
$script_html .= "var mother_hp = \"010-2345-6789\";";
$script_html .= "var m_tag = \"초대장\";";
$script_html .= "var m_msg = \"초대장\";";
$script_html .= "var m_url = \"http://m.dejavu-m.com/?m=1\";";
$script_html .= "var board_url = \"http://m.dejavu-m.com/board.php?m=1\";";
$script_html .= "var photo_2g_url = \"\";";
$script_html .= "//-->";
$script_html .= "</script>";

if (!empty($map_html)) {
	$script_html .= "<script type=\"text/javascript\" src=\"https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId={$naver_map_key_v3}\"></script>";
	$script_html .= "<script>";
	$script_html .= "try {document.execCommand('BackgroundImageCache', false, true);} catch(e) {}";
	$script_html .= "$(document).ready(function () {";
	$script_html .= "	if ($(\"#nmap\")) {";
	$script_html .= "		$(\".map_area\").attr(\"style\", \"margin-bottom:0px;\");";
	//$script_html .= "		$(\"#nmap\").html(\"<iframe src='./map.php?shop_id={$shop_info["shop_id"]}' width='100%' height='300' scrolling='no' frameborder='0' allowtransparency='true'></iframe>\");";
	$script_html .= "	}";
	$script_html .= "});";
	$script_html .= "</script>";
}

$default_html = str_replace("<!--@SCRIPT@-->", $script_html, $default_html);

if ($sample_info['sample_type'] == 'B')
{
  if ($sample_id == "66") {
	  $body_html .= $visual_html;		// 메인
  	$body_html .= $write_html;		// 초대글
  	$body_html .= $gallery_html;	// 겔러리
  	$body_html .= $map_html;		// 퀵메뉴
  	$body_html .= $appr_html;		// 감사장
  }
  else {
  	$body_html .= $visual_html;		// 메인
  	$body_html .= $gallery_html;	// 겔러리
  	$body_html .= $write_html;		// 초대글
  	$body_html .= $map_html;		// 퀵메뉴
  	$body_html .= $appr_html;		// 감사장
	}
} else {
	$body_html .= $visual_html;		// 메인
	$body_html .= $write_html;		// 초대글
	$body_html .= $gallery_html;	// 겔러리
	$body_html .= $map_html;		// 퀵메뉴
	$body_html .= $appr_html;		// 감사장
}
// 기본 html 내용이 있는 경우
if ($default_html != "")
	$body_html = str_replace("@BODY@", $body_html, $default_html);


$body_html = stripslashes($body_html);


// navermap 직접 호출
$from_map1 = 'href="#" class="btn-naver-map" onclick="return false;" id="btn_nmap"';
$to_map1 = 'href="http://m.map.naver.com/map.nhn?lat='. $shop_info['xlocation'] .'&lng='. $shop_info['ylocation'] .'&dlevel=11&title='. $shop_info['address'] .' '. $shop_info['shop_name'] .'&isShowPolygon=true&isDetailAddress=true" target="_blank" class="btn-naver-map map_link_new"';
$body_html = str_replace($from_map1, $to_map1, $body_html);

$from_map2 = 'href="#" onclick="return false;" id="btn_nmap"';
$to_map2 = 'href="http://m.map.naver.com/map.nhn?lat='. $shop_info['xlocation'] .'&lng='. $shop_info['ylocation'] .'&dlevel=11&title='. $shop_info['address'] .' '. $shop_info['shop_name'] .'&isShowPolygon=true&isDetailAddress=true" target="_blank" class="btn1 map_link_new"';
$body_html = str_replace($from_map2, $to_map2, $body_html);
// 1. 이미지 경로 교정 (기존에 넣으신 것)
$body_html = str_replace('src="/data/', 'src="//m.dejavu-m.com/data/', $body_html);

// 2. CSS 경로 교정 (에러 나는 new_mobile.css 해결)
$body_html = str_replace('href="css/', 'href="//m.dejavu-m.com/css/', $body_html);
$body_html = str_replace('href="/css/', 'href="//m.dejavu-m.com/css/', $body_html);

// 3. JS 경로 교정 (에러 나는 m.js, scripts.js 등 해결)
$body_html = str_replace('src="js/', 'src="//m.dejavu-m.com/js/', $body_html);
$body_html = str_replace('src="/js/', 'src="//m.dejavu-m.com/js/', $body_html);

// --- maker/sample_viewer.php 하단부 ---

// --- 기존에 추가했던 테스트 코드는 모두 지우고 이 아래를 넣으세요 ---

if (isset($body_html) && $body_html != "") {
    // 1. 도메인 통합 (www -> m)
    $body_html = str_replace('www.dejavu-m.com', 'm.dejavu-m.com', $body_html);
    $body_html = str_replace('http://m.dejavu-m.com', 'https://m.dejavu-m.com', $body_html);

    // 2. JS 파일 경로 강제 교정 (대괄호 [] 대신 array() 사용)
    $js_list = array('sound.js', 'm.js', 'scripts.js', 'flowtype2.js', 'kakao.min.js', 'jquery-1.12.4.min.js');
    foreach ($js_list as $js) {
        $body_html = str_replace('src="'.$js, 'src="/js/'.$js, $body_html);
        $body_html = str_replace("src='".$js, "src='/js/".$js, $body_html);
    }

    // 3. CSS 파일 경로 강제 교정
    $css_list = array('reset.css', 'style.css', 'aos.css', 'new_mobile.css', 'common.css');
    foreach ($css_list as $css) {
        $body_html = str_replace('href="'.$css, 'href="/css/'.$css, $body_html);
        $body_html = str_replace("href='".$css, "href='/css/".$css, $body_html);
    }

    // 4. 데이터(이미지) 및 기타 경로 보정
    $body_html = str_replace('="/data/', '="//m.dejavu-m.com/data/', $body_html);
    $body_html = str_replace('="data/', '="//m.dejavu-m.com/data/', $body_html);
    $body_html = str_replace('="/js/', '="//m.dejavu-m.com/js/', $body_html);
    $body_html = str_replace('="/css/', '="//m.dejavu-m.com/css/', $body_html);

    // 5. 중복 경로 정제
    $body_html = str_replace('/js/js/', '/js/', $body_html);
    $body_html = str_replace('/css/css/', '/css/', $body_html);
}

// 최종 출력 (기존에 있던 echo 줄입니다)
echo $body_html;
// 최종 출력
echo $body_html;
echo $body_html;
echo $body_html;
?>
<?php
//업체별 신규 네이버지도, BGM
include_once($_SERVER["DOCUMENT_ROOT"]."/m/shop_bgm.php");
?>