<?php
/**
 *  sample.php
 *  @Desc      : 샘플 목록
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
import ( "class.controller.SampleCon" ); // 서비스 로그 저장
import ( "class.controller.SampleDetailCon" ); // 서비스 로그 저장
import ( "php.util.PagingClass" );

$SampleCon = new SampleCon ();
$SampleDetailCon = new SampleDetailCon ();
/**
 *
 * @var parameter setting
 */
$_a = $StringClass->getRequest ( 'a' );

if ($_a == "insert" || $_a == "update")
	include_once ("sample_form.php");
else
	include_once ("sample_list.php");
?>