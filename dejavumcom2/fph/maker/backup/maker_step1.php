<?php 
$main_info = array();
$arrShopList = array();
$arrSubShopList = array();
$arrSampleList = array();

$main_info['shop_label'] = "식장선택";
$main_info['sub_shop_label']	= "지점선택";
$main_info['sample_label']	= "샘플선택";

$main_info['show_time']	= "13:00";
$main_info['show_tflag']	= "PM";
$main_info['show_t']	= "13";
$main_info['show_m']	= "00";

if ($_SESSION['dejavu_id'])
{
	// get main info
	$param = array();
	$param['main_id'] = $_SESSION['dejavu_id'];
	$result = $MainCon->getMainList($param);
	if ($result)
	{
		$main_info = $result[0];
	
		if ($main_info['show_time'])
		{
			$tmp_time = explode(":",$main_info["show_time"]);

			if ($tmp_time[0] > 12)
				$main_info['show_tflag'] = "PM";
			else
				$main_info['show_tflag'] = "AM";
			$main_info['show_t'] = ($tmp_time[0] > 12)? ($tmp_time[0] - 12):$tmp_time[0];
			//if ($main_info['show_t'] < 10)
			//	$main_info['show_t'] = "0".$main_info['show_t'];
			$main_info['show_m'] = $tmp_time[1];
		}
	}	
	else
	{
		$main_info['shop_id'] = 56;
		$main_info['parent_shop_id'] = $main_info['shop_id'];
	}
	
/* 	$param = array();
	$param['parent_shop_id'] = $main_info['shop_id'];
	$arrSubShopList = $ShopCon->getShopList($param); */
	
	//new dBug($main_info);
	if ($main_info['parent_shop_id'] == "0")
		$main_info['parent_shop_id'] = $main_info['shop_id'];
}
else
{
	$main_info['shop_id'] = 56;
	$main_info['parent_shop_id'] = $main_info['shop_id'];
}


