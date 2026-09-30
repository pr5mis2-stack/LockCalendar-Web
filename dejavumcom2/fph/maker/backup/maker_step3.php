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
	
	if ($main_info)
	{
		$sparam = array();
		$sparam['shop_id'] = $main_info['shop_id'];
		$shop_result = $ShopCon->getShopList($sparam);
		if ($shop_result)
			$shop_info = $shop_result[0];
	}

	// get gallery info
	//new dBug($param);
	$gallery_result = $GalleryCon->getGalleryList($param);
	if ($gallery_result)
		$gallery_info = $gallery_result[0];
	
	// get gallery photo list
	$photo_list = array("1"=>array("photo_id"=>"", "photo_url"=>"", "order_no"=>"1")
			,"2"=>array("photo_id"=>"", "photo_url"=>"", "order_no"=>"2")
			,"3"=>array("photo_id"=>"", "photo_url"=>"", "order_no"=>"3")
			,"4"=>array("photo_id"=>"", "photo_url"=>"", "order_no"=>"4")
			,"5"=>array("photo_id"=>"", "photo_url"=>"", "order_no"=>"5"));
	
	$param["order_by"] = "30";
	$photo_data = $GalleryPhotoCon->getGalleryPhotoList($param);
	
	foreach($photo_data as $key=>$val)
	{
		$photo_list[$val["order_no"]]["photo_id"] = $val["photo_id"];
		$photo_list[$val["order_no"]]["photo_url"] = $val["photo_url"];
		$photo_list[$val["order_no"]]["order_no"] = $val["order_no"];
	}
}
else
	$StringClass->alertMsg("메인부터 작성해 주세요.", "", "", "");
?>
<h4>갤러리에 사용될 예쁜 아기 사진을 등록해주세요.</h4>
<p class="txt_style">※ 샘플에 나오지 않은 나머지 사진은 사진 더보기 메뉴에 등록되며 최대 5장 등록이 가능합니다^^</p>
<form name='frm' method="post" target="_actionfrm" action="maker_step3_proc.php" class="form" enctype="multipart/form-data">
<input type="hidden" id="main_id" name="main_id" value="<?=$_SESSION['dejavu_id']?>" />
<input type="hidden" id="s" name="s" value="S" />
<input type="hidden" id="is_gallery" name="is_gallery" value="<?=$main_info['is_gallery'];?>" />
<input type="hidden" id="gallery_type" name="gallery_type" value="<?=$gallery_info['gallery_type'];?>" />
<input type="hidden" id="p" name="p" value="G" />
<table cellspacing="0" border="1" class="tbl_type2" style="width:511px">
	<caption><span class="blind">갤러리 정보</span></caption>
	<colgroup>
		<col style="width:130px" />
		<col style="width:" />
	</colgroup>
	<tbody>
		<tr>
			<th scope="row">갤러리타입</th>
			<td>
				<fieldset>
					<legend>갤러리타입</legend>
					<div class="select" style="width:200px;z-index:21;">
						<span class="ctrl" onclick="toggleSelbox(1)"><span class="arrow"></span></span>
						<div id="i_list1_val" class="value" onclick="toggleSelbox(1)">갤러리타입</div>
							<ul id="i_list1" class="i_list" style="width:198px"><!-- no_scroll -->
							<li onClick="selSelbox('1', 'gallery_type', '0', '스크롤형')"><label for="e0">스크롤형</label></li>
							<?php if ($shop_info['gallery_type'] == "1") { ?>
							<li onClick="selSelbox('1', 'gallery_type', '1', '슬라이드형')"><label for="e0">슬라이드형</label></li>
							<?php } ?>
							</ul>
					</div>
				</fieldset>
			</td>
		</tr>
	</tbody>
