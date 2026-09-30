<?php 
$main_info = array();

$invitation_info["memo"] = "부모라는 이름을 선물하고\n큰 사랑과 감사를 가르쳐준 우리 아이가\n드디어 첫 생일을 맞이하였습니다.\n그동안 사랑을 베풀어 주신 모든 분들께\n감사의 마음을 전하기 위해\n조촐한 자리를 마련하였습니다.\n바쁘시더라도 참석해 주시면\n큰 기쁨이 되겠습니다";
if ($_SESSION['dejavu_id'])
{
	// get main info
	$param = array();
	$param['main_id'] = $_SESSION['dejavu_id'];
	$result = $MainCon->getMainList($param);
	if ($result)
		$main_info = $result[0];
	//new dBug($param);
	$invitation_result = $InvitationCon->getInvitationList($param);
	if ($invitation_result)
		$invitation_info = $invitation_result[0];
}
else
	$StringClass->alertMsg("메인부터 작성해 주세요.", "", "", "");
?>
<form id="frm" name='frm' method="post" target="_actionfrm" action="maker_step4_proc.php" class="form">
<input type="hidden" id="main_id" name="main_id" value="<?=$_SESSION['dejavu_id']?>" />
<input type="hidden" id="s" name="s" value="S" />
<input type="hidden" name="is_invitation" id="is_invitation" value="<?=$main_info['is_invitation'];?>" />
<input type="hidden" id="p" name="p" value="I" />
<h4>초대문구가 노출되며 수정 버튼을 통해 직접 입력이 가능합니다.</h4>
<p class="txt_style">※ 직접 입력 시 100자 이하로 입력해주세요. 건너뛰기를 누르시면 초대글 제작 없이 다음단계로 진행됩니다.</p>
<table cellspacing="0" border="1" class="tbl_type2" style="width:511px">
	<caption><span class="blind">초대글 정보</span></caption>
	<colgroup>
		<col style="width:130px" />
		<col style="width:" />
	</colgroup>
	<tbody>
		<tr>
			<th scope="row">문구수정</th>
			<td><textarea id="memo" name="memo" class="input_style" style="width:380px;height:100px;" ><?=$invitation_info['memo']?></textarea><label for="초대문구" class="blind">초대문구</label>
			</td>
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