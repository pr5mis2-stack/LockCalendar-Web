<?php
import("class.controller.WWWRoot");
import("class.controller.ImageCon");
import("class.model.AppreciationDao");

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
class AppreciationCon extends WWWRoot {
		
	private $AppreciationDao;
	private $ImageCon;
	private $param;

	/**
	 * 
	 * AppreciationCon
	 * 
	 * @ClassName  : AppreciationCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->AppreciationDao 		= new AppreciationDao();
		$this->ImageCon		= new Imagecon();
	}

	/**
	 * 
	 * getAppreciationCnt
	 * 
	 * @ClassName  : AppreciationCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function getAppreciationCnt($param=array())
	{
		$result = $this->AppreciationDao->selectAppreciationCnt($param);
		return $result;		
	}
	
	/**
	 * 
	 * getAppreciationList
	 * 
	 * @ClassName  : AppreciationCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 */
	public function getAppreciationList($param=array(), $start_num='', $end_num='')
	{
		$result = $this->AppreciationDao->selectAppreciationList($param, $start_num, $end_num);
		return $result;			
	}
	
	/**
	 * 
	 * addAppreciation
	 * 
	 * @ClassName  : AppreciationCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function addAppreciation($param=array())
	{
		$result = $this->AppreciationDao->insertAppreciation($param);
		return $result;			
	}
	
	/**
	 * 
	 * setAppreciation
	 * 
	 * @ClassName  : AppreciationCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function setAppreciation($param=array())
	{
		$result = 0;	
		if (isset($param['main_id']))
			$result = $this->AppreciationDao->updateAppreciation($param);
		return $result;			
	}
	
	/**
	 * 
	 * delAppreciation
	 * 
	 * @ClassName  : AppreciationCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $main_id
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function delAppreciation($main_id=0)
	{
		$result = 0;	
		if (!empty($main_id))
			$result = $this->AppreciationDao->deleteAppreciation($main_id);
		return $result;			
	}
}
?>