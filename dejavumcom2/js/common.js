// 필드 입력값 체크
function checkVariableField(fldName, msg)
{
	if (document.getElementById(fldName).value == "")
	{
		alert(msg);
		document.getElementById(fldName).focus();
		return false;
	}		
	else
		return true;
}

//키보드에서 숫자만 입력 가능하도록 제한한다.
function checkInputNumber()
{
	if((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105))
	{
		event.returnValue = true;
	}
	else
	{
		switch(event.keyCode)
		{
			case 8:		/* Backspace */
			case 9:		/* Tab */
			case 13:	/* Enter */
			case 35:	/* End */
			case 36:	/* Home */
			case 37:	/* Left Arrow */
			case 38:	/* Up Arrow */
			case 39:	/* Right Arrow */
			case 40:	/* Down Arrow */
			case 45:
			case 46:	/* Del */
			case 109:
			case 144:	/* Num lock */
			case 189:	/* - */
				event.returnValue = true;
				break;

			default:
				event.returnValue = false;
				break;
		}
	}
}

// 일정 개수의 문자가 입력되면 포커스를 이동시킨다.
function focusMove(current, next, len)
{
	if(len == '0')
	{
		next.focus();
		return;
	}
		
	if(current.value.length == len)
	{
		next.focus();
		return;
	}
}

function emailCheck(emailStr)
{
	var checkTLD = 1;
	var knownDomsPat = /^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;
	var emailPat = /^(.+)@(.+)$/;
	var specialChars = "\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
	var validChars = "\[^\\s" + specialChars + "\]";
	var quotedUser = "(\"[^\"]*\")";
	var ipDomainPat = /^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
	var atom = validChars + '+';
	var word = "(" + atom + "|" + quotedUser + ")";
	var userPat = new RegExp("^" + word + "(\\." + word + ")*$");
	var domainPat = new RegExp("^" + atom + "(\\." + atom +")*$");
	var matchArray = emailStr.match(emailPat);
	var errorMsg = "올바른 메일 주소를 입력하십시오.";

	if(matchArray == null)
	{
		alert(errorMsg);
		return false;
	}

	var user = matchArray[1];
	var domain = matchArray[2];

	for(i = 0; i < user.length; i++)
	{
		if(user.charCodeAt(i) > 127)
		{
			alert(errorMsg);
			return false;
		}
	}

	for(i = 0; i < domain.length; i++)
	{
		if(domain.charCodeAt(i) > 127)
		{
			alert(errorMsg);
			return false;
		}
	}

	if(user.match(userPat) == null)
	{
		alert(errorMsg);
		return false;
	}

	var IPArray = domain.match(ipDomainPat);

	if(IPArray != null)
	{
		for(var i = 1; i <= 4; i++)
		{
			if(IPArray[i] > 255)
			{
				alert(errorMsg);
				return false;
			}
		}

		return true;
	}

	var atomPat = new RegExp("^" + atom + "$");
	var domArr = domain.split(".");
	var len = domArr.length;

	for(i = 0; i < len; i++)
	{
		if(domArr[i].search(atomPat) == -1)
		{
			alert(errorMsg);
			return false;
		}
	}

	if(checkTLD && domArr[domArr.length-1].length != 2 && domArr[domArr.length-1].search(knownDomsPat) == -1) 
	{
		alert(errorMsg);
		return false;
	}

	if(len < 2)
	{
		alert(errorMsg);
		return false;
	}

	return true;
}

function existSpecialChar(field)
{
	if(field.value.indexOf('\'') != (-1) ||
		field.value.indexOf('\"') != (-1) || 
		field.value.indexOf('+') != (-1) || 
		field.value.indexOf('*') != (-1))
	{
		alert("+,*,%,!,$, (, ), \',\", ^ 등의 특수문자는 사용하실 수 없습니다.");
		field.focus();
		return true;
	}
	
	if(field.value.indexOf('&') != (-1) ||
		field.value.indexOf('#') != (-1) || 
		field.value.indexOf('!') != (-1) || 
		field.value.indexOf('^') != (-1) || 
		field.value.indexOf('@') != (-1))
	{
		alert("+,*,%,!,$, (, ), \',\", ^ 등의 특수문자는 사용하실 수 없습니다.");
		field.focus();
		return true;
	}

	return false;
}

function isAllSpace(field)
{
	var fieldStr = field.value;
	var count = 0;

	for (var i = 0; i < fieldStr.length; i++)
	{
		if(fieldStr.charAt(i) == " ")
			count++;
	}

	if(count == fieldStr.length)
		return true;
	else
		return false;
}


// 문자 공백 제거
String.prototype.trim = function() {  
	return this.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
}

