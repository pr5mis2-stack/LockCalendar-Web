<?php
#ini_set("session.cookie_domain",".dejavu-m.com") ;
#session_start();

/**
 *  pop_top.php
 *  @Desc      : Front에서 공통으로 사용되는 파일-상단메뉴 popup용
 *  @Author    : suya
 *  @Date      : 2012. 04. 27
 *  @param 	 
 *  @Return
 */

require_once ($_SERVER["DOCUMENT_ROOT"]."/include/common_header.php");

import("class.controller.ServiceLogCon");    // 서비스 로그 저장

$ServiceLogCon = new ServiceLogCon();

session_cache_limiter("none");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-store" />
<meta http-equiv="Pragma" content="no-cache" />
<title>dejavu</title>
<script type="text/javascript" src="/js/ajax.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/jquery-1.6.4.js"></script>
<script type="text/javascript" src="/js/calendar.js"></script>
<script type="text/javascript" src="/js/AC_RunActiveContent.js"></script>
<?=$link_css;?>
<script>
function setPng24(obj) {
	obj.width=obj.height=1;
	obj.className=obj.className.replace(/\bpng24\b/i,'');
	obj.style.filter =
	"progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+ obj.src +"',sizingMethod='image');"
	obj.src=''; 
	return '';
}

</script>
<!--[if IE 6]>
<script type="text/javascript" src="../js/DD_belatedPNG.js"></script>  
<script type="text/javascript">  
// DD_belatedPNG.fix('img, .png');   
</script>  
<![endif]-->
<style type="text/css">
.png24 {
   tmp:expression(setPng24(this));
}
png{
}
</style>
</head>
<body>
<?php
$ServiceLogCon->InsertServiceLog();
?>