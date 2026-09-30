<?phpPHP
$sms_url = "http://smsapi.cafe24.com/sms_list.php"; // ۿû URL
$sms['user_id'] = "dejavusms"; // SMS ̵
$sms['secure'] = "2e99335486e8c9e2e3f32c367db26469 " ;//Ű
$sms['date'] = "" ;//ȸ 
$sms['day'] = "1" ;//ȸ 
$sms['startNo'] = "0" ;//ȸ ۹ȣ
$sms['displayNo'] = "10" ;// 
$sms['sendType'] = "" ;//߼
$sms['sendStatus'] = "" ;//߼ۻ
$sms['receivePhone'] = "" ;//˻ Źȣ
$sms['sendPhone'] = "" ;//˻ ߽Źȣ

$host_info = explode("/", $sms_url);
$host = $host_info[2];
$path = $host_info[3]."/".$host_info[4];
srand((double)microtime()*1000000);
$boundary = "---------------------".substr(md5(rand(0,32000)),0,10);

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
    echo $msg[1];
}
else {
    echo "Connection Failed";
}
?>