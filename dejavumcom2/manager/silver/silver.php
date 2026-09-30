<?php
/**
 *  main.php
 *  @Desc      : 고희연 초대장 목록
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
import ( "class.controller.MainCon" );
import ( "class.controller.InvitationCon" );
import ( "class.controller.AppreciationCon" );
import ( "class.controller.GalleryCon" );
import ( "class.controller.GalleryPhotoCon" );
import ( "class.controller.GuestbookCon" );

$MainCon = new MainCon ();
$InvitationCon = new InvitationCon ();
$AppreciationCon = new AppreciationCon ();
$GalleryCon = new GalleryCon ();
$GalleryPhotoCon = new GalleryPhotoCon ();
$GuestbookCon = new GuestbookCon ();

/**
 *
 * @var parameter setting
 */
$_a = $StringClass->getRequest ( 'a' );

if ($_a == "insert" || $_a == "update")
	include_once ("silver_form.php");
else
	include_once ("silver_list.php");
?>