<?php 
/**
 *  login_proc.php
 *  @Desc      : 로그인 처리.
 *  @Author    : uno 
 *  @Date      : 2011. 06. 15. 오전 11:03:57
 *  @param 	 
 *  @Return
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/include/common_header.php");
import("class.controller.MainCon");

$MainCon 			= new MainCon();
/**
 * 
 * @var pageing setting
 */
$thisPage = "/member/login.php";

/**
 * 
 * @var parameter setting
 */
$user_email		= isset($_POST['user_email']) ? trim($_POST['user_email']) : (isset($_GET['user_email']) ? trim($_GET['user_email']) : '');
$user_passwd	= isset($_POST['user_passwd']) ? trim($_POST['user_passwd']) : (isset($_GET['user_passwd']) ? trim($_GET['user_passwd']) : '');


$errCode = "100";

/**
 * info check
 */
if (empty($user_email) || empty($user_passwd))
	$errCode = "200";

if ($errCode == "100")
{
	$param = array();
	$param['email'] 	= $user_email;
	$param['passwd'] 	= $user_passwd;
	
	$result = $MainCon->getMainCnt($param);
	if ($result)
	{
		$arrList = $MainCon->getMainList($param);

		if($arrList)
		{
			$userInfo = $arrList[0];	
			$_SESSION["dejavu_id"]	= $userInfo['main_id'];
			$_SESSION["user_email"]	= $userInfo['user_email'];
		}
		else
			$errCode = "300";
	}
	else
		$errCode = "300";
}

echo $errCode;
?>