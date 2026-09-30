<?php
#ini_set("session.cookie_domain",".dejavu-m.com") ;
#session_start();
#session_cache_limiter("none");
/**
 *  search_proc.php
 *  @Desc      : 검색결과 처리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/include/common_header.php");

import("class.controller.MainCon");
import("class.controller.SampleCon");
import("class.controller.SampleDetailCon");
import("class.controller.ShopCon");
import("class.controller.ShopSampleCon");
import("php.util.JSON");

$MainCon         	= new MainCon();
$SampleCon         	= new SampleCon();
$SampleDetailCon    = new SampleDetailCon();
$ShopCon         	= new ShopCon();
$ShopSampleCon		= new ShopSampleCon();
$JSON 			= new Services_JSON();

/**
 * 
 * @var pageing setting
 */
$thisPage = "/maker/search_proc.php";

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

if ($_s == "shop")	{				// sub shop searh
	$shop_list = array();
	$shop_id = $StringClass->getRequest('shop_id');
	if (!empty($shop_id))
	{
		$param['parent_shop_id'] = $shop_id;
		$param['order_by'] = "20";
		$param['contract_end'] = "0";	// 계약종료 여부 (0:계약중,1:계약종료)
		$result = $ShopCon->getShopList($param);
		
		if(!empty($result))
		{
			//new dBug($result);
			//exit;
			foreach($result as $key=>$val)
			{
				//new dBug($val);
				//new dBUg($val["shop_name"]);
				$shop_info = array("shop_info"=>
								array("shop_id"=>$val["shop_id"]
									, "shop_name"=>$val["shop_name"]
								));
				array_push($shop_list, $shop_info);
	 		}
	 		$arrRtn["shop_list"] = $shop_list;
	
			$arrXml["header"]["result_code"] = "000";
			$arrXml["header"]["result_msg"] = "SUCCESS";
	 		$arrXml["body"] = $arrRtn;
		}
	}
}
else if ($_s == "sample") {		// sample search
	$sample_list = array();
	$shop_id = $StringClass->getRequest('shop_id');
	if (!empty($shop_id))
	{
		$param['shop_id'] = $shop_id;
		$param['is_use'] = 1;
		$param['order_by'] = "20";		
		$result = $ShopSampleCon->getShopSampleList($param);
	
		if(!empty($result))
		{
			foreach($result as $row)
			{
				$sample_info = array("sample_info"=>
						array("sample_id"=>$row["sample_id"]
								, "sample_name"=>$row["sample_name"]
						));
				array_push($sample_list, $sample_info);
			}
			$arrRtn["sample_list"] = $sample_list;
	
			$arrXml["header"]["result_code"] = "000";
			$arrXml["header"]["result_msg"] = "SUCCESS";
			$arrXml["body"] = $arrRtn;
		}
	}	
} else if ($_s == "viewtype") {	// viewtype search
	$shop_id = $StringClass->getRequest('shop_id');
	if (!empty($shop_id))
	{
		$param['shop_id'] = $shop_id;
		$param['order_by'] = "20";		
		$result = $ShopCon->getShopList($param);
	
		if(!empty($result))
		{
			$arrRtn["gallery_type"] = $result[0]["gallery_type"];
	
			$arrXml["header"]["result_code"] = "000";
			$arrXml["header"]["result_msg"] = "SUCCESS";
			$arrXml["body"] = $arrRtn;
		}
	}	
} else if ($_s == "sampletime") {	// time search
	$shop_id = $StringClass->getRequest('shop_id');
	if (!empty($shop_id))
	{
		$param['shop_id'] = $shop_id;
		$result = $ShopCon->getShopList($param);

		if(!empty($result))
		{
			if (!empty($result[0]["time_week"]) || !empty($result[0]["time_sat"]) || !empty($result[0]["time_sun"])) {
				if (!empty($result[0]["time_week"]))
				{
					$arrRtn["time_week"] = "<b>평일</b><br />".str_replace("\n", "<br />", $result[0]["time_week"])."<br />";
				}
				else 
					$arrRtn["time_week"] = "";
				if (!empty($result[0]["time_sat"]))
				{
					$arrRtn["time_sat"] = "<b>토요일</b><br />".str_replace("\n", "<br />", $result[0]["time_sat"])."<br />";
				}
				else 
					$arrRtn["time_sat"] = "";
				if (!empty($result[0]["time_sun"]))
				{
					$arrRtn["time_sun"] = "<b>일요일</b><br />".str_replace("\n", "<br />", $result[0]["time_sun"])."<br />";
				}
				else
					$arrRtn["time_sun"] = "";

				$arrXml["header"]["result_code"] = "000";
				$arrXml["header"]["result_msg"] = "SUCCESS";
				$arrXml["body"] = $arrRtn;
			}
		}
	}
}
echo trim($JSON->encode($arrXml));
?>