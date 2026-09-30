<?php
/**
 *  pmolog_list.php
 *  @Desc      : 프로모션 참여 관리
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

// 검색어 검색
if (!empty($sch_target) && !empty($sch_keyword)) {
	switch ($sch_target) {
		case "shop_id" :
			$param['shop_id'] = $sch_keyword;
			break;
		case "shop_name" :
			$param['shop_name'] = $sch_keyword;
			break;
		case "email" :
			$param['email'] = $sch_keyword;
			break;
		case "father_name" :
			$param['father_name'] = $sch_keyword;
			break;
		case "mother_name" :
			$param['mother_name'] = $sch_keyword;
			break;
		case "baby_name" :
			$param['baby_name'] = $sch_keyword;
			break;
		case "reg_date" :
			$param['reg_date'] = $sch_keyword;
			break;
	}
}

$cnt = $PromotionCon->getPromotionLogCnt($param);
$arrList = $PromotionCon->getPromotionLogList($param, $startPaging, $pageRowCnt);

/**
 * ******************************************************************************************
 * @Desc 페이지 번호 목록 출력
 * *****************************************************************************************
 */
$getParam = "&m=pmolog";
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

	var strUrl = "<?=$thisPage;?>?m=pmolog&sch_date="+ sch_date +"&is_popup="+ is_popup +"&sch_target="+ sch_target +"&sch_keyword="+ sch_keyword;

	location.href = strUrl;
}

function goReset()
{
	var strUrl = "<?=$thisPage;?>?m=pmolog";
	location.href = strUrl;
}

function downExcel() 
{
	var sch_date	= $("#sch_date").val();
	var is_popup	= $("#is_popup").val();
    var sch_target	= $("#sch_target").val();
    var sch_keyword	= $("#sch_keyword").val();

	var strUrl = "./pmolog/pmolog_excel.php?sch_date="+ sch_date +"&is_popup="+ is_popup +"&sch_target="+ sch_target +"&sch_keyword="+ sch_keyword;

	location.href = strUrl;
}
//-->
</script>
<div class="body">
	<div class="content" id="content" tabindex="0">
		<h1 class="h1">프로모션참여 로그 목록</h1>
		<form action="" method="post">
			<div id="search_box" class="table">
				<table class="list01">
					<colgroup>
						<col width="12%">
						<col width="25%">
						<col width="12%">
						<col width="25%">
						<col width="26%">
					</colgroup>
					<tbody>
						<tr>
							<th style="vertical-align: middle;">참여기간</th>
							<td style="text-align: left; vertical-align: middle; padding-left: 15px;">
								<select id="sch_date" name="sch_date">
									<option value="a" <?php if($sch_date == "a" || $sch_end == "") echo" selected";?>>전체</option>
									<option value="0" <?php if($sch_date == "1") echo" selected";?>>최근1개월</option>
									<option value="1" <?php if($sch_date == "6") echo" selected";?>>최근6개월</option>
								</select>
							</td>
							<th style="vertical-align: middle;">검색어</th>
							<td style="text-align: left; vertical-align: middle; padding-left: 15px;">
								<select name="sch_target" id="sch_target">
									<option value="shop_name" <?php if($sch_target == "shop_name") echo" selected";?>>업체명</option>
									<option value="email" <?php if($sch_target == "email") echo" selected";?>>이메일</option>
									<option value="father_name" <?php if($sch_target == "father_name") echo" selected";?>>아버지이름</option>
									<option value="mother_name" <?php if($sch_target == "mother_name") echo" selected";?>>어머니이름</option>
									<option value="baby_name" <?php if($sch_target == "baby_name") echo" selected";?>>아기이름</option>
									<option value="reg_date" <?php if($sch_target == "reg_date") echo" selected";?>>등록일</option>

								</select>
								<input type="text" name="sch_keyword" id="sch_keyword" style="width: 150px;" value="<?=$sch_keyword;?>">
							</td>
							<td style="text-align: center; vertical-align: middle; padding-left: 15px;">
								<input type="button" onclick="goSearch()" value="검색">
								<input type="button" onclick="goReset()" value="검색초기화">
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
                    검색결과 프로모션 참여(<?=$cnt;?>)
                    <span class="side"> <span class="btn"><a href="javascript:downExcel()">엑셀다운로드</a></span></span>
					</caption>
					<thead>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">업체명</th>
							<th scope="col" class="nowr">이메일</th>
							<th scope="col" class="nowr">아버지 이름</th>
							<th scope="col" class="nowr">아버지 연락처</th>
							<th scope="col" class="nowr">어머니 이름</th>
							<th scope="col" class="nowr">어머니 연락처</th>
							<th scope="col" class="nowr">아기 이름</th>
							<th scope="col" class="nowr">행사일시</th>
							<th scope="col" class="nowr">등록일</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">업체명</th>
							<th scope="col" class="nowr">이메일</th>
							<th scope="col" class="nowr">아버지 이름</th>
							<th scope="col" class="nowr">아버지 연락처</th>
							<th scope="col" class="nowr">어머니 이름</th>
							<th scope="col" class="nowr">어머니 연락처</th>
							<th scope="col" class="nowr">아기 이름</th>
							<th scope="col" class="nowr">행사일시</th>
							<th scope="col" class="nowr">등록일</th>
						</tr>
					</tfoot>
					<tbody>
				    <?php
					foreach ( $arrList as $item ) {
					?>
				    	<tr>
							<td class="nowr"><?=$listNum;?></td>
							<td class="nowr"><?=$item['shop_name'];?></td>
							<td class="nowr"><?=$item['email'];?></td>
							<td class="nowr"><?=$item['father_name'];?></td>
							<td class="nowr"><?=$item['father_hp'];?></td>
							<td class="nowr"><?=$item['mother_name'];?></td>
							<td class="nowr"><?=$item['mother_hp'];?></td>
							<td class="nowr"><?=$item['baby_name'];?></td>			
							<td class="nowr"><?=$item['show_date'];?> <?=$item['show_time'];?></td>																																
							<td class="nowr"><?=$item['reg_date'];?></td>
						</tr>
				    <?php
						$listNum--;
					}
					?>
                </tbody>
				</table>
			</div>
			<div class="btnArea">
				<span class="side"></span>
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