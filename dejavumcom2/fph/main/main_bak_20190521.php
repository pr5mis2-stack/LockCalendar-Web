<?php
    /**
 *  main.php
 *  @Desc      : 
 *  @Author    : SUYA
 *  @Date      : 2012. 03. 07.  11:03:57
 *  @param 	 
 *  @Return
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/include/common_top.php");
?>
<link rel="stylesheet" type="text/css" href="/css/navigation.css" />
<script type="text/javascript" src="/js/navigation.plug-in.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#side-nav a").vertSlider({
	
	});
});

function showhidden(obj){
	var obj2 = document.getElementById(obj);
	if(obj2.style.display=='none'){
		obj2.style.display = 'block';
	}else{
		obj2.style.display='none';
	}
}
</script>
<html>


<!--̾˾-->

<script language="JavaScript">

function setcookie( name, value, expirehours ) {
var todayDate = new Date();
todayDate.setHours( todayDate.getHours() + expirehours );
document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}

function closeWin() {
if ( document.notice_form.chkbox.checked ){
setcookie( "maindiv", "done" , 24 );
}

document.all['divpop'].style.display = "none";

}

</script>

 <!--̾˾  -->

 

</HEAD>

 <BODY>

 

<!-- ̾POPUP -->

<div id="divpop" style="width:400px; height:800px; position:absolute; left:100px; top:150px; z-index:1000; visibility:hidden;">
<table width=450 height=397 cellpadding=2 cellspacing=0>
<form name="notice_form">
<tr>
    <td align=center bgcolor=white>
<img src='http://dejavu-m.com/main/images/mobile.jpg'  border='0'>    </td>
</tr>
<tr>

    <td align=right bgcolor=#000000>
        <input type="checkbox" name="chkbox" value=""><font color=#FFFFFF size=3px> Ϸ  â  
        </font><a href="javascript:closeWin();"><B><font color=#FFFFFF size=3px>[ݱ]</font></B></a>
    </td>
</tr>
        </form>
</table>

</div>

<script language="Javascript">
cookiedata = document.cookie;  
if ( cookiedata.indexOf("maindiv=done") < 0 ){    
    document.all['divpop'].style.visibility = "visible";
    }
    else {
        document.all['divpop'].style.visibility = "hidden";
}
</script>

<!-- ̾POPUP  -->


<head>
	<title></title>

<script language="JavaScript">
<!--
function setCookie( name, value, expiredays ) { 
	var todayDate = new Date(); 
		todayDate.setDate( todayDate.getDate() + expiredays ); 
		document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";" 
	} 

function closeWin() { 
	if ( document.notice_form.chkbox.checked ){ 
		setCookie( "maindiv", "done" , 1 ); 
	} 
	document.all['divpop'].style.visibility = "hidden";
}
//-->  
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">  




	<div id="container">
		<div class="content1">
			<div id="main-container">
				<div id="main-container-background">
					<div class="row-273 s0 mobile-public"><img src="/img/main_visual.png" alt="Dejavu Ʈ ʴ" width="960" height="695" usemap="#main_visual" /></div>
					<div class="row-273 s1 mobile-public"><img src="/img/main_visual2.png" alt="Dejavu Ʈ ʴ" width="960" height="695" usemap="#main_visual" /></div>
					<div class="row-273 s2 mobile-public"><img src="/img/main_visual3.png" alt="Dejavu Ʈ ʴ" width="960" height="695" usemap="#main_visual" /></div>
					<div class="row-273 s3 mobile-public"><img src="/img/main_visual4.png" alt="Dejavu Ʈ ʴ" width="960" height="695" usemap="#main_visual" /></div>
					<div class="row-273 s4 mobile-public"><img src="/img/main_visual5.png" alt="Dejavu Ʈ ʴ" width="960" height="695" usemap="#main_visual" /></div>
					<div class="row-273 s5 mobile-public"><img src="/img/main_visual6.png" alt="Dejavu Ʈ ʴ" width="960" height="695" usemap="#main_visual" /></div>
					<!--<div class="row-273 s6 mobile-public"><img src="/img/main_visual7.png" alt="Dejavu Ʈ ʴ" width="960" height="695" usemap="#main_visual" /></div>-->
					<div class="row-273 s6 mobile-public"><img src="/img/main_visual8.png" alt="Dejavu Ʈ ʴ" width="960" height="695" usemap="#main_visual" /></div>
					<div class="row-273 s7 mobile-public"><img src="/img/main_visual.png" alt="Dejavu Ʈ ʴ" width="960" height="695" usemap="#main_visual" /></div>
				</div>
			</div>
			<map name="main_visual" id="main_visual">
			  <area shape="rect" coords="593,565,876,618" href="/maker/main.php" title="Ʈ ʴ "/>
			</map>
		</div>
		
		<div class="content2">
			<ul>
			<li>
				<p class="mphoto" onclick="javascript:showhidden('sample_review')" style="cursor:pointer"><img src="/img/thumb_1.png" alt="" width="146" height="260" /></p>
				<h4>1</h4>
			</li>
			<li>
				<p class="mphoto" onclick="javascript:showhidden('sample_review2')" style="cursor:pointer"><img src="/img/thumb_2.png" alt="" width="146" height="260" /></p>
				<h4>2</h4>
			</li>
			<li>
				<p class="mphoto" onclick="javascript:showhidden('sample_review3')" style="cursor:pointer"><img src="/img/thumb_3.png" alt="" width="146" height="260" /></p>
				<h4>3</h4>
			</li>
			<li>
				<p class="mphoto" onclick="javascript:showhidden('sample_review4')" style="cursor:pointer"><img src="/img/thumb_4.jpg" alt="" width="146" height="260" /></p>
				<h4>4</h4>
			</li>
			<li>
				<p class="mphoto" onclick="javascript:showhidden('sample_review5')" style="cursor:pointer"><img src="/img/thumb_5.jpg" alt="" width="146" height="260" /></p>
				<h4>5</h4>
			</li>
			<li>
				<p class="mphoto" onclick="javascript:showhidden('sample_review6')" style="cursor:pointer"><img src="/img/thumb_6.jpg" alt="" width="146" height="260" /></p>
				<h4>6</h4>
			</li>
			<li>
				<p class="mphoto" onclick="javascript:showhidden('sample_review7')" style="cursor:pointer"><img src="/img/thumb_8.jpg" alt="" width="146" height="260" /></p>
				<h4>7</h4>
			</li>
			<li>
				<p class="mphoto" onclick="javascript:showhidden('sample_review8')" style="cursor:pointer"><img src="/img/thumb_9.jpg" alt="" width="146" height="260" /></p>
				<h4>8</h4>
			</li>
			<li>
				<p class="mphoto" onclick="javascript:showhidden('sample_review9')" style="cursor:pointer"><img src="/img/thumb_10.jpg" alt="" width="146" height="260" /></p>
				<h4>9</h4>
			</li>
			<li>
				<p class="mphoto" onclick="javascript:showhidden('sample_review10')" style="cursor:pointer"><img src="/img/thumb_11.jpg" alt="" width="146" height="260" /></p>
				<h4>10</h4>
			</li>
			
			</ul>
		</div>
	</div>

<?php require_once($_SERVER["DOCUMENT_ROOT"]."/include/common_footer.php"); ?>


