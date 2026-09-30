<script language="Javascript">
<!--
function postShopBgm()
{
    if (is_proc_ing) {
        alert("진행중 입니다.");
        return;
    }

    document.bgmFrm.submit();
}

/**
*
*/
function postBgmDelete(media_id)
{
   if (is_proc_ing) {
       alert("진행중 입니다.");
       return;
   }

   var goUrl = "./shop/shop_proc.php";
   var param = "&a=file_delete&media_id="+ media_id;
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
           	location.reload();
           }
           else
           	alert('처리중 오류가 발생하였습니다.');
		}
		, error: function (data, status, err) { }
       , complete: function () { }
	});
}

-->
</script>
<h1 class="h1">업체 BGM 관리</h1>
<div class="table even">

	<fieldset class="section">
		<h2 class="h2">파일 관리<button type="button" class="sTog" title="Open/Close"></button></h2>
		<form name='bgmFrm' method="post" target="_actionfrm"
			action="./shop/shop_proc.php" class="form" enctype="multipart/form-data">
			<input type="hidden" name="a" value="file_insert" /> <input
				type="hidden" name="shop_id" value="<?=$shop_id;?>" /> <input
				type="hidden" name="upload_dir" value="BGM" />
			<table class="list01">
				<colgroup>
					<col width="15%">
					<col width="30%">
					<col width="15%">
					<col width="30%">
					<col width="10%">
				</colgroup>
				<tbody>
					<tr>
						<th>분류</th>
						<td style="text-align: left; padding-left: 15px;"><select
							id="media_type" name="media_type">
								<option value="4">돌잔치BGM</option>
								<option value="5">결혼식BGM</option>
								<option value="6">고희연BGM</option>
						</select></td>
						<th>파일</th>
						<td style="text-align: left; padding-left: 15px;"><input
							type='file' size='10' name='user_file[]' /></td>
						<td><span class="side"> <input type="button" id="btnPost"
								onClick="postShopBgm();" value="등록">
						</span></td>
					</tr>
				</tbody>
			</table>
		</form>

		<form name='bgmListFrm' method="post" target="_actionfrm"
			action="./shop/shop_proc.php" class="form">
			<div class="table even">
				<table width="100%" border="1" cellspacing="0" class="_memberList">
					<thead>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">파일명</th>
							<th scope="col" class="nowr">타입</th>
							<th scope="col" class="nowr">등록일</th>
							<th scope="col" class="nowr">삭제</th>
						</tr>
					</thead>
					<tbody>
            <?php
            foreach ( $bgmArrList as $item ) {
            ?>
						<tr>
							<td class="nowr"><?=$listNum;?></td>
							<td class="nowr"><a href="<?=$conf_bgm_shop_url.$item['file_url'];?>" target="_blank"><?=$item['file_name'];?></a></td>
							<td class="nowr"><?phpif ($item['media_type'] == "4") {echo"돌잔치BGM";} else if ($item['media_type'] == "5") {echo "결혼식BGM";} else if ($item['media_type'] == "6") {echo "고희연BGM";}?></td>
							<td class="nowr"><?=$item['reg_date'];?></td>
							<td class="nowr"><input type="button" onClick="postBgmDelete(<?=$item['media_id'];?>)" value="삭제" /></td>
						</tr>
						<?php
							$listNum --;
						}
						?>
		      </tbody>
				</table>
			</div>
		</form>
	</fieldset>
</div>