<script language="Javascript">
<!--
function postShopVideo()
{
    if (is_proc_ing) {
        alert("진행중 입니다.");
        return;
    }

    document.videoFrm.submit();
}

/**
*
*/
function postVodDelete(media_id)
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
<h1 class="h1">업체 동영상 관리</h1>
<div class="table even">

	<fieldset class="section">
		<h2 class="h2">동영상 관리<button type="button" class="sTog" title="Open/Close"></button></h2>
		<form name='videoFrm' method="post" target="_actionfrm"
			action="./shop/shop_proc.php" class="form">
			<input type="hidden" name="a" value="video_insert" /> <input
				type="hidden" name="shop_id" value="<?=$shop_id;?>" /> <input
				type="hidden" name="media_type" value="3" />
			<table class="list01">
				<colgroup>
					<col width="20%">
					<col width="70%">
					<col width="10%">
				</colgroup>
				<tbody>
					<tr>
						<th>동영상URL</th>
						<td style="text-align: left; padding-left: 15px;"><input
							type='text' name='file_url' id="file_url" style="width: 700px;" /></td>
						<td><span class="side"> <input type="button" id="btnPost"
								onClick="postShopVideo();" value="등록">
						</span></td>
					</tr>
				</tbody>
			</table>
		</form>

		<form name='imgListFrm' method="post" target="_actionfrm"
			action="./shop/shop_proc.php" class="form">
			<div class="table even">
				<table width="100%" border="1" cellspacing="0" class="_memberList">
					<thead>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">URL</th>
							<th scope="col" class="nowr">등록일</th>
							<th scope="col" class="nowr">삭제</th>
						</tr>
					</thead>
					<tbody>
						    <?php
										foreach ( $videoArrList as $item ) {
											?>
						    <tr>
							<td class="nowr"><?=$listNum;?></td>
							<td class="nowr"><a href="<?=$item['file_url'];?>"
								target="_blank"><?=$item['file_url'];?></a></td>
							<td class="nowr"><?=$item['reg_date'];?></td>
							<td class="nowr"><input type="button"
								onClick="postVodDelete(<?=$item['media_id'];?>)" value="삭제" /></td>
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