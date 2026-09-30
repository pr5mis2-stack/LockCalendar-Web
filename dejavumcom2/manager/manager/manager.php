<?php
/**
 *  manager.php
 *  @Desc      : 관리자 목록
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
import ( "class.controller.ManagerCon" ); // 서비스 로그 저장

$ManagerCon = new ManagerCon ();

/**
 *
 * @var parameter setting
 */
$_a = $StringClass->getRequest ( 'a' );

if ($_a == "insert" || $_a == "update")
	include_once ("manager_form.php");
else
	include_once ("manager_list.php");
?>