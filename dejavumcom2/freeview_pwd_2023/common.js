

/*====================================================
	Client-side access to querystring name=value pairs
	Version 1.3
	28 May 2008
	
	License (Simplified BSD):
	http://adamv.com/dev/javascript/qslicense.txt
*/
function Querystring(qs) { // optionally pass a querystring to parse
	this.params = {};
	
	if (qs == null) qs = location.search.substring(1, location.search.length);
	if (qs.length == 0) return;

// Turn <plus> back to <space>
// See: http://www.w3.org/TR/REC-html40/interact/forms.html#h-17.13.4.1
	qs = qs.replace(/\+/g, ' ');
	var args = qs.split('&'); // parse out name/value pairs separated via &
	
// split out each name=value pair
	for (var i = 0; i < args.length; i++) {
		var pair = args[i].split('=');
		var name = decodeURIComponent(pair[0]);
		
		var value = (pair.length==2)
			? decodeURIComponent(pair[1])
			: name;
		
		this.params[name] = value;
	}
}

Querystring.prototype.get = function(key, default_) {
	var value = this.params[key];
	return (value != null) ? value : default_;
}

Querystring.prototype.contains = function(key) {
	var value = this.params[key];
	return (value != null);
}
/*====================================================*/




function sleep(sec) {
    var now = new Date();
    var exitTime = now.getTime() + (sec*1000);
    while (true) {
          now = new Date();
          if (now.getTime() > exitTime) return;
    }
}


function create_request()
{
	var request = false;
	try {
		request = new XMLHttpRequest();
	} catch (trymicrosoft) {
		try {
			request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (othermicrosoft) {
			try {
				request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (failed) {
				request = false;
			}
		}
	}

	if (!request)
		alert("Error initializing XMLHttpRequest!");
	return request;
}


///////////////////////////
// http://kldp.net/snippet/detail.php?type=snippet&id=43
String.prototype.trim = function()
{
	var pattern = !arguments[0] ?
			/^\s+|\s+$/g :
			new RegExp('^['+arguments[0]+']+|['+arguments[0]+']+$', 'g');

	return this.replace(pattern, '');
}



/////////////////////////////////////////////////////////////////////////////

// LIBRARY: UTF8URLDecode
function UTF8URLDecode( req )
{
	var bytes = new Array;
	var percentCode = "%".charCodeAt(0);

	// phase 1. req를 byte array로 변환
	for( i=0; i<req.length; i++ )
	{
		var c;
		if( req.charCodeAt(i) == percentCode )
		{
			c = parseInt( req.substr(i+1, 2), 16 );
			i += 2;
		}
		else
		{
			c = req.charCodeAt(i);
		}

		bytes[bytes.length] = c;
	}


	var result = "";

	// phase 2. byte array를 조합하여 UCS2로 전환
	for( i=0; i<bytes.length; i++ )
	{
		var ch;
		if( (bytes[i]&0x80) == 0 )
		{
			ch = bytes[i];
		}
		else if( (bytes[i]&0xe0) == 0xC0 )
		{
			ch = ((bytes[i] & 0x1f) << 6) | (bytes[i+1] & 0x3f);
			i++;
		}
		else if( (bytes[i]&0xf0) == 0xe0 )
		{
			ch = ((bytes[i] & 0x0f) << 12) | ((bytes[i+1] & 0x3f) << 6) | (bytes[i+2] & 0x3f);
			i += 2;
		}

		result += String.fromCharCode(ch);
	}

	return result;
}


/**
*
*  URL encode / decode
*  http://www.webtoolkit.info/
*
**/
 
var Url = {
 
	// public method for url encoding
	encode : function (string) {
		return escape(this._utf8_encode(string));
	},
 
	// public method for url decoding
	decode : function (string) {
		return this._utf8_decode(unescape(string));
	},
 
	// private method for UTF-8 encoding
	_utf8_encode : function (string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";
 
		for (var n = 0; n < string.length; n++) {
 
			var c = string.charCodeAt(n);
 
			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}
 
		}
 
		return utftext;
	},
 
	// private method for UTF-8 decoding
	_utf8_decode : function (utftext) {
		var string = "";
		var i = 0;
		var c = c1 = c2 = 0;
 
		while ( i < utftext.length ) {
 
			c = utftext.charCodeAt(i);
 
			if (c < 128) {
				string += String.fromCharCode(c);
				i++;
			}
			else if((c > 191) && (c < 224)) {
				c2 = utftext.charCodeAt(i+1);
				string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
				i += 2;
			}
			else {
				c2 = utftext.charCodeAt(i+1);
				c3 = utftext.charCodeAt(i+2);
				string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
				i += 3;
			}
 
		}
 
		return string;
	}
 
}


/**
*
* iframe auto resizing (by 행복한고니)
*
*/
function resizeIF(obj)
{
    var Body;
    var H, Min;

    // 최소 높이 설정 (너무 작아지는 것을 방지)
    Min = 500;

    Body = (obj.contentWindow.document.getElementsByTagName('BODY'))[0];
    H = parseInt(Body.scrollHeight) + 30;
    obj.style.height =  (H<Min?Min:H) + 'px';

    window.scrollTo(1, 1);
}


function addLoadEvent(func){ //함수 선언

	var oldonload = window.onload; //이전 함수값 저장
	if(typeof window.onload != 'function'){ //윈도우가 로드되었을때 함수 호출 여부 판단
		window.onload = function(){
			func(); // 호출된 함수가 없을 경우 그냥 함수 실행
		}
	}else{
		window.onload = function(){ //호출된 함수가 있을 경우에 이전 함수 뒤에 함수 추가
			oldonload();
			func();
		}
	}
}

/*
    if(navigator.appVersion.indexOf("MSIE 6") > -1){//ie6 인경우

    imageSlider(340, 1); // Move Width, Move Item Count

    }else if (navigator.appVersion.indexOf("MSIE 7") > -1){//ie7 인경우

    imageSlider(340, 1); // Move Width, Move Item Count

    }else if(navigator.appVersion.indexOf("MSIE 7") > -1){//ie8 인경우

    imageSlider(340, 1); // Move Width, Move Item Count

    }else{
    imageSlider(370, 1); // Move Width, Move Item Count

    }


*/



function checkVersionIE8() {
         if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) {
                  var ieversion = new Number(RegExp.$1)
                  if (ieversion >= 8 )
                           return false;
                  else if (ieversion < 8 )
                           return true;
         }
         return false;
}

