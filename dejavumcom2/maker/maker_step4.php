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

	if ($main_info['type_value'] == "W")
	{
		if ($main_info['sample_id'] == 13)
			$invitation_info["memo"] = "각자 서로 다른길을 걸어온 저희가\n이제 부부의 연으로\n한 길을 걸어가고자 합니다\n평생을 좋은 남편, 좋은 아내로 살겠습니다\n한 곳을 바라보며\n첫발을 떼는 자리에 참석하시어\n기쁨의 자리를\n축복으로 더욱 빛내주시기 바랍니다";
		else
			$invitation_info["memo"] = "서로의 이름을 부르는 것만으로도\n사랑의 깊이를 확인 할 수 있는 두 사람이\n꽃과 나무처럼 걸어와서\n서로의 모든것이 되기위해\n오랜 기다림 끝에 혼례식을 치르는 날\n세상은 더욱 아름다워라.\n\n<이혜인 - 사랑의 사람들이여>";
	}
	else if ($main_info['type_value'] == "S")
		$invitation_info["memo"] = "긴 세월동안 두터운 정을 키워오신\n어르신들과 친지분들을 모시고\n소중한 자리를 마련하고자 합니다.\n부디 참석하셔서 자리를 빛내주시면\n더없는 기쁨이 되겠습니다.";
	else
		$invitation_info["memo"] = "부모라는 이름을 선물하고\n큰 사랑과 감사를 가르쳐준 우리 아이가\n드디어 첫 생일을 맞이하였습니다.\n그동안 사랑을 베풀어 주신 모든 분들께\n감사의 마음을 전하기 위해\n조촐한 자리를 마련하였습니다.\n바쁘시더라도 참석해 주시면\n큰 기쁨이 되겠습니다";
	
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
			<td><textarea id="memo" name="memo" class="input_style" style="width:380px;height:200px;" ><?=$invitation_info['memo']?></textarea><label for="초대문구" class="blind">초대문구</label>
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