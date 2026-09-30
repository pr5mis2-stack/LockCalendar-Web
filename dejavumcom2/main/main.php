<?php
    /**
 *  main.php
 *  @Desc      : 메인
 *  @Author    : SUYA
 *  @Date      : 2012. 03. 07. 오전 11:03:57
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

function showhidden_preview(obj) {
	$("#pop_style300 .preview .con .sample").hide();
	$("#"+obj).show();
}
</script>
<!--레이어팝업-->
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
<!--레이어팝업 끝 -->
<!-- 레이어POPUP 시작-->
<!--
<div id="divpop" style="width:400px; height:800px; position:absolute; left:100px; top:150px; z-index:1000; visibility:hidden;">
<form name="notice_form">
<table width=450 height=397 cellpadding=2 cellspacing=0>
	<tr>
	    <td align=center bgcolor=white>
	<img src='http://dejavu-m.com/main/images/mobile.jpg'  border='0'>    </td>
	</tr>
	<tr>
	    <td align=right bgcolor=#000000>
	        <input type="checkbox" name="chkbox" value=""><font color=#FFFFFF size=3px>오늘 하루 이 창을 열지 않음.
	        </font><a href="javascript:closeWin();"><B><font color=#FFFFFF size=3px>[닫기]</font></B></a>
	    </td>
	</tr>
</table>
</form>
</div>
-->
<script language="Javascript">
cookiedata = document.cookie;  
if ( cookiedata.indexOf("maindiv=done") < 0 ){    
    document.all['divpop'].style.visibility = "visible";
    }
    else {
        document.all['divpop'].style.visibility = "hidden";
}
</script>
<!-- 레이어POPUP 끝 -->
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

function showTab(tab) {
	if (tab == 2) {
		$("#tab01").attr("src", "/img/main_tab01.jpg");
		$("#tab02").attr("src", "/img/main_tab02_on.jpg");
		$("#tab03").attr("src", "/img/main_tab03.jpg");
		$("#sample_tab02").show();
		$("#sample_tab01").hide();
		$("#sample_tab03").hide();
		showhidden_preview('sp_wd1');
	} else if (tab == 3) {
		$("#tab01").attr("src", "/img/main_tab01.jpg");
		$("#tab02").attr("src", "/img/main_tab02.jpg");
		$("#tab03").attr("src", "/img/main_tab03_on.jpg");
		$("#sample_tab03").show();
		$("#sample_tab01").hide();
		$("#sample_tab02").hide();
		showhidden_preview('sp_sv1');
	} else {
		$("#tab01").attr("src", "/img/main_tab01_on.jpg");
		$("#tab02").attr("src", "/img/main_tab02.jpg");
		$("#tab03").attr("src", "/img/main_tab03.jpg");
		$("#sample_tab01").show();
		$("#sample_tab02").hide();
		$("#sample_tab03").hide();
		showhidden_preview('sp_bb1');
	}
}
//-->  
</script>
<script src="http://www.dejavu-m.com/js/jquery.easing.1.3.js"></script>
<script src="http://www.dejavu-m.com/js/idangerous.swiper.js"></script>
<link rel="stylesheet" href="http://www.dejavu-m.com/css/idangerous.swiper.css">
<<style>
<!--
#slide1 { width: 950px; margin: 0 auto; padding: 69px 0 0 30px;}
#slide1 .inner { width:980px; /*margin-left:50px; margin-right:50px;*/ }
#slide1 .swiper-slide { width:237px; height:300px; }
#slide1 .swiper-slide p { margin-left:10px; }
#slide1 .swiper-slide h4 { font-size: 12px; font-weight: normal; margin-top: 10px; color: #333; }
#slide1 .swiper-button-prev{left:-10px; /*left:170px;*/background:url("http://eventimg.auction.co.kr/md/auction/09520E7F2F/w_btn_prev2.png") left top no-repeat;width: 80px;/*top:195px;*/z-index: 20;height: 80px;position: absolute;cursor:pointer;}
#slide1 .swiper-button-next{right:-10px; /*right:170px;*/background:url("http://eventimg.auction.co.kr/md/auction/09520E7F2F/w_btn_next2.png") left top no-repeat;width: 80px;/*top:195px;*/z-index: 20;height: 80px;position: absolute;cursor: pointer;}

