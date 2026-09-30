<?php
/**
 *  login.php
 *  @Desc      : 로그인
 *  @Author    : uno
 *  @Date      : 2012. 03. 07. 오전 11:03:57
 *  @param 	 
 *  @Return
 */
/**
 *
 * @var parameter setting
 */
$ret_url = ! empty ( $_SERVER ["HTTP_REFERER"] ) ? $_SERVER ["HTTP_REFERER"] : '/manager/?m=main';

$thisPage = "/manager/login.php";
?>
<script type="text/javascript">
    var is_login_ing = false;

    function loginUser() {
        var id = $("#uid").val().trim();
        var pwd = $("#upw").val().trim();
        var ret_url = $("#ret_url").val();
        if (ret_url == "")
            ret_url = "/manager/index.php";

        if (is_login_ing) {
            alert("로그인 진행중 입니다.");
        }

        if (id.length == 0 || pwd.length == 0 || id == "아이디" || pwd == "비밀번호") {
            alert("아이디와 비밀번호를 입력해주세요.");
        }

        var goUrl = "/manager/login/login_proc.php";
        var param = "user_id=" + id + "&passwd=" + pwd;

        is_login_ing = true;

        $.ajax({
            type: 'post'
                      , async: true
                      , url: goUrl
                      , data: param
                      , beforeSend: function () { }
                      , success: function (data) {
                          is_login_ing = false;

                          var result = data.trim();

                          if (result == "100")
                              location.href = ret_url;
                          else if (result == "200")
                              alert('로그인 정보가 없습니다.');
                          else if (result == "300")
                              alert('정보가 일치하지 않습니다.다시 확인해 주세요.');
                          else
                              alert('로그인중 오류가 발생되었습니다.');
                      }
                      , error: function (data, status, err) { }
                      , complete: function () { }
        });
    }

	$(document).ready(function () {
		$("#uid").focus();

		$("#uid").keypress(function(){
			if (event.keyCode==13)
				$("#upw").focus();
		});
		
		$("#upw").keypress(function(){
			if (event.keyCode==13)
				loginUser();
		});
	});
    
</script>

<!-- 로그인전 진입 경로 url -->
<div id="loginAccess" class="gLogin">
	<h1>관리자만 접속이 가능합니다.</h1>
	<div class="mLogin" id="gLogin">
		<input type="hidden" id="ret_url" value="<?=$ret_url?>" />
		<fieldset>
			<ul class="idpw">
				<li><input type="text" name="user_id" id="uid" value=""
					class="iText" title="아이디" /></li>
				<li><input type="password" name="password" id="upw" value=""
					class="iText" title="비밀번호" /></li>
			</ul>
			<div class="buttonArea">
				<p class="keeping"></p>
				<span class="buttonAccount"><input type="button" value="로그인"
					onclick="loginUser()" /></span>
			</div>
		</fieldset>
	</div>
</div>