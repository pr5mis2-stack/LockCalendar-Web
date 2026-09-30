<?php 
import("class.controller.MainCon");

$MainCon        	= new MainCon();
$mid = 0;
$_step = $StringClass->getRequest('step');
$_on2 = (in_array($_step, array("", "1", "2")))? "on":"";
$_on3 = ($_step == "3")? "on":"";
$_on4 = ($_step == "4")? "on":"";
$_on5 = ($_step == "5")? "on":"";
?>
		<div class="gnb">
			<ul>
				<li class="n2 <?=$_on2;?>"><a href="/maker/main.php">메인</a></li>
				<li class="n3 <?=$_on3;?>"><a href="/maker/main.php?step=3">갤러리</a></li>
				<li class="n4 <?=$_on4;?>"><a href="/maker/main.php?step=4">초대글</a></li>
				<li class="n5 <?=$_on5;?>"><a href="/maker/main.php?step=5">감사장</a></li>
				<li id="menu7" class="n8"><a href="javascript:viewHelp()">제작가이드</a></li>
				<li class="btn1"><button type="button" onClick="viewModal('modalSend')"><span class="blind">폰으로 보내기</span></button></li>
				<li class="btn2"><button type="button" onClick="modalPreViewer(<?=$_SESSION['dejavu_id'];?>)"><span class="blind">초대장 미리보기</span></button></li>
			</ul>
		</div>