<?php
set_time_limit(0);
#ini_set("session.cookie_domain",".dejavu-m.com") ;
#session_start();
#session_cache_limiter("none");
/**
 *  search_proc.php
 *  @Desc      : step1 저장 처리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/include/common_header.php");

import("class.controller.MainCon");
import("class.controller.PromotionCon");
import("class.controller.ImageCon");
import("php.util.ConvertImage");
import("php.util.ResizeImage");
import("php.util.JSON");

$MainCon		= new MainCon();
$PromotionCon   = new PromotionCon();
$ImageCon		= new ImageCon();
$ConvertImage 	= new ConvertImage();
$JSON 			= new Services_JSON();

/**
 * 
 * @var pageing setting
 */
$thisPage = "/maker/maker_step1_proc.php";

/**
 * 
 * @var parameter setting
 */
$_s				= $StringClass->getRequest('s');

$main_id		= $StringClass->getRequest('main_id');
if (!empty($main_id) && !ctype_digit((string)$main_id)) { $main_id = ''; } // 보안: main_id는 숫자만 허용 (경로/쿼리 조작 방지)
$shop_id		= $StringClass->getRequest('shop_id');
$parent_shop_id	= $StringClass->getRequest('parent_shop_id');
$sample_id		= $StringClass->getRequest('sample_id');
$view_type		= $StringClass->getRequest('view_type');
$show_date		= $StringClass->getRequest('show_date');
$show_time		= $StringClass->getRequest('show_time');
$holl_name		= $StringClass->getRequest('holl_name');
$email			= $StringClass->getRequest('email');
$passwd			= $StringClass->getRequest('pwd');
$father_name	= $StringClass->getRequest('father_name');
$father_hp		= $StringClass->getRequest('father_hp');
$mother_name	= $StringClass->getRequest('mother_name');
$mother_hp		= $StringClass->getRequest('mother_hp');
$baby_name		= $StringClass->getRequest('baby_name');
$type			= $StringClass->getRequest('type');		// 샘플타입
$is_bank		= $StringClass->getRequest('is_bank');
$bank_memo		= $StringClass->getRequest('bank_memo');

#new dBug($_POST);
$param = array();
$save_url = "";
$arrXml = array(
		"header"=>array("result_code"=>"100", "result_msg"=>"FAIL")
		, "body"=>array()
);

