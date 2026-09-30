<?php
/**
 *  menu.php
 *  @Desc      : 관리자메뉴
 *  @Author    : SUYA
 *  @Date      : 2012. 03. 07. 오전 11:03:57
 *  @param 	 
 *  @Return
 */
$param = array();
?>
<div class="header">
    <div class="account">
	    <ul>
	    	<li><a href="http://fph.dejavu-m.com/">Home</a></li>
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
            <li role="menuitem" aria-haspopup="true"><a href="/admin/?m=main"><span>초대장 등록관리</span></a></li>
            
        </ul>
    </div>
</div>