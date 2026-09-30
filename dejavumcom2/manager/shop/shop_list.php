<?php
/**
 *  shop_list.php
 *  @Desc      : 관리자 목록 관리
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
$sch_end = $StringClass->getRequest ( 'sch_end' );
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
// 계약 종료여부
if ($sch_end != "") {
	switch ($sch_end) {
		case "a" :
			$param ['contract_end'] = "";
			break; // 전체
		case "0" :
			$param ['contract_end'] = "0";
			break; // 계약중
		case "1" :
			$param ['contract_end'] = "1";
			break; // 계약종료
	}
}

// 검색어 검색
if (! empty ( $sch_target ) && ! empty ( $sch_keyword )) {
	switch ($sch_target) {
		case "reg_date" :
			$param ['reg_date'] = $sch_keyword;
			break;
		case "shop_name" :
			$param ['shop_name'] = $sch_keyword;
			break;
		case "ceo_name" :
			$param ['ceo_name'] = $sch_keyword;
			break;
		case "staff_name" :
			$param ['staff_name'] = $sch_keyword;
			break;
		case "memo" :
			$param ['memo'] = $sch_keyword;
			break;
	}
}
$cnt = $ShopCon->getShopCnt ( $param );
$arrList = $ShopCon->getShopList ( $param, $startPaging, $pageRowCnt );

/**
 * ******************************************************************************************
 * @Desc 페이지 번호 목록 출력
 * *****************************************************************************************
 */
$getParam = "&m=shop";
$getParam .= "&sch_date={$sch_date}";
$getParam .= "&sch_end={$sch_end}";
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
$cntParam ['contract_end'] = "0";
$useCnt = $ShopCon->getShopCnt ( $cntParam ); // 계약중
$cntParam ['contract_end'] = "1";
$endCnt = $ShopCon->getShopCnt ( $cntParam ); // 계약종료
$cntParam ['contract_end'] = "";
$totalCnt = $ShopCon->getShopCnt ( $cntParam ); // 전체
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
	var sch_end		= $("#sch_end").val();
    var sch_target	= $("#sch_target").val();
    var sch_keyword	= $("#sch_keyword").val();

	var strUrl = "<?=$thisPage;?>?m=shop&sch_date="+ sch_date +"&sch_end="+ sch_end +"&sch_target="+ sch_target +"&sch_keyword="+ sch_keyword;

	location.href = strUrl;
}

