<?php
import("class.controller.WWWRoot");
import("class.controller.ImageCon");
import("class.model.ShopSampleDao");

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
class ShopSampleCon extends WWWRoot {
		
	private $ShopSampleDao;
	private $ImageCon;
	private $param;

	/**
	 * 
	 * ShopSampleCon
	 * 
	 * @ClassName  : ShopSampleCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->ShopSampleDao 	= new ShopSampleDao();
		$this->ImageCon			= new Imagecon();
	}

	/**
	 * 
	 * getShopSampleCnt
	 * 
	 * @ClassName  : ShopSampleCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function getShopSampleCnt($param=array())
	{
		$result = $this->ShopSampleDao->selectShopSampleCnt($param);
		return $result;		
	}
	
	/**
	 * 
	 * getShopSampleList
	 * 
	 * @ClassName  : ShopSampleCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 */
	public function getShopSampleList($param=array(), $start_num='', $end_num='')
	{
		$result = $this->ShopSampleDao->selectShopSampleList($param, $start_num, $end_num);
		return $result;			
	}
	
	/**
	 * 
	 * addShopSample
	 * 
	 * @ClassName  : ShopSampleCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function addShopSample($param=array())
	{
		$result = $this->ShopSampleDao->insertShopSample($param);
		return $result;			
	}
	
	/**
	 * 
	 * delShopSample
	 * 
	 * @ClassName  : ShopSampleCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $ShopSample_id
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function delShopSample($param=array())
	{
		$result = 0;	
		if (!empty($param['shop_id']) && !empty($param['sample_id']))
			$result = $this->ShopSampleDao->deleteShopSample($param);
		return $result;			
	}
}
?>