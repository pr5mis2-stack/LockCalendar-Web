<?php
set_time_limit(0);
/**
 *  maker_step2_proc.php
 *  @Desc      : 상품등록 처리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/include/common_header.php");

import("class.controller.MainCon");
import("class.controller.InvitationCon");
import("class.controller.ImageCon");
import("php.util.ConvertImage");
import("php.util.JSON");

$MainCon 		= new MainCon();
$ImageCon		= new ImageCon();
$ConvertImage 	= new ConvertImage();
$JSON 			= new Services_JSON();
$InvitationCon		= new InvitationCon();

/**
 *
 * @var pageing setting
 */
$thisPage = "/manager/product_proc.php";

/**
 *
 * @var parameter setting
 */
$_s				= $StringClass->getRequest('s');
$main_id		= $StringClass->getRequest('main_id');
$is_invitation 	= $StringClass->getRequest('is_invitation');
$memo			= $StringClass->getRequest('memo');

$param = array();
$arrXml = array(
		"header"=>array("result_code"=>"100", "result_msg"=>"FAIL")
		, "body"=>array()
);

if (!empty($main_id))	{
	$param['main_id'] = $main_id;
	$param['is_invitation'] = $is_invitation;
	$result = $MainCon->setMain($param);
	
	$result = $InvitationCon->getInvitationCnt($param);
	$sparam = $param;
	$sparam['memo'] = $memo;
	
	if ($result)
		$result2 = $InvitationCon->setInvitation($sparam);
	else 
		$result2 = $InvitationCon->addInvitation($sparam);
	
	if(!empty($result2))
	{
		echo "<script>document.domain = 'dejavu-m.com';</script>";
		
		if ($_s == "G")
			$StringClass->alertMsg('저장되었습니다.','parent', 'main.php?step=5', '');
		else if ($_s == "M")
			echo "<script>parent.modalPreViewerPop();</script>";
		else
			$StringClass->alertMsg('저장되었습니다.','parent', 'main.php?step=4', '');
	}
	else
		$StringClass->alertMsg('저장 중 오류가 발생하였습니다.','', '', 'NONE');
}
else
	$StringClass->alertMsg('초대장 정보가 없습니다.','', '', 'NONE');
?>