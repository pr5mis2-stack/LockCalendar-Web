// 길찾기
//http://m.map.naver.com/route.nhn?ey=1&ex=1&ename=%EC%84%9C%EC%9A%B8%ED%8A%B9%EB%B3%84%EC%8B%9C+%EC%86%A1%ED%8C%8C%EA%B5%AC+%EB%B0%A9%EC%9D%B4%EB%8F%99+22-5



function getMapLocationCode(address)
{
	var encording = "utf-8";
	var coord = "tm128";
    var goUrl = "http://openapi.map.naver.com/api/geocode.php";
    var param = "&key="+ map_key +"&encoding="+ encording +"&coord="+ coord +"&query="+ address;
	
    $.ajax({
    	type: 'GET'
        , async: true
        , url: goUrl
        , data: param
        , success: responseLocationParse
        , error: function () { }
        , complete: function () { }
	});

}

function responseLocationParse(xml)
{
	$error_code = $(xml).find("error_code");
	$mapInfo = $(xml).find("item");
	var mapCnt = $mapInfo.length;
	var userquery = "";
	var xlocation = "";
	var ylocation = "";
	var city = "";
	var zone = "";
	
	if (mapCnt > 0)
	{
		userquery = $mapInfo[0].find("userquery").text();
		xlocation = $mapInfo[0].find("x").text();
		ylocation = $mapInfo[0].find("y").text();
		city = $mapInfo[0].find("sido").text();
		zone = $mapInfo[0].find("sigugun").text();
	}
	else
		alert('지도정보가 없습니다.\n주소를 다시 확인해 주세요');
	
	alert("userquery="+ userquery +"\nxlocation="+xlocation+"\nylocation="+ylocation+"\ncity="+city+"\nzone="+zone);
}