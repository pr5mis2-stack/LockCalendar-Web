<?php
require_once(dirname(__DIR__) . "/conf/DejavuConf.php");
require_once(dirname(__DIR__) . "/import.php");

import("class.controller.ShopCon");

$ShopCon 			= new ShopCon();

$shop_id			= $StringClass->getRequest('shop_id');
/* shop info */
$param = array();
$param['shop_id'] = $shop_id;
$arrList = $ShopCon->getShopList($param);
if ($arrList)
	$userInfo = $arrList[0];
else
	$StringClass->alertMsg('정보가 없습니다.','_self','','');
//new dBug($userInfo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US" xml:lang="en_US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Naver 지도</title>
<link rel='stylesheet' type='text/css' media='all' href='http://dejavu-m.com/css/default.css' charset='utf-8' />
<!-- prevent IE6 flickering -->
<script type="text/javascript">
	try {document.execCommand('BackgroundImageCache', false, true);} catch(e) {}
</script>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<!--script type="text/javascript" src="http://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=<?=$naver_map_key_v3;?>"></script-->
<script type="text/javascript" src="https://oapi.map.naver.com/openapi/v3/maps.js?ncpClientId=<?=$naver_map_key_v3;?>"></script>
</head>

<body style="margin: 0;">
<div id = "nMap" style="border:0px; width:100%; height:400px;"></div>
<script>
var HOME_PATH = 'https://navermaps.github.io/maps.js/docs';

var weddinghall = new naver.maps.LatLng(<?=$userInfo['xlocation'];?>, <?=$userInfo['ylocation'];?>),
map = new naver.maps.Map('nMap', {
    center: weddinghall,
    zoom: 10,
    minZoom: 6,
    mapTypeControl: true,
    mapTypeControlOptions: {
        style: naver.maps.MapTypeControlStyle.BUTTON,
        position: naver.maps.Position.TOP_RIGHT
    },
    zoomControl: true,
    zoomControlOptions: {
        style: naver.maps.ZoomControlStyle.SMALL,
        position: naver.maps.Position.TOP_LEFT
    }
}),
marker = new naver.maps.Marker({
    map: map,
    position: weddinghall,
    icon: {
        url: HOME_PATH +'/img/example/pin_default.png',
        size: new naver.maps.Size(22, 35),
        origin: new naver.maps.Point(0, 0),
        anchor: new naver.maps.Point(11, 35)
    },
    shadow: {
        url: HOME_PATH +'/img/example/shadow-pin_default.png',
        size: new naver.maps.Size(40, 35),
        origin: new naver.maps.Point(0, 0),
        anchor: new naver.maps.Point(11, 35)
    }
});

var contentString = [
    '<div class="iw_inner" style="margin:2px;font-size: 0.9em;">',
    '   <h3><?=$userInfo['shop_name'];?></h3>',
    '   <p><?=$userInfo['address'];?> <?=$userInfo['address1'];?><br />',
	<?php if (strlen($userInfo['tel']) > 7) { echo("'"+ $userInfo['tel'] +"',"); } ?>
	'</div>'
].join('');

// info window
var infowindow = new naver.maps.InfoWindow({
	content: contentString,
	maxWidth: 140,
	backgroundColor: "#eee",
	borderColor: "#2db400",
	borderWidth: 1,
	anchorSize: new naver.maps.Size(30, 30),
	anchorSkew: true,
	anchorColor: "#eee",
	pixelOffset: new naver.maps.Point(20, -20)
});

naver.maps.Event.addListener(marker, "click", function(e) {
	if (infowindow.getMap()) {
	    infowindow.close();
	} else {
	    infowindow.open(map, marker);
	}
});

infowindow.open(map, marker);

</script>
</body>
</html>