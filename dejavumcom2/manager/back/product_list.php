<?php
/**
 *  product_list.php
 *  @Desc      : 메인 이미지 관리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
import ( "class.controller.ProductCon" );
$ProductCon = new ProductCon ();

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
		case "category_id" :
			$param ['category_id'] = $search_keyword;
			break;
		case "category_id" :
			$param ['category_id'] = $search_keyword;
			break;
		case "category_name" :
			$param ['category_name'] = $search_keyword;
			break;
	}
}
$cnt = $ProductCon->getProductCnt ( $param );
$arrList = $ProductCon->getProductList ( $param );

/**
 * ******************************************************************************************
 * @Desc 페이지 번호 목록 출력
 * *****************************************************************************************
 */
$getParam = "&menu=product";
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
    function goSearch() {
        $("#boardFrm").submit();
    }

</script>
<div class="body">
	<div class="content" id="content" tabindex="0">
		<form name='boardFrm' id="boardFrm" method="post"
			action="/manager/index.php" class="form">
			<input type="hidden" id="menu" name="menu" value="product" />

			<h1 class="h1">상품목록</h1>
			<div class="table even">
				<table width="100%" border="1" cellspacing="0" class="_memberList">
					<caption>
						<span class="side"> <span class="btn"><a
								href="/manager/index.php?menu=product&action=insert">상품등록</a></span>
						</span>
					</caption>
					<thead>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">이미지</th>
							<th scope="col" class="nowr">상품명</th>
							<th scope="col" class="nowr">가격</th>
							<th scope="col" class="nowr">할인가</th>
							<th scope="col" class="nowr">판매여부</th>
							<th scope="col" class="nowr">재고수량</th>
							<th scope="col" class="nowr">등록일</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">이미지</th>
							<th scope="col" class="nowr">상품명</th>
							<th scope="col" class="nowr">가격</th>
							<th scope="col" class="nowr">할인가</th>
							<th scope="col" class="nowr">판매여부</th>
							<th scope="col" class="nowr">재고수량</th>
							<th scope="col" class="nowr">등록일</th>
						</tr>
					</tfoot>
					<tbody>
				    <?php
								foreach ( $arrList as $item ) {
									?>
				    <tr>
							<td class="nowr"><?=$listNum;?></td>
							<td class="nowr"><a
								href="/manager/index.php?menu=product&action=update&pid=<?=$item['product_id'];?>"><?php if($item['title_image']) {?><img
									src="<?=$conf_product_file_url.$item['title_image'];?>"
									style="height: 40px;" /><?php }?></a></td>
							<td class="nowr"><a
								href="/manager/index.php?menu=product&action=update&pid=<?=$item['product_id'];?>"><?=$item['product_name'];?></a></td>
							<td class="nowr"><?=$item['price'];?></td>
							<td class="nowr"><?=$item['sale_price'];?></td>
							<td class="nowr"><?=$item['is_sale_label'];?></td>
							<td class="nowr"><?=$item['product_cnt'];?></td>
							<td class="nowr"><?=$item['reg_date'];?></td>
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
						href="/manager/index.php?menu=product&action=insert">상품등록</a></span>
				</span>
			</div>
		</form>

	</div>
</div>
<!--*****메인 끝*****-->