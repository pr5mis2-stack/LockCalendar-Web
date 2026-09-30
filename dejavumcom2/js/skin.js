/* 쿠키 */
function getCookie(cookieName){
	var cookies=document.cookie;
	if(cookies.indexOf(cookieName)==-1)return false;
	cookie=cookies.substr(cookies.indexOf(cookieName));
	cookie=cookie.split(';')[0];
	cookie=cookie.substr(cookie.indexOf('=')+1);
	return cookie;
}

function getStyleAtt(obj,stylePrp){
	var att="";
	if(obj.currentStyle){
	stylePrp=stylePrp.replace(/\-(\w)/g,function(k,z){return z.toUpperCase();});
	att=obj.currentStyle[stylePrp];
	}
	else if(document.defaultView&&document.defaultView.getComputedStyle){
	att=document.defaultView.getComputedStyle(obj,null).getPropertyValue(stylePrp);
	}
	return att;
}

function setCookie( name, value, expiredays )
{
	var todayDate = new Date();
	todayDate.setDate( todayDate.getDate() + expiredays );
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}

/* 리사이즈 */
var switchMetaContent = function() {
	var meta_tag = "";
	
	if (/AppleWebKit/.test(navigator.userAgent)) {
		document.write ("<meta name=\"viewport\" content=\"user-scalable=no, initial-scale = 1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width\" />");
	} 
	else if (/Opera/.test(navigator.userAgent) && !/Opera Mini/.test(navigator.userAgent)) {
		document.write ("<meta name=\"viewport\" content=\"user-scalable=no, initial-scale = 0.75, maximum-scale=0.75, minimum-scale=0.75, width=device-width\" />");
	} 
	else {
		document.write ("<meta name=\"viewport\" content=\"user-scalable=no, initial-scale = 1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width\" />");
	}
}

switchMetaContent();

// wrapper 의 높이를 최소한 화면 사이즈로 늘린다. 
$(document).ready(function(){
	bodyresize(); 
	
	$("#btn_nmap").click(function () {
		gotoNaverMap(s_xloc, s_yloc, s_addr);
	});
	
	$("#btn_call_f").click(function () {
		top.location.href = "tel:"+father_hp;
	});	

	$("#btn_call_m").click(function () {
		top.location.href = "tel:"+mother_hp;
	});	

	$("#btn_sms_f").click(function () {
		top.location.href = "sms:"+father_hp;
	});	
	
	$("#btn_sms_m").click(function () {
		top.location.href = "sms:"+mother_hp;
	});	

	$("#btn_board").click(function () {
		location.href = board_url;
		//window.open('about:blank').location.href = board_url;
	});	

	$("#btn_gallery").click(function () {
		location.href = gallery_url;
		//window.open('about:blank').location.href = gallery_url;
	});	
	
	$("#btn_kakao").click(function () {
		kakaoTalkSend(m_url, m_msg);
	});	
	
	$("#btn_facebook").click(function () {
		goSns('facebook', m_url, m_msg, m_tag); 
	});	
	
	$("#btn_twitter").click(function () {
		goSns('twitter', m_url, m_msg, m_tag); 
	});	
	
	$("#btn_me2day").click(function () {
		goSns('me2day', m_url, m_msg, m_tag); 
	});	
});
/* 윈도우 조절시 레이아웃 위치 재조정 */
$(window).bind("resize", function() {
	bodyresize();
});

var deBodyWidth = 0;
var deBodyHeight = 0;

function bodyresize() {
	var defaultwidth = 320;
	var bodywidth = $("body").width();
	if( deBodyWidth == 0 || deBodyWidth != bodywidth) {
		deBodyWidth = bodywidth;
		var bodyratio = bodywidth / defaultwidth;
		var bodyfontsize = 10 * bodyratio;
		$("body").css("font-size", bodyfontsize);
	}

}

/**
 * view naver largemap
 */
gotoNaverMap = function(xloc, yloc, addr) {

	var goUrl = "http://m.map.naver.com/map.nhn?lng="+xloc+"&lat="+yloc+"&dlevel=11&title="+encodeURIComponent(addr)+"&isShowPolygon=true&isDetailAddress=true";
	window.open('about:blank').location.href = goUrl;
}

/**
 * view naver route
 */
gotoNaverRoute = function(xloc, yloc, addr) {
	var goUrl = "http://m.map.naver.com/route.nhn?ex="+xloc+"&ey="+yloc+"&ename="+encodeURIComponent(addr);
	window.open('about:blank').location.href = goUrl;
}

/**
 * send sns
 */
sendSNS = function(site, url, msg, tag) { 
	var goUrl; 
	
	if (site == "facebook") {
		goUrl = "http://www.facebook.com/sharer.php?u=" + url + "&t=" + encodeURIComponent(msg); 
	} else if(site == "twitter") { 
		goUrl = "http://twitter.com/home?status=" + encodeURIComponent(msg) + " " + encodeURIComponent(url); 
	} else if(site == "me2day") { 
		goUrl = "http://me2day.net/posts/new?new_post[body]=" + encodeURIComponent(msg) + " " + encodeURIComponent(url) + "&new_post[tags]=" + encodeURIComponent(tag); 
	}
	top.location.href = goUrl; 
} 

/**
 * kakaotalk
 */
kakaoTalkSend = function(url, msg) {
	kakao.link("talk").send({   
		msg : msg,
        url : url,  
        appid : "m.dejavu-m.com",
        appver : "2.0",
        appname : "데자뷰",
        type : "link"
	});
}

/**
 * kakaostory
 */
KakaoStorySend = function(url, msg, cont, img)
{
	kakao.link("story").send({   
		post : url,
		appid : "m.dejavu-m.com",
		appver : "1.0",
		appname : "데자뷰",
		urlinfo : JSON.stringify({title:msg, desc:cont, imageurl:[img], type:"article"})
	});
}