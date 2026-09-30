<?php
/**
 *  sample_list.php
 *  @Desc      : 샘플 목록 관리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */

/**
 *
 * @var parameter setting
 */
$sch_date = $StringClass->getRequest ( 'sch_date' );
$sch_use = $StringClass->getRequest ( 'sch_use' );
$sch_type = $StringClass->getRequest ( 'sch_type' );
$sch_target = $StringClass->getRequest ( 'sch_target' );
$sch_keyword = $StringClass->getRequest ( 'sch_keyword' );

$pageRowCnt = 15;
$nowPage = (isset($_GET['nowPage']) ? $_GET['nowPage'] : '');
$thisPage = $_SERVER['PHP_SELF'];
if (empty ( $nowPage ))
	$nowPage = 1;

$startPaging = ($nowPage - 1) * $pageRowCnt;
$endPaging = $nowPage * $pageRowCnt;

/**
 *
 * @var get board data setting
 */
$param = array ();
// 등록기간별 검색옵션
if ($sch_date != "") {
	switch ($sch_date) {
		case "a" :
			$param ['st_date'] = "";
			$param ['ed_date'] = "";
			break; // 전체
		case "1" :
			$param ['st_date'] = date ( "Y-m-d", strtotime ( date ( "Y-m-d" ) . ' - 1month' ) );
			$param ['ed_date'] = date ( "Y-m-d" );
			break; // 최근 1개월
		case "6" :
			$param ['st_date'] = date ( "Y-m-d", strtotime ( date ( "Y-m-d" ) . ' - 6month' ) );
			$param ['ed_date'] = date ( "Y-m-d" );
			break; // 최근 6개월
	}
}
// 사용여부
if ($sch_use != "") {
	switch ($sch_use) {
		case "a" :
			$param ['is_use'] = "";
			break; // 전체
		case "0" :
			$param ['is_use'] = "0";
			break; // 미사용
		case "1" :
			$param ['is_use'] = "1";
			break; // 사용
	}
}
if ($sch_type != "") {
	switch ($sch_type) {
		case "B" :
			$param ['sample_type'] = "B";
			break;
		case "W" :
			$param ['sample_type'] = "W";
			break;
		case "S" :
			$param ['sample_type'] = "S";
			break;
		default :
			$param ['sample_type'] = "B";
			break;
	}
}
// 검색어 검색
if (! empty ( $sch_target ) && ! empty ( $sch_keyword )) {
	switch ($sch_target) {
		case "reg_date" :
			$param ['reg_date'] = $sch_keyword;
			break;
		case "sample_id" :
			$param ['sample_id'] = $sch_keyword;
			break;
		case "sample_name" :
			$param ['sample_name'] = $sch_keyword;
			break;
	}
}

$cnt = $SampleCon->getSampleCnt ( $param );
$arrList = $SampleCon->getSampleList ( $param, $startPaging, $pageRowCnt );

/**
 * ******************************************************************************************
 * @Desc 페이지 번호 목록 출력
 * *****************************************************************************************
 */
$getParam = "&m=sample";
$getParam .= "&sch_date={$sch_date}";
$getParam .= "&sch_use={$sch_use}";
$getParam .= "&sch_type={$sch_type}";
$getParam .= "&sch_target={$sch_target}";
$getParam .= "&sch_keyword={$sch_keyword}";

$page = new Paging ( 'BOARD' );
$page->initPaging ( $cnt, $pageBlockSize, $pageRowCnt, $nowPage, $thisPage . "?", $getParam );
$page_list = $page->getPaging ();

$listNum = $cnt - $startPaging; // List numbering

/**
 * ******************************************************************************************
 * @Desc 전체 등록 수량 체크
 * *****************************************************************************************
 */
$cntParam = array ();
$cntParam ['sample_type'] = $param ['sample_type'];
$cntParam ['is_use'] = "1";
$useCnt = $SampleCon->getSampleCnt ( $cntParam ); // 사용
$cntParam ['is_use'] = "0";
$endCnt = $SampleCon->getSampleCnt ( $cntParam ); // 미사용
$cntParam ['is_use'] = "";
$totalCnt = $SampleCon->getSampleCnt ( $cntParam ); // 전체
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
function goSearch()
{
	var sch_date	= $("#sch_date").val();
	var sch_use		= $("#sch_use").val();
	var sch_type	= $("#sch_type").val();
    var sch_target	= $("#sch_target").val();
    var sch_keyword	= $("#sch_keyword").val();

	var strUrl = "<?=$thisPage;?>?m=sample&sch_date="+ sch_date +"&sch_use="+ sch_use +"&sch_type="+ sch_type +"&sch_target="+ sch_target +"&sch_keyword="+ sch_keyword;

	location.href = strUrl;
}

function goReset()
{
	var strUrl = "<?=$thisPage;?>?m=sample";
	location.href = strUrl;
}

