<?php
/**
 *  promotion_list.php
 *  @Desc      : 프로모션 관리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */

/**
 *
 * @var parameter setting
 */
$sch_date = $StringClass->getRequest('sch_date');
$sch_end = $StringClass->getRequest('sch_end');
$sch_target = $StringClass->getRequest('sch_target');
$sch_keyword = $StringClass->getRequest('sch_keyword');
$is_popup = $StringClass->getRequest('is_popup');

$pageRowCnt = 15;
$nowPage = (isset($_GET['nowPage']) ? $_GET['nowPage'] : '');
$thisPage = $_SERVER['PHP_SELF'];
if (empty($nowPage))
	$nowPage = 1;

$startPaging = ($nowPage - 1) * $pageRowCnt;
$endPaging = $nowPage * $pageRowCnt;

/**
 *
 * @var get board data setting
 */
$param = array();
                             
// 등록기간별 검색옵션
if ($sch_date != "") {
	switch ($sch_date) {
		case "a" :
			$param['st_date'] = "";
			$param['ed_date'] = "";
			break; // 전체
		case "1" :
			$param['st_date'] = date("Y-m-d", strtotime(date("Y-m-d") . ' - 1month'));
			$param['ed_date'] = date("Y-m-d");
			break; // 최근 1개월
		case "6" :
			$param['st_date'] = date("Y-m-d", strtotime(date("Y-m-d") . ' - 6month'));
			$param['ed_date'] = date("Y-m-d");
			break; // 최근 6개월
	}
}

if ($is_popup != "")
	$param['is_popup'] = $is_popup;

// 검색어 검색
if (!empty($sch_target) && !empty($sch_keyword)) {
	switch ($sch_target) {
		case "shop_id" :
			$param['shop_id'] = $sch_keyword;
			break;
		case "shop_name" :
			$param['shop_name'] = $sch_keyword;
			break;
		case "reg_date" :
			$param['reg_date'] = $sch_keyword;
			break;
	}
}

$cnt = $PromotionCon->getPromotionCnt($param);
$arrList = $PromotionCon->getPromotionList($param, $startPaging, $pageRowCnt);

/**
 * ******************************************************************************************
 * @Desc 페이지 번호 목록 출력
 * *****************************************************************************************
 */
$getParam = "&m=promotion";
$getParam .= "&sch_date={$sch_date}";
$getParam .= "&is_popup={$is_popup}";
$getParam .= "&sch_target={$sch_target}";
$getParam .= "&sch_keyword={$sch_keyword}";

$page = new Paging('BOARD');
$page->initPaging($cnt, $pageBlockSize, $pageRowCnt, $nowPage, $thisPage . "?", $getParam );
$page_list = $page->getPaging();

$listNum = $cnt - $startPaging; // List numbering
?>
<!--*****메인*****-->
<style>
#num ul {
	list-style: none;
}

#num ul li {
	display: inline;
	padding-right: 10px;
}

#num ul li b {
	color: #f00;
}
</style>
<script language="Javascript">
<!--
var is_proc_ing = false;

function goSearch()
{
	var sch_date	= $("#sch_date").val();
	var is_popup	= $("#is_popup").val();
    var sch_target	= $("#sch_target").val();
    var sch_keyword	= $("#sch_keyword").val();

	var strUrl = "<?=$thisPage;?>?m=promotion&sch_date="+ sch_date +"&is_popup="+ is_popup +"&sch_target="+ sch_target +"&sch_keyword="+ sch_keyword;

	location.href = strUrl;
}

function goReset()
{
	var strUrl = "<?=$thisPage;?>?m=promotion";
	location.href = strUrl;
}

function postManager()
{
	document.boardFrm.submit();
}

function gotoEdit(did)
{
	var url = "./promotion/goto_maker.php?did="+did;
	window.open(url);	
}

