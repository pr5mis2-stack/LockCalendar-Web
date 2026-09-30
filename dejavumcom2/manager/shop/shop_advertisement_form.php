<script language="Javascript">
<!--
function postShopAdver()
{
    if (is_proc_ing) {
        alert("진행중 입니다.");
        return;
    }

    if (!checkVariableField('user_file', '배너이미지를 입력해 주세요.')) return false;
    if (!checkVariableField('site_url', 'URL을 입력해 주세요.')) return false;
    if (!checkVariableField('st_date', '시작일을 입력해 주세요.')) return false;
    if (!checkVariableField('ed_date', '종료일을 입력해 주세요.')) return false;
	if ($("#st_date").val() > $("#ed_date").val())
	{
		$("#ed_date").focus();
		alert("종료일이 시작일보다 커야합니다.");
		return false;
	}
    
    document.AdverFrm.submit();
}

/**
*
*/
function postAdverDelete(adver_id)
{
   if (is_proc_ing) {
       alert("진행중 입니다.");
       return;
   }
   
   var goUrl = "./shop/shop_proc.php";
   var param = "&a=adver_delete&adver_id="+ adver_id;
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
<h1 class="h1">광고배너 관리</h1>
<div class="table even">

	<fieldset class="section">
		<h2 class="h2">광고배너 관리<button type="button" class="sTog" title="Open/Close"></button></h2>
		<form name='AdverFrm' method="post" target="_actionfrm"
			action="./shop/shop_proc.php" class="form" enctype="multipart/form-data">
			<input type="hidden" name="a" value="adver_insert" /> <input
				type="hidden" name="shop_id" value="<?=$shop_id;?>" /> <input
				type="hidden" id="adver_id" name="adver_id" value="" /> <input
				type="hidden" name="upload_dir" value="BANNER" />
			<table class="list01">
				<colgroup>
					<col width="20%">
					<col width="30%">
					<col width="20%">
					<col width="30%">
				</colgroup>
				<tbody>
					<tr>
						<th>시작일</th>
						<td style="text-align: left; padding-left: 15px;"><input
							type="text" id="st_date" name="st_date"
							value="<?=$userInfo['st_date'];?>" style="width: 100px;"
							maxlength="10" /><b style="color: red;"> * 2013-01-01 형식으로 입력해
								주세요.</b></td>
						<th>종료일</th>
						<td style="text-align: left; padding-left: 15px;"><input
							type="text" id="ed_date" name="ed_date"
							value="<?=$userInfo['ed_date'];?>" style="width: 100px;"
							maxlength="10" /><b style="color: red;"> * 2013-01-31 형식으로 입력해
								주세요.</b></td>
					</tr>
					<tr>
						<th>URL</th>
						<td colspan="3" style="text-align: left; padding-left: 15px;"><input
							type="text" id="site_url" name="site_url"
							value="<?=$userInfo['site_url'];?>" style="width: 800px;"
							maxlength="200" /></td>
					</tr>
					<tr>
						<th>배너</th>
						<td style="text-align: left; padding-left: 15px;"><input
							type='file' size='10' id="user_file" name='user_file[]' />
	                        <?php if ($userInfo['file_url']) echo "<img src='{$conf_img_banner_url}{$userInfo['file_url']}' style='width:80px;' />"; ?>
	                        </td>
						<th>배너위치</th>
						<td colspan="3"><select id="view_flag" name="view_flag">
								<option value="N"
									<?php if ($userInfo['view_flag'] == "N") {echo "selected"; } ?>>하단고정형</option>
								<option value="Y"
									<?php if ($userInfo['view_flag'] == "Y") {echo "selected"; } ?>>유동형</option>
						</select></td>
					</tr>
					<tr>
						<td colspan="4"><span class="side" style="float: right;"> <input
								type="button" id="btnPost" onClick="postShopAdver();" value="등록">
						</span></td>
					</tr>

				</tbody>
			</table>
		</form>

		<form name='adverListFrm' method="post" target="_actionfrm"
			action="./shop/shop_proc.php" class="form">
			<div class="table even">
				<table width="100%" border="1" cellspacing="0" class="_memberList">
					<thead>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">Banner</th>
							<th scope="col" class="nowr">URL</th>
							<th scope="col" class="nowr">시작일</th>
							<th scope="col" class="nowr">종료일</th>
							<th scope="col" class="nowr">배너위치</th>
							<th scope="col" class="nowr">등록일</th>
							<th scope="col" class="nowr">삭제</th>
						</tr>
					</thead>
					<tbody>
						    <?php
										foreach ( $adverArrList as $item ) {
											?>
						    <tr>
							<td class="nowr"><?=$listNum;?></td>
							<td class="nowr"><a
								href="<?=$conf_img_banner_url.$item['file_url'];?>"
								target="_blank"><img
									src='<?=$conf_img_banner_url.$item['file_url'];?>'
									style='width: 80px;' /></a></td>
							<td class="nowr"><?=$item['site_url'];?></td>
							<td class="nowr"><?=$item['st_date'];?></td>
							<td class="nowr"><?=$item['ed_date'];?></td>
							<td class="nowr"><?=($item['view_flag'] == "N")? "하단고정형":"유동형";?></td>
							<td class="nowr"><?=$item['reg_date'];?></td>
							<td class="nowr"><input type="button"
								onClick="postAdverDelete(<?=$item['adver_id'];?>)" value="삭제" /></td>
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