function goReset()
{
	var strUrl = "<?=$thisPage;?>?m=shop";
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
		<h1 class="h1">업체 목록</h1>
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
							<th style="vertical-align: middle;">계약</th>
							<td
								style="text-align: left; vertical-align: middle; padding-left: 15px;">
								<select id="sch_end" name="sch_end">
									<option value="a"
										<?php if($sch_end == "a" || $sch_end == "") echo" selected";?>>전체</option>
									<option value="0" <?php if($sch_end == "0") echo" selected";?>>계약중</option>
									<option value="1" <?php if($sch_end == "1") echo" selected";?>>계약종료</option>
							</select>
							</td>
							<th style="vertical-align: middle;">검색어</th>
							<td
								style="text-align: left; vertical-align: middle; padding-left: 15px;">
								<select name="sch_target" id="sch_target">
									<option value="">검색대상</option>
									<option value="shop_name" <?php if($sch_target == "shop_name") echo" selected";?>>업체명</option>
									<option value="ceo_name" <?php if($sch_target == "ceo_name") echo" selected";?>>대표자명</option>
									<option value="staff_name" <?php if($sch_target == "staff_name") echo" selected";?>>담당자명</option>
									<option value="memo" <?php if($sch_target == "memo") echo" selected";?>>메모</option>
									<option value="reg_date" <?php if($sch_target == "reg_date") echo" selected";?>>등록일</option>
							</select> <input type="text" name="sch_keyword" id="sch_keyword" style="width: 150px;" value="<?=$sch_keyword;?>">
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
						<td style="text-align: left; vertical-align: middle; padding-left: 15px;"><?=number_format($totalCnt);?> 업체</td>
						<th style="vertical-align: middle;">계약중 등록수량</th>
						<td style="text-align: left; vertical-align: middle; padding-left: 15px;"><?=number_format($useCnt);?> 업체</td>
						<th style="vertical-align: middle;">계약종료 등록수량</th>
						<td style="text-align: left; vertical-align: middle; padding-left: 15px;"><?=number_format($endCnt);?> 업체</td>
					</tr>
				</tbody>
			</table>
		</div>
		<form name='boardFrm' method="post" target="_actionfrm" action="./shop/shop_proc.php" class="form">
			<div class="table even">
				<table width="100%" border="1" cellspacing="0" class="_memberList">
					<caption>
                    검색결과 업체(<?=$cnt;?>)
                    <span class="side"> <span class="btn"><a href="/manager/?m=shop&a=insert">생성</a></span></span>
					</caption>
					<thead>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">업체명</th>
							<th scope="col" class="nowr">본사</th>
							<!-- <th scope="col" class="nowr">시(도)</th> -->
							<th scope="col" class="nowr">전화번호</th>
							<!-- <th scope="col" class="nowr">대표자명</th> -->
							<th scope="col" class="nowr">담당자명</th>
							<th scope="col" class="nowr">메모</th>
							<th scope="col" class="nowr">돌잔치</th>
							<th scope="col" class="nowr">결혼식</th>
							<th scope="col" class="nowr">고희연</th>
							<th scope="col" class="nowr">가입일</th>
							<th scope="col" class="nowr">수정일</th>
							<th scope="col" class="nowr">계약여부</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">업체명</th>
							<th scope="col" class="nowr">본사</th>
							<!-- <th scope="col" class="nowr">시(도)</th> -->
							<th scope="col" class="nowr">전화번호</th>
							<!-- <th scope="col" class="nowr">대표자명</th> -->
							<th scope="col" class="nowr">담당자명</th>
							<th scope="col" class="nowr">메모</th>
							<th scope="col" class="nowr">돌잔치</th>
							<th scope="col" class="nowr">결혼식</th>
							<th scope="col" class="nowr">고희연</th>
							<th scope="col" class="nowr">가입일</th>
							<th scope="col" class="nowr">수정일</th>
							<th scope="col" class="nowr">계약여부</th>
						</tr>
					</tfoot>
					<tbody>
				    <?php
					foreach ( $arrList as $item ) {
					?>
				    <tr>
						<td class="nowr"><a href="/manager/?m=shop&a=update&shop_id=<?=$item['shop_id'];?>"><?=$listNum;?></a></td>
						<td class="nowr"><a href="/manager/?m=shop&a=update&shop_id=<?=$item['shop_id'];?>"><?=$item['shop_name'];?></a></td>
						<td class="nowr"><a href="/manager/?m=shop&a=update&shop_id=<?=$item['shop_id'];?>"><?=$item['parent_shop_name'];?></a></td>
						<!--<td class="nowr"><a href="/manager/?m=shop&a=update&shop_id=<?=$item['shop_id'];?>"><?=$item['city'];?></a></td>-->
						<td class="nowr"><a href="/manager/?m=shop&a=update&shop_id=<?=$item['shop_id'];?>"><?=$item['tel'];?></a></td>
						<!--<td class="nowr"><a href="/manager/?m=shop&a=update&shop_id=<?=$item['shop_id'];?>"><?=$item['ceo_name'];?></a></td>-->
						<td class="nowr"><a href="/manager/?m=shop&a=update&shop_id=<?=$item['shop_id'];?>"><?=$item['staff_name'];?></a></td>
						<td class="nowr"><a href="/manager/?m=shop&a=update&shop_id=<?=$item['shop_id'];?>"><?=$StringClass->strcut_utf8($item['memo'], 10) ;?></a></td>
						<td class="nowr"><a href="/manager/?m=shop&a=update&shop_id=<?=$item['shop_id'];?>"><?=($item['is_baby'] == 1)? "사용":"미사용";?></a></td>
						<td class="nowr"><a href="/manager/?m=shop&a=update&shop_id=<?=$item['shop_id'];?>"><?=($item['is_wedding'] == 1)? "사용":"미사용";?></a></td>
						<td class="nowr"><a href="/manager/?m=shop&a=update&shop_id=<?=$item['shop_id'];?>"><?=($item['is_silver'] == 1)? "사용":"미사용";?></a></td>
						<td class="nowr"><a href="/manager/?m=shop&a=update&shop_id=<?=$item['shop_id'];?>"><?=$item['short_reg_date'];?></a></td>
						<td class="nowr"><a href="/manager/?m=shop&a=update&shop_id=<?=$item['shop_id'];?>"><?=$item['short_edt_date'];?></a></td>
						<td class="nowr"><a href="/manager/?m=shop&a=update&shop_id=<?=$item['shop_id'];?>"><?=$item['contract'];?></a></td>
					</tr>
				    <?php
						$listNum --;
					}
					?>
                </tbody>
				</table>
			</div>
			<div class="btnArea">
				<span class="side"> <span class="btn"><a href="/manager/?m=shop&a=insert">생성</a></span>
				</span>
			</div>
		</form>

		<div class="search">
			<form action="" class="pagination xe-pagination" style="float: none; text-align: center;" method="post">
				<div id="num">
			<?=$page_list;?>
			</div>
			</form>
		</div>
	</div>
</div>
<!--*****메인 끝*****-->