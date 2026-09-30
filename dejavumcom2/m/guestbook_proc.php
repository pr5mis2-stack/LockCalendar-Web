<?php 
/**
 *  maker_step2_proc.php
 *  @Desc      : 상품등록 처리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
require_once(dirname(__DIR__) . "/conf/DejavuConf.php");
require_once(dirname(__DIR__) . "/import.php");

import("class.controller.MainCon");
import("class.controller.GuestbookCon");
import("php.util.JSON");

$MainCon 		= new MainCon();
$GuestbookCon	= new GuestbookCon();
$JSON 			= new Services_JSON();

/**
 *
 * @var pageing setting
 */
$thisPage = "guestbook_proc.php";

/**
 *
 * @var parameter setting
 */
$_s				= $StringClass->getRequest('s');
$main_id		= $StringClass->getRequest('m');
$param = array();
$arrXml = array(
		"header"=>array("result_code"=>"100", "result_msg"=>"FAIL")
		, "body"=>array()
);
$pageRowCnt = 5;

if ($_s == "save")
{
	if (!empty($main_id))	{
		$param['main_id'] 		= $main_id;
		$param['writer_name'] 	= $StringClass->getRequest('writer_name');
		$param['passwd']		= $StringClass->getRequest('passwd');
		$param['memo']			= $StringClass->getRequest('memo');
		$result = $GuestbookCon->addGuestbook($param);

		if ($result)
		{
			$arrXml["header"]["result_code"] = "000";
			$arrXml["header"]["result_msg"] = "SUCCESS";
		}
	}
}
else if ($_s == "del")
{
	$gid = $StringClass->getRequest('guestbook_id');
	$param['guestbook_id'] = $gid;
	$result = $GuestbookCon->getGuestbookList($param);
	if ($result)
	{
		$row = $result[0];
		if ($row['passwd'] == $StringClass->getRequest('passwd'))
		{
			$result2 = $GuestbookCon->delGuestbook($gid);
			if ($result2)
			{
				$arrXml["header"]["result_code"] = "000";
				$arrXml["header"]["result_msg"] = "SUCCESS";
			}
		}
		else
		{
			$arrXml["header"]["result_code"] = "300";
			$arrXml["header"]["result_msg"] = "비밀번호가 맞지 않습니다.";
		}
	}
	else
	{
		$arrXml["header"]["result_code"] = "200";
		$arrXml["header"]["result_msg"] = "삭제할 글이 없습니다.";
	}
}
else if ($_s == "more")
{
	$startPaging = $StringClass->getRequest('next');
	$param['main_id'] = $main_id;
	$arrList = $GuestbookCon->getGuestbookList($param, $startPaging, $pageRowCnt);
	$guestbook_list = array();
	foreach($arrList as $key=>$val)
	{
		$data = array();
		$data['guestbook_id'] = $val['guestbook_id'];
		$data['main_id'] = $val['main_id'];
		$data['writer_name'] = $val['writer_name'];
		$data['writer_ip'] = $val['writer_ip'];
		$data['memo'] = nl2br($val['memo']);
		$data['reg_date'] = $val['reg_date'];
		
		array_push($guestbook_list, $data);
	}
	
	$arrXml["header"]["result_code"] = "000";
	$arrXml["header"]["result_msg"] = "";
	$arrXml['body']['guestbook_list'] = $guestbook_list;
}
echo trim($JSON->encode($arrXml));
?>