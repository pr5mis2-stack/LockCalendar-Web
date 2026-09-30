<?php
/**
 *  login_proc.php
 *  @Desc      : 로그인 처리.
 *  @Author    : uno 
 *  @Date      : 2011. 06. 15. 오전 11:03:57
 *  @param 	 
 *  @Return
 */
require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/common_header.php");
import ( "class.controller.ManagerCon" );

$ManagerCon = new ManagerCon ();
/**
 *
 * @var pageing setting
 */
$thisPage = "/manager/login_proc.php";

/**
 *
 * @var parameter setting
 */
$user_id = isset($_POST['user_id']) ? trim($_POST['user_id']) : (isset($_GET['user_id']) ? trim($_GET['user_id']) : '');
$user_passwd = isset($_POST['passwd']) ? trim($_POST['passwd']) : (isset($_GET['passwd']) ? trim($_GET['passwd']) : '');

$errCode = "100";

/**
 * info check
 */
if (empty ( $user_id ) || empty ( $user_passwd ))
	$errCode = "200";

if ($errCode == "100") {
	$param = array ();
	$param ['manager_id'] = $user_id;
	$param ['passwd'] = $user_passwd;
	$param ['is_use'] = 1;
	
	$result = $ManagerCon->getManagerCnt ( $param );
	if ($result) {
		$arrList = $ManagerCon->getManagerList ( $param );
		
		if ($arrList) {
			$userInfo = $arrList [0];
			$_SESSION ["manager_id"] = $userInfo ['manager_id'];
			$_SESSION ["manager_name"] = $userInfo ['manager_name'];
		} else
			$errCode = "300";
	} else
		$errCode = "300";
}

echo $errCode;
?>