//브라우져 종류 체크
function getNavigatorInfoStr()
{
    var name = navigator.appName, ver = navigator.appVersion,
        ver_int = parseInt(navigator.appVersion), ua = navigator.userAgent, infostr;
    if(name == "Microsoft Internet Explorer")
    {
        if(ver.indexOf("MSIE 3.0") != -1)
            return "Internet Explorer 3.0x";
        if(ver_int != 4)
            return "Internet Explorer " + ver.substring(0, ver.indexOf(" "));

        var real_ver = parseInt(ua.substring(ua.indexOf("MSIE ") + 5));
        if(real_ver >= 7)
            infostr = "Windows Internet Explorer ";
        else
            infostr = "Microsoft Internet Explorer ";

        if(ua.indexOf("MSIE 5.5") != -1)
            return infostr + "5.5";
        else
            return infostr + real_ver + ".x";

        return "Internet Explorer";
    }
    else if(name == "Netscape")
    {
        if(parseInt(ua.substring(8, 8)) <= 4)
          return "Netscape " + ver.substring(0, ver.indexOf(" "));
        else if(ua.lastIndexOf(" ") < ua.lastIndexOf("/"))
          return ua.substring(ua.lastIndexOf(" "));
        else
            return "Netscape";
    }
    else
        return name;
}

// OS 체크
function getOSInfoStr()
{
    var ua = navigator.userAgent;

    if(ua.indexOf("NT 6.0") != -1) return "Windows Vista/Server 2008";
    else if(ua.indexOf("NT 5.2") != -1) return "Windows Server 2003";
    else if(ua.indexOf("NT 5.1") != -1) return "Windows XP";
    else if(ua.indexOf("NT 5.0") != -1) return "Windows 2000";
    else if(ua.indexOf("NT") != -1) return "Windows NT";
    else if(ua.indexOf("9x 4.90") != -1) return "Windows Me";
    else if(ua.indexOf("98") != -1) return "Windows 98";
    else if(ua.indexOf("95") != -1) return "Windows 95";
    else if(ua.indexOf("Win16") != -1) return "Windows 3.x";
    else if(ua.indexOf("Windows") != -1) return "Windows";
    else if(ua.indexOf("Linux") != -1) return "Linux";
    else if(ua.indexOf("Macintosh") != -1) return "Macintosh";
    else return "";
}

// 레이어 노출, 비노출 처리 
// layer_view_onoff('neLayer', 0);  layer_view_onoff('neLayer', 1); 
function layer_view_onoff(lname, flag) 
{
    if (document.layers) {
        layer = document.layers[lname];        
    }
    else if (document.all) {
        layer = document.all[lname];
    }
    else {
        layer = document.getElementById(lname);        
    }

    if (lname == '')
        return;

    if (layer != null) {

        if (document.layers) {
            layer.style.display = (flag == 0) ? 'block' : 'none';
        }
        else if (document.all) {
            layer.style.display = (flag == 0) ? 'block' : 'none';
        }
        else {
            layer.style.display = (flag == 0) ? 'block' : 'none';
        }
    }
    
}

function layer_view_toggle(lname) 
{
    if (document.layers) {
        layer = document.layers[lname];        
    }
    else if (document.all) {
        layer = document.all[lname];
    }
    else {
        layer = document.getElementById(lname);        
    }

    if (lname == '')
        return;

    if (layer != null) {
    	alert(layer.style.display);
        if (document.layers) {
            layer.style.display = (layer.style.display == 'none') ? 'block' : 'none';
        }
        else if (document.all) {
            layer.style.display = (layer.style.display == 'none') ? 'block' : 'none';
        }
        else {
            layer.style.display = (layer.style.display == 'none') ? 'block' : 'none';
        }
        alert(layer.style.display);
    }
    
}


//필드 비활성화 처리
function selDisableStyle(val, flag)
{
	if (flag == "1")
	{
		document.getElementById(val).style.background = "silver";
		document.getElementById(val).disabled = true;
	}
	else
	{
		document.getElementById(val).style.background = "#FFFFFF";
		document.getElementById(val).disabled = false;
	}
}

// 탭에서 onmousesover 하였을 때 스타일을 on class명으로 변경
function onFocusMouse(lname, seq, count) 
{
    var layer;

    for (var i = 1; i <= count; i++) {
        layer = document.getElementById(lname + i);

        layer.className = "";
    }
    layer = document.getElementById(lname + seq);
    layer.className = "on";
}

//탭에서 onmousesover 하였을 때 스타일을 지정된 스타일로 변경
function onFocusMouseInClass(lname, seq, count, className) 
{
    var layer;

    for (var i = 1; i <= count; i++) {
        layer = document.getElementById(lname + i);

        layer.className = "";
    }
    layer = document.getElementById(lname + seq);
    layer.className = className;
}

// 토글 출력(이미지)
function toggleOnOff(iname, seq, count) 
{
    var img_url;

    for (var i = 1; i <= count; i++) {
        img_url = document.getElementById(iname + i);
        img_url.src = img_url.src.replace('_on.gif', '.gif');
    }
    
    img_url = document.getElementById(iname + seq);
    img_url.src = img_url.src.replace('.gif', '_on.gif');
}

