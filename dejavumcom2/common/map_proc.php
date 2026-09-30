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

import("php.util.GoogleConverter");

$GoogleConverter = new GoogleConverter();

/**
 * 
 * @var pageing setting
 */
$thisPage = "/common/map_proc.php";

/**
 * 
 * @var parameter setting
 */
$_a			= $StringClass->getRequest('a');
$address 	= $StringClass->getRequest('address');
$lat		= $StringClass->getRequest('lat');
$lng		= $StringClass->getRequest('lng');

if ($_a == "a2c")
{
    if ($address)
    {
    	$result = $GoogleConverter->getLatLngByAddress(str_replace(" ", "", $address));
    	
    	if ($result)
    	{
    		if ($result->status == "OK")
    		{
    			$results = $result->results[0];
    			//new dBug($result);
	    		$lat = $results->geometry->location->lat;
	    		$lng = $results->geometry->location->lng;
	    		$address = $results->formatted_address;
	    		if ($address)
	    		{
	    			$address = trim(str_replace("대한민국", "", $address));
	    			$address = trim(str_replace("한국", "", $address));
	    		}
				echo "100;".$lat.";".$lng.";".$address;
    		}
    		else
    			echo"200";
    	}
        else
            echo"200";
    }
    else
        echo"99";
    exit;
}
else if ($_a == "c2a")
{
	if ($lat && $lng)
	{
		$param = array();
		$param['manager_id'] 	= $manager_id;
		$param['passwd'] 		= $passwd;
		$param['manager_name'] 	= $manager_name;
		$param['is_use'] 		= $is_use;
	
		$result = $ManagerCon->addManager($param);
	
		if ($result)
			echo"100";
		else
			echo"200";
	}
	else
		echo"99";
	exit;
}
?>