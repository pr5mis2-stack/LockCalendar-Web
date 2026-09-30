<?php
    /**
 *  index.php
 *  @Desc      : 관리자 메뉴
 *  @Author    : SUYA
 *  @Date      : 2012. 03. 07. 오전 11:03:57
 *  @param 	 
 *  @Return
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/include/manager_top.php");

import("php.util.PagingClass");

$_m = isset($_POST['m']) ? $_POST['m'] : $_GET['m'];
$_a = isset($_POST['a']) ? $_POST['a'] : $_GET['a'];

?>
<div class="x">
<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/admin/menu.php");

if (!empty($_m))
	include_once($_m.".php");
?>
</div>
<?php require_once($_SERVER["DOCUMENT_ROOT"]."/include/manager_footer.php"); ?>