#slide2 { width: 950px; margin: 0 auto; padding: 69px 0 0 30px;}
#slide2 .inner { width:980px; /*margin-left:50px; margin-right:50px;*/ }
#slide2 .swiper-slide { width:237px; height:300px; }
#slide2 .swiper-slide p { margin-left:10px; }
#slide2 .swiper-slide h4 { font-size: 12px; font-weight: normal; margin-top: 10px; color: #333; }
#slide2 .swiper-button-prev{left:-10px; /*left:170px;*/background:url("http://eventimg.auction.co.kr/md/auction/09520E7F2F/w_btn_prev2.png") left top no-repeat;width: 80px;/*top:195px;*/z-index: 20;height: 80px;position: absolute;cursor:pointer;}
#slide2 .swiper-button-next{right:-10px; /*right:170px;*/background:url("http://eventimg.auction.co.kr/md/auction/09520E7F2F/w_btn_next2.png") left top no-repeat;width: 80px;/*top:195px;*/z-index: 20;height: 80px;position: absolute;cursor: pointer;}

#slide3 { width: 950px; margin: 0 auto; padding: 69px 0 0 30px;}
#slide3 .inner { width:980px; /*margin-left:50px; margin-right:50px;*/ }
#slide3 .swiper-slide { width:237px; height:300px; }
#slide3 .swiper-slide p { margin-left:10px; }
#slide3 .swiper-slide h4 { font-size: 12px; font-weight: normal; margin-top: 10px; color: #333; }
#slide3 .swiper-button-prev{left:-10px; /*left:170px;*/background:url("http://eventimg.auction.co.kr/md/auction/09520E7F2F/w_btn_prev2.png") left top no-repeat;width: 80px;/*top:195px;*/z-index: 20;height: 80px;position: absolute;cursor:pointer;}
#slide3 .swiper-button-next{right:-10px; /*right:170px;*/background:url("http://eventimg.auction.co.kr/md/auction/09520E7F2F/w_btn_next2.png") left top no-repeat;width: 80px;/*top:195px;*/z-index: 20;height: 80px;position: absolute;cursor: pointer;}

.content2 .center { width: 950px; margin: 0 auto; }
.content2 .center .left { width: 345px; float:left; }
.content2 .center .right { width: 605px; float: right; }
.content2 .center .right div { margin-bottom: 20px; }
.content2 .center .right ul { /*width: 950px;*/ width: 80%; padding: 0 0 0 10px; /*float: left;*/}
.content2 .center .right ul li { margin:0 0 40px 20px; }
.content2 .center .right ul li .mphoto { width: 73px; height:130px;}
.content2 .center .right ul li .mphoto img { width:73px; height:130px; }