// 탭 토글 출력(이미지버젼)
function toggleTabOnOff(lname, iname, seq, count) 
{
    var layer;
    var img_url;

    for (var i = 1; i <= count; i++) {
        layer = document.getElementById(lname + i);
        img_url = document.getElementById(iname + i);
        img_url.src = img_url.src.replace('_on.gif', '.gif');
        layer_view_onoff(lname + i, 1);        
    }
    
    layer_view_onoff(lname + seq, 0);
    img_url = document.getElementById(iname + seq);
    img_url.src = img_url.src.replace('.gif', '_on.gif');
}

// 탭 토글 출력(css 버젼)
function toggleTabCssOnOff(lname, iname, seq, count) 
{
    var layer;
    var css_layer;

    for (var i = 1; i <= count; i++) {
        layer = document.getElementById(lname + i);
        css_layer = document.getElementById(iname + i);
        css_layer.className = "off";

        layer_view_onoff(lname + i, 1);        
    }
    
    layer_view_onoff(lname + seq, 0);
    css_layer = document.getElementById(iname + seq);
    css_layer.className = "on";
}

//selectbox에 option 값 추가 함수
function addOptions(value, label)
{
	var newOption = document.createElement("OPTION");
	newOption.value =  value;
	newOption.text =  label;
	return newOption;
}

//업로드 이미지 미리보기
//onchange="fileUploadPreview(this, document.getElementById('nf_preview'));"
function fileUploadPreview(thisObj, preViewer) 
{
	if(!/(\.gif|\.jpg|\.jpeg|\.png)$/i.test(thisObj.value)) { return; }	

	 preViewer = (typeof(preViewer) == "object") ? preViewer : document.getElementById(preViewer);
	 var ua = window.navigator.userAgent;
	
	 if (ua.indexOf("MSIE") > -1) {
	     var img_path = "";
	     if (thisObj.value.indexOf("\\fakepath\\") < 0) {
	         img_path = thisObj.value;
	     } else {
	         thisObj.select();
	         var selectionRange = document.selection.createRange();
	         img_path = selectionRange.text.toString();
	         thisObj.blur();
	     }
	     preViewer.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='fi" + "le://" + img_path + "', sizingMethod='scale')";
	 } else {
	     preViewer.innerHTML = "";
	     var W = preViewer.offsetWidth;
	     var H = preViewer.offsetHeight;
	     var tmpImage = document.createElement("img");
	     preViewer.appendChild(tmpImage);
	
	     tmpImage.onerror = function () {
	         return preViewer.innerHTML = "";
	     }
	
	     tmpImage.onload = function () {
	         if (this.width > W) {
	             this.height = this.height / (this.width / W);
	             this.width = W;
	         }
	         if (this.height > H) {
	             this.width = this.width / (this.height / H);
	             this.height = H;
	         }
	     }
	     if (ua.indexOf("Firefox/3") > -1) {
	         var picData = thisObj.files.item(0).getAsDataURL();
	         tmpImage.src = picData;
	     } else {
	         tmpImage.src = "file://" + thisObj.value;
	     }
	 }
}

function proc(){
	;
}


//iframe auto resize
function Iframe_Autoresize(arg) {
	arg.height = eval(arg.name+".document.body.scrollHeight");
}

function centerNewPopWin(url, winName, width, height) {
	  var wi = screen.width - width;
	  var hi = screen.height - height;
	  
	  
	  if( wi < 0 ) wi = 0;   
	  if( hi < 0 ) hi = 0;

	  var info = 'left=' + (wi/2) + ',top=' + (hi/2) + ',width='  + width + ',height=' + height + ',resizable=no,scrollbars=yes,menubars=no,status=yes';
	  var newwin = window.open(url, winName, info);
	  newwin.focus();		  
}

// 쿠키 셋팅 cookie set
function setCookie(cookieName, cookieValue){
	//document.cookie = cookieName + "=" + escape(cookieValue) + ";expire=62208000; path=/";
	var todayDate = new Date();
	var expires = new Date();
	expires.setTime(todayDate.getTime() + 1000*60*60*24*31);
	
	document.cookie = cookieName + "=" + escape(cookieValue) + ";expires="+expires.toGMTString()+";path=/";	
}
// 쿠키 가져오기 cookie get
function getCookie(cookieName){
	var theCookie = ""+document.cookie;
	
	var ind=theCookie.indexOf(cookieName);
	
	if(ind==-1 || cookieName=="")	return "";
	var ind1 = theCookie.indexOf(';', ind);
	
	if(ind1==-1) ind1 = theCookie.length;
	return unescape(theCookie.substring(ind+cookieName.length+1, ind1));
}

function number_format(input){
    var input = String(input);
    var reg = /(\-?\d+)(\d{3})($|\.\d+)/;
    if(reg.test(input)){
        return input.replace(reg, function(str, p1,p2,p3){
                return number_format(p1) + "," + p2 + "" + p3;
            }
        );
    }else{
        return input;
    }
}
