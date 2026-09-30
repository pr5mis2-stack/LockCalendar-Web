<?php
import("class.controller.WWWRoot");
import("class.model.Photo2GDao");

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
class Photo2GCon extends WWWRoot {
		
	private $Photo2GDao;
	private $param;

	/**
	 * 
	 * Photo2GCon
	 * 
	 * @ClassName  : Photo2GCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->Photo2GDao 		= new Photo2GDao();
	}

	/**
	 * 
	 * setPhoto2G
	 * 
	 * @ClassName  : Photo2GCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function setPhoto2G($param=array())
	{
		$result = 0;	
		if (isset($param['main_id']))
		{
			if ($this->Photo2GDao->selectPhoto2GCnt($param['main_id']) > 0)
				$result = $this->Photo2GDao->updatePhoto2G($param);
			else
				$result = $this->Photo2GDao->insertPhoto2G($param);
		}
		return $result;			
	}
}
?>