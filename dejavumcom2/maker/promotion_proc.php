<?php
/**
 *  promotion_proc.php
 *  @Desc      : 검색결과 처리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/include/common_header.php");

import("class.controller.MainCon");
import("class.controller.PromotionCon");
import("php.util.JSON");

$MainCon         	= new MainCon();
$PromotionCon       = new PromotionCon();
$JSON 				= new Services_JSON();

/**
 * 
 * @var pageing setting
 */
$thisPage = "/maker/promotion_proc.php";

/**
 * 
 * @var parameter setting
 */
$_s				= $StringClass->getRequest('s');
$param = array();
$arrXml = array(
	"header"=>array("result_code"=>"100", "result_msg"=>"FAIL")
	, "body"=>array()
);
$promotion_list = array();

// 프로모션 참여 업체 정보
if ($_s == "ps")	{
	$shop_list = array();
	$shop_id = $StringClass->getRequest('shop_id');
	if (!empty($shop_id))
	{
		$param['shop_id'] = $shop_id;
		//new dBug($param);
		$result = $PromotionCon->getPromotionList($param);

		if(!empty($result))
		{
			//new dBug($result);
			//exit;
			foreach($result as $key=>$val)
			{
				//new dBug($val);
				//new dBUg($val["shop_name"]);
				$promotion_info = array("promotion_info"=>
						array(
							"shop_id"=>$val["shop_id"]
							, "shop_name"=>$val["shop_name"]
							, "is_popup"=>$val["is_popup"]
							, "img_width"=>$val["img_width"]
							, "img_height"=>$val["img_height"]
							, "file_name"=>$val["file_name"]
							, "file_ext"=>$val["file_ext"]
							, "file_url"=>$conf_img_shop_url.$val["file_url"]
						));
				array_push($promotion_list, $promotion_info);
			}
			$arrRtn["promotion_list"] = $promotion_list;

			$arrXml["header"]["result_code"] = "000";
			$arrXml["header"]["result_msg"] = "SUCCESS";
			$arrXml["body"] = $arrRtn;
		}
	}
}

// 프로모션 참여 여부 체크
if ($_s == "iap")	{				
	$shop_list = array();
	$main_id = $StringClass->getRequest('main_id');
	if (!empty($main_id))
	{
		$result = $PromotionCon->isAddedPromotionLog($main_id);
		
		if($result > 0)
	 		$arrRtn["isAdded"] = 1;
		else
			$arrRtn["isAdded"] = 0;

		$arrXml["header"]["result_code"] = "000";
		$arrXml["header"]["result_msg"] = "SUCCESS";
		$arrXml["body"] = $arrRtn;
	}
	else
	{
		$arrRtn["isAdded"] = 0;

		$arrXml["header"]["result_code"] = "000";
		$arrXml["header"]["result_msg"] = "SUCCESS";
		$arrXml["body"] = $arrRtn;
	}
}

echo trim($JSON->encode($arrXml));
?>