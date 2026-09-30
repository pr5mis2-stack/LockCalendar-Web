<?php
/**
 *  main_list.php
 *  @Desc      : 초대장 목록 관리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */

/**
 *
 * @var parameter setting
 */
$sample_type = $StringClass->getRequest ( 'sample_type' );
$interval = $StringClass->getRequest ( 'interval' );
if ($interval == "") $interval = "12";

/**
 *
 * @var get board data setting
 */
$param = array ();
$param['interval'] = $interval;
$param['sample_type'] = $sample_type;

/**
 * ******************************************************************************************
 * @Desc 페이지 번호 목록 출력
 * *****************************************************************************************
 */
$getParam = "&m=main";
$getParam .= "&sample_type={$sample_type}";
$getParam .= "&interval={$interval}";

/**
 * ******************************************************************************************
 * @Desc 전체 등록 수량 체크
 * *****************************************************************************************
 */
$endCnt = $DataCon->getDataCnt($param); // 행사종료후
$param['interval'] = "";
$totalCnt = $DataCon->getDataCnt($param); // 전체
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
	var sample_type	= $("#sample_type").val();
	var interval	= $("#interval").val();

	var strUrl = "<?=$thisPage;?>?m=data&sample_type="+ sample_type +"&interval="+ interval;

	location.href = strUrl;
}


function gotoDel()
{
    if (is_proc_ing) {
        alert("진행중 입니다.");
        return;
    }

	var sample_type	= $("#sample_type").val();
	var interval	= $("#interval").val();      
    var goUrl = "./data/data_proc.php";
    var param = "&a=delete&sample_type="+ sample_type +"&interval="+ interval;

	if (interval == "")
	{
		alert("삭제할 기간을 선택해 주세요.");
		return false;
	}

	if (confirm('정말 삭제하시겠습니까?'))
	{
	    is_proc_ing = true;

		document._delfrm.location.href = goUrl + "?" + param;
	}
}
//-->
</script>
<div class="body">
	<div class="content" id="content" tabindex="0">
		<h1 class="h1">초대장 삭제 대상</h1>
		<form action="" method="post">
			<div id="search_box" class="table">
				<table class="list01">
					<colgroup>
						<col width="15%">
						<col width="20%">
						<col width="15%">
						<col width="20%">
						<col width="30%">
					</colgroup>
					<tbody>
						<tr>
							<th style="vertical-align: middle;">초대장 타입</th>
							<td style="text-align: left; vertical-align: middle; padding-left: 15px;">
								<select id="sample_type" name="sample_type">
									<option value="" <?php if($sample_type == "") echo" selected";?>>전체</option>
									<option value="B" <?php if($sample_type == "B") echo" selected";?>>돌잔치</option>
									<option value="W" <?php if($sample_type == "W") echo" selected";?>>결혼식</option>
									<option value="S" <?php if($sample_type == "S") echo" selected";?>>고희연</option>
								</select>
							</td>
							<th style="vertical-align: middle;">행사종료 기간</th>
							<td style="text-align: left; vertical-align: middle; padding-left: 15px;">
 								<select id="interval" name="interval">
 									<option value="36" <?php if($interval == "36") echo" selected";?>>3년전</option>
 									<option value="24" <?php if($interval == "24") echo" selected";?>>2년전</option>
									<option value="12" <?php if($interval == "12") echo" selected";?>>1년전</option>
									<option value="6" <?php if($interval == "6") echo" selected";?>>6개월전</option>
									<option value="3" <?php if($interval == "3") echo" selected";?>>3개월전</option>
									<option value="1" <?php if($interval == "1") echo" selected";?>>1개월전</option>
 								</select>
 							</td>
							<td style="text-align: center; vertical-align: middle; padding-left: 15px;">
								<input type="button" onclick="goSearch()" value="검색">
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div id="result_box" class="table">
				<table class="list01">
					<colgroup>
						<col width="15%">
						<col width="20%">
						<col width="15%">
						<col width="20%">
						<col width="30%">
					</colgroup>
					<tbody>
						<tr>
							<th style="vertical-align: middle;">전체 건수</th>
							<td style="text-align: left; vertical-align: middle; padding-left: 15px;">
								<?=number_format($totalCnt);?> 건
							</td>
							<th style="vertical-align: middle;">검색된 건수</th>
							<td style="text-align: left; vertical-align: middle; padding-left: 15px;">
								<?=number_format($endCnt);?> 건
							</td>
							<td style="text-align: center; vertical-align: middle; padding-left: 15px;">
								<input type="button" onclick="gotoDel()" value="삭제">
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</form>
	</div>
</div>
<iframe name="_delfrm" id="_delfrm" src="" width="100%" height="100" frameborder="0" scrolling="auto"></iframe>
<!--*****메인 끝*****-->