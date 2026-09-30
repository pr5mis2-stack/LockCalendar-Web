<?php
#ini_set("session.cookie_domain",".dejavu-m.com") ;
#session_start();
#session_cache_limiter("none");
/**
 *  member_proc.php
 *  @Desc      : 회원정보 처리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/include/common_header.php");

import("class.controller.MainCon");
import("class.controller.GalleryCon");
import("class.controller.GalleryPhotoCon");
import("class.controller.GuestbookCon");
import("class.controller.InvitationCon");
import("class.controller.AppreciationCon");

$MainCon        	= new MainCon();
$GalleryCon			= new GalleryCon();
$GalleryPhotoCon 	= new GalleryPhotoCon();
$GuestbookCon		= new GuestbookCon();
$InvitationCon		= new InvitationCon();
$AppreciationCon	= new AppreciationCon();

/**
 * 
 * @var pageing setting
 */
$thisPage = "/admin/main_proc.php";

/**
 * 
 * @var parameter setting
 */
$_a				= $StringClass->getRequest('a');
$main_id		= $StringClass->getRequest('main_id');

$return = "99";

if ($_a == "delete")
{
	if ($main_id)
	{
		$result1 = $AppreciationCon->delAppreciation($main_id);
		$result2 = $InvitationCon->delInvitation($main_id);
		$result3 = $GuestbookCon->delGuestbookByMainID($main_id);
		$result4 = $GalleryPhotoCon->delGalleryPhotoByMainID($main_id);
		$result5 = $GalleryCon->delGallery($main_id);
		
		// file 삭제 
		$dir = $conf_img_thumbnail_dir.$main_id;
		
		foreach (scandir($dir) as $item) {
			if ($item == '.' || $item == '..') continue;
			unlink($dir.DIRECTORY_SEPARATOR.$item);
		}
		rmdir($dir);
		
		$result = $MainCon->delMain($main_id);
		
		
		if ($result)
			$return = "100";
		else
			$return = "200";
	}
}
echo $return;
?>