#pop_style300 {width:300px;padding:0;text-align:center;font-size:12px;color:#fff;line-height:normal;white-space:normal;position:relative;margin: 0 auto; }
#pop_style300 .preview{width:300px;height:750px;background:url(../img/preview_bg_300.png) no-repeat;position:relative}
#pop_style300 .preview .con {width:255px;height:430px;overflow-x:hidden;overflow-y:scroll;border:1px solid #d7d7d7;position:absolute;left:20px;top:60px}
#pop_style300 .preview .con .sample { width:242px; }
-->
</style>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">  
	<div id="container">
		<div class="content1">
			<div id="main-container">
				<div id="main-container-background">
					<div class="row-273 s0 mobile-public"><img src="/img/main_visual.png" alt="Dejavu 스마트 초대장" width="960" height="695" usemap="#main_visual" /></div>
					<div class="row-273 s1 mobile-public"><img src="/img/main_visual2.png" alt="Dejavu 스마트 초대장" width="960" height="695" usemap="#main_visual" /></div>
					<div class="row-273 s2 mobile-public"><img src="/img/main_visual3.png" alt="Dejavu 스마트 초대장" width="960" height="695" usemap="#main_visual" /></div>
					<div class="row-273 s3 mobile-public"><img src="/img/main_visual4.png" alt="Dejavu 스마트 초대장" width="960" height="695" usemap="#main_visual" /></div>
					<div class="row-273 s4 mobile-public"><img src="/img/main_visual5.png" alt="Dejavu 스마트 초대장" width="960" height="695" usemap="#main_visual" /></div>
					<div class="row-273 s5 mobile-public"><img src="/img/main_visual6.png" alt="Dejavu 스마트 초대장" width="960" height="695" usemap="#main_visual" /></div>
					<!--<div class="row-273 s6 mobile-public"><img src="/img/main_visual7.png" alt="Dejavu 스마트 초대장" width="960" height="695" usemap="#main_visual" /></div>-->
					<div class="row-273 s6 mobile-public"><img src="/img/main_visual8.png" alt="Dejavu 스마트 초대장" width="960" height="695" usemap="#main_visual" /></div>
					<div class="row-273 s7 mobile-public"><img src="/img/main_visual.png" alt="Dejavu 스마트 초대장" width="960" height="695" usemap="#main_visual" /></div>
				</div>
			</div>
			<map name="main_visual" id="main_visual">
			  <area shape="rect" coords="593,565,876,618" href="/maker/main.php" title="스마트 초대장 만들기"/>
			</map>
		</div>
		
		<div class="content2">
			<div class="center">
				<div class="left">
					<div id="pop_style300">
						<div class="preview">
							<span class="con">
							<img src="/img/sp1.jpg" alt="샘플1" class="sample" id="sp_bb1" />
							<img src="/img/sp2.jpg" alt="샘플2" class="sample" id="sp_bb2" style="display:none"/>
							<img src="/img/sp3.jpg" alt="샘플3" class="sample" id="sp_bb3" style="display:none"/>
							<img src="/img/sp4.jpg" alt="샘플4" class="sample" id="sp_bb4" style="display:none"/>
							<img src="/img/sp5.jpg" alt="샘플5" class="sample" id="sp_bb5" style="display:none"/>
							<img src="/img/sp6.jpg" alt="샘플6" class="sample" id="sp_bb6" style="display:none"/>
							<img src="/img/sp8.jpg" alt="샘플7" class="sample" id="sp_bb8" style="display:none"/>
							<img src="/img/sp9.jpg" alt="샘플8" class="sample" id="sp_bb9" style="display:none"/>
							<img src="/img/sp10.jpg" alt="샘플9" class="sample" id="sp_bb10" style="display:none"/>
							<img src="/img/sp11.jpg" alt="샘플10" class="sample" id="sp_bb11" style="display:none"/>
							
							<img src="/img/sp12.png" alt="샘플11" class="sample" id="sp_bb12" style="display:none"/>
							<img src="/img/sp13.png" alt="샘플12" class="sample" id="sp_bb13" style="display:none"/>
							<img src="/img/sp14.png" alt="샘플13" class="sample" id="sp_bb14" style="display:none"/>
							<img src="/img/sp15.png" alt="샘플14" class="sample" id="sp_bb15" style="display:none"/>
							<img src="/img/sp16.png" alt="샘플15" class="sample" id="sp_bb16" style="display:none"/>
							
							<img src="/img/sp_wd1.jpg" alt="샘플1" class="sample" id="sp_wd1" style="display:none"/>
							<img src="/img/sp_wd2.jpg" alt="샘플2" class="sample" id="sp_wd2" style="display:none"/>
							<img src="/img/sp_wd3.jpg" alt="샘플3" class="sample" id="sp_wd3" style="display:none"/>
							<img src="/img/sp_wd4.jpg" alt="샘플4" class="sample" id="sp_wd4" style="display:none"/>
							<img src="/img/sp_wd5.jpg" alt="샘플5" class="sample" id="sp_wd5" style="display:none"/>
							<img src="/img/sp_sv1.jpg" alt="샘플1" class="sample" id="sp_sv1" style="display:none"/>
							<img src="/img/sp_sv2.jpg" alt="샘플2" class="sample" id="sp_sv2" style="display:none"/>
							</span>
						</div>
					</div>
				</div>
				<div class="right">
					<div><img src="/img/main_tab00.jpg" /><a href="javascript:showTab(1);"><img id="tab01" src="/img/main_tab01_on.jpg" /></a><a href="javascript:showTab(2);"><img id="tab02" src="/img/main_tab02.jpg" /></a><a href="javascript:showTab(3);"><img id="tab03" src="/img/main_tab03.jpg" /></a><img src="/img/main_tab04.jpg" /></div>
					
					<ul id="sample_tab01">
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_bb1')" style="cursor:pointer"><img src="/img/thumb_1.png" alt="샘플1" /></p>
							<h4>돌잔치 샘플1</h4>
						</li>
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_bb2')" style="cursor:pointer"><img src="/img/thumb_2.png" alt="샘플2" /></p>
							<h4>돌잔치 샘플2</h4>
						</li>
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_bb3')" style="cursor:pointer"><img src="/img/thumb_3.png" alt="샘플3" /></p>
							<h4>돌잔치 샘플3</h4>
						</li>
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_bb4')" style="cursor:pointer"><img src="/img/thumb_4.jpg" alt="샘플4" /></p>
							<h4>돌잔치 샘플4</h4>
						</li>
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_bb5')" style="cursor:pointer"><img src="/img/thumb_5.jpg" alt="샘플5" /></p>
							<h4>돌잔치 샘플5</h4>
						</li>
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_bb6')" style="cursor:pointer"><img src="/img/thumb_6.jpg" alt="샘플6" /></p>
							<h4>돌잔치 샘플6</h4>
						</li>
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_bb8')" style="cursor:pointer"><img src="/img/thumb_8.jpg" alt="샘플7" /></p>
							<h4>돌잔치 샘플7</h4>
						</li>
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_bb9')" style="cursor:pointer"><img src="/img/thumb_9.jpg" alt="샘플8" /></p>
							<h4>돌잔치 샘플8</h4>
						</li>
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_bb10')" style="cursor:pointer"><img src="/img/thumb_10.jpg" alt="샘플9" /></p>
							<h4>돌잔치 샘플9</h4>
						</li>
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_bb11')" style="cursor:pointer"><img src="/img/thumb_11.jpg" alt="샘플10" /></p>
							<h4>돌잔치 샘플10</h4>
						</li>
						
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_bb12')" style="cursor:pointer"><img src="/img/thumb_12.png" alt="샘플11" /></p>
							<h4>돌잔치 샘플11</h4>
						</li>
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_bb13')" style="cursor:pointer"><img src="/img/thumb_13.png" alt="샘플12" /></p>
							<h4>돌잔치 샘플12</h4>
						</li>
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_bb14')" style="cursor:pointer"><img src="/img/thumb_14.png" alt="샘플13" /></p>
							<h4>돌잔치 샘플13</h4>
						</li>
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_bb15')" style="cursor:pointer"><img src="/img/thumb_15.png" alt="샘플14" /></p>
							<h4>돌잔치 샘플14</h4>
						</li>																								
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_bb16')" style="cursor:pointer"><img src="/img/thumb_16.png" alt="샘플14" /></p>
							<h4>돌잔치 샘플15</h4>
						</li>
					</ul>
					<ul id="sample_tab02" style="display:none;">
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_wd1')" style="cursor:pointer"><img src="/img/thumb_wd1.jpg" alt="샘플1" /></p>
							<h4>웨딩 샘플1</h4>
						</li>
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_wd2')" style="cursor:pointer"><img src="/img/thumb_wd2.jpg" alt="샘플2" /></p>
							<h4>웨딩 샘플2</h4>
						</li>
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_wd3')" style="cursor:pointer"><img src="/img/thumb_wd3.jpg" alt="샘플3" /></p>
							<h4>웨딩 샘플3</h4>
						</li>
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_wd4')" style="cursor:pointer"><img src="/img/thumb_wd4.jpg" alt="샘플2" /></p>
							<h4>웨딩 샘플4</h4>
						</li>
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_wd5')" style="cursor:pointer"><img src="/img/thumb_wd5.jpg" alt="샘플3" /></p>
							<h4>웨딩 샘플5</h4>
						</li>
					</ul>

					<ul id="sample_tab03" style="display:none;">
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_sv1')" style="cursor:pointer"><img src="/img/thumb_sv1.jpg" alt="샘플1" /></p>
							<h4>고희연 샘플1</h4>
						</li>
						<li>
							<p class="mphoto" onclick="javascript:showhidden_preview('sp_sv2')" style="cursor:pointer"><img src="/img/thumb_sv2.jpg" alt="샘플2" /></p>
							<h4>고희연 샘플2</h4>
						</li>
					</ul>
				</div>
			</div>

		</div>
	</div>

<?php require_once($_SERVER["DOCUMENT_ROOT"]."/include/common_footer.php"); ?>


