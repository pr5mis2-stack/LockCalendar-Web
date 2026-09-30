<?php
import("class.controller.WWWRoot");
import("php.util.StringClass");

/**
 *
 *  ServiceLogCon
 *
 *  @Desc     : 서비스 로그 처리 Class 
 *  @Author   : 이정수
 *  @Date     : 2011. 08. 19 
 *  @Version  :
 */
class ServiceLogCon extends WWWRoot {

	private $stringClass;

	/**
	 *
	 *  ServiceLogCon
	 *
 	 *  @Desc      : 서비스 로그 처리 Class 
 	 *  @Author    : 이정수
 	 *  @Date      : 2011. 08. 19 
	 *  @Return    :
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 *
	 *  InsertServiceLog
	 *
	 *  @Desc      : 서비스 로그 입력
 	 *  @Author    : 이정수
 	 *  @Date      : 2011. 08. 19 
 	 *  @param     : $param Array
	 *  @Return    :
	 */
	public function InsertServiceLog()
	{	
		$result = "";
		// 파일로 로그 저장
		$result = $this->InsertServiceLogToFile();
		// 디비로 로그 저장
		//$result = $this->InsertServiceLogToDB();
		return $result;
	}

	/**
	 *
	 *  InsertServiceLogToFile
	 *
	 *  @Desc      : 서비스 로그 파일로 저장
 	 *  @Author    : 이정수
 	 *  @Date      : 2011. 09 01 
 	 *  @param     : $param Array
	 *  @Return    :
	 */
	public function InsertServiceLogToFile()
	{
		global $conf_log_dir;
		global $cookie_param;
		global $conf_guiguiland_service_id;
		$result = true;

		// file save location setting
		$log_file = $conf_log_dir."visit/visit_".date("Ymd").".log";
		
		// file log setting
		$log_msg = "";
		$urlParse = parse_url($_SERVER["REQUEST_URI"]);
		parse_str($urlParse["query"] ?? '', $get_param);
		
		/**
		 * $param["service_id"]		= $conf_guiguiland_service_id;
		 * $param["service_ip"] 	= $_SERVER["SERVER_ADDR"];												// service_ip
		 * $param["user_id"]	 	= (!empty($cookie_param['UserID']))? $cookie_param['UserID']:"";		// user_id 
		 * $param["user_ip"]	 	= $_SERVER["REMOTE_ADDR"];												// user_ip
		 * $param["service_url"]	= $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];						// service_url
		 * $param["service_page"]	= $_SERVER["SCRIPT_NAME"];												// service_page
		 * $param["service_param"]	= $_SERVER["QUERY_STRING"];												// service_param
		 * $param["location_id"]	= (!empty($get_param["lid"]))? $get_param["lid"]:"";	// location_id 
		 * $param["reg_year"]		= date("Y");
		 * $param["reg_month"]		= date("m");
		 * $param["reg_day"]		= date("d");
		 * $param["reg_date"]		= date("YmdHis");
		 */
		
		$log_msg .= $conf_guiguiland_service_id."\t";											// service_id
		$log_msg .= $_SERVER["SERVER_ADDR"]."\t";												// service_ip
		$log_msg .= (!empty($cookie_param['UserID']))? $cookie_param['UserID']."\t":"\t";	// user_id 
		$log_msg .= $_SERVER["REMOTE_ADDR"]."\t";												// user_ip
		$log_msg .= $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]."\t";							// service_url
		$log_msg .= $_SERVER["SCRIPT_NAME"]."\t";												// service_page
		$log_msg .= $_SERVER["QUERY_STRING"]."\t";												// service_param
		$log_msg .= (!empty($get_param["lid"]))? $get_param["lid"]."\t":"\t";				// location_id 
		$log_msg .= date("Y")."\t";
		$log_msg .= date("m")."\t";
		$log_msg .= date("d")."\t";
		$log_msg .= date("YmdHis")."\n";
		
		if  ($fp = fopen($log_file, "a"))
		{
			if (fwrite($fp, $log_msg))
				$result = true;
			else
				$result = false;

			fclose($fp);
		}
		else
		{
			$result = false;
		}
		
		return $result;
	}

}
?>