function gotoDel(sid)
{
    if (is_proc_ing) {
        alert("진행중 입니다.");
        return;
    }
    
    var goUrl = "./promotion/promotion_proc.php";
    var param = "&a=delete&shop_id="+ sid;

	if (sid == "")
	{
		alert("선택된 프로모션이 없습니다.");
		return false;
	}
	
    is_proc_ing = true;

    $.ajax({
    	type: 'post'
        , async: true
        , url: goUrl
        , data: param
        , beforeSend: function () { }
        , success: function (data) {

        	is_proc_ing = false;

            var result = data.trim();

            if (result == "100")
            {
            	alert('처리되었습니다');
				location.reload();
            }
            else
            	alert('처리중 오류가 발생하였습니다.');
		}
		, error: function (data, status, err) { }
        , complete: function () { }
	});
}
//-->
</script>
<div class="body">
	<div class="content" id="content" tabindex="0">
		<h1 class="h1">프로모션등록 목록</h1>
		<form action="" method="post">
			<div id="search_box" class="table">
				<table class="list01">
					<colgroup>
						<col width="10%">
						<col width="10%">
						<col width="10%">
						<col width="10%">
						<col width="10%">
						<col width="25%">
						<col width="25%">
					</colgroup>
					<tbody>
						<tr>
							<th style="vertical-align: middle;">등록기간</th>
							<td style="text-align: left; vertical-align: middle; padding-left: 15px;">
								<select id="sch_date" name="sch_date">
									<option value="a" <?php if($sch_date == "a" || $sch_end == "") echo" selected";?>>전체</option>
									<option value="0" <?php if($sch_date == "1") echo" selected";?>>최근1개월</option>
									<option value="1" <?php if($sch_date == "6") echo" selected";?>>최근6개월</option>
								</select>
							</td>
							<th style="vertical-align: middle;">팝업여부</th>
							<td style="text-align: left; vertical-align: middle; padding-left: 15px;">
								<select id="is_popup" name="is_popup">
									<option value="" <?php if($is_popup == "") echo" selected";?>>전체</option>
									<option value="0" <?php if($is_popup == "0") echo" selected";?>>미사용</option>
									<option value="1" <?php if($is_popup == "1") echo" selected";?>>사용</option>
								</select>
							</td>
							<th style="vertical-align: middle;">검색어</th>
							<td style="text-align: left; vertical-align: middle; padding-left: 15px;">
								<select name="sch_target" id="sch_target">
									<option value="shop_name"
										<?php if($sch_target == "shop_name") echo" selected";?>>업체명</option>
									<option value="reg_date"
										<?php if($sch_target == "reg_date") echo" selected";?>>등록일</option>
							</select> <input type="text" name="sch_keyword" id="sch_keyword"
								style="width: 150px;" value="<?=$sch_keyword;?>">
							</td>
							<td
								style="text-align: center; vertical-align: middle; padding-left: 15px;">
								<input type="button" onclick="goSearch()" value="검색"> <input
								type="button" onclick="goReset()" value="검색초기화">
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</form>
		<form name='boardFrm' method="post" target="_actionfrm" action="./promotion/promotion_proc.php" class="form">
			<div class="table even">
				<table width="100%" border="1" cellspacing="0" class="_memberList">
					<caption>
                    검색결과 프로모션(<?=$cnt;?>)
                    <span class="side"> <span class="btn"><a href="/manager/?m=promotion&a=insert">생성</a></span></span>
					</caption>
					<thead>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">업체명</th>
							<th scope="col" class="nowr">팝업사용</th>
							<th scope="col" class="nowr">이미지</th>
							<th scope="col" class="nowr">이미지 Width</th>
							<th scope="col" class="nowr">이미지 Height</th>
							<th scope="col" class="nowr">등록일</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">업체명</th>
							<th scope="col" class="nowr">팝업사용</th>
							<th scope="col" class="nowr">이미지</th>
							<th scope="col" class="nowr">이미지 Width</th>
							<th scope="col" class="nowr">이미지 Height</th>
							<th scope="col" class="nowr">등록일</th>
						</tr>
					</tfoot>
					<tbody>
				    <?php
					foreach ( $arrList as $item ) {
					?>
				    	<tr>
							<td class="nowr"><a href="/manager/?m=promotion&a=update&shop_id=<?=$item['shop_id'];?>"><?=$listNum;?></a></td>
							<td class="nowr"><a href="/manager/?m=promotion&a=update&shop_id=<?=$item['shop_id'];?>"><?=$item['shop_name'];?></a></td>
							<td class="nowr"><a href="/manager/?m=promotion&a=update&shop_id=<?=$item['shop_id'];?>"><?=($item['is_popup'] == 1) ? "사용" : "미사용";?></a></td>
							<td class="nowr"><a href="/manager/?m=promotion&a=update&shop_id=<?=$item['shop_id'];?>"><?=($item['file_url'] != "") ? "<a href='{$conf_img_shop_url}{$item["file_url"]}' target='_blank'>{$item["file_name"]}</a>" : "";?></td>
							<td class="nowr"><a href="/manager/?m=promotion&a=update&shop_id=<?=$item['shop_id'];?>"><?=$item['img_width'];?>px</a></td>
							<td class="nowr"><a href="/manager/?m=promotion&a=update&shop_id=<?=$item['shop_id'];?>"><?=$item['img_height'];?>px</a></td>
							<td class="nowr"><a href="/manager/?m=promotion&a=update&shop_id=<?=$item['shop_id'];?>"><?=$item['reg_date'];?></a></td>
						</tr>
				    <?php
						$listNum --;
					}
					?>
                </tbody>
				</table>
			</div>
			<div class="btnArea">
				<span class="side"> <span class="btn"><a href="/manager/?m=promotion&a=insert">생성</a></span>
				</span>
			</div>
		</form>

		<div class="search">
			<form action="" class="pagination xe-pagination"
				style="float: none; text-align: center;" method="post">
				<div id="num">
			<?=$page_list;?>
			</div>
			</form>
		</div>
	</div>
</div>
<!--*****메인 끝*****-->