</table>
<p class="txt_style"></p>
<table cellspacing="0" border="1" class="tbl_type2" style="width:511px">
	<caption><span class="blind">갤러리 정보</span></caption>
	<colgroup>
		<col style="width:130px" />
		<col style="width:" />
	</colgroup>
	<tbody>
		<tr>
			<th scope="row">사진1</th>
			<td>
			<input type="hidden" id="order_no1" name="order_no1" value="1" />
			<?php if (!empty($photo_list["1"]["photo_id"])) { ?>
			<input type="file" id="userfile1" name="user_file1" class="input_style" style="width:220px" /><label for="userfile" class="blind">사진선택1</label>
			<span class="button style3 blue" style="margin-left:10px;margin-right:10px;"><button type="button" id="btnShopPhot1" onclick="window.open('about:blank').location.href = '<?=$photo_list["1"]['photo_url'];?>';">파일확인</button></span>
			<span class="button style3"><button type="button" id="btnDelImg1" onclick="gotoPhotoDel(<?=$photo_list["1"]["photo_id"];?>)">삭&nbsp;제</button></span>
			<?php } else { ?>
			<input type="file" id="userfile1" name="user_file1" class="input_style" style="width:380px" /><label for="userfile" class="blind">사진선택1</label>
			<?php } ?>
			<br/><span class="txt_style_red">※ 좌측의 샘플을 보신 후 사진 번호에 맞게 가로,세로 사진을 올려주세요.</span></td>
		</tr>
		<tr>
			<th scope="row">사진2</th>
			<td>
			<input type="hidden" id="order_no2" name="order_no2" value="2" />
			<?php if (!empty($photo_list["2"]["photo_id"])) { ?>
			<input type="file" id="userfile2" name="user_file2" class="input_style" style="width:220px" /><label for="userfile" class="blind">사진선택2</label>
			<span class="button style3 blue" style="margin-left:10px;margin-right:10px;"><button type="button" id="btnShopPhot2" onclick="window.open('about:blank').location.href = '<?=$photo_list["2"]['photo_url'];?>';">파일확인</button></span>
			<span class="button style3"><button type="button" id="btnDelImg5" onclick="gotoPhotoDel(<?=$photo_list["2"]['photo_id'];?>)">삭&nbsp;제</button></span>
			<?php } else { ?>
			<input type="file" id="userfile2" name="user_file2" class="input_style" style="width:380px" /><label for="userfile" class="blind">사진선택2</label>
			<?php } ?>
			<br/><span class="txt_style_red">※ 좌측의 샘플을 보신 후 사진 번호에 맞게 가로,세로 사진을 올려주세요.</span></td>
		</tr>
		<tr>
			<th scope="row">사진3</th>
			<td>
			<input type="hidden" id="order_no3" name="order_no3" value="3" />
			<?php if (!empty($photo_list["3"]["photo_id"])) { ?>
			<input type="file" id="userfile3" name="user_file3" class="input_style" style="width:220px" /><label for="userfile" class="blind">사진선택3</label>
			<span class="button style3 blue" style="margin-left:10px;margin-right:10px;"><button type="button" id="btnShopPhot3" onclick="window.open('about:blank').location.href = '<?=$photo_list["3"]['photo_url'];?>';">파일확인</button></span>
			<span class="button style3"><button type="button" id="btnDelImg5" onclick="gotoPhotoDel(<?=$photo_list["3"]['photo_id'];?>)">삭&nbsp;제</button></span>
			<?php } else { ?>
			<input type="file" id="userfile3" name="user_file3" class="input_style" style="width:380px" /><label for="userfile" class="blind">사진선택3</label>
			<?php } ?>
			<br/><span class="txt_style_red">※ 좌측의 샘플을 보신 후 사진 번호에 맞게 가로,세로 사진을 올려주세요.</span></td>
		</tr>
		<tr>
			<th scope="row">사진4</th>
			<td>
			<input type="hidden" id="order_no4" name="order_no4" value="4" />
			<?php if (!empty($photo_list["4"]["photo_id"])) { ?>
			<input type="file" id="userfile4" name="user_file4" class="input_style" style="width:220px" /><label for="userfile" class="blind">사진선택4</label>
			<span class="button style3 blue" style="margin-left:10px;margin-right:10px;"><button type="button" id="btnShopPhot4" onclick="window.open('about:blank').location.href = '<?=$photo_list["4"]['photo_url'];?>';">파일확인</button></span>
			<span class="button style3"><button type="button" id="btnDelImg5" onclick="gotoPhotoDel(<?=$photo_list["4"]['photo_id'];?>)">삭&nbsp;제</button></span>
			<?php } else { ?>
			<input type="file" id="userfile4" name="user_file4" class="input_style" style="width:380px" /><label for="userfile" class="blind">사진선택4</label>
			<?php } ?>
			</td>
		</tr>
		<tr>
			<th scope="row">사진5</th>
			<td>
			<input type="hidden" id="order_no5" name="order_no5" value="5" />
			<?php if (!empty($photo_list["5"]["photo_id"])) { ?>
			<input type="file" id="userfile5" name="user_file5" class="input_style" style="width:220px" /><label for="userfile" class="blind">사진선택5</label>
			<span class="button style3 blue" style="margin-left:10px;margin-right:10px;"><button type="button" id="btnShopPhot5" onclick="window.open('about:blank').location.href = '<?=$photo_list["5"]['photo_url'];?>';">파일확인</button></span>
			<span class="button style3"><button type="button" id="btnDelImg5" onclick="gotoPhotoDel(<?=$photo_list["5"]['photo_id'];?>)">삭&nbsp;제</button></span>
			<?php } else { ?>
			<input type="file" id="userfile5" name="user_file5" class="input_style" style="width:380px" /><label for="userfile" class="blind">사진선택5</label>
			<?php } ?>
			</td>
		</tr>
	</tbody>
</table>
</form>
<p class="txt_style"></p>

<script type="text/javascript">
<!--
var _sample_id = "<?=$main_info['sample_id'];?>";
var _gallery_type = "<?=$gallery_info['gallery_type'];?>";

if (_gallery_type == "1")
	selSelbox('1', 'gallery_type', '1', '슬라이드형')
else
	selSelbox('1', 'gallery_type', '0', '스크롤형')

if (_sample_id != "")
	viewSampleViewer(_sample_id);
//-->
</script>