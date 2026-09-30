<?php
// ni_set("session.cookie_domain",".dejavu-m.com") ;
// ession_start();
// ession_cache_limiter("none");
/**
 * member_proc.php
 * @Desc : 회원정보 처리
 * @Author : suya
 * @Date :
 * 
 * @param
 *        	@Return
 */
require_once ($_SERVER["DOCUMENT_ROOT"] . "/include/common_header.php");

import ( "class.controller.ManagerCon" );

$ManagerCon = new ManagerCon ();

/**
 *
 * @var pageing setting
 */
$thisPage = "/manager/manager_proc.php";

/**
 *
 * @var parameter setting
 */
$_a = $StringClass->getRequest ( 'a' );
$manager_id = $StringClass->getRequest ( 'manager_id' );
$passwd = $StringClass->getRequest ( 'passwd' );
$manager_name = $StringClass->getRequest ( 'manager_name' );
$is_use = $StringClass->getRequest ( 'is_use' );

if ($_a == "update") {
	if ($manager_id) {
		$param = array ();
		$param ['manager_id'] = $manager_id;
		if ($passwd)
			$param ['passwd'] = $passwd;
		$param ['manager_name'] = $manager_name;
		$param ['is_use'] = $is_use;
		
		$result = $ManagerCon->setManager ( $param );
		
		if ($result)
			echo "100";
		else
			echo "200";
	} else
		echo "99";
	exit ();
} else if ($_a == "insert") {
	if ($manager_id) {
		$param = array ();
		$param ['manager_id'] = $manager_id;
		$param ['passwd'] = $passwd;
		$param ['manager_name'] = $manager_name;
		$param ['is_use'] = $is_use;
		
		$result = $ManagerCon->addManager ( $param );
		
		if ($result)
			echo "100";
		else
			echo "200";
	} else
		echo "99";
	exit ();
} else if ($_a == "delete") {
	if ($manager_id) {
		$result = $ManagerCon->delManager ( $manager_id );
		
		if ($result)
			echo "100";
		else
			echo "200";
	} else
		echo "99";
	exit ();
}
?>