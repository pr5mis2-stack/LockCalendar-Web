<?php
/**
 *  sample_form.php
 *  @Desc      : 샘플정보 관리
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
$sample_id = $StringClass->getRequest ( 'sample_id' );

/**
 *
 * @var get board data setting
 */
if ($_a == "view" || $_a == "update") {
	$param = array ();
	$param ['sample_id'] = $sample_id;
	// new dBug($param);
	$arrList = $SampleCon->getSampleList ( $param );
	if ($arrList)
		$sampleInfo = $arrList[0];
	else
		$StringClass->alertMsg ( '정보가 없습니다.', '_self', '', '' );
	
	// 기본 내용
	$arrDList = "";
	$dparam = array ();
	$dparam ['sample_id'] = $sample_id;
	$dparam ['part'] = "D";
	// new dBug($param);
	$arrDList = $SampleDetailCon->getSampleDetailList ( $dparam );
	if ($arrDList)
	{
		$detailInfo = $arrDList[0];
		$detail_Did = $detailInfo["detail_id"];
		$detail_Dhtml = $detailInfo["detail_html"];
		$img_zipfile = ($detailInfo["img_zipfile"] !="")? $detailInfo["img_zipfile"] : $img_zipfile;
	}
	
	// 메인 내용
	$arrDList = "";
	$dparam = array ();
	$dparam ['sample_id'] = $sample_id;
	$dparam ['part'] = "M";
	// new dBug($param);
	$arrDList = $SampleDetailCon->getSampleDetailList ( $dparam );
	if ($arrDList)
	{
		$detailInfo = $arrDList[0];
		$detail_Mid = $detailInfo["detail_id"];
		$detail_Mhtml = $detailInfo["detail_html"];
		$img_zipfile = ($detailInfo["img_zipfile"] !="")? $detailInfo["img_zipfile"] : $img_zipfile;
	}
	
	// 초대글 내용
	$arrDList = "";
	$dparam = array ();
	$dparam ['sample_id'] = $sample_id;
	$dparam ['part'] = "I";
	// new dBug($param);
	$arrDList = $SampleDetailCon->getSampleDetailList ( $dparam );
	if ($arrDList)
	{
		$detailInfo = $arrDList[0];
		$detail_Iid = $detailInfo["detail_id"];
		$detail_Ihtml = $detailInfo["detail_html"];
		$img_zipfile = ($detailInfo["img_zipfile"] !="")? $detailInfo["img_zipfile"] : $img_zipfile;
	}

	// 갤러리 내용
	$arrDList = "";
	$dparam = array ();
	$dparam ['sample_id'] = $sample_id;
	$dparam ['part'] = "G";
	// new dBug($param);
	$arrDList = $SampleDetailCon->getSampleDetailList ( $dparam );
	if ($arrDList)
	{
		$detailInfo = $arrDList[0];
		$detail_Gid = $detailInfo["detail_id"];
		$detail_Ghtml = $detailInfo["detail_html"];
		$img_zipfile = ($detailInfo["img_zipfile"] !="")? $detailInfo["img_zipfile"] : $img_zipfile;
	}
	
	// 덕담게시판 내용
	$arrDList = "";
	$dparam = array ();
	$dparam ['sample_id'] = $sample_id;
	$dparam ['part'] = "B";
	// new dBug($param);
	$arrDList = $SampleDetailCon->getSampleDetailList ( $dparam );
	if ($arrDList)
	{
		$detailInfo = $arrDList[0];
		$detail_Bid = $detailInfo["detail_id"];
		$detail_Bhtml = $detailInfo["detail_html"];
		$img_zipfile = ($detailInfo["img_zipfile"] !="")? $detailInfo["img_zipfile"] : $img_zipfile;
	}
	
	// 퀵메뉴 내용
	$arrDList = "";
	$dparam = array ();
	$dparam ['sample_id'] = $sample_id;
	$dparam ['part'] = "Q";
	// new dBug($param);
	$arrDList = $SampleDetailCon->getSampleDetailList ( $dparam );
	if ($arrDList)
	{
		$detailInfo = $arrDList[0];
		$detail_Qid = $detailInfo["detail_id"];
		$detail_Qhtml = $detailInfo["detail_html"];
		$img_zipfile = ($detailInfo["img_zipfile"] !="")? $detailInfo["img_zipfile"] : $img_zipfile;
	}
	
	// 감사장 내용
	$arrDList = "";
	$dparam = array ();
	$dparam ['sample_id'] = $sample_id;
	$dparam ['part'] = "A";
	// new dBug($param);
	$arrDList = $SampleDetailCon->getSampleDetailList ( $dparam );
	if ($arrDList)
	{
		$detailInfo = $arrDList[0];
		$detail_Aid = $detailInfo["detail_id"];
		$detail_Ahtml = $detailInfo["detail_html"];
		$img_zipfile = ($detailInfo["img_zipfile"] !="")? $detailInfo["img_zipfile"] : $img_zipfile;
	}
	
	if ($sampleInfo['sample_type'] == "B")
		$conf_img_sample_url = $conf_img_sample_url . "baby/";
	else if ($sampleInfo['sample_type'] == "W")
		$conf_img_sample_url = $conf_img_sample_url . "wedding/";
	else if ($sampleInfo['sample_type'] == "S")
		$conf_img_sample_url = $conf_img_sample_url . "silver/";
}
/**
 * ******************************************************************************************
 * @Desc 페이지 번호 목록 출력
 * *****************************************************************************************
 */
$getParam = "&m=sample&a=update&sample_id=" . $sample_id;
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

.bbutton { width:100%; height:100px; }
</style>
<script language="Javascript">
    var is_proc_ing = false;
    var map_key = "<?=$naver_map_key;?>";

    $(document).ready(function () {

    });

	/**
	 * 샘플 등록,수정
	 */
	
    function postSample()
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        var sample_id		= $("#sample_id").val();
        var sample_name		= $("#sample_name").val();
        var is_use			= $('#is_use option:selected').val();
        var sample_type		= $('#sample_type option:selected').val();
        
        var goUrl = "./sample/sample_proc.php";
        var param = "&a=<?=$_a;?>&sample_id="+ sample_id
        			+"&sample_name="+ sample_name
        			+"&is_use="+ is_use
        			+"&sample_type="+ sample_type;

        <?php if ($_a == "view" || $_a == "update") { ?>
        if (!checkVariableField('sample_id', '코드를 입력해 주세요.')) return false;
        <?php } ?>
        if (!checkVariableField('sample_name', '샘플명을 입력해 주세요.')) return false;
        
        			
        //location.href = goUrl + "?" + param;
		//return false;

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
                	<?php if ($_a == "view" || $_a == "update") { ?>
					location.reload();
					<?php } else { ?>
					location.href="/manager/?m=sample";
					<?php } ?>
                }
                else
                	alert('처리중 오류가 발생하였습니다.');
			}
			, error: function (data, status, err) { }
            , complete: function () { }
		});
    }

	/**
	 * 샘플 삭제
	 */
    function postDelete()
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        var sample_id	= $("#sample_id").val();
        
        var goUrl = "./sample/sample_proc.php";
        var param = "&a=delete&sample_id="+ sample_id;
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
					location.href="/manager/?m=sample";
                }
                else
                	alert('처리중 오류가 발생하였습니다.');
			}
			, error: function (data, status, err) { }
            , complete: function () { }
		});
    }

	/**
	 * 샘플 디테일 등록, 수정
	 */
    function postSampleDDetail()
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        if ($("#detail_Did").val() != "")
        	document.infoDFrm.a.value = "detail_update";
    	
        document.infoDFrm.submit();
    }
	    	 
    function postSampleMDetail()
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        if ($("#detail_Mid").val() != "")
        	document.infoMFrm.a.value = "detail_update";
    	
        document.infoMFrm.submit();
    }

    function postSampleIDetail()
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        if ($("#detail_Iid").val() != "")
        	document.infoIFrm.a.value = "detail_update";
    	
        document.infoIFrm.submit();
    }

    function postSampleGDetail()
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        if ($("#detail_Gid").val() != "")
        	document.infoGFrm.a.value = "detail_update";
    	
        document.infoGFrm.submit();
    }

    function postSampleBDetail()
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        if ($("#detail_Bid").val() != "")
        	document.infoBFrm.a.value = "detail_update";
    	
        document.infoBFrm.submit();
    }

    function postSampleQDetail()
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        if ($("#detail_Qid").val() != "")
        	document.infoQFrm.a.value = "detail_update";
    	
        document.infoQFrm.submit();
    }

    function postSampleADetail()
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        if ($("#detail_Aid").val() != "")
        	document.infoAFrm.a.value = "detail_update";
    	
        document.infoAFrm.submit();
    }
    
</script>
<div class="body">
	<div class="content" id="content" tabindex="0">
		<h1 class="h1">샘플 관리</h1>
		<form name="boardFrm" method="post" target="_actionfrm" action="./sample/sample_proc.php" class="form">
			<input type="hidden" id="sample_id" name="sample_id" value="<?=$sampleInfo['sample_id'];?>" />
			<div class="table even">
				<fieldset class="section">
					<h2 class="h2">샘플 정보<button type="button" class="sTog" title="Open/Close"></button></h2>
					<table class="list01">
						<colgroup>
							<col width="15%">
							<col width="18%">
							<col width="15%">
							<col width="18%">
							<col width="15%">
							<col width="18%">
						</colgroup>
						<tbody>
							<tr>
								<th>샘플명</th>
								<td style="text-align: left; padding-left: 15px;">
								<input type="text" id="sample_name" name="sample_name" value="<?=$sampleInfo['sample_name'];?>" style="width: 340px;" />
								</td>
								<th>샘플타입</th>
								<td style="text-align: left; padding-left: 15px;">
								<select id="sample_type" name="sample_type">
									<option value="B" <?php if ($sampleInfo['sample_type'] == "B") echo "selected";?>>돌잔치</option>
									<option value="W" <?php if ($sampleInfo['sample_type'] == "W") echo "selected";?>>결혼식</option>
									<option value="S" <?php if ($sampleInfo['sample_type'] == "S") echo "selected";?>>고희연</option>
								</select>
								</td>
								<th>사용유무</th>
								<td style="text-align: left; padding-left: 15px;">
								<select id="is_use" name="is_use">
									<option value="1" <?php if ($sampleInfo['is_use'] == "1") echo "selected";?>>사용중</option>
									<option value="0" <?php if ($sampleInfo['is_use'] == "0") echo "selected";?>>미사용</option>
								</select>
								</td>
							</tr>
							<tr>
								<th>등록일</th>
								<td style="text-align: left; padding-left: 15px;"><?=$sampleInfo['reg_date'];?></td>
								<th>수정일</th>
								<td style="text-align: left; padding-left: 15px;"><?=$sampleInfo['edt_date'];?></td>
								<th></th>
								<td></td>
							</tr>
						</tbody>
					</table>
				</fieldset>
			</div>
			<div class="btnArea">
				<span class="side">
				<input type="button" id="btnPost" onClick="postSample();" value="등록"> 
				<input type="button" id="btnDelete" onClick="postDelete();" value="삭제"> 
				<input type="button" onClick="history.back();" value="목록으로">
				</span>
			</div>
		</form>
		<?php if ($sample_id) {?>
        <h1 class="h1">샘플 상세정보 등록</h1>
		<div class="table even">
			<b style="color: red;">* HTML중 이미지 경로는 "sample_images"로 지정하여 등록하여 주세요. 입력된 이미지 경로는 저장시 저장된 경로로 자동 변경 됩니다.</b>
			<fieldset class="section">
				<h2 class="h2">기본 내용<button type="button" class="sTog" title="Open/Close"></button></h2>
				<form id='infoDFrm' name='infoDFrm' method="post" target="_actionfrm" action="./sample/sample_proc.php" class="form" enctype="multipart/form-data">
				<input type="hidden" id="detail_Did" name="detail_id" value="<?=$detail_Did;?>" />
				<input type="hidden" name="sample_id" value="<?=$sample_id;?>" />
				<input type="hidden" name="sample_type" value="<?=$sampleInfo['sample_type']?>" />
				<input type="hidden" name="a" value="detail_insert" />
				<input type="hidden" name="part" value="D" />
				<input type="hidden" name="upload_dir" value="SAMPLE" />
				<table class="list01">
					<colgroup>
						<col width="10%">
						<col width="80%">
						<col width="10%">
					</colgroup>
					<tbody>
						<tr>
							<th>이미지 zip</th>
							<td colspan="2" style="text-align: left; padding-left: 15px;">
							<input type='file' size='10' name='user_file' /> 
	                        <?php if ($img_zipfile) echo "&nbsp;&nbsp;<a href='{$conf_img_sample_url}{$sample_id}/{$img_zipfile}' target='_blank'>{$img_zipfile}</a>&nbsp;&nbsp;";?>
							<b style="color: red;">* 폴더 없이 이미지파일들끼리만 압축하여 등록해 주세요.</b>
	                        </td>
						</tr>
						<tr>
							<th style="vertical-align: middle;">HTML</th>
							<td style="text-align: left; padding-left: 15px;">
							<textarea name="detail_html" style="width: 100%; height: 100px;"><?=stripslashes($detail_Dhtml);?></textarea>
							<b style="color: red;">* 각 block 이외의 내용이 있을경우 해당 내용을 입력해 주세요. block 부분은 @BODY@로 넣어 주세요.</b>
							</td>
							<td><span class="side"><input type="button" class="bbutton" onClick="postSampleDDetail();" value="저장"></span></td>
						</tr>
					</tbody>
				</table>
				</form>
			</fieldset>
			
			<fieldset class="section">
				<h2 class="h2">메인 내용<button type="button" class="sTog" title="Open/Close"></button></h2>
				<form id='infoMFrm' name='infoMFrm' method="post" target="_actionfrm" action="./sample/sample_proc.php" class="form">
				<input type="hidden" id="detail_Mid" name="detail_id" value="<?=$detail_Mid;?>" />
				<input type="hidden" name="sample_id" value="<?=$sample_id;?>" />
				<input type="hidden" name="sample_type" value="<?=$sampleInfo['sample_type']?>" />
				<input type="hidden" name="a" value="detail_insert" />
				<input type="hidden" name="part" value="M" />
				<table class="list01">
					<colgroup>
						<col width="10%">
						<col width="80%">
						<col width="10%">
					</colgroup>
					<tbody>
						<tr>
							<th style="vertical-align: middle;">HTML</th>
							<td style="text-align: left; padding-left: 15px;">
							<textarea name="detail_html" style="width: 100%; height: 100px;"><?=stripslashes($detail_Mhtml);?></textarea>
							<b style="color: red;">* 메인 내용의 block 내용을 넣어 주세요.</b>
							</td>
							<td><span class="side"><input type="button" class="bbutton" onClick="postSampleMDetail();" value="저장"></span></td>
						</tr>
					</tbody>
				</table>
				</form>
			</fieldset>
			
			<fieldset class="section">
				<h2 class="h2">갤러리 내용<button type="button" class="sTog" title="Open/Close"></button></h2>
				<form id='infoGFrm' name='infoGFrm' method="post" target="_actionfrm" action="./sample/sample_proc.php" class="form">
				<input type="hidden" id="detail_Gid" name="detail_id" value="<?=$detail_Gid;?>" />
				<input type="hidden" name="sample_id" value="<?=$sample_id;?>" />
				<input type="hidden" name="sample_type" value="<?=$sampleInfo['sample_type']?>" />
				<input type="hidden" name="a" value="detail_insert" />
				<input type="hidden" name="part" value="G" />
				<table class="list01">
					<colgroup>
						<col width="10%">
						<col width="80%">
						<col width="10%">
					</colgroup>
					<tbody>
						<tr>
							<th style="vertical-align: middle;">HTML</th>
							<td style="text-align: left; padding-left: 15px;">
							<textarea name="detail_html" style="width: 100%; height: 100px;"><?=stripslashes($detail_Ghtml);?></textarea>
							<b style="color: red;">* 갤러리 내용의 block 내용을 넣어 주세요.</b>
							</td>
							<td><span class="side"><input type="button" class="bbutton" onClick="postSampleGDetail();" value="저장"></span></td>
						</tr>
					</tbody>
				</table>
				</form>
			</fieldset>
			
			<fieldset class="section">
				<h2 class="h2">초대글 내용<button type="button" class="sTog" title="Open/Close"></button></h2>
				<form id='infoIFrm' name='infoIFrm' method="post" target="_actionfrm" action="./sample/sample_proc.php" class="form">
				<input type="hidden" id="detail_Iid" name="detail_id" value="<?=$detail_Iid;?>" />
				<input type="hidden" name="sample_id" value="<?=$sample_id;?>" />
				<input type="hidden" name="sample_type" value="<?=$sampleInfo['sample_type']?>" />
				<input type="hidden" name="a" value="detail_insert" />
				<input type="hidden" name="part" value="I" />
				<table class="list01">
					<colgroup>
						<col width="10%">
						<col width="80%">
						<col width="10%">
					</colgroup>
					<tbody>
						<tr>
							<th style="vertical-align: middle;">HTML</th>
							<td style="text-align: left; padding-left: 15px;">
							<textarea name="detail_html" style="width: 100%; height: 100px;"><?=stripslashes($detail_Ihtml);?></textarea>
							<b style="color: red;">* 초대글 내용의 block 내용을 넣어 주세요.</b>
							</td>
							<td><span class="side"><input type="button" class="bbutton" onClick="postSampleIDetail();" value="저장"></span></td>
						</tr>
					</tbody>
				</table>
				</form>
			</fieldset>
			
			<!--
			<fieldset class="section">
				<h2 class="h2">덕담게시판 내용<button type="button" class="sTog" title="Open/Close"></button></h2>
				<form id='infoBFrm' name='infoBFrm' method="post" target="_actionfrm" action="./sample/sample_proc.php" class="form">
				<input type="hidden" id="detail_Bid" name="detail_id" value="<?=$detail_Bid;?>" />
				<input type="hidden" name="sample_id" value="<?=$sample_id;?>" />
				<input type="hidden" name="sample_type" value="<?=$sampleInfo['sample_type']?>" />
				<input type="hidden" name="a" value="detail_insert" />
				<input type="hidden" name="part" value="B" />
				<table class="list01">
					<colgroup>
						<col width="10%">
						<col width="90%">
					</colgroup>
					<tbody>
						<tr>
							<th style="vertical-align: middle;">HTML</th>
							<td style="text-align: left; padding-left: 15px;">
							<textarea name="detail_html" style="width: 100%; height: 100px;"><?=stripslashes($detail_Bhtml);?></textarea>
							<b style="color: red;">* 게시판 내용의 block 내용을 넣어 주세요.</b>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="btnArea">
					<span class="side"> <input type="button" id="btnPost"
						onClick="postSampleBDetail();" value="저장">
					</span>
				</div>
				</form>
			</fieldset>
			-->
			<fieldset class="section">
				<h2 class="h2">퀵메뉴 내용<button type="button" class="sTog" title="Open/Close"></button></h2>
				<form id='infoQFrm' name='infoQFrm' method="post" target="_actionfrm" action="./sample/sample_proc.php" class="form">
				<input type="hidden" id="detail_Qid" name="detail_id" value="<?=$detail_Qid;?>" />
				<input type="hidden" name="sample_id" value="<?=$sample_id;?>" />
				<input type="hidden" name="sample_type" value="<?=$sampleInfo['sample_type']?>" />
				<input type="hidden" name="a" value="detail_insert" />
				<input type="hidden" name="part" value="Q" />
				<table class="list01">
					<colgroup>
						<col width="10%">
						<col width="80%">
						<col width="10%">
					</colgroup>
					<tbody>
						<tr>
							<th style="vertical-align: middle;">HTML</th>
							<td style="text-align: left; padding-left: 15px;">
							<textarea name="detail_html" style="width: 100%; height: 100px;"><?=stripslashes($detail_Qhtml);?></textarea>
							<b style="color: red;">* 퀵메뉴 내용의 block 내용을 넣어 주세요.</b>
							</td>
							<td><span class="side"><input type="button" class="bbutton" onClick="postSampleQDetail();" value="저장"></span></td>
						</tr>
					</tbody>
				</table>
				</form>
			</fieldset>
			
			<fieldset class="section">
				<h2 class="h2">감사장 내용<button type="button" class="sTog" title="Open/Close"></button></h2>
				<form id='infoAFrm' name='infoAFrm' method="post" target="_actionfrm" action="./sample/sample_proc.php" class="form">
				<input type="hidden" id="detail_Aid" name="detail_id" value="<?=$detail_Aid;?>" />
				<input type="hidden" name="sample_id" value="<?=$sample_id;?>" />
				<input type="hidden" name="sample_type" value="<?=$sampleInfo['sample_type']?>" />
				<input type="hidden" name="a" value="detail_insert" />
				<input type="hidden" name="part" value="A" />
				<table class="list01">
					<colgroup>
						<col width="10%">
						<col width="80%">
						<col width="10%">
					</colgroup>
					<tbody>
						<tr>
							<th style="vertical-align: middle;">HTML</th>
							<td style="text-align: left; padding-left: 15px;">
							<textarea name="detail_html" style="width: 100%; height: 100px;"><?=stripslashes($detail_Ahtml);?></textarea>
							<b style="color: red;">* 감사장 내용의 block 내용을 넣어 주세요.</b>
							</td>
							<td><span class="side"><input type="button" class="bbutton" onClick="postSampleADetail();" value="저장"></span></td>
						</tr>
					</tbody>
				</table>
				</form>
			</fieldset>

		</div>
        
        <?php } ?>
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