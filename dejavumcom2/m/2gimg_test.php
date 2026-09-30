<?php
/**
 *  search_proc.php
 *  @Desc      : 검색결과 처리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
#namespace Knplabs\Snappy;

// snap 이용
//require_once('Knplabs/Snappy/Media.php');
//require_once('Knplabs/Snappy/Image.php');


set_time_limit(0);
require_once(dirname(__DIR__) . "/conf/DejavuConf.php");
require_once(dirname(__DIR__) . "/import.php");

import("class.controller.Photo2GCon");

$Photo2GCon        	= new Photo2GCon();

$main_id		= $_GET["main_id"];


// The URL to get your HTML
$url = "http://m.dejavu-m.com/?m=".$main_id."\&p=m\&t=p\&f=n";
// Command to execute
//$command = "/home/bin/wkhtmltoimage-i386 --load-error-handling ignore --disable-javascript --width 414 --height 739 --quality 90 --zoom 1.0 ";
$command = "/home/bin/wkhtmltoimage-i386 --load-error-handling ignore --disable-javascript --width 720 --height 1050 --quality 90";
// 13 720 1180
// http://m.dejavu-m.com/2gimg_test.php?main_id=103079

// 15 720 1050
// http://m.dejavu-m.com/2gimg_test.php?main_id=103081


/*
// snap 이용
$options = array('load-error-handling'=>'ignore', 'disable-javascript'=>true);
$snap = new Image('/home/bin/wkhtmltoimage-i386', $options);
//$snap = new Image('/home/bin/wkhtmltoimage-i386');

header("Content-Type:image/jpeg");
$snap->output($url);
*/


// Directory for the image to be saved
$img_dir = $conf_img_thumbnail_dir . $main_id ."/2gimg.jpg";
$img_url = $conf_mimg_thumbnail_url . $main_id ."/2gimg.jpg";

// Putting together the command for `shell_exec()`
$ex = "$command $url " . $img_dir;

// The full command is: "/usr/bin/wkhtmltoimage-i386 --load-error-handling ignore --width 1024 --height 500 --quality 100 --encoding "utf-8" --zoom 1.0 http://www.google.com/ /var/www/images/example.jpg"
// If we were to run this command via SSH, it would take a picture of google.com, and save it to /vaw/www/images/example.jpg

// Generate the image
// NOTE: Don't forget to `escapeshellarg()` any user input!

$output = shell_exec($ex);

$StringClass->alertMsg('', '', $img_url."?d=".date("his"), '');
?>