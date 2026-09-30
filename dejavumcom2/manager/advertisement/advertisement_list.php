<?php
/**
 *  advertisement_list.php
 *  @Desc      : 광고 목록 관리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */

/**
 *
 * @var parameter setting
 */
$search_target = $StringClass->getRequest ( 'search_target' );
$search_keyword = $StringClass->getRequest ( 'search_keyword' );

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
if (! empty ( $search_target ) && ! empty ( $search_keyword )) {
	switch ($search_target) {
		case "company_name" :
			$param ['company_name'] = $search_keyword;
			break;
		case "reg_date" :
			$param ['reg_date'] = $search_keyword;
			break;
	}
}
$cnt = $AdvertisementCon->getAdvertisementCnt ( $param );
$arrList = $AdvertisementCon->getAdvertisementList ( $param, $startPaging, $pageRowCnt );

/**
 * ******************************************************************************************
 * @Desc 페이지 번호 목록 출력
 * *****************************************************************************************
 */
$getParam = "&m=advertisement";
$getParam .= "&search_target={$search_target}";
$getParam .= "&search_keyword={$search_keyword}";

$page = new Paging ( 'BOARD' );
$page->initPaging ( $cnt, $pageBlockSize, $pageRowCnt, $nowPage, $thisPage . "?", $getParam );
$page_list = $page->getPaging ();

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
function goSearch()
{
    var search_target   = $("#search_target").val();
    var search_keyword  = $("#search_keyword").val();

	var strUrl = "<?=$thisPage;?>?m=advertisement&search_target="+ search_target +"&search_keyword="+ search_keyword;

	location.href = strUrl;
}

function postAdvertisement()
{
	document.boardFrm.submit();
}
//-->
</script>
<div class="body">
	<div class="content" id="content" tabindex="0">
		<form name='boardFrm' method="post" target="_actionfrm"
			action="./advertisement/advertisement_proc.php" class="form">
			<h1 class="h1">광고 목록</h1>
			<div class="table even">
				<table width="100%" border="1" cellspacing="0" class="_memberList">
					<caption>
                    모든 광고(<?=$cnt;?>)
                    <span class="side"> <span class="btn"><a
								href="/manager/?m=advertisement&a=insert">생성</a></span>
						</span>
					</caption>
					<thead>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">업체명</th>
							<th scope="col" class="nowr">배너</th>
							<th scope="col" class="nowr">광고시작일</th>
							<th scope="col" class="nowr">광고종료일</th>
							<th scope="col" class="nowr">가입일</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">업체명</th>
							<th scope="col" class="nowr">배너</th>
							<th scope="col" class="nowr">광고시작일</th>
							<th scope="col" class="nowr">광고종료일</th>
							<th scope="col" class="nowr">가입일</th>
						</tr>
					</tfoot>
					<tbody>
				    <?php
								foreach ( $arrList as $item ) {
									?>
				    <tr>
							<td class="nowr"><a
								href="/manager/?m=advertisement&a=update&adver_id=<?=$item['adver_id'];?>"><?=$listNum;?></a></td>
							<td class="nowr"><a
								href="/manager/?m=advertisement&a=update&adver_id=<?=$item['adver_id'];?>"><?=$item['company_name'];?></a></td>
							<td class="nowr"><a
								href="<?=$conf_img_banner_url.$item['file_url'];?>"
								target="_blank"><img
									src="<?=$conf_img_banner_url.$item['file_url'];?>"
									style="width: 80px;" /></a></td>
							<td class="nowr"><a
								href="/manager/?m=advertisement&a=update&adver_id=<?=$item['adver_id'];?>"><?=$item['st_date'];?></a></td>
							<td class="nowr"><a
								href="/manager/?m=advertisement&a=update&adver_id=<?=$item['adver_id'];?>"><?=$item['ed_date'];?></a></td>
							<td class="nowr"><a
								href="/manager/?m=advertisement&a=update&adver_id=<?=$item['adver_id'];?>"><?=$item['reg_date'];?></a></td>
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
						href="/manager/?m=advertisement&a=insert">생성</a></span>
				</span>
			</div>
		</form>

		<div class="search">
			<form action="" class="pagination xe-pagination" method="post">
				<div id="num">
			<?=$page_list;?>
			</div>
			</form>
			<form action="" method="post">
				<select name="search_target" id="search_target">
					<option value="">검색대상</option>
					<option value="company_name"
						<?php if($search_target == "company_name") echo" selected";?>>업체명</option>
				</select> <input type="text" name="search_keyword"
					id="search_keyword" value="<?=$search_keyword;?>"> <input
					type="button" onclick="goSearch()" value="검색">
			</form>
		</div>
	</div>
</div>
<!--*****메인 끝*****-->