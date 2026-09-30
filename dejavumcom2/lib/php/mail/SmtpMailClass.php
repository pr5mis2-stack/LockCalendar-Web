<?php
class SmtpMail {

	private $smtp_id = "kdh_admin@datahouse.co.kr"; 
    private $smtp_pwd = "ahfdlq05"; 

    private $host = "mail.datahouse.co.kr"; // 이건 자신의 컴터에 깔려있다면 이고 다른 SMTP를 이용하는 분이라면 다른 주소를 써주시면 됩니다. 
    private $port = 25; 
    private $tomail = ""; 
    private $frommail ="kdh_admin@datahouse.co.kr"; 
    private $webid="nearBuy"; 
    private $subject = ""; 
    private $type = "text/html"; // 이건 html 형식으로 보낼때 씁니다. 
    private $message = ""; 
	
	function __construct()
	{
		
	}

	function setTomail($to='')
	{
		$this->tomail = trim($to);
	}

	function setSubject($title='')
	{
		$this->subject = trim($title);
	}

	function setMessage($msg='')
	{
		$this->message = trim($msg);
	}
	
	function sendMail()
	{	
	    $fp = fsockopen($this->host, $this->port, &$errno, &$errstr, 30);  
	
	    if($fp) { 
	        fgets($fp, 128);  
	        fputs($fp, "helo ".$_SERVER["HTTP_HOST"]."\n");  
	        fgets($fp, 128);  
	
	        // 이부분에 다음과 같이 로긴과정만 들어가면됩니다. 
	        fputs($fp, "auth login\n"); 
	        fgets($fp,128); 
	        fputs($fp, base64_encode($this->smtp_id)."\n"); 
	        fgets($fp,128); 
	        fputs($fp, base64_encode($this->smtp_pwd)."\n"); 
	        fgets($fp,128); 
	
	        fputs($fp, "mail from: <".$this->frommail.">\n");  
	        $returnvalue[0] = fgets($fp, 128);  
	        fputs($fp, "rcpt to: <".$this->tomail.">\n");  
	        $returnvalue[1] = fgets($fp, 128); 
	        fputs($fp, "data\n");  
	        fgets($fp, 128);  
	        fputs($fp, "Return-Path: ".$this->frommail."\n");  
	        fputs($fp, "From: ".$webid." <".$this->frommail.">\n");  
	        fputs($fp, "To: <".$this->tomail.">\n");  
	        fputs($fp, "Subject: ".$this->subject."\n");  
	        fputs($fp, "Content-Type: ".$this->type."; charset='utf8'\n");  
	        //fputs($fp, "Content-Transfer-Encoding: base64\n");  
	        fputs($fp, "\n");  
	
	        //$message= chunk_split(base64_encode($message));  
	        fputs($fp, $this->message);  
	        fputs($fp, "\n");  
	        fputs($fp, "\n.\n");  
	        $returnvalue[2] = fgets($fp, 128);  
	        fclose($fp);  
	
	        if (str_starts_with($returnvalue[0], "250") && str_starts_with($returnvalue[1], "250") && str_starts_with($returnvalue[2], "250")) { 
	            $sendmail_flag = true; 
	        } 
	    } 
	
	    return $sendmail_flag;
	}
}

?>