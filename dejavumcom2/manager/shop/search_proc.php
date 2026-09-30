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
$JSON 				= new Services_JSON();

/**
 * 
 * @var pageing setting
 */
$thisPage = "/manager/shop/search_proc.php";

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

// sample search
if ($_s == "type") {		
	$sample_list = array();
	$sample_type = $StringClass->getRequest('sch_type');
	if (!empty($sample_type))
	{
		$param['sample_type'] = $sample_type;
		$param['is_use'] = 1;
		$param['order_by'] = "20";
		$result = $SampleCon->getSampleList($param);
	
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
} 

echo trim($JSON->encode($arrXml));
?>