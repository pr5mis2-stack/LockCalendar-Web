<?php
/**
 *  manager_form.php
 *  @Desc      : 회원정보 관리
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
$manager_id = $StringClass->getRequest ( 'manager_id' );
$search_target = $StringClass->getRequest ( 'search_target' );
$search_keyword = $StringClass->getRequest ( 'search_keyword' );

/**
 *
 * @var get board data setting
 */
if ($_a == "view" || $_a == "update") {
	$param = array ();
	$param ['manager_id'] = $manager_id;
	// new dBug($param);
	$arrList = $ManagerCon->getManagerList ( $param );
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
$getParam = "&m=manager";
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
	
    function postManager()
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        var manager_id		= $("#manager_id").val();
        var passwd			= $("#passwd").val();
        var manager_name	= $("#manager_name").val();
        var is_use			= $('#is_use option:selected').val();
        
        var goUrl = "./manager/manager_proc.php";
        var param = "&a=<?=$_a;?>&manager_id="+ manager_id +"&passwd="+ passwd +"&manager_name="+ manager_name +"&is_use="+ is_use;
        //location.href = goUrl + "?" + param;
		//return false;
		
        if (!checkVariableField('manager_id', '매니저명을 입력해 주세요.')) return false;
        if (!checkVariableField('passwd', '비밀번호를 입력해 주세요.')) return false;
        if (!checkVariableField('manager_name', '매니저명을 입력해 주세요.')) return false;

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

    function postDelete()
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        var manager_id		= $("#manager_id").val();
        
        var goUrl = "./manager/manager_proc.php";
        var param = "&a=delete&manager_id="+ manager_id;
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

                if (result == "100")
                {
                	alert('처리되었습니다');
					location.href="/manager/?m=manager";
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
		<h1 class="h1">매니저 관리</h1>
		<form name="boardFrm" method="post" target="_actionfrm"
			action="./manager/manager_proc.php" class="form">
			<div class="table even">
				<fieldset class="section">
					<h2 class="h2">매니저 정보<button type="button" class="sTog" title="Open/Close"></button></h2>
					<table class="list01">
						<colgroup>
							<col width="20%">
							<col width="30%">
							<col width="20%">
							<col width="30%">
						</colgroup>
						<tbody>
							<tr>
								<th>아이디</th>
								<td style="text-align: left; padding-left: 15px;"><input
									type="text" id="manager_id" name="manager_id"
									value="<?=$userInfo['manager_id'];?>" style="width: 100px;" /></td>
								<th>비밀번호</th>
								<td style="text-align: left; padding-left: 15px;"><input
									type="text" id="passwd" name="passwd"
									value="<?=$userInfo['passwd'];?>" style="width: 100px;" /></td>
							</tr>
							<tr>
								<th>이름</th>
								<td style="text-align: left; padding-left: 15px;"><input
									type="text" id="manager_name" name="manager_name"
									value="<?=$userInfo['manager_name'];?>" style="width: 100px;" /></td>
								<th>사용유무</th>
								<td style="text-align: left; padding-left: 15px;"><select
									id="is_use" name="is_use">
										<option value="1"
											<?php if ($userInfo['is_use'] == "1") echo "selected";?>>사용중</option>
										<option value="0"
											<?php if ($userInfo['is_use'] == "0") echo "selected";?>>미사용</option>
								</select></td>
							</tr>
							<tr>
								<th>가입일</th>
								<td colspan="3" style="text-align: left; padding-left: 15px;"><?=$userInfo['reg_date'];?></td>
							</tr>
						</tbody>
					</table>
				</fieldset>

			</div>
			<div class="btnArea">
				<span class="side"> <input type="button" id="btnPost"
					onClick="postManager();" value="등록"> <input type="button"
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