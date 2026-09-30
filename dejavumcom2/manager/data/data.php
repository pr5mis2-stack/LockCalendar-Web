<?php
/**
 *  main.php
 *  @Desc      : 초대장 목록
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
import ( "class.controller.DataCon" );

$DataCon = new DataCon ();
/**
 *
 * @var parameter setting
 */
$_a = $StringClass->getRequest ( 'a' );

include_once ("data_list.php");
?>