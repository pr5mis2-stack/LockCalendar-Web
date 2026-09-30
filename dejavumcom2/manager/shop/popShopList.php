<?php
/**
 *  popShopList.php
 *  @Desc      : 관리자 목록 관리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/pop_top.php");

import ( "class.controller.ShopCon" ); // 서비스 로그 저장
import ( "php.util.PagingClass" );

$ShopCon = new ShopCon ();

/**
 *
 * @var parameter setting
 */
$thisPage = "/manager/shop/popShopList.php";
$search_target = $StringClass->getRequest ( 'search_target' );
$search_keyword = $StringClass->getRequest ( 'search_keyword' );

$pageRowCnt = 15;
$nowPage = (isset($_GET['nowPage']) ? $_GET['nowPage'] : '');
if (empty ( $nowPage ))
	$nowPage = 1;

$startPaging = ($nowPage - 1) * $pageRowCnt;
$endPaging = $nowPage * $pageRowCnt;

/**
 *
 * @var get board data setting
 */
$param = array ();
$param ['parent_shop_id'] = 0;

if (! empty ( $search_target ) && ! empty ( $search_keyword )) {
	switch ($search_target) {
		case "shop_id" :
			$param ['shop_id'] = $search_keyword;
			break;
		case "shop_name" :
			$param ['shop_name'] = $search_keyword;
			break;
		case "reg_date" :
			$param ['reg_date'] = $search_keyword;
			break;
	}
}
$cnt = $ShopCon->getParentShopCnt ( $param );
$arrList = $ShopCon->getParentShopList ( $param, $startPaging, $pageRowCnt );

/**
 * ******************************************************************************************
 * @Desc 페이지 번호 목록 출력
 * *****************************************************************************************
 */
$getParam = "&m=shop";
$getParam .= "&search_target={$search_target}";
$getParam .= "&search_keyword={$search_keyword}";

$page = new Paging ( 'BOARD' );
$page->initPaging ( $cnt, $pageBlockSize, $pageRowCnt, $nowPage, $thisPage . "?", $getParam );
$page_list = $page->getPaging ();

$listNum = $cnt - $startPaging; // List numbering

?>
<link rel="stylesheet" href="/css/xe.min.css" type="text/css"
	media="all" />
<link rel="stylesheet" href="/css/message.css" type="text/css"
	media="all" />
<link rel="stylesheet" href="/css/admin_ko.css" type="text/css"
	media="all" />
<link rel="stylesheet" href="/css/admin.min.css" type="text/css"
	media="all" />
<script type="text/javascript" src="/js/message.js"></script>
<script type="text/javascript" src="/js/admin.min.js"></script>

<div class="x">
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

	var strUrl = "<?=$thisPage;?>?m=shop&search_target="+ search_target +"&search_keyword="+ search_keyword;

	location.href = strUrl;
}

function selShop(shop_id, shop_name)
{
	opener.boardFrm.parent_shop_id.value = shop_id;
	opener.boardFrm.parent_shop_name.value = shop_name;
	
	self.close();
	
}
//-->
</script>
	<div class="body">
		<div class="content" id="content" tabindex="0">
			<form name='boardFrm' method="post" target="_actionfrm"
				action="./shop/shop_proc.php" class="form">
				<h1 class="h1">업체 목록</h1>
				<div class="table even">
					<table width="100%" border="1" cellspacing="0" class="_memberList">
						<caption>
                    모든 업체(<?=$cnt;?>)
                    <span class="side"> </span>
						</caption>
						<thead>
							<tr>
								<th scope="col" class="nowr">No</th>
								<th scope="col" class="nowr">업체명</th>
								<th scope="col" class="nowr">시(도)</th>
								<th scope="col" class="nowr">대표자명</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th scope="col" class="nowr">No</th>
								<th scope="col" class="nowr">업체명</th>
								<th scope="col" class="nowr">시(도)</th>
								<th scope="col" class="nowr">대표자명</th>
							</tr>
						</tfoot>
						<tbody>
				    <?php
								foreach ( $arrList as $item ) {
									?>
				    <tr>
								<td class="nowr"><?=$listNum;?></td>
								<td class="nowr"><a href="#"
									onClick="selShop('<?=$item['shop_id'];?>', '<?=$item['shop_name'];?>');"><?=$item['shop_name'];?></a></td>
								<td class="nowr"><?=$item['city'];?></td>
								<td class="nowr"><?=$item['ceo_name'];?></td>
							</tr>
				    <?php
									$listNum --;
								}
								?>
                </tbody>
					</table>
				</div>
				<div class="btnArea">
					<span class="side"> </span>
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
						<option value="reg_date"
							<?php if($search_target == "reg_date") echo" selected";?>>가입일시</option>
						<option value="shop_name"
							<?php if($search_target == "shop_name") echo" selected";?>>업체명</option>
						<option value="ceo_name"
							<?php if($search_target == "ceo_name") echo" selected";?>>대표자명</option>
						<option value="staff_name"
							<?php if($search_target == "staff_name") echo" selected";?>>담당자명</option>

					</select> <input type="text" name="search_keyword"
						id="search_keyword" value="<?=$search_keyword;?>"> <input
						type="button" onclick="goSearch()" value="검색">
				</form>
			</div>
		</div>
	</div>
	<!--*****메인 끝*****-->
</div>
<?php require_once($_SERVER["DOCUMENT_ROOT"]."/include/manager_footer.php"); ?>