if ($_s == "del_file")	// 메인 사진 삭제
{
	if (!empty($main_id))	{
		
		// get main info
		$param = array();
		$param['main_id'] = $main_id;
		$result = $MainCon->getMainList($param);
		if ($result)
		{
			$main_info = $result[0];
			//new dBug($main_info);
			//exit;
			if ($main_info['main_photo_url'])
				$ImageCon->unlinkFIle($main_info['main_photo_url']);
		}
		
		$result = $MainCon->delMainPhoto($main_id);

		if ($result)
		{
			$arrXml["header"]["result_code"] = "000";
			$arrXml["header"]["result_msg"] = "SUCCESS";
		}
	}
	echo trim($JSON->encode($arrXml));
}
else
{
	/**
	 * 최초 저장시
	 */
	if (empty($main_id) && empty($_SESSION["dejavu_id"]))
		$main_id = $MainCon->getMainID();
	else if (empty($main_id) && !empty($_SESSION["dejavu_id"]))
		$main_id = $_SESSION["dejavu_id"];
	//echo $main_id;
	
	$fparam = array();
	$fparam['upload_dir'] = "THUMBNAIL";
	$fparam['first_dir'] = substr($main_id, 0, 3) . "/";
	$fparam['middle_dir'] = $main_id . "/";
	
	$param_filename = array();
	$param_filename = $ImageCon->uploadFiles($fparam);

	// 이미지 비율에 맞게 큰부분을 1280 사이즈로 조정
	if(!empty($param_filename))
	{
		foreach($param_filename as $key=>$val)
		{
			$save_dir = $conf_img_thumbnail_dir.$fparam['first_dir'].$fparam['middle_dir'].$val;
			$save_url = $conf_mimg_thumbnail_url.$fparam['first_dir'].$fparam['middle_dir'].$val;
				
			dejavu_fix_exif_orientation($save_dir); // EXIF 회전 보정 (리사이즈 전 적용)
			$Image = new Image($save_dir);
			$Image->ratioresize(1024, 1024);
			$Image->save();
			//new dBug($save_dir);
		}
	}
	
	// 등록된 email인지 확인
	$ckEmail = $MainCon->checkEmail($email, $main_id);
	if ($ckEmail > 0)
	{
		if ($ckEmail == 99)
			$StringClass->alertMsg('이메일 정보가 없습니다.','', '', 'NONE');
		else
			$StringClass->alertMsg('이미 등록된 이메일입니다.','', '', 'NONE');
	}
	
	$param["main_id"] 		= $main_id;
	$param["shop_id"] 		= $shop_id;
	$param["parent_shop_id"] 		= $parent_shop_id;
	$param["sample_id"] 	= $sample_id;
	$param["view_type"] 	= $view_type;
	$param["show_date"] 	= $show_date;
	$param["show_time"] 	= $show_time;
	$param["holl_name"] 	= $holl_name;
	$param["email"] 		= $email;
	$param["passwd"] 		= $passwd;
	$param["father_name"] 	= $father_name;
	$param["father_hp"] 	= $father_hp;
	$param["mother_name"] 	= $mother_name;
	$param["mother_hp"] 	= $mother_hp;
	$param["baby_name"] 	= $baby_name;
	if ($save_url)
		$param['main_photo_url'] = $save_url;
	
	$param["is_bank"] 		= $is_bank;
	$param["bank_memo"] 	= $bank_memo;

	$ckparam = array();
	$ckparam['main_id'] = $main_id;
	$result = $MainCon->getMainCnt($ckparam);


	if ($result)
	{
		$result2 = $MainCon->setMain($param);

		// 프로모션 업체 여부 체크
		$ckParam = array();
		$ckParam['shop_id'] = $shop_id;
		$ckResult = $PromotionCon->getPromotionList($ckParam);

		if(!empty($ckResult))
		{
			// 프로모션 참여여부 체크
			$pckResult = $PromotionCon->isAddedPromotionLog($main_id);
			if($pckResult == 0)
			{
				$saveParam = array();
				$saveParam['shop_id'] = $shop_id;
				$saveParam['main_id'] = $main_id;
				$PromotionCon->addPromotionLog($saveParam);
			}
		}
	}
	else
	{
		$result2 = $MainCon->addMain($param);

		// 프로모션 업체 여부 체크
		$ckParam = array();
		$ckParam['shop_id'] = $shop_id;
		$ckResult = $PromotionCon->getPromotionList($ckParam);

		if(!empty($ckResult))
		{
			// 프로모션 참여여부 체크
			$pckResult = $PromotionCon->isAddedPromotionLog($main_id);
			if($pckResult == 0)
			{
				$saveParam = array();
				$saveParam['shop_id'] = $shop_id;
				$saveParam['main_id'] = $main_id;
				$PromotionCon->addPromotionLog($saveParam);
			}
		}
	}
	
	if ($result2)
	{	
		$_SESSION["dejavu_id"]	= $main_id;
		$_SESSION["user_email"]	= $email;
		
		if(!empty($result2))
		{
			//echo $_SESSION["dejavu_id"];
			echo "<script>try{document.domain = 'dejavu-m.com';}catch(e){}; parent.document.frm.main_id.value = '{$main_id}';</script>";
			
			if ($_s == "G")
			{
				if ($type == "S")
					$StringClass->alertMsg('저장되었습니다.','parent', 'main.php?step=4', '');
				else
					$StringClass->alertMsg('저장되었습니다.','parent', 'main.php?step=3', '');
			}
			else if ($_s == "M")
				echo "<script>parent.fileReset();parent.modalPreViewerPop();</script>";
			else
				$StringClass->alertMsg('저장되었습니다.','parent', 'main.php?step=1', '');
		}
		else
			$StringClass->alertMsg('저장중 오류가 발생하였습니다.','', '', 'NONE');
		
	}
}
?>