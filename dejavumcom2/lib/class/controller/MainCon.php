<?php
import("class.controller.WWWRoot");
import("class.controller.ImageCon");
import("class.model.MainDao");

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
class MainCon extends WWWRoot {
		
	private $MainDao;
	private $ImageCon;
	private $param;

	/**
	 * 
	 * MainCon
	 * 
	 * @ClassName  : MainCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->MainDao 		= new MainDao();
		$this->ImageCon		= new Imagecon();
	}

	/**
	 * 
	 * getMainID
	 * 
	 * @ClassName  : MainCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 10. 20.
	 * @return return_type
	 */
	public function getMainID()
	{
		$result = $this->MainDao->selectMaxMainID();
		return $result;
	}
	
	/**
	 * 
	 * getMainCnt
	 * 
	 * @ClassName  : MainCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function getMainCnt($param=array())
	{
		$result = $this->MainDao->selectMainCnt($param);
		return $result;		
	}
	
	/**
	 * 
	 * getMainList
	 * 
	 * @ClassName  : MainCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 */
	public function getMainList($param=array(), $start_num='', $end_num='')
	{
		if (!empty($param) || !empty($start_num) || !empty($end_num))
  		$result = $this->MainDao->selectMainList($param, $start_num, $end_num);
		return $result;			
	}

	/**
	 *
	 * getFphCnt
	 *
	 * @ClassName  : MainCon
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function getFphCnt($param=array())
	{
		$result = $this->MainDao->selectFphCnt($param);
		return $result;
	}
	
	/**
	 *
	 * getFphList
	 *
	 * @ClassName  : MainCon
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 */
	public function getFphList($param=array(), $start_num='', $end_num='')
	{
		$result = $this->MainDao->selectFphList($param, $start_num, $end_num);
		return $result;
	}
	
	/**
	 *
	 * checkEmail
	 *
	 * @ClassName  : MainDao
	 * @Comment    : 등록된 이메일인지 체크
	 * @Author     : suya
	 * @Date       : 2013. 11. 9.
	 * @param unknown_type $email
	 * @param unknown_type $main_id
	 * @return return_type
	 */
	public function checkEmail($email='', $main_id=0)
	{
		$result = 99;
		if (!empty($email))
			$result = $this->MainDao->checkEmail($email, $main_id);
		return $result;
	}
	
	/**
	 * 
	 * addMain
	 * 
	 * @ClassName  : MainCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function addMain($param=array())
	{
		$result = $this->MainDao->insertMain($param);
		return $result;			
	}
	
	/**
	 * 
	 * setMain
	 * 
	 * @ClassName  : MainCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function setMain($param=array())
	{
		$result = 0;	
		if (isset($param['main_id']) && !empty($param['main_id']))
			$result = $this->MainDao->updateMain($param);
		return $result;			
	}
	
	/**
	 * 
	 * delMain
	 * 
	 * @ClassName  : MainCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $main_id
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function delMain($main_id=0)
	{
		$result = 0;	
		if (!empty($main_id))
			$result = $this->MainDao->deleteMain($main_id);
		return $result;			
	}

	/**
	 * 
	 * setCountMain
	 * 
	 * @ClassName  : MainCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 10. 29.
	 * @param unknown_type $main_id
	 * @return return_type
	 */
	public function setCountMain($main_id=0)
	{
		$result = 0;
		if (!empty($main_id))
			$result = $this->MainDao->upCountMain($main_id);
		return $result;
	}
	
	/**
	 * 
	 * delMainPhoto
	 * 
	 * @ClassName  : MainCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2014. 1. 7.
	 * @param unknown_type $main_id
	 * @return return_type
	 */
	public function delMainPhoto($main_id=0)
	{
		$result = 0;
		if (!empty($main_id))
			$result = $this->MainDao->deleteMainPhoto($main_id);
		return $result;
	}
}
?>