/**
 * 바로가기 등록
 * @param mid
 */
function onClickPraseApp(mid){
    if(isAndroid()){
        location.href="http://m.dejavu-m.com/?m="+mid;
    }else{
        if(isiphone()||isIpad()){
            var b="dejavu-m://";
            var a="http://http://m.dejavu-m.com/?m="+mid;
            onClickApp(b,a)
        }
    }
}

function onClickApp(c,b){
    var a=+new Date;
    try{
        location.href=c
    }
    catch(d){}
    setTimeout(function(){if(+new Date-a<2000){location.href=b}},500)
}

/**
 * 아이폰 체크
 * @returns
 */
function isiphone() {
	return hasStringInUserAgent("iphone")
}

/**
 * 아이패드 체크
 * @returns
 */
function isIpad() {
	return hasStringInUserAgent("ipad")
}

/**
 * 안드로이드 체크
 * @returns {Boolean}
 */
function isAndroid() {
	return hasStringInUserAgent("android") || hasStringInUserAgent("Linux")
}

/**
 * 아이팟 체크
 * @returns
 */
function isIpod() {
	return hasStringInUserAgent("ipod")
}

/**
 * 문자열 체크
 * @param b
 * @returns {Boolean}
 */
function hasStringInUserAgent(b) {
	var a = navigator.userAgent.toLowerCase();
	if (a.indexOf(b) != -1) {
		return true
	} else {
		return false
	}
}

/**
 * 바로가기 링크 파비콘 설정
 */
function makeHeadLink()
{
	if(isiphone()) {
	   document.write('<link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon.png" />');	// 114X114
	} else if(isIpad()) {
	   document.write('<link rel="apple-touch-icon" sizes="72*72" href="/img/favicon/apple-touch-icon-ipad.png" />'); 	// 72X72
	} else if(isIpod()) {
	   document.write('<link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon.png" />');	// 57X57
	} else if(isAndroid()) {
	   document.write('<link rel="apple-touch-icon-precomposed" href="/img/favicon/apple-touch-icon.png" />');
	} else {
	   document.write('<link rel="shortcut icon" href="/img/favicon/favicon.ico" />');
	}
}
