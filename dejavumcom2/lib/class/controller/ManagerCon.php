<?php
import("class.controller.WWWRoot");
import("class.controller.ImageCon");
import("class.model.ManagerDao");

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
class ManagerCon extends WWWRoot {
		
	private $ManagerDao;
	private $ImageCon;
	private $param;

	/**
	 * 
	 * ManagerCon
	 * 
	 * @ClassName  : ManagerCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->ManagerDao 		= new ManagerDao();
		$this->ImageCon		= new Imagecon();
	}

	/**
	 * 
	 * getManagerCnt
	 * 
	 * @ClassName  : ManagerCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function getManagerCnt($param=array())
	{
		$result = $this->ManagerDao->selectManagerCnt($param);
		return $result;		
	}
	
	/**
	 * 
	 * getManagerList
	 * 
	 * @ClassName  : ManagerCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 */
	public function getManagerList($param=array(), $start_num='', $end_num='')
	{
		$result = $this->ManagerDao->selectManagerList($param, $start_num, $end_num);
		return $result;			
	}
	
	/**
	 * 
	 * addManager
	 * 
	 * @ClassName  : ManagerCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function addManager($param=array())
	{
		$result = $this->ManagerDao->insertManager($param);
		return $result;			
	}
	
	/**
	 * 
	 * setManager
	 * 
	 * @ClassName  : ManagerCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function setManager($param=array())
	{
		$result = 0;	
		if (isset($param['manager_id']) && !empty($param['manager_id']))
			$result = $this->ManagerDao->updateManager($param);
		return $result;			
	}
	
	/**
	 * 
	 * delManager
	 * 
	 * @ClassName  : ManagerCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $Manager_id
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function delManager($manager_id='')
	{
		$result = 0;	
		if (!empty($manager_id))
			$result = $this->ManagerDao->deleteManager($manager_id);
		return $result;			
	}
}
?>