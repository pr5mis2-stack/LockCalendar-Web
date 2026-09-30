<?php
#ini_set("session.cookie_domain",".dejavu-m.com") ;
#session_start();
#session_cache_limiter("none");
/**
 *  sms_proc.php
 *  @Desc      : sms 발송처리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/include/common_header.php");

import("php.sms.Cafe24SMSClass");
import("php.util.JSON");

$Cafe24SMSClass = new Cafe24SMSClass();
$JSON 			= new Services_JSON();

/**
 * 
 * @var pageing setting
 */
$thisPage = "/common/sms_proc.php";

/**
 * 
 * @var parameter setting
 */
$_a			= $StringClass->getRequest('a');
$receiver 	= $StringClass->getRequest('receiver');
$msg		= $StringClass->getRequest('msg');
$arrXml = array(
		"header"=>array("result_code"=>"100", "result_msg"=>"FAIL")
		, "body"=>array()
);

if (empty($receiver))
{
	$arrXml["header"]["result_code"] = "100";
	$arrXml["header"]["result_msg"] = "발송번호가 없습니다.";
}
else if (empty($msg))
{
	$arrXml["header"]["result_code"] = "100";
	$arrXml["header"]["result_msg"] = "메세지가 없습니다.";
}
else
{
	$receiver = preg_replace("/[^0-9]*/s", "", $receiver);
	
	if (!strstr($receiver, "-"))
	{	
		$tmp_hp = $receiver;
		$receiver = substr($tmp_hp, 0, 3)."-".substr($tmp_hp, 3, 4). "-".substr($tmp_hp, 7, 4);
	}
	
	$tmp_sp = explode("-", $receiver);
	
	/******************** 인증정보 ********************/
	$sms_url = "http://sslsms.cafe24.com/sms_sender.php"; // 전송요청 URL
	// $sms_url = "https://sslsms.cafe24.com/sms_sender.php"; // HTTPS 전송요청 URL
	$sms['user_id'] = base64_encode("dejavusms"); //SMS 아이디.
	$sms['secure'] = base64_encode("2e99335486e8c9e2e3f32c367db26469 ") ;//인증키
	$msg = str_replace("@@","&",$msg);
	$sms['msg'] = base64_encode(stripslashes($msg));
	
	$sms['rphone'] = base64_encode($receiver);
	$sms['sphone1'] = base64_encode($tmp_sp[0]);
	$sms['sphone2'] = base64_encode($tmp_sp[1]);
	$sms['sphone3'] = base64_encode($tmp_sp[2]);
	// 20151205 설정변경으로 발송 폰번호 고정
	$sms['sphone1'] = base64_encode("02");
	$sms['sphone2'] = base64_encode("2677");
	$sms['sphone3'] = base64_encode("1542");
	
	//$sms['rdate'] = base64_encode($_POST['rdate']);
	//$sms['rtime'] = base64_encode($_POST['rtime']);
	$sms['mode'] = base64_encode("1"); // base64 사용시 반드시 모드값을 1로 주셔야 합니다.
	//$sms['returnurl'] = base64_encode($_POST['returnurl']);
	//$sms['testflag'] = base64_encode($_POST['testflag']);
	//$sms['destination'] = urlencode(base64_encode($_POST['destination']));
	$returnurl = $_POST['returnurl'];
	//$sms['repeatFlag'] = base64_encode($_POST['repeatFlag']);
	//$sms['repeatNum'] = base64_encode($_POST['repeatNum']);
	//$sms['repeatTime'] = base64_encode($_POST['repeatTime']);
	$nointeractive = "1"; //사용할 경우 : 1, 성공시 대화상자(alert)를 생략
	
	$host_info = explode("/", $sms_url);
	$host = $host_info[2];
	$path = $host_info[3]."/".$host_info[4];
	
	srand((double)microtime()*1000000);
	$boundary = "---------------------".substr(md5(rand(0,32000)),0,10);
	//print_r($sms);
	
	//new dBug($sms);
	//exit;
	// 헤더 생성
	$header = "POST /".$path ." HTTP/1.0\r\n";
	$header .= "Host: ".$host."\r\n";
	$header .= "Content-type: multipart/form-data, boundary=".$boundary."\r\n";
	
	// 본문 생성
	foreach($sms AS $index => $value){
		$data .="--$boundary\r\n";
		$data .= "Content-Disposition: form-data; name=\"".$index."\"\r\n";
		$data .= "\r\n".$value."\r\n";
		$data .="--$boundary\r\n";
	}
	$header .= "Content-length: " . strlen($data) . "\r\n\r\n";
	
	$fp = fsockopen($host, 80);
	
	if ($fp) {
		fputs($fp, $header.$data);
		$rsp = '';
		while(!feof($fp)) {
			$rsp .= fgets($fp,8192);
		}
		fclose($fp);
		$msg = explode("\r\n\r\n",trim($rsp));
		$rMsg = explode(",", $msg[1]);
		$Result= $rMsg[0]; //발송결과
		$Count= $rMsg[1]; //잔여건수
	
		//발송결과 알림
		if($Result=="success") {
			$arrXml["header"]["result_code"] = "000";
			$arrXml["header"]["result_msg"] = "잔여건수는 ".$Count."건 입니다.";
		}
		else if($Result=="reserved") {
			$arrXml["header"]["result_code"] = "000";
			$arrXml["header"]["result_msg"] = "잔여건수는 ".$Count."건 입니다.";
		}
		else if($Result=="3205") {
			$arrXml["header"]["result_code"] = "100";
			$arrXml["header"]["result_msg"] = "잘못된 번호형식입니다.";
		}
		else if($Result=="0044") {
			$arrXml["header"]["result_code"] = "200";
			$arrXml["header"]["result_msg"] = "스팸문자는발송되지 않습니다.";
		}
		else {
			$arrXml["header"]["result_code"] = "999";
			$arrXml["header"]["result_msg"] = $Result;
		}
	}
	else {
		$arrXml["header"]["result_code"] = "999";
		$arrXml["header"]["result_msg"] = "Connection Failed";
	}
}
echo trim($JSON->encode($arrXml));
?>