<?php
/**
 *  index.php
 *  @Desc      : index
 *  @Author    : SUYA
 *  @Date      : 2012. 03. 07. 오전 11:03:57
 *  @param 	 
 *  @Return
 */

//echo "<META http-equiv=\"refresh\" content=\"0; url=/notice.html\">";
//exit;

if (!empty($_SESSION['dejavu_id']))
	echo "<META http-equiv=\"refresh\" content=\"0; url=/maker/main.php\">";
else
	echo "<META http-equiv=\"refresh\" content=\"0; url=/main/main.php\">";
?>
<script language="Javascript" type="text/Javascript"> 
var mobileKeyWords = new Array('iPhone', 'iPod', 'BlackBerry', 'Android', 'Windows CE', 'BlackBerry', 'LG', 'MOT', 'SAMSUNG', 'SonyEricsson'); 
for (var word in mobileKeyWords){ 
if (navigator.userAgent.match(mobileKeyWords[word]) != null){ 
parent.window.location.href='./mobile.html'; 
break; 
} 
} 
</script> 