function postShop()
{
	document.boardFrm.submit();
}
//-->
</script>
<div class="body">
	<div class="content" id="content" tabindex="0">
		<h1 class="h1">샘플 목록</h1>
		<form action="" method="post">
			<div id="search_box" class="table">
				<table class="list01">
					<colgroup>
						<col width="8%">
						<col width="8%">
						<col width="8%">
						<col width="8%">
						<col width="8%">
						<col width="8%">
						<col width="8%">
						<col width="20%">
						<col width="17%">
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
							<th style="vertical-align: middle;">사용여부</th>
							<td style="text-align: left; vertical-align: middle; padding-left: 15px;">
								<select id="sch_use" name="sch_use">
									<option value="a" <?php if($sch_use == "a" || $sch_use == "") echo" selected";?>>전체</option>
									<option value="0" <?php if($sch_use == "0") echo" selected";?>>미사용</option>
									<option value="1" <?php if($sch_use == "1") echo" selected";?>>사용중</option>
								</select>
							</td>
							<th style="vertical-align: middle;">타입</th>
							<td style="text-align: left; vertical-align: middle; padding-left: 15px;">
								<select id="sch_type" name="sch_type">
									<option value="B" <?php if($sch_type == "B" || $sch_type == "") echo" selected";?>>돌잔치</option>
									<option value="W" <?php if($sch_type == "W") echo" selected";?>>결혼식</option>
									<option value="S" <?php if($sch_type == "S") echo" selected";?>>고희연</option>
								</select>
							</td>
							<th style="vertical-align: middle;">검색어</th>
							<td style="text-align: left; vertical-align: middle; padding-left: 15px;">
								<select name="sch_target" id="sch_target">
									<option value="">검색대상</option>
									<option value="sample_name" <?php if($sch_target == "sample_name") echo" selected";?>>샘플명</option>
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
		<div id="search_box" class="table">
			<table class="list01">
				<colgroup>
					<col width="13%">
					<col width="20%">
					<col width="13%">
					<col width="20%">
					<col width="13%">
					<col width="20%">
				</colgroup>
				<tbody>
					<tr>
						<th style="vertical-align: middle;">전체 등록수량</th>
						<td style="text-align: left; vertical-align: middle; padding-left: 15px;"><?=number_format($totalCnt);?> 개</td>
						<th style="vertical-align: middle;">사용중 등록수량</th>
						<td style="text-align: left; vertical-align: middle; padding-left: 15px;"><?=number_format($useCnt);?> 개</td>
						<th style="vertical-align: middle;">미사용 등록수량</th>
						<td style="text-align: left; vertical-align: middle; padding-left: 15px;"><?=number_format($endCnt);?> 개</td>
					</tr>
				</tbody>
			</table>
		</div>
		<form name='boardFrm' method="post" target="_actionfrm"
			action="./sample/sample_proc.php" class="form">
			<div class="table even">
				<table width="100%" border="1" cellspacing="0" class="_memberList">
					<caption>
                    검색결과 샘플(<?=$cnt;?>)
                    <span class="side"> <span class="btn"><a
								href="/manager/?m=sample&a=insert">생성</a></span>
						</span>
					</caption>
					<thead>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">타입</th>
							<th scope="col" class="nowr">샘플명</th>
							<th scope="col" class="nowr">사용유무</th>
							<th scope="col" class="nowr">등록일</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">타입</th>
							<th scope="col" class="nowr">샘플명</th>
							<th scope="col" class="nowr">사용유무</th>
							<th scope="col" class="nowr">등록일</th>
						</tr>
					</tfoot>
					<tbody>
				    <?php
								foreach ( $arrList as $item ) {
									?>
				    <tr>
						<td class="nowr"><a href="/manager/?m=sample&a=update&sample_id=<?=$item['sample_id'];?>"><?=$listNum;?></a></td>
						<td class="nowr"><a href="/manager/?m=sample&a=update&sample_id=<?=$item['sample_id'];?>"><?=$item['sample_type_name'];?></a></td>
						<td class="nowr"><a href="/manager/?m=sample&a=update&sample_id=<?=$item['sample_id'];?>"><?=$item['sample_name'];?></a></td>
						<td class="nowr"><a href="/manager/?m=sample&a=update&sample_id=<?=$item['sample_id'];?>"><?phpif ($item['is_use'] == "1") {echo"사용";} else {echo "미사용";}?></a></td>
						<td class="nowr"><a href="/manager/?m=sample&a=update&sample_id=<?=$item['sample_id'];?>"><?=$item['reg_date'];?></a></td>
					</tr>
				    <?php
						$listNum --;
					}
					?>
                </tbody>
				</table>
			</div>
			<div class="btnArea">
				<span class="side"> <span class="btn"><a
						href="/manager/?m=sample&a=insert">생성</a></span>
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