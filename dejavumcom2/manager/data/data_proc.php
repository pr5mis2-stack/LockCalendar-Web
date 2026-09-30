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

import ( "class.controller.DataCon" );

$DataCon = new DataCon ();

/**
 *
 * @var pageing setting
 */
$thisPage = "/manager/data/data_proc.php";

/**
 *
 * @var parameter setting
 */
$_a = $StringClass->getRequest ( 'a' );
$sample_type = $StringClass->getRequest ( 'sample_type' );
$interval = $StringClass->getRequest ( 'interval' );

/**
 *
 * @var get board data setting
 */
$param = array ();
$param['interval'] = $interval;
$param['sample_type'] = $sample_type;
//new dBug($param);

if ($_a == "delete") {
	if ($interval) {
		
		$num = 0;
		$arrList = $DataCon->getMainId($param);
		
		foreach ( $arrList as $item ) {
			$main_id = $item['main_id'];
			//echo "main_id : ".$main_id;
			if ($main_id > 0)
			{
				// file 삭제
				$dir = $conf_img_thumbnail_dir . substr($main_id, 0, 3) . "/" . $main_id;
				//echo " | dir : ".$dir."<br>";
				
				if (is_dir($dir))
				{
					foreach ( scandir ( $dir ) as $item ) {
						if ($item == '.' || $item == '..')
							continue;
						//echo "file = ".$dir . DIRECTORY_SEPARATOR . $item."<br>";
						unlink ( $dir . DIRECTORY_SEPARATOR . $item );
					}
					rmdir ( $dir );
				}
				$result = $DataCon->delData ( $main_id );
				$num++;
			}
		}
		
		if ($num > 0)
			echo("<script>alert('". $num ."건이 삭제되었습니다.');parent.location.reload();</script>");
		else
			echo("<script>alert('삭제중 오류가 발생되었습니다.');</script>");
	}
}
?>