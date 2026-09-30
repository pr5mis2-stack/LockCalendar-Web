<?php
import("class.controller.WWWRoot");
import("class.controller.ImageCon");
import("class.model.DataDao");

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
class DataCon extends WWWRoot {
		
	private $DataDao;
	private $ImageCon;
	private $param;

	/**
	 * 
	 * DataCon
	 * 
	 * @ClassName  : DataCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->DataDao 		= new DataDao();
		$this->ImageCon		= new Imagecon();
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
	public function getDataCnt($param=array())
	{
		$result = $this->DataDao->selectDataCnt($param);
		return $result;
	}
	
	public function getMainId($param=array())
	{
		$result = $this->DataDao->selectMainId($param);
		return $result;
	}
	
	/**
	 * 
	 * delData
	 * 
	 * @ClassName  : MainCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $main_id
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function delData($main_id=0)
	{
		$result = 0;	
		if (!empty($main_id))
			$result = $this->DataDao->deleteData($main_id);
		return $result;			
	}

}
?>