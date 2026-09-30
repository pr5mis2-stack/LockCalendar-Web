<?php
/**
 *  advertisement_form.php
 *  @Desc      : 배너정보 관리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
/**
 *
 * @var parameter setting
 */
$_a = $StringClass->getRequest ( 'a' );
$adver_id = $StringClass->getRequest ( 'adver_id' );
$search_target = $StringClass->getRequest ( 'search_target' );
$search_keyword = $StringClass->getRequest ( 'search_keyword' );

/**
 *
 * @var get board data setting
 */
if ($_a == "view" || $_a == "update") {
	$param = array ();
	$param ['adver_id'] = $adver_id;
	// new dBug($param);
	$arrList = $AdvertisementCon->getAdvertisementList ( $param );
	if ($arrList)
		$userInfo = $arrList [0];
	else
		$StringClass->alertMsg ( '정보가 없습니다.', '_self', '', '' );
}
/**
 * ******************************************************************************************
 * @Desc 페이지 번호 목록 출력
 * *****************************************************************************************
 */
$getParam = "&m=advertisement&a=update&adver_id=" . $adver_id;
$getParam .= "&search_target={$search_target}";
$getParam .= "&search_keyword={$search_keyword}";

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
    var is_proc_ing = false;
    var map_key = "<?=$naver_map_key;?>";

    $(document).ready(function () {
    });

	/**
	 *
	 */
    function postDelete()
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        var adver_id		= $("#adver_id").val();
        
        var goUrl = "./advertisement/advertisement_proc.php";
        var param = "&a=delete&adver_id="+ adver_id;
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
					location.href="/manager/?m=advertisement";
                }
                else
                	alert('처리중 오류가 발생하였습니다.');
			}
			, error: function (data, status, err) { }
            , complete: function () { }
		});
    }



    function postAdvertisement()
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        if (!checkVariableField('company_name', '업체명을 입력해 주세요.')) return false;
        if (!checkVariableField('user_file', '배너이미지를 입력해 주세요.')) return false;
        if (!checkVariableField('st_date', '시작일을 입력해 주세요.')) return false;
        if (!checkVariableField('ed_date', '종료일을 입력해 주세요.')) return false;
		if ($("#st_date").val() > $("#ed_date").val())
		{
			$("#ed_date").focus();
			alert("종료일이 시작일보다 커야합니다.");
			return false;
		}

        if ($("#adver_id").val() != "")
        	document.productFrm.a.value = "update";

    	
        document.productFrm.submit();
    }

</script>
<div class="body">
	<div class="content" id="content" tabindex="0">
		<h1 class="h1">광고 관리</h1>
		<form name='productFrm' method="post" target="_actionfrm"
			action="./advertisement/advertisement_proc.php" class="form"
			enctype="multipart/form-data">
			<input type="hidden" id="a" name="a" value="insert" /> <input
				type="hidden" id="adver_id" name="adver_id"
				value="<?=$userInfo['adver_id'];?>" /> <input type="hidden"
				id="upload_dir" name="upload_dir" value="BANNER" />

			<div class="table even">
				<fieldset class="section">
					<h2 class="h2">광고 정보<button type="button" class="sTog" title="Open/Close"></button></h2>
					<table class="list01">
						<colgroup>
							<col width="20%">
							<col width="30%">
							<col width="20%">
							<col width="30%">
						</colgroup>
						<tbody>
							<tr>
								<th>업체명</th>
								<td style="text-align: left; padding-left: 15px;"><input
									type="text" id="company_name" name="company_name"
									value="<?=$userInfo['company_name'];?>" style="width: 340px;" /></td>
								<th>배너</th>
								<td style="text-align: left; padding-left: 15px;"><input
									type='file' size='10' id="user_file" name='user_file[]' />
	                        <?php if ($userInfo['file_url']) echo "<img src='{$conf_img_banner_url}{$userInfo['file_url']}' style='width:80px;' />"; ?>
	                        </td>
							</tr>
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
								<th>등록일</th>
								<td style="text-align: left; padding-left: 15px;"><?=$userInfo['reg_date'];?></td>
								<th>수정일</th>
								<td style="text-align: left; padding-left: 15px;"><?=$userInfo['edt_date'];?></td>
							</tr>
						</tbody>
					</table>
				</fieldset>

			</div>
			<div class="btnArea">
				<span class="side"> <input type="button" id="btnPost"
					onClick="postAdvertisement();" value="등록"> <input type="button"
					id="btnDelete" onClick="postDelete();" value="삭제"> <input
					type="button" onClick="history.back();" value="목록으로">
				</span>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
<!--
var action = "<?=$_a;?>";

if (action == "insert") {
	$("#btnDelete").hide();
	$("#btnPost").val("등록");
} else if (action == "update") {
	$("#btnDelete").show();
	$("#btnPost").val("수정");
}
//-->
</script>
<!--*****메인 끝*****-->