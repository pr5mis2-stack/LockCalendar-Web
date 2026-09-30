<?php
import("class.controller.WWWRoot");
import("class.model.CommonCodeDao");

/**
 * 
 * 
 * @ClassName  :
 * @FileName   : file_name
 * @Package    : package_name
 * @Comment    : 
 * @Author     : suya
 * @Date       : 2013. 8. 3.
 */
class CommonCodeCon extends WWWRoot {
		
	private $CommonCodeDao;
	private $param;

	/**
	 * 
	 * CommonCodeCon
	 * 
	 * @ClassName  : CommonCodeCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->CommonCodeDao 		= new CommonCodeDao();
	}

	/**
	 * 
	 * getCommonCodeCnt
	 * 
	 * @ClassName  : CommonCodeCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function getCommonCodeCnt($param=array())
	{
		$result = $this->CommonCodeDao->selectCommonCodeCnt($param);
		return $result;		
	}
	
	/**
	 * 
	 * getCommonCodeList
	 * 
	 * @ClassName  : CommonCodeCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 */
	public function getCommonCodeList($param=array(), $start_num='', $end_num='')
	{
		$result = $this->CommonCodeDao->selectCommonCodeList($param, $start_num, $end_num);
		return $result;			
	}
	
	/**
	 * 
	 * addCommonCode
	 * 
	 * @ClassName  : CommonCodeCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function addCommonCode($param=array())
	{
		$result = $this->CommonCodeDao->insertCommonCode($param);
		return $result;			
	}
	
	/**
	 * 
	 * setCommonCode
	 * 
	 * @ClassName  : CommonCodeCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function setCommonCode($param=array())
	{
		$result = 0;	
		if (!empty($param['code_tbl']) && !empty($param['code_fld']) && !empty($param['code_val']) )
			$result = $this->CommonCodeDao->updateCommonCode($param);
		return $result;			
	}
	
	/**
	 * 
	 * delCommonCode
	 * 
	 * @ClassName  : CommonCodeCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $CommonCode_id
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function delCommonCode($param=array())
	{
		$result = 0;	
		
		if (!empty($param['code_tbl']) && !empty($param['code_fld']) && !empty($param['code_val']) )
			$result = $this->CommonCodeDao->deleteCommonCode($CommonCode_id);
		return $result;			
	}
}
?>