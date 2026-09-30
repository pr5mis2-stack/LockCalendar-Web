<?php
/**
 *  product_form.php
 *  @Desc      : 상품등록 관리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
import ( "class.controller.CategoryCon" );
import ( "class.controller.ProductCon" );
import ( "class.controller.OrderCon" );
import ( "class.controller.PaymentCon" );

$CategoryCon = new CategoryCon ();
$ProductCon = new ProductCon ();
$OrderCon = new OrderCon ();
$PaymentCon = new PaymentCon ();

/**
 *
 * @var parameter setting
 */
$order_code = $StringClass->getRequest ( 'order_code' );
$search_target = $StringClass->getRequest ( 'search_target' );
$search_keyword = $StringClass->getRequest ( 'search_keyword' );

$param = array ();
$param ['order_code'] = $order_code;
$arrList = $OrderCon->getOrderProductList ( $param );
$ordList = $OrderCon->getOrderList ( $param );
$payList = $PaymentCon->getOrderPaymentList ( $param );
if ($ordList)
	$ordInfo = $ordList [0];
if ($payList)
	$payInfo = $payList [0];
	
	// new dBug($ordInfo);
	// new dBug($payInfo);
/**
 * ******************************************************************************************
 * @Desc 페이지 번호 목록 출력
 * *****************************************************************************************
 */
$getParam = "&menu=order";
$getParam .= "&search_target={$search_target}";
$getParam .= "&search_keyword={$search_keyword}";

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
    var is_proc_ing = false;

    function postManager()
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        var order_code			= $("#order_code").val();
        var payment_id			= $("#payment_id").val();
        var payment_result     	= $('#payment_result option:selected').val();
        var order_status		= $('#order_status option:selected').val()
        var logistics_status	= $('#logistics_status option:selected').val()
        var logistics_name		= $('#logistics_name').val();
        var logistics_code  	= $('#logistics_code').val();
        
        var goUrl = "./order_proc.php";
        var param = "&mode=update&order_code="+ order_code +"&payment_id="+ payment_id +"&payment_result="+ payment_result +"&order_status="+ order_status
        		  + "&logistics_status="+ logistics_status +"&logistics_name="+ logistics_name +"&logistics_code="+ logistics_code;
        //location.href = goUrl + "?" + param;
		//return false;
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

</script>
<div class="body">
	<div class="content" id="content" tabindex="0">
		<h1 class="h1">주문관리</h1>
		<form name="boardFrm" method="post" target="_actionfrm"
			action="order_proc.php" class="form">
			<input type="hidden" id="order_code" name="order_code"
				value="<?=$order_code;?>" /> <input type="hidden" id="payment_id"
				name="payment_id" value="<?=$payInfo['payment_id'];?>" />
			<div class="table even">
				<fieldset class="section">
					<h2 class="h2">
						주문상품
						<button type="button" class="sTog" title="Open/Close">
							<i class="icon-chevron-up"></i>
						</button>
					</h2>
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
									<th scope="col" class="nowr">옵션</th>
									<th scope="col" class="nowr">수량</th>
									<th scope="col" class="nowr">가격</th>
								</tr>
							</thead>
							<tbody>
						    <?php
										$listNum = count ( $arrList );
										foreach ( $arrList as $item ) {
											?>
						    <tr>
									<td class="nowr"><?=$listNum;?></td>
									<td class="nowr"><img
										src='<?=$conf_product_file_url;?><?=$item['title_image'];?>'
										style='height: 40px;' alt='<?=$item['product_name'];?>'></td>
									<td class="nowr"><?=$item['product_name'];?></td>
									<td class="nowr"><?=$item['product_options'];?></td>
									<td class="nowr"><?=$item['product_cnt'];?></td>
									<td class="nowr"><?=number_format($item['order_price']);?>원</td>
								</tr>
						    <?php
											$listNum --;
										}
										?>
		                </tbody>
						</table>
					</div>
				</fieldset>
				<fieldset class="section">
					<h2 class="h2">
						결제금액
						<button type="button" class="sTog" title="Open/Close">
							<i class="icon-chevron-up"></i>
						</button>
					</h2>
					<table class="list01">
						<colgroup>
							<col width="30%">
							<col width="30%">
							<col width="40%">
						</colgroup>
						<thead>
							<tr>
								<th>총 상품금액</th>
								<th>배송비</th>
								<th>결재금액</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?=number_format($payInfo['payment_value'] - $deliver_price);?>원</td>
								<td><?=number_format($deliver_price);?>원</td>
								<td><?=number_format($payInfo['payment_value']);?>원</td>
							</tr>
						</tbody>
					</table>
				</fieldset>
				<fieldset class="section">
					<h2 class="h2">
						배송지 정보
						<button type="button" class="sTog" title="Open/Close">
							<i class="icon-chevron-up"></i>
						</button>
					</h2>
					<table class="list01">
						<colgroup>
							<col width="20%">
							<col width="80%">
						</colgroup>
						<tbody>
							<tr>
								<th>수령인</th>
								<td style="text-align: left; padding-left: 15px;"><?=$ordInfo['receiver_name'];?></td>
							</tr>
							<tr>
								<th>연락처1</th>
								<td style="text-align: left; padding-left: 15px;"><?=$ordInfo['receiver_hp1'];?>-<?=$ordInfo['receiver_hp2'];?>-<?=$ordInfo['receiver_hp3'];?></td>
							</tr>
							<tr>
								<th>연락처2</th>
								<td style="text-align: left; padding-left: 15px;"><?=$ordInfo['receiver_tel1'];?>-<?=$ordInfo['receiver_tel2'];?>-<?=$ordInfo['receiver_tel3'];?></td>
							</tr>
							<tr>
								<th>배송지</th>
								<td style="text-align: left; padding-left: 15px;">[<?=$ordInfo['receiver_zipcode'];?>] <?=$ordInfo['receiver_addr1'];?> <?=$ordInfo['receiver_addr2'];?></td>
							</tr>
							<tr>
								<th>배송메모</th>
								<td style="text-align: left; padding-left: 15px;"><?=$ordInfo['logistics_memo'];?></td>
							</tr>
						</tbody>
					</table>
				</fieldset>
				<fieldset class="section">
					<h2 class="h2">
						결제 정보
						<button type="button" class="sTog" title="Open/Close">
							<i class="icon-chevron-up"></i>
						</button>
					</h2>
					<table class="list01">
						<colgroup>
							<col width="20%">
							<col width="30%">
							<col width="20%">
							<col width="30%">
						</colgroup>
						<tbody>
							<tr>
								<th>결제방식</th>
								<td style="text-align: left; padding-left: 15px;"><?=$ordInfo['payment_type_label'];?> (<?=$ordInfo['payment_result_label'];?>)</td>
								<th>결재상태</th>
								<td style="text-align: left; padding-left: 15px;"><select
									id="payment_result" name="payment_result">
										<option value="N"
											<?php if ($ordInfo['payment_result'] == "N") echo "selected";?>>결재미완료</option>
										<option value="Y"
											<?php if ($ordInfo['payment_result'] == "Y") echo "selected";?>>결재완료</option>
								</select>
							
							</tr>
							<tr>
								<th>주문상태</th>
								<td style="text-align: left; padding-left: 15px;"><select
									id="order_status" name="order_status">
										<option value="10"
											<?php if ($payInfo['order_status'] == "10") echo "selected";?>>주문</option>
										<option value="20"
											<?php if ($payInfo['order_status'] == "20") echo "selected";?>>반품</option>
										<option value="30"
											<?php if ($payInfo['order_status'] == "30") echo "selected";?>>환불</option>
								</select></td>
								<th>배송상태</th>
								<td style="text-align: left; padding-left: 15px;"><select
									id="logistics_status" name="logistics_status">
										<option value="10"
											<?php if ($ordInfo['logistics_status'] == "10") echo "selected";?>>주문중</option>
										<option value="20"
											<?php if ($ordInfo['logistics_status'] == "20") echo "selected";?>>배송준비중</option>
										<option value="30"
											<?php if ($ordInfo['logistics_status'] == "30") echo "selected";?>>배송중</option>
										<option value="40"
											<?php if ($ordInfo['logistics_status'] == "40") echo "selected";?>>배송완료</option>
								</select></td>
							</tr>
	                    <?php if ($ordInfo['payment_type'] == "B") { ?>
						<tr>
								<th>입금자명</th>
								<td style="text-align: left; padding-left: 15px;"><?=$ordInfo['bank_sender'];?></td>
								<th>입금예정일</th>
								<td style="text-align: left; padding-left: 15px;"><?=$ordInfo['bank_date'];?></td>
							</tr>
	                    <?php } ?>
						<tr>
								<th>택배사명</th>
								<td style="text-align: left; padding-left: 15px;"><input
									type="text" size="10" id="logistics_name" name="logistics_name"
									value="<?=$ordInfo['logistics_name'];?>" style="width: 200px;" /></td>
								<th>송장번호</th>
								<td style="text-align: left; padding-left: 15px;"><input
									type="text" size="10" id="logistics_code" name="logistics_code"
									value="<?=$ordInfo['logistics_code'];?>" style="width: 200px;" /></td>
							</tr>
							<tr>
								<th>배송일</th>
								<td style="text-align: left; padding-left: 15px;"><?=$ordInfo['short_logistics_date'];?></td>
								<th>주문일</th>
								<td style="text-align: left; padding-left: 15px;"><?=$ordInfo['large_reg_date'];?></td>
							</tr>
						</tbody>
					</table>
				</fieldset>

			</div>
			<div class="btnArea">
				<span class="side"> <input type="button" onClick="postManager();"
					value="적용">
				</span>
			</div>
		</form>

	</div>
</div>
<!--*****메인 끝*****-->