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

$PageView = "FRONT";				// 페이징 처리를 위한 구분값

// 상단 메뉴 이미지
$strFileName = $_SERVER['PHP_SELF'];

$pageBlockSize = 10; 	 // 페이징 처리 (페이징 넘버 노출 사이즈)
$pageRowCnt = 10; 		 // 페이징 처리(화면 출력 row 갯수)

import("class.controller.MainCon");
import("class.controller.GuestbookCon");
import("class.controller.CommonCodeCon");
import("php.util.PagingClass");

$MainCon        	= new MainCon();
$GuestbookCon		= new GuestbookCon();
$CommonCodeCon		= new CommonCodeCon();

/**
 *
 * @var pageing setting
 */
$thisPage = "/m/board.php";

/**
 * 
 * @var parameter setting
 */
$_m = $StringClass->getRequest('m');
$_p = $StringClass->getRequest('p');

$nowPage = $StringClass->getRequest('nowPage');
if (empty($nowPage)) $nowPage = 1;

$pageRowCnt = 5;
$startPaging = ($nowPage - 1) * $pageRowCnt;
$endPaging = $nowPage * $pageRowCnt;

if (empty($_m))
{
	$StringClass->alertMsg('초대장 정보가 없습니다.','', '', 'CLOSE');
	exit;
}
/**
 * 
 * @var Default data setting
 */
$param = array();
$param['main_id'] = $_m;
$result = $MainCon->getMainList($param);
if ($result)
{
	$main_info = $result[0];

	if ($main_info)
	{
		/**
		 *
		 * @var get board data setting
		 */
		$cnt = $GuestbookCon->getGuestbookCnt($param);
		$arrList = $GuestbookCon->getGuestbookList($param, $startPaging, $pageRowCnt);

		/**
		 * ******************************************************************************************
		 * @Desc 페이지 번호 목록 출력
		 * ******************************************************************************************/
		$getParam = "&m={$m}";
		
		$page = new Paging('BOARD');
		$page->initPaging($cnt, $pageBlockSize, $pageRowCnt, $nowPage, $thisPage."?", $getParam);
		$page_list = $page->getPaging();
		
		$listNum = $cnt - $startPaging;	// List numbering
	}
}
else
{
	$StringClass->alertMsg('초대장 정보가 없습니다.','', '', 'CLOSE');
	exit;
}

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
	$("#btnGotoDejavu").click(function () {
		gotoDejavu();
	});

	$("#btnSave").click(function () {
		gotoSave();
	});

	$("#btnMore").click(function () {
		gotoMore();
	});
});


gotoDejavu = function () {
	var m = $("#m").val();
	var p = $("#p").val();
	location.href="/?m="+m+"&p="+p;
}

gotoReload = function () {
	var m = $("#m").val();
	var p = $("#p").val();
	location.href="/guestbook.php?m="+m+"&p="+p;
}

gotoSave = function () {
	var m = $("#m").val();
	var writer_name = $("#writer_name").val();
	var passwd = $("#passwd").val();
	var memo = $("#memo").val();
	var inputdata = "s=save&m="+m+"&writer_name="+writer_name+"&passwd="+passwd+"&memo="+memo;

	if (writer_name == "")
	{
		alert("이름을 입력해 주세요");
		$("#writer_name").focus();
		return false;
	}
	else if (passwd == "")
	{
		alert("비밀번호를 입력해 주세요");
		$("#passwd").focus();
		return false;
	}
	else if (memo == "")
	{
		alert("내용을 입력해 주세요");
		$("#memo").focus();
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
					alert("저장되었습니다.");
					gotoReload();
					return true;
				}
				else
				{
	                alert("저장중 오류가 발생했습니다.");
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

setDelid = function(gid) {
	$("#guestbook_id").val(gid);	
}

gotoResetPw = function() {
	$("#pw").val("");
}

gotoMore = function() {
	var m = $("#m").val();
	var next = eval($("#next").val()) + <?=$pageRowCnt;?>;
	var inputdata = "s=more&m="+m+"&next="+next;

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
				if (body.guestbook_list)
					addData(body.guestbook_list);
				$("#next").val(next);
				return true;
			}
			else
			{
                alert("더이상 글이 없습니다.");
                return false;
			}
		}
		, error: function(data, status, err) {
		}
		, complete: function() { 
		}
	});
}

addData = function(row) {
	if (row.length > 0)
	{
		$("#listview li").filter(':last-child').removeClass("ui-last-child");
		for(var i=0; i < row.length; i++)
		{
			var data = "";
	
			//data += "<li data-icon='delete' data-corners='false' data-shadow='false' data-iconshadow='true' data-wrapperels='div' data-iconpos='right' data-theme='c' class='ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-btn-up-c'>";
			//data += "<div class='ui-btn-inner ui-li'><div class='ui-btn-text'><a href='#popupDel' data-rel='popup' data-position-to='window' onclick='setDelid("+row[i]['guestbook_id']+");' class='ui-link-inherit'>";
			//data += "<p class='ui-li-aside ui-li-desc'><strong>"+row[i]['reg_date']+"</strong></p>";
			//data += "<h2 class='ui-li-heading'>"+row[i]['writer_name']+"</h2>";
			//data += "<p class='ui-li-desc'>"+row[i]['memo']+"</p>";
			//data += "</a></div><span class='ui-icon ui-icon-delete ui-icon-shadow'>&nbsp;</span></div></li>";
			data += "<li data-corners='false' data-shadow='false' data-iconshadow='true' data-wrapperels='div' data-icon='arrow-r' data-iconpos='right' data-theme='c' class='ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-btn-up-c'><div class='ui-btn-inner ui-li'><div class='ui-btn-text'>";
			data += "<a href='guestbook_view.php?m="+ $("#m").val() +"&amp;id="+ row[i]['guestbook_id'] +"' class='ui-link-inherit'>";
			data += "<p class='ui-li-aside ui-li-desc'><strong>"+ row[i]['reg_date'] +"</strong></p>";
			data += "<h2 class='ui-li-heading'>"+ row[i]['writer_name'] +"</h2>";
			data += "<p class='ui-li-desc'>"+ row[i]['memo'] +"</p>";
			data += "</a></div>";
			data += "<span class='ui-icon ui-icon-arrow-r ui-icon-shadow'>&nbsp;</span></div></li>";

			$("#listview").append(data);
		}
		$("#listview li").filter(':last-child').addClass("ui-last-child");
	}
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
<style>
.ui-header {
  text-shadow: 0 0 0 #eee;
}
.ui-header h1 { color:#fff; } 

</style>
</head>
<body class="ui-mobile-viewport ui-overlay-a">
<input type="hidden" id="m" name="m" value="<?=$_m;?>" />
<input type="hidden" id="p" name="p" value="<?=$_p;?>" />
<input type="hidden" id="guestbook_id" name="guestbook_id" value="" />
<input type="hidden" id="next" name="next" value="0" />
<div data-role="page" class="jqm-demos" data-quicklinks="true" id="jqm-demos">

	<div data-role="header" role="banner" class="ui-header ui-bar-inherit">
		<h1 class="ui-title" role="heading" aria-level="1"><?=$main_info['baby_name'];?> 돌잔치 방명록</h1>
		<!--<a href="#" id="btnGotoDejavu" class="ui-btn-left ui-btn ui-icon-back ui-btn-icon-notext ui-shadow ui-corner-all" data-role="button" role="button">이전</a>-->
		<a href="#" id="btnGotoDejavu" class="ui-btn-left ui-btn " data-role="button" role="button" style="margin-top: 8px;">이전</a>
		<a href="#" id="btnSave" class="ui-btn-right ui-btn" data-role="button" role="button" style="margin-top: 8px;">글저장</a>
	</div>

	<div class="ui-grid-a">
	    <div class="ui-block-a" style="width:95%;margin-left:1em;">
			<div class="ui-field-contain">
			    <label for="textinput-fc">이름</label>
			    <input type="text" name="writer_name" id="writer_name" placeholder="이름을 입력해 주세요" value="">
			</div>
			<div class="ui-field-contain">
			    <label for="textinput-fc">비밀번호</label>
			    <input type="password" name="passwd" id="passwd" maxlength="4" placeholder="비밀번호를 입력해 주세요" value="" autocomplete="off">
			</div>        
			<div class="ui-field-contain">
				<label for="textinput-fc">내용</label>
				<textarea cols="40" rows="8" name="memo" id="memo" placeholder="내용을 입력해 주세요" ></textarea>
			</div>
		</div>
	</div>

	<div data-role="content" class="jqm-content" role="main" style="width:95%;">
		<ul id="listview" data-role="listview" data-inset="true">
		<?php
		foreach($arrList as $item) {
		?>
		<li><a href="guestbook_view.php?m=<?=$_m;?>&id=<?=$item['guestbook_id'];?>" >
	    <h2><?=$item['writer_name'];?></h2>
	    <p><?=nl2br($item['memo']);?></p>
	        <p class="ui-li-aside"><strong><?=$item['reg_date'];?></strong></p></a>
	    </li>
	    <?php
			$listNum--;
		}
		?>
		</ul>
		<div id="btnMore" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="c" data-disabled="false" class="ui-btn ui-shadow ui-btn-corner-all ui-btn-up-c" aria-disabled="false"><span class="ui-btn-inner"><span class="ui-btn-text">더보기</span></span></div>
	</div>
</div>
</body>
</html>