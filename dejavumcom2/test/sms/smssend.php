<?php
if($_POST['action']=='go'){

   /********************  ********************/
    $sms_url = "http://sslsms.cafe24.com/sms_sender.php"; // ۿû URL
	// $sms_url = "https://sslsms.cafe24.com/sms_sender.php"; // HTTPS ۿû URL
    $sms['user_id'] = base64_encode("dejavusms"); //SMS ̵.
    $sms['secure'] = base64_encode("2e99335486e8c9e2e3f32c367db26469 ") ;//Ű
    $sms['msg'] = base64_encode(stripslashes($_POST['msg']));

    $sms['rphone'] = base64_encode($_POST['rphone']);
    $sms['sphone1'] = base64_encode($_POST['sphone1']);
    $sms['sphone2'] = base64_encode($_POST['sphone2']);
    $sms['sphone3'] = base64_encode($_POST['sphone3']);
    $sms['rdate'] = base64_encode($_POST['rdate']);
    $sms['rtime'] = base64_encode($_POST['rtime']);
    $sms['mode'] = base64_encode("1"); // base64  ݵ 尪 1 ּž մϴ.
    $sms['returnurl'] = base64_encode($_POST['returnurl']);
    $sms['testflag'] = base64_encode($_POST['testflag']);
    $sms['destination'] = urlencode(base64_encode($_POST['destination']));
    $returnurl = $_POST['returnurl'];
    $sms['repeatFlag'] = base64_encode($_POST['repeatFlag']);
    $sms['repeatNum'] = base64_encode($_POST['repeatNum']);
    $sms['repeatTime'] = base64_encode($_POST['repeatTime']);
    $nointeractive = $_POST['nointeractive']; //  : 1,  ȭ(alert) 

    $host_info = explode("/", $sms_url);
    $host = $host_info[2];
    $path = $host_info[3]."/".$host_info[4];

    srand((double)microtime()*1000000);
    $boundary = "---------------------".substr(md5(rand(0,32000)),0,10);
    //print_r($sms);

    //  
    $header = "POST /".$path ." HTTP/1.0\r\n";
    $header .= "Host: ".$host."\r\n";
    $header .= "Content-type: multipart/form-data, boundary=".$boundary."\r\n";

    //  
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
        $Result= $rMsg[0]; //߼۰
        $Count= $rMsg[1]; //ܿǼ

        //߼۰ ˸
        if($Result=="success") {
            $alert = "";
            $alert .= " ܿǼ ".$Count." Դϴ.";
        }
        else if($Result=="reserved") {
            $alert = " Ǿϴ.";
            $alert .= " ܿǼ ".$Count." Դϴ.";
        }
        else if($Result=="3205") {
            $alert = "߸ ȣԴϴ.";
        }

		else if($Result=="0044") {
            $alert = "Թڴ¹߼۵ ʽϴ.";
        }
		
        else {
            $alert = "[Error]".$Result;
        }
    }
    else {
        $alert = "Connection Failed";
    }

     if($nointeractive=="1" && ($Result!="success" && $Result!="Test Success!" && $Result!="reserved") ) {
        echo "<script>alert('".$alert ."')</script>";
    }
    else if($nointeractive!="1") {
        echo "<script>alert('".$alert ."')</script>";
    }
    echo "<script>location.href='".$returnurl."';</script>";
}
?>
