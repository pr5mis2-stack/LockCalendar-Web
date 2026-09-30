<?php 
$main_info = array();

if ($_SESSION['dejavu_id'])
{
	// get main info
	$param = array();
	$param['main_id'] = $_SESSION['dejavu_id'];
	$result = $MainCon->getMainList($param);
	if ($result)
		$main_info = $result[0];
	
	// 감사장 기본문구 설정
	if ($main_info['type_value'] == "W")
		$appreciation_info['memo'] = "바쁘신 와중에도\n저희 결혼식에 참석하셔서\n축하와 호의를 베풀어 주신데 대하여\n진심으로 감사의 말씀을 전합니다.\n서로 아끼고 사랑하며 진실 된 마음으로\n함께 할 것을 약속드립니다.\n감사합니다.";
	else if ($main_info['type_value'] == "S") {
		//$appreciation_info['memo'] = "긴 세월동안 두터운 정을 키워오신\n어르신들과 친지분들을 모시고\n소중한 자리를 마련하고자 합니다.\n부디 참석하셔서 자리를 빛내주시면\n더없는 기쁨이 되겠습니다.";
		$appreciation_info['memo'] = "귀한시간 내주시어 저희 부모님의 생신연을 함께 해 주시어 진심으로 감사드립니다.";
	} else 
		$appreciation_info['memo'] = "사랑으로 축하해주신 모든분들께 보답하는 \n마음으로 건강하게 잘 키우겠습니다.";
	
	$appreciation_result = $AppreciationCon->getAppreciationList($param);
	if ($appreciation_result)
		$appreciation_info = $appreciation_result[0];
	/*
	$cparam = array();
	$cparam['code_tbl'] = "tb_appreciation";
	$cparam['code_fld'] = "memo";
	$arrSampleList = $CommonCodeCon->getCommonCodeList($cparam);
	*/
}
else
	$StringClass->alertMsg("메인부터 작성해 주세요.", "", "", "");

//new dBug($appreciation_info['memo']);
?>
<form name='frm' method="post" target="_actionfrm" action="maker_step5_proc.php" class="form" enctype="multipart/form-data">
<input type="hidden" id="main_id" name="main_id" value="<?=$_SESSION['dejavu_id']?>" />
<input type="hidden" id="s" name="s" value="S" />
<input type="hidden" name="is_invitation" id="is_invitation" value="<?=$main_info['is_invitation'];?>" />
<input type="hidden" id="p" name="p" value="A" />
<h4>행사에 참석해주신 손님분들께 감사의 인사를 전하세요.</h4>
<p class="txt_style">※ 행사날짜가 지나면 초대장 주소가 감사장으로 변경됩니다^^</p>
<table cellspacing="0" border="1" class="tbl_type2" style="width:511px">
	<caption><span class="blind">감사장 정보</span></caption>
	<colgroup>
		<col style="width:130px" />
		<col style="width:" />
	</colgroup>
	<tbody>
		<tr>
			<th scope="row">문구수정</th>
			<td><textarea id="memo" name="memo" class="input_style" style="width:380px;height:200px;" ><?=$appreciation_info['memo'];?></textarea><label for="감사문구" class="blind">감사문구</label>
			</td>
		</tr>


		<tr>
			<th scope="row">사진선택</th>
			<td><input type="file" id="userfile" name="user_file[]" class="input_style" style="width:380px" /><label for="userfile" class="blind">사진선택</label>
			<br/><span class="txt_style_red">※ 좌측의 샘플을 보신 후 사진 번호에 맞게 가로,세로 사진을 올려주세요.</span></td>
		</tr>

<!--
			<tr>
				<th scope="row">사진선택</th> 
				<td><input type="file" id="userfile" name="user_file[]" class="input_style" style="width:3800px" /><label for="userfile" class="blind">사진선택</label>
				<?php if (!empty($main_info['thx_photo_url'])) { ?>
				<span class='button style3 blue'><button type='button' id='btnShopPhoto' onclick="window.open('about:blank').location.href = '<?=$main_info['thx_photo_url'];?>';">파일확인</button></span>
				<span class="button style3"><button type="button" id="btnDelImg1" onclick="gotoPhotoDel()">삭&nbsp;제</button></span>
				<?php } ?>
				<br/><span class="txt_style_red">※ 좌측의 샘플을 보신 후 사진 번호에 맞게 가로,세로 사진을 올려주세요.</span></td>
			</tr>
-->

	</tbody>

</table>
</form>
<p class="txt_style"></p>
<script type="text/javascript">
<!--
var _sample_id = "<?=$main_info['sample_id'];?>";

if (_sample_id != "")
	viewSampleViewer(_sample_id);
//-->
</script>