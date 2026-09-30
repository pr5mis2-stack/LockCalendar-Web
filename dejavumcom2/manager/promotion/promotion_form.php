<?php
/**
 *  promotion_form.php
 *  @Desc      : 프로모션정보 관리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
/**
 *
 * @var parameter setting
 */
$_a = $StringClass->getRequest('a');
$shop_id = $StringClass->getRequest('shop_id');
$sch_date = $StringClass->getRequest('sch_date');
$sch_end = $StringClass->getRequest('sch_end');
$sch_target = $StringClass->getRequest('sch_target');
$sch_keyword = $StringClass->getRequest('sch_keyword');

/**
 *
 * @var get board data setting
 */
if ($_a == "view" || $_a == "update") {
	$param = array ();
	$param['shop_id'] = $shop_id;
	// new dBug($param);
	$arrList = $PromotionCon->getPromotionList($param);
	if ($arrList)
		$promoInfo = $arrList[0];
	else
		$StringClass->alertMsg('정보가 없습니다.', '_self', '', '');
} else {
	$shopList = $PromotionCon->getNonAddedShopList();
}

/**
 * ******************************************************************************************
 * @Desc 페이지 번호 목록 출력
 * *****************************************************************************************
 */
$getParam = "&m=promotion";
$getParam .= "&sch_date={$sch_date}";
$getParam .= "&sch_end={$sch_end}";
$getParam .= "&sch_target={$sch_target}";
$getParam .= "&sch_keyword={$sch_keyword}";
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
	
	function postPromotion()
	{
		if (is_proc_ing) {
			alert("진행중 입니다.");
			return;
		}

		document.promoFrm.submit();
	}

	/**
	*
	*/
	function postPromotionDelete(shop_id)
	{
		if (is_proc_ing) {
			alert("진행중 입니다.");
			return;
		}
		
		var goUrl = "./promotion/promotion_proc.php";
		var param = "&a=delete&shop_id="+ shop_id;
		//location.href = goUrl + "?" + param;
			//return false;
			is_proc_ing = true;

		$.ajax({
			type: 'post'
			, async: true
			, url: goUrl
			, data: param
			, beforeSend: function () { 
				is_proc_ing = true;
			}
			, success: function (data) {

				is_proc_ing = false;

				var result = data.trim();

				if (result == "100")
				{
					alert('처리되었습니다');
					location.href = "/manager/?<?=$getParam;?>";
				}
				else
					alert('처리중 오류가 발생하였습니다.');
				}
				, error: function (data, status, err) { }
			, complete: function () { }
		});
	}

	function gotoList()
	{
		location.href = "/manager/?<?=$getParam;?>";
	}

	function setShopId(shop_id)
	{
		$("#shop_id").val($("#sel_shop_id option:selected").val());
	}
</script>
<div class="body">
	<div class="content" id="content" tabindex="0">
		<h1 class="h1">프로모션 관리</h1>
		<form name="promoFrm" method="post" target="_actionfrm"
			action="./promotion/promotion_proc.php" class="form" enctype="multipart/form-data">
			<input type="hidden" name="a" value="<?=($promoInfo['shop_id'] != "")? "update" : "insert";?>" />
			<input type="hidden" id="shop_id" name="shop_id" value="<?=$promoInfo['shop_id'];?>" />
			<input type="hidden" id="upload_dir" name="upload_dir" value="SHOP" />
			<div class="table even">
				<fieldset class="section">
					<h2 class="h2">
						프로모션 등록
						<button type="button" class="sTog" title="Open/Close"></button>
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
								<th>업체정보</th>
								<td style="text-align: left; padding-left: 15px;">
								<?php 
								if ($promoInfo['shop_id'] != "") { 
									echo $promoInfo['shop_name'];
								} else {
									echo"<select id='sel_shop_id' name='sel_shop_id' onchange='setShopId()'><option value=''>업체선택</option>";
									foreach($shopList as $item ) {
										echo"<option value='{$item['shop_id']}'>{$item['shop_name']}</option>";
									}
									echo"</select>";
								} 
								?>
								</td>
								<th>팝업여부</th>
								<td style="text-align: left; padding-left: 15px;">
									<select id="is_popup" name="is_popup">
										<option value="0" <?php if($promoInfo["is_popup"] == "0") echo" selected";?>>미사용</option>
										<option value="1" <?php if($promoInfo["is_popup"] == "1") echo" selected";?>>사용</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>팝업이미지</td>
								<td colspan="3" style="text-align: left; padding-left: 15px;">
								<input type='file' size='10' name='user_file[]' />
								<?php if($promoInfo["file_url"] != "") echo "<a href='{$conf_img_shop_url}{$promoInfo["file_url"]}' target='_blank'>{$promoInfo["file_name"]}</a>"; ?>
								</td>
							</tr>
							<tr>
								<td>이미지 Width</td>
								<td style="text-align: left; padding-left: 15px;">
								<input	type="text" size="10" id="img_width" name="img_width" value="<?=$promoInfo["img_width"];?>" /> px
								</td>
								<td>이미지 Height</td>
								<td style="text-align: left; padding-left: 15px;">
								<input	type="text" size="10" id="img_height" name="img_height" value="<?=$promoInfo["img_height"];?>" /> px
								</td>
							</tr>
						</tbody>
					</table>
				</fieldset>

			</div>
			<div class="btnArea">
				<span class="side"> 
					<input type="button" id="btnPost" onClick="postPromotion();" value="<?=($promoInfo['shop_id'] != "")? "수정" : "등록";?>"> 
					<input type="button" onClick="postPromotionDelete(<?=$promoInfo['shop_id'];?>)" value="삭제" />
					<input type="button" onClick="gotoList();" value="목록으로">
				</span>
			</div>
		</form>

	</div>
</div>
<!--*****메인 끝*****-->