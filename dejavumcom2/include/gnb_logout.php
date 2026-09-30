<?php 
import("class.controller.MainCon");
$MainCon        	= new MainCon();
$param = array();
$param['main_id'] = $_SESSION['dejavu_id'];
$result = $MainCon->getMainList($param);
if ($result)
{
	$main_info = $result[0];
}
?>
	<script>
	function logOut()
	{
		location.href = "/member/logout.php";
	}
	</script>
	<!-- header -->
	<div id="header">
		<h1><a href="/main/main.php"><span class="blind">데자뷰</span></a></h1>
		<div class="lnb">
			<fieldset>
				<legend>로그인 영역</legend>
				<p><span><?=$main_info['father_name'].",".$main_info['mother_name']?></span> 님, 환영합니다.</p>
				<span class="button style1"><button type="button" onClick="logOut()">로그아웃</button></span>
				<span class="button style2"><button type="button" onClick="gotoMaker()">초대장수정</button></span>
			</fieldset>
		</div>
		<?php include_once($_SERVER["DOCUMENT_ROOT"]."/include/gnb_maker.php"); ?>
	</div>
	<!-- //header -->