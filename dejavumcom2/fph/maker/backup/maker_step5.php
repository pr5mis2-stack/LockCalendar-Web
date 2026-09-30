<?php 
$main_info = array();

$appreciation_info['memo'] = "사랑으로 축하해주신 모든분들께 보답하는 \n마음으로 건강하게 잘 키우겠습니다.";

if ($_SESSION['dejavu_id'])
{
	// get main info
	$param = array();
	$param['main_id'] = $_SESSION['dejavu_id'];
	$result = $MainCon->getMainList($param);
	if ($result)
		$main_info = $result[0];
	
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
?>
<form name='frm' method="post" target="_actionfrm" action="maker_step5_proc.php" class="form" enctype="multipart/form-data">
<input type="hidden" id="main_id" name="main_id" value="<?=$_SESSION['dejavu_id']?>" />
<input type="hidden" id="s" name="s" value="S" />
<input type="hidden" name="is_invitation" id="is_invitation" value="<?=$main_info['is_invitation'];?>" />
<input type="hidden" id="p" name="p" value="A" />
<h4>행사에 참석해주신 손님분들께 감사의 인사를 전하세요.</h4>
<p class="txt_style">※ 직접 입력 시 100자 이하로 입력해주세요.</p>
<table cellspacing="0" border="1" class="tbl_type2" style="width:511px">
	<caption><span class="blind">감사장 정보</span></caption>
	<colgroup>
		<col style="width:130px" />
		<col style="width:" />
	</colgroup>
	<tbody>
		<tr>
			<th scope="row">문구수정</th>
			<td><textarea id="memo" name="memo" class="input_style" style="width:380px;height:100px;" ><?=$appreciation_info['memo'];?></textarea><label for="감사문구" class="blind">감사문구</label>
			</td>
		</tr>
		<tr>
			<th scope="row">사진선택</th>
			<td><input type="file" id="userfile" name="user_file[]" class="input_style" style="width:380px" /><label for="userfile" class="blind">사진선택</label>
			<br/><span class="txt_style_red">※ 좌측의 샘플을 보신 후 사진 번호에 맞게 가로,세로 사진을 올려주세요.</span></td>
		</tr>
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