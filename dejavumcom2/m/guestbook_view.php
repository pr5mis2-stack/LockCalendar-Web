<?php
#ini_set("session.cookie_domain",".dejavu-m.com") ;
#session_start();
#session_cache_limiter("none");

header("Cache-Control:no-cache");
header("Pragma:no-cache");
/**
 *  search_proc.php
 *  @Desc      : 검색결과 처리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
require_once(dirname(__DIR__) . "/conf/DejavuConf.php");
require_once(dirname(__DIR__) . "/import.php");

// 로그인 페이지 분기 설정 (일반 로그인 페이지로 분기)
$login_url = $conf_login_url;

// 상단 메뉴 이미지
$strFileName = $_SERVER['PHP_SELF'];

import("class.controller.MainCon");
import("class.controller.GuestbookCon");
import("class.controller.CommonCodeCon");

$MainCon        	= new MainCon();
$GuestbookCon		= new GuestbookCon();
$CommonCodeCon		= new CommonCodeCon();

/**
 *
 * @var pageing setting
 */
$thisPage = "/m/guestbook_view.php";

/**
 * 
 * @var parameter setting
 */
$_m = $StringClass->getRequest('m');
$_gid = $StringClass->getRequest('id');


if (empty($_m))
{
	$StringClass->alertMsg('초대장 정보가 없습니다.','', '', 'CLOSE');
	exit;
}

if (empty($_gid))
{
	$StringClass->alertMsg('방명록 정보가 없습니다.','', '', 'CLOSE');
	exit;
}

/**
 * 
 * @var Default data setting
 */
$param = array();
$param['main_id'] = $_m;
$param['guestbook_id'] = $_gid;
$arrList = $GuestbookCon->getGuestbookList($param);

if (count($arrList) < 1)
{
	$StringClass->alertMsg('초대장 정보가 없습니다.','', '', 'CLOSE');
	exit;
}

$item = $arrList[0];

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>데자뷰 - 스마트초대장</title>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
<link rel="stylesheet" href="http://view.jquerymobile.com/master/css/themes/default/jquery.mobile.css">
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script> 
<script type="text/javascript">
document.domain = 'dejavu-m.com';

$(document).ready(function () {

});

gotoResetPw = function() {
	$("#pw").val("");
}

gotoDel = function (m, gid, pwd) {
	var inputdata = "s=del&m="+m+"&guestbook_id="+gid+"&passwd="+pwd;

	if (pwd == "")
	{
		alert("비밀번호를 입력해 주세요");
		$("#pw").focus();
		return false;
	}
	else
	{
		$.ajax({
			type: "POST"
			, async: true
			, url: "guestbook_proc.php"
			, data: inputdata
	        , dataType: "json"
			, success: function(json) {
				var header = json.header;
				var body = json.body;
	
				if (header.result_code == "000")
				{
					alert("삭제되었습니다.");
					location.href="/guestbook.php?m=<?=$_m;?>";
					return true;
				}
				else if (header.result_code == "100")
				{
	                alert("삭제중 오류가 발생했습니다.");
	                return false;
				}
				else
				{
	                alert(header.result_msg);
	                return false;
				}
			}
			, error: function(data, status, err) {
			}
			, complete: function() { 
			}
		});
	}
}

</script>
</head>
<body class="ui-mobile-viewport ui-overlay-a">
<input type="hidden" id="m" name="m" value="<?=$_m;?>" />
<div data-role="page" class="jqm-demos" data-quicklinks="true" id="jqm-demos">

	<div data-role="header" role="banner" class="ui-header ui-bar-inherit">
		<h1 class="ui-title" role="heading" aria-level="1"><?=$main_info['baby_name'];?> 돌잔치 방명록</h1>
		<a href="#" id="btnBack" data-rel="back" class="ui-btn-left ui-btn ui-icon-back ui-btn-icon-notext ui-shadow ui-corner-all" data-role="button" role="button">이전</a>
	</div>

	<div data-role="content"  >
		<div class="content-primary">
			<form>
		    <ul data-role="listview">
				<li data-role="fieldcontain">
		        	<label for="memo"  style="float:left;">이름 : <?=$item['writer_name'];?></label>
		        	<label for="regdate" style="float:right; ">작성일 : <?=$item['reg_date'];?></label>
				</li>
			</ul>
			</form>
		</div>
		<div class="ui-field-contain" style="padding-top:30px;">
			<?=nl2br($item['memo']);?>
		</div>
		
		<a href="#popupDel" data-role="button" data-rel='popup' data-position-to='window'>삭제</a>
	</div>
	<div data-role="popup" id="popupDel" data-theme="a" class="ui-corner-all"> 
		<div style="padding:10px 20px;">
	    	<h3>비밀번호를 입력해 주세요</h3>
	        <label for="pw" class="ui-hidden-accessible">Password:</label>
	        <input type="password" name="passwd" id="pw" value="" placeholder="password" data-theme="a">
	        <a href="#" onclick="gotoResetPw()" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-rel="back">취소</a>
	        <a href="#" onclick="gotoDel('<?=$_m?>', '<?=$_gid;?>', $('#pw').val())" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-transition="flow">삭제</a>
		</div>
	</div>	
</div>
</body>
</html>