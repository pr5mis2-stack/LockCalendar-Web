<?php
/**
 *  menu.php
 *  @Desc      : 관리자메뉴
 *  @Author    : SUYA
 *  @Date      : 2012. 03. 07. 오전 11:03:57
 *  @param 	 
 *  @Return
 */
$param = array ();
?>
<div class="header">
	<div class="account">
		<ul>
			<li><a href="http://www.dejavu-m.com/">Home</a></li>
			<li><a href="/member/logout.php">Log-out</a></li>
		</ul>
	</div>
	<script>
	function duesPop(url)
	{
		var dues = window.open(url, 'dues', 'width=800,height=700,scrollbar=Y');
	}
	</script>
	<div class="gnb" role="navigation">
		<ul class="nav-gnb">
			<li role="menuitem" aria-haspopup="true"><a href="/manager/?m=main"><span>돌잔치 등록관리</span></a></li>
			<li role="menuitem" aria-haspopup="true"><a href="/manager/?m=wedding"><span>결혼식 등록관리</span></a></li>
			<li role="menuitem" aria-haspopup="true"><a href="/manager/?m=silver"><span>고희연 등록관리</span></a></li>
			<li role="menuitem" aria-haspopup="true"><a href="/manager/?m=sample"><span>샘플관리</span></a></li>
			<li role="menuitem" aria-haspopup="true"><a href="/manager/?m=shop"><span>업체관리</span></a></li>
			<li role="menuitem" aria-haspopup="true"><a href="/manager/?m=manager"><span>매니저 관리</span></a></li>
			<li role="menuitem" aria-haspopup="true"><a href="/manager/?m=data"><span>초대장 삭제 관리</span></a></li>
			<li role="menuitem" aria-haspopup="true"><a href="/manager/?m=promotion"><span>프로모션 등록관리</span></a></li>
			<li role="menuitem" aria-haspopup="true"><a href="/manager/?m=pmolog"><span>프로모션 참여관리</span></a></li>
		</ul>
	</div>
</div>