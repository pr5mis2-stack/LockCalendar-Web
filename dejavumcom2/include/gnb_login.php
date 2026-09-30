	<script type="text/javascript" src="/js/login.js"></script>
	<!-- header -->
	<div id="header">
		<h1><a href="/main/main.php"><span class="blind">데자뷰</span></a></h1>
		<form id="loginFrm" name="loginFrm">
		<input type="hidden" id="ret_url" name="ret_url" value="" />
		<div class="lnb">
			<fieldset>
				<legend>로그인 영역</legend>
				<span class="input_text"><input type="text" id="user_email" name="user_email" /><label for="userId" class="i_label" style="display:block;">이메일 주소를 입력하세요</label></span>
				<span class="input_pw"><input type="password" id="user_passwd" name="user_passwd" /><label for="userPw" class="i_label2" style="display:block;">비밀번호</label></span>
				<span class="button style1"><button type="button" onclick="logIn();">로그인</button></span>
				<span class="button style2"><button type="button" onclick="gotoMaker();">초대장만들기</button></span>
			</fieldset>
		</div>
		</form>
		<?php 
		if (strstr($_SERVER["REQUEST_URI"], '/maker/'))
			include_once($_SERVER["DOCUMENT_ROOT"]."/include/gnb_maker.php");
		else
			include_once($_SERVER["DOCUMENT_ROOT"]."/include/gnb_sample.php");
		?>
	</div>
	<!-- //header -->