//$param = array();
//$param['order_by'] = "20";
//$param['contract_end'] = "0";	// 계약종료 여부 (0:계약중,1:계약종료)
//$arrShopList = $ShopCon->getParentShopList($param);
?>
<h4>초대장 기본 정보를 입력해 주세요.</h4>
<form id="frm" name='frm' method="post" target="_actionfrm" action="maker_step1_proc.php" class="form" enctype="multipart/form-data">
<input type="hidden" name="main_id" id="main_id" value="<?=$main_info['main_id'];?>" />
<input type="hidden" name="parent_shop_id" id="parent_shop_id" value="<?=$main_info['parent_shop_id'];?>" />
<input type="hidden" name="shop_id" id="shop_id" value="<?=$main_info['shop_id'];?>" />
<input type="hidden" name="sample_id" id="sample_id" value="<?=$main_info['sample_id'];?>" />
<input type="hidden" name="view_type" id="view_type" value="<?=$main_info['view_type'];?>" />
<input type="hidden" name="show_time" id="show_time" value="<?=$main_info['show_time'];?>" />
<input type="hidden" name="show_tflag" id="show_tflag" value="<?=$main_info['show_tflag'];?>" />
<input type="hidden" id="show_t" name="show_t" value="<?=$main_info['show_t'];?>" />
<input type="hidden" id="show_m" name="show_m" value="<?=$main_info['show_m'];?>" />
<input type="hidden" id="p" name="p" value="M" />
<input type="hidden" id="s" name="s" value="S" />
<?php if (!empty($_SESSION['dejavu_id'])) { ?>
<input type="hidden" id="pwd" mame="pwd" value="<?=$main_info['passwd'];?>" />
<?php } ?>
<table cellspacing="0" border="1" class="tbl_type2" style="width:511px">
	<caption><span class="blind">초대장 기본 정보</span></caption>
	<colgroup>
		<col style="width:130px" />
		<col style="width:" />
	</colgroup>
	<tbody>
		<tr id="tr_1" style="display:none;">
			<th scope="row">지점선택</th>
			<td>
				<fieldset>
					<legend>지점선택</legend>
					<div class="select" style="width:200px;z-index:23;">
						<span class="ctrl" onclick="toggleSelbox(2)"><span class="arrow"></span></span>
						<div id="i_list2_val" class="value" onclick="toggleSelbox(2)">지점선택</div>
						<ul id="i_list2" class="i_list" style="width:198px">
						</ul>
					</div>
				</fieldset>
			</td>
		</tr>
		<tr id="tr_2">
			<th scope="row">샘플선택</th>
			<td>
				<fieldset>
					<legend>샘플선택</legend>
					<div class="select" style="width:200px;z-index:22;">
						<span class="ctrl" onclick="toggleSelbox(3)"><span class="arrow"></span></span>
						<div id="i_list3_val" class="value" onclick="toggleSelbox(3)">샘플선택</div>
						<ul id="i_list3" class="i_list" style="width:198px">
						</ul>
					</div>
				</fieldset>
			</td>
		</tr>
		<tr id="tr_3" style="display:none;">
			<th scope="row">보기방식</th>
			<td>
				<fieldset>
					<legend>보기방식</legend>
					<div class="select" style="width:200px;z-index:21;">
						<span class="ctrl" onclick="toggleSelbox(4)"><span class="arrow"></span></span>
						<div id="i_list4_val" class="value" onclick="toggleSelbox(4)">보기방식</div>
						<ul id="i_list4" class="i_list" style="width:198px">
						</ul>
					</div>
				</fieldset>
			</td>
		</tr>
		<tr>
			<th scope="row">이메일</th>
			<td><input type="text" id="email" name="email" value="<?=$main_info['email'];?>" class="input_style" style="width:184px" /><label for="userEmail" class="blind">이메일</label></td>
		</tr>
		<?php if (empty($_SESSION['dejavu_id'])) { ?>
		<tr>
			<th scope="row">비밀번호</th>
			<td><input type="text" id="pwd" name="pwd" value="<?=$main_info['passwd'];?>" class="input_style" style="width:184px" /><label for="userEmail" class="blind">이메일</label></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<p class="txt_style">※ 입력하신 비밀번호는 초대장 수정 및 관리 시 필요하오니 반드시 기억해 주세요.</p>

<div class="boxstyle" style="width:511px;margin-top:25px">
	<table cellspacing="0" border="1" class="tbl_type2" style="width:511px">
		<caption><span class="blind">행사 정보</span></caption>
		<colgroup>
			<col style="width:130px" />
			<col style="width:" />
		</colgroup>
		<tbody>
			<tr>
				<th scope="row">일정</th>
				<td><input type="text" id="show_date" name="show_date" value="<?=$main_info['show_date']?>" class="input_style datepicker" style="width:80px;margin-right:5px;" /><button type="button" class="btn_calendar"><span class="blind">달력보기</span></button></td>
			</tr>
			<tr>
				<th scope="row">시간</th>
				<td>
					<fieldset>
						<legend>오전/오후</legend>
						<div class="select" style="width:57px;z-index:20;">
							<span class="ctrl" onclick="toggleSelbox(5)"><span class="arrow"></span></span>
							<div id="i_list5_val" class="value" onclick="toggleSelbox(5)">오전</div>
							<ul id="i_list5" class="i_list" style="width:55px"><!-- no_scroll -->
							<li onClick="selSelbox('5', 'show_tflag', 'AM', '오전')"><label for="e0">오전</label></li>
							<li onClick="selSelbox('5', 'show_tflag', 'PM', '오후')"><label for="e0">오후</label></li>
							</ul>
						</div>
						<legend>시</legend>
						<div class="select" style="width:57px;z-index:20;">
							<span class="ctrl" onclick="toggleSelbox(6)"><span class="arrow"></span></span>
							<div id="i_list6_val" class="value" onclick="toggleSelbox(6)">1</div>
							<ul id="i_list6" class="i_list" style="width:55px">
							<li onClick="selSelbox('6', 'show_t', '01', '1')"><label for="e0">1</label></li>
							<li onClick="selSelbox('6', 'show_t', '02', '2')"><label for="e0">2</label></li>
							<li onClick="selSelbox('6', 'show_t', '03', '3')"><label for="e0">3</label></li>
							<li onClick="selSelbox('6', 'show_t', '04', '4')"><label for="e0">4</label></li>
							<li onClick="selSelbox('6', 'show_t', '05', '5')"><label for="e0">5</label></li>
							<li onClick="selSelbox('6', 'show_t', '06', '6')"><label for="e0">6</label></li>
							<li onClick="selSelbox('6', 'show_t', '07', '7')"><label for="e0">7</label></li>
							<li onClick="selSelbox('6', 'show_t', '08', '8')"><label for="e0">8</label></li>
							<li onClick="selSelbox('6', 'show_t', '09', '9')"><label for="e0">9</label></li>
							<li onClick="selSelbox('6', 'show_t', '10', '10')"><label for="e0">10</label></li>
							<li onClick="selSelbox('6', 'show_t', '11', '11')"><label for="e0">11</label></li>
							<li onClick="selSelbox('6', 'show_t', '12', '12')"><label for="e0">12</label></li>
							</ul>
						</div>시
						<legend>오전/오후</legend>
						<div class="select" style="width:57px;z-index:20;">
							<span class="ctrl" onclick="toggleSelbox(7)"><span class="arrow"></span></span>
							<div id="i_list7_val" class="value" onclick="toggleSelbox(7)">00</div>
							<ul id="i_list7" class="i_list" style="width:55px"><!-- no_scroll -->
							<li onClick="selSelbox('7', 'show_m', '00', '00')"><label for="e0">00</label></li>
							<li onClick="selSelbox('7', 'show_m', '10', '10')"><label for="e0">10</label></li>
							<li onClick="selSelbox('7', 'show_m', '20', '20')"><label for="e0">20</label></li>
							<li onClick="selSelbox('7', 'show_m', '30', '30')"><label for="e0">30</label></li>
							<li onClick="selSelbox('7', 'show_m', '40', '40')"><label for="e0">40</label></li>
							<li onClick="selSelbox('7', 'show_m', '50', '50')"><label for="e0">50</label></li>
							</ul>
						</div>분
					</fieldset>
					<!-- time map start -->
					<!-- time map end -->
				</td>
			</tr>
			<tr>
				<th scope="row">홀이름</th>
				<td><input type="text" id="holl_name" name="holl_name" value="<?=$main_info['holl_name'];?>" class="input_style" style="width:125px" /></td>
			</tr>
			<tr>
				<th scope="row">아빠이름</th>
				<td><input type="text" id="father_name" name="father_name" value="<?=$main_info['father_name'];?>" class="input_style" style="width:125px" /></td>
			</tr>
			<tr>
				<th scope="row">아빠전화번호</th>
				<td><input type="text" id="father_hp" name="father_hp" value="<?=$main_info['father_hp'];?>" class="input_style" style="width:125px" /></td>
			</tr>
			<tr>
				<th scope="row">엄마이름</th>
				<td><input type="text" id="mother_name" name="mother_name" value="<?=$main_info['mother_name'];?>" class="input_style" style="width:125px" /></td>
			</tr>
			<tr>
				<th scope="row">엄마전화번호</th>
				<td><input type="text" id="mother_hp" name="mother_hp" value="<?=$main_info['mother_hp'];?>" class="input_style" style="width:125px" /></td>
			</tr>
			<tr>
				<th scope="row">아기이름</th>
				<td><input type="text" id="baby_name" name="baby_name" value="<?=$main_info['baby_name'];?>" class="input_style" style="width:125px" /></td>
			</tr>
			<tr>
				<th scope="row">사진선택</th>
				<td><input type="file" id="userfile" name="user_file[]" class="input_style" style="width:220px" /><label for="userfile" class="blind">사진선택</label>
				<?php if (!empty($main_info['main_photo_url'])) { ?>
				<span class='button style3 blue'><button type='button' id='btnShopPhoto' onclick="window.open('about:blank').location.href = '<?=$main_info['main_photo_url'];?>';">파일확인</button></span>
				<span class="button style3"><button type="button" id="btnDelImg1" onclick="gotoPhotoDel()">삭&nbsp;제</button></span>
				<?php } ?>
				<br/><span class="txt_style_red">※ 좌측의 샘플을 보신 후 사진 번호에 맞게 가로,세로 사진을 올려주세요.</span></td>
			</tr>
			</tbody>
		</table>
	</dl>
</div>
</form>
<p class="txt_style">※ 생성된 초대장은 행사일 이후 최대 30일까지 보관되며, 30일 이후에는 자동 삭제됩니다.</p>
<table cellspacing="0" border="1" class="tbl_type2" style="width:511px">
	<caption><span class="blind">개인정보수집이용에 관한 사항</span></caption>
	<colgroup>
		<col style="width:">
	</colgroup>
	<tbody>
		<tr>
			<th scope="row" style="line-height: 25px;">개인정보수집이용에 관한 사항</th>
		</tr>
		<tr>
			<td style="width:500px;height:60px;">
			<div style="overflow-y:auto; width:100%; height:100%; padding:4px"> 
			<b>수집하는 개인정보의 항목</b><br><br>
			필수항목 : 가입자, 이름, 이메일, 비밀번호, 휴대폰번호, 행사업체, 행사일자<br>
			선택항목 : 아빠이름, 엄마이름, 아기이름, 인사말 등 초대장 제작 시 기입정보<br><br>
			<b>수집하는 개인정보의 목적</b><br><br>
			성명, 이메일, 비밀번호 : 초대장제작 이용에 따른 본인 식별 절차에 이용<br>
			휴대전화번호 : 초대장 전달 및 하객과의 의사소통 경로의 확보에 이용<br>
			그 외 선택항목 : 하객과의 의사소통 및 행사 안내 정보를 제공하기 위한 자료<br><br>
			<b>수집한 개인정보의 보유 및 이용기간</b><br><br>
			계약 또는 청약철회 등에 관한 기록 : 5년<br>
			대금결제 및 재화등의 공급에 관한 기록 : 5년<br>
			소비자의 불만 또는 분쟁처리에 관한 기록 : 3년
			</div>
			</td>
		</tr>
	</tbody>
</table>
<br>
<p style="text-align: center; margin-bottom:10px;"><input type="checkbox" id="agree1" value="y"> 이용약관에 동의합니다. [<a href="/policy/service.php" target="_blank">이용약관 보기</a>]</p>
<p style="text-align: center; margin-bottom:10px;margin-right: 45px;"><input type="checkbox" id="agree2" value="y"> 개인정보수집이용에 동의합니다.</p>
<script type="text/javascript">
<!--
var _parent_shop_id = "<?=$main_info['parent_shop_id'];?>";
var _parent_shop_name = "<?=$main_info['parent_shop_name'];?>";
var _shop_id = "<?=$main_info['shop_id'];?>";
var _shop_name = "<?=$main_info['shop_name'];?>";
var _sample_id = "<?=$main_info['sample_id'];?>";
var _sample_name = "<?=$main_info['sample_name'];?>";
var _view_type = "<?=$main_info['view_type'];?>";
var _show_tflag = "<?=$main_info['show_tflag'];?>";
var _show_t = "<?=$main_info['show_t'];?>";
var _show_m = "<?=$main_info['show_m'];?>";

if (_shop_id != "")
{
	// 서브가 없는 경우
	if (_shop_id == _parent_shop_id)
	{
		//selSelbox('1', 'shop_id', _shop_id, _shop_name);
		getSubShopList(_shop_id);
		getSampleList(_shop_id);
		//getViewtypeList(_shop_id);
		getSampleTime(_shop_id)
	}
	// 서브가 있는 경우
	else
	{
		//selSelbox('1', 'parent_shop_id', _parent_shop_id, _parent_shop_name);
		getSubShopList(_parent_shop_id);
		getSampleList(_shop_id);
		//getViewtypeList(_shop_id);
		getSampleTime(_shop_id)
	}
}

//if (_view_type == "1")
//	selSelbox('4', 'view_type', _view_type, "가로타입");
//else
//	selSelbox('4', 'view_type', _view_type, "세로타입");
		

if (_show_tflag == "AM")
	selSelbox('5', 'show_tflag', _show_tflag, "오전");
else
	selSelbox('5', 'show_tflag', _show_tflag, "오후");
	
if (_show_t  != "")
	selSelbox('6', 'show_t',  _show_t , _show_t);
if (_show_m != "")
	selSelbox('7', 'show_m',  _show_m, _show_m);
//-->
</script>
