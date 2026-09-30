<?php
/**
 *  wedding_form.php
 *  @Desc      : 웨딩 회원정보 관리
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
$main_id = $StringClass->getRequest ( 'main_id' );
$sch_date = $StringClass->getRequest ( 'sch_date' );
$sch_end = $StringClass->getRequest ( 'sch_end' );
$sch_target = $StringClass->getRequest ( 'sch_target' );
$sch_keyword = $StringClass->getRequest ( 'sch_keyword' );

/**
 *
 * @var get board data setting
 */
if ($_a == "view" || $_a == "update") {
	$param = array ();
	$param ['main_id'] = $main_id;
	// new dBug($param);
	$arrList = $MainCon->getMainList ( $param );
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
$getParam = "&m=wedding";
$getParam .= "&sch_date={$sch_date}";
$getParam .= "&sch_end={$sch_end}";
$getParam .= "&sch_target={$sch_target}";
$getParam .= "&sch_keyword={$sch_keyword}";
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
	
    function postMain()
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        var main_id	= $("#main_id").val();
        var passwd	= $("#passwd").val();
        
        var goUrl = "./wedding/wedding_proc.php";
        var param = "&a=<?=$_a;?>&main_id="+ main_id +"&passwd="+ passwd;
        //location.href = goUrl + "?" + param;
		//return false;
		is_proc_ing = true;

        $.ajax({
        	type: 'post'
            , async: true
            , url: goUrl
            , data: param
            , beforeSend: function () { }
            , success: function (data) {

            	is_proc_ing = false;

                var result = data.trim();

                //alert(result);
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
</script>
<div class="body">
	<div class="content" id="content" tabindex="0">
		<h1 class="h1">결혼식 초대장 관리</h1>
		<form name="boardFrm" method="post" target="_actionfrm"
			action="./wedding/wedding_proc.php" class="form">
			<input type="hidden" id="main_id" name="main_id"
				value="<?=$userInfo['main_id'];?>" />
			<div class="table even">
				<fieldset class="section">
					<h2 class="h2">
						비밀번호 변경
						<button type="button" class="sTog" title="Open/Close"></button>
					</h2>
					<table class="list01">
						<colgroup>
							<col width="20%">
							<col width="30%">
							<col width="20%">
							<col width="30%">
						</colgroup>
						<tbody>
							<tr>
								<th>이메일</th>
								<td style="text-align: left; padding-left: 15px;"><?=$userInfo['email'];?></td>
								<th>비밀번호</th>
								<td style="text-align: left; padding-left: 15px;"><input
									type="text" id="passwd" name="passwd"
									value="<?=$userInfo['passwd'];?>" style="width: 100px;" /></td>
							</tr>
						</tbody>
					</table>
				</fieldset>

			</div>
			<div class="btnArea">
				<span class="side"> <input type="button" id="btnPost"
					onClick="postMain();" value="수정"> <input type="button"
					onClick="history.back();" value="목록으로">
				</span>
			</div>
		</form>

	</div>
</div>
<!--*****메인 끝*****-->