<?php
/**
 * 
 *  Cafe24SMSClass
 *
 *  @Desc     : Cafe24 활용한 SMS 발송
 *  @Author   : 이정수
 *  @Date     : 2013. 10. 27
 *  @Version  :
 *  
 */  
class Cafe24SMSClass {

	private $result			= null;

	// 아레오 정보
	private $Cafe24Info = array("sms_url"=>"http://sslsms.cafe24.com/sms_sender.php"
								, "user_id"=>"dejavusms"
								, "secure"=>"2e99335486e8c9e2e3f32c367db26469"
								, "testflag"=>"N"
							);
	
	/**
	 * 
	 *  Cafe24SMSClass
	 *
	 *  @Desc      : 
	 *  @Author    : 이정수
	 *  @Date      : 2011. 4. 4. 오후 3:55:54
	 *  @Return    :
	 */
	public function __construct()
	{

	}

	/**
	 * 
	 *  AddSMS
	 *
	 *  @Desc      : sms 전송 입력 
	 *  @Author    : 이정수
	 *  @Date      : 2011. 4. 4. 오후 4:18:15
	 *  @param unknown_type $sender		: 보내는 사람
	 *  @param unknown_type $receiver	: 받는 사람
	 *  @param unknown_type $sms_msg	: 전송 메세지
	 *  @param unknown_type $sms_time	: 예약시간
	 *  @Return    : 전송결과 (성공 : 000/실패 : 100/오류 : 200)
	 */
	public function AddSMS($sender='', $receiver='', $sms_msg='')
	{
		$rtn = array("result_code"=>"100", "result_msg"=>"FAIL");
		
		if (empty($sender) || empty($receiver) || empty($sms_msg))
		{
			$rtn["result_code"] = "999";
			$ttn["result_msg"] = "not info";
			return $rtn;
		}
		
		/******************** 인증정보 ********************/
		$sms_url = $Cafe24Info ["sms_url"];	 // 전송요청 URL
		$sms['user_id'] = base64_encode($Cafe24Info["user_id"]); //SMS 아이디.
		$sms['secure'] = base64_encode($Cafe24Info["secure"]) ;//인증키
		$sms['mode'] = base64_encode("1"); // base64 사용시 반드시 모드값을 1로 주셔야 합니다.
		
		$sms['msg'] = base64_encode(stripslashes($sms_msg));
		$sms['rphone'] = base64_encode($receiver);	// 받는번호
		$tmp_sender = explode("-", $sender);
		$sphone1 = (sizeof($tmp_sender) >= 1)? $tmp_sender[0]:"";
		$sphone2 = (sizeof($tmp_sender) >= 2)? $tmp_sender[1]:"";
		$sphone3 = (sizeof($tmp_sender) >= 3)? $tmp_sender[2]:"";
		
		$sms['sphone1'] = base64_encode($sphone1);	// 전송번호
		$sms['sphone2'] = base64_encode($sphone2);	// 전송번호
		$sms['sphone3'] = base64_encode($sphone3);	// 전송번호

		// test 일경우 Y 처리
		if ($Cafe24Info["testflag"] == "Y")
			$sms['testflag'] = base64_encode("Y");
		$nointeractive = $_POST['nointeractive']; //사용할 경우 : 1, 성공시 대화상자(alert)를 생략
		
		
		$host_info = explode("/", $sms_url);
		$host = $host_info[2];
		$path = $host_info[3];
		
		srand((double)microtime()*1000000);
		$boundary = "---------------------".substr(md5(rand(0,32000)),0,10);
		//print_r($sms);
		
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
				$rtn["result_code"] = "000";
				$ttn["result_msg"] = "잔여건수는 ".$Count."건 입니다.";
			}
			else if($Result=="reserved") {
				$rtn["result_code"] = "000";
				$ttn["result_msg"] = "잔여건수는 ".$Count."건 입니다.";
			}
			else if($Result=="3205") {
				$rtn["result_code"] = "100";
				$ttn["result_msg"] = "잘못된 번호형식입니다.";
			}
			else if($Result=="0044") {
				$rtn["result_code"] = "200";
				$ttn["result_msg"] = "스팸문자는발송되지 않습니다.";
			}
			else {
				$rtn["result_code"] = "999";
				$ttn["result_msg"] = $Result;
			}
		}
		else {
			$rtn["result_code"] = "999";
			$ttn["result_msg"] = "Connection Failed";
		}
		
		return $rtn;
	}
}
?>