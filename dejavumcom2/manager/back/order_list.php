<?php
/**
 *  order_list.php
 *  @Desc      : 메인 이미지 관리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
import ( "class.controller.OrderCon" );
$OrderCon = new OrderCon ();

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
$cnt = $OrderCon->getOrderCnt ( $param );
$arrList = $OrderCon->getOrderList ( $param );

/**
 * ******************************************************************************************
 * @Desc 페이지 번호 목록 출력
 * *****************************************************************************************
 */
$getParam = "&menu=order";
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
			<input type="hidden" id="menu" name="menu" value="order" />

			<h1 class="h1">주문목록</h1>
			<div class="table even">
				<table width="100%" border="1" cellspacing="0" class="_memberList">
					<caption>
						<span class="side"> <span class="btn"></span>
						</span>
					</caption>
					<thead>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">이미지</th>
							<th scope="col" class="nowr">상품명</th>
							<th scope="col" class="nowr">주문아이디</th>
							<th scope="col" class="nowr">수취인명</th>
							<th scope="col" class="nowr">결제타입</th>
							<th scope="col" class="nowr">결제금액</th>
							<th scope="col" class="nowr">입금예정일</th>
							<th scope="col" class="nowr">입금자명</th>
							<th scope="col" class="nowr">주문상태</th>
							<th scope="col" class="nowr">결제상태</th>
							<th scope="col" class="nowr">배송상태</th>
							<th scope="col" class="nowr">주문일</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">이미지</th>
							<th scope="col" class="nowr">상품명</th>
							<th scope="col" class="nowr">주문아이디</th>
							<th scope="col" class="nowr">수취인명</th>
							<th scope="col" class="nowr">결제타입</th>
							<th scope="col" class="nowr">결제금액</th>
							<th scope="col" class="nowr">입금예정일</th>
							<th scope="col" class="nowr">입금자명</th>
							<th scope="col" class="nowr">주문상태</th>
							<th scope="col" class="nowr">결제상태</th>
							<th scope="col" class="nowr">배송상태</th>
							<th scope="col" class="nowr">주문일</th>
						</tr>
					</tfoot>
					<tbody>
				    <?php
								foreach ( $arrList as $item ) {
									?>
				    <tr>
							<td class="nowr"><?=$listNum;?></td>
							<td class="nowr"><a
								href="/manager/index.php?menu=order&action=view&order_code=<?=$item['order_code'];?>"><?php if($item['first_product_image']) {?><img
									src="<?=$conf_product_file_url.$item['first_product_image'];?>"
									style="height: 40px;" /><?php }?></a></td>
							<td class="nowr"><a
								href="/manager/index.php?menu=order&action=view&order_code=<?=$item['order_code'];?>"><?=$item['first_product_label'];?></a></td>
							<td class="nowr"><?=$item['user_id'];?></td>
							<td class="nowr"><?=$item['receiver_name'];?></td>
							<td class="nowr"><?=$item['payment_type_label'];?></td>
							<td class="nowr"><?=number_format($item['payment_value']);?></td>
							<td class="nowr"><?=$item['bank_date'];?></td>
							<td class="nowr"><?=$item['bank_sender'];?></td>
							<td class="nowr"><?=$item['order_status_label'];?></td>
							<td class="nowr"><?=$item['payment_result_label'];?></td>
							<td class="nowr"><?=$item['logistics_status_label'];?></td>
							<td class="nowr"><?=$item['large_reg_date'];?></td>
						</tr>
				    <?php
									$listNum --;
								}
								?>
                </tbody>
				</table>
			</div>

			<div class="btnArea">
				<span class="side"> <span class="btn"></span>
				</span>
			</div>
		</form>

	</div>
</div>
<!--*****메인 끝*****-->