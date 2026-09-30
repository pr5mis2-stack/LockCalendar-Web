<?php 
require_once($_SERVER["DOCUMENT_ROOT"]."/include/pop_top.php");

//$latitude = trim($_COOKIE["latitude"]);
$latitude = !empty($_POST["latitude"])? trim($_POST["latitude"]):trim($_GET["latitude"]);
	
//$longitude = trim($_COOKIE["longitude"]);
$longitude = !empty($_POST["longitude"])? trim($_POST["longitude"]):trim($_GET["longitude"]);
	
if(empty($latitude))	$latitude = "37.549996";
if(empty($longitude))   $longitude = "126.919974";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US" xml:lang="en_US">
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>OpenAPI 2.0 - 지도 생성</title>
		<!-- prevent IE6 flickering -->
		<script type="text/javascript">
			try {document.execCommand('BackgroundImageCache', false, true);} catch(e) {}
		</script>

<script type="text/javascript" src="http://openapi.map.naver.com/openapi/naverMap.naver?ver=2.0&key=<?=$naver_map_key;?>"></script>
</head>

<body>
<div id = "testMap" style="border:1px solid #000; width:500px; height:400px; margin:20px;"></div>
 
		<script type="text/javascript">
			var oPoint = new nhn.api.map.LatLng(<?=$latitude;?>, <?=$longitude;?>);
			nhn.api.map.setDefaultPoint('LatLng');
			oMap = new nhn.api.map.Map('testMap' ,{
						point : oPoint,
						zoom : 10,
						enableWheelZoom : true,
						enableDragPan : true,
						enableDblClickZoom : false,
						mapMode : 0,
						activateTrafficMap : false,
						activateBicycleMap : false,
						minMaxLevel : [ 1, 14 ],
						size : new nhn.api.map.Size(500, 400)
					});
			//줌 컨트롤을 생성합니다.
			var mapZoom=new	nhn.api.map.ZoomControl();
			mapZoom.setPosition({left:20,top:20});
			
			//지도 타입 버튼을 생성합니다.
			var mapType=new nhn.api.map.MapTypeBtn();
			mapType.setPosition({left:50,top:20});

			oMap.addControl(mapZoom);
			oMap.addControl(mapType);


			var oSize = new nhn.api.map.Size(28, 37);
			var oOffset = new nhn.api.map.Size(14, 37);
			var oIcon = new nhn.api.map.Icon('http://static.naver.com/maps2/icons/pin_spot2.png', oSize, oOffset);
			   
			var oMarker = new nhn.api.map.Marker(oIcon, { title : '식장' });  //마커를 생성한다 
			oMarker.setPoint(oPoint); //마커의 좌표를 oPoint 에 저장된 좌표로 지정한다
			oMap.addOverlay(oMarker); //마커를 네이버 지도위에 표시한다
			 
			var oLabel = new nhn.api.map.MarkerLabel(); // 마커 라벨를 선언한다. 
			oMap.addOverlay(oLabel); // - 마커의 라벨을 지도에 추가한다. 
			oLabel.setVisible(true, oMarker); // 마커의 라벨을 보이게 설정한다.

			
		</script>
</body>
</html>