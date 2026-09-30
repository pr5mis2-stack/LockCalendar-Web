<?php
/*
 * 서비스 환경설정 파일 (전역 변수)
 */
require_once __DIR__ . "/conf/DejavuConf.php";

/*
 * import (include_once 자동처리 함수)
 *
 * ex) 사용할 파일내에서 import("php.db.DaoClass"); 로 사용할 경우
 *     내부적으로 include_once(서비스 절대경로+"/php/db/DaoClass.php");로 내부처리해준다.
 *     import("class.controller.member.*"); 로 사용할 경우
 *     서비스 절대경로 +"/class/controller/member/ 하부의 모든 php파일을 include 처리한다.
 *
 * @author
 * @version 1.0
 * @param $path : include 처리할 파일 경로, $parent_path : 부모 경로명 (디폴트 LIB), $file_ext : 파일 확장자 (디폴트 php)
 * @exception
 * @return
 */

define("PARENT_PATH_DEFAULT", $conf_lib_dir);
define("FILE_EXT_DEFAULT", "php");

function import($path, $parent_path = PARENT_PATH_DEFAULT, $file_ext = FILE_EXT_DEFAULT)
{
	$arr = explode(".", $path);
	$class = $arr[sizeof($arr)-1];

	if ($class == "*")
	{
		$dir = $parent_path . str_replace(".", "/", $path);
		$dir = str_replace("/*", "", $dir);

		if (is_dir($dir))
		{
			if ($d = opendir($dir))
			{
				while(($file = readdir($d)) != false)
				{
					
					$current_file = explode(".", $file);
					$current_file_ext = end($current_file);
				
					if ($file == "." || $file == ".." || ($current_file_ext != $file_ext))
						continue;
					else
						include_once $dir . "/" . $file;
				}
			}
			
			closedir($d);
		}
	}
	else
	{
		include_once $parent_path . str_replace(".", "/", $path). "." . $file_ext;
	}
}

/**
 *  유틸리티(DBug) 클래스 임포트 
 *
 *  @Desc      : DBug 등 전역적으로 사용할 패키지를 임포트한다.
 *  @Author    : 손명석
 *  @Date      : 2010.11.18
 */

import("php.util.DBugClass");				// 상용화시 커맨트 처리 필요
import("php.util.StringClass");

$StringClass = new StringClass();
foreach($_GET as $key=>$val)
	$_GET[$key] = $StringClass->escapeString($val);
?>