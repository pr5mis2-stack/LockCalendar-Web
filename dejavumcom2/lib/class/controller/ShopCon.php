<?php
import("class.controller.WWWRoot");
import("class.controller.ImageCon");
import("class.model.ShopDao");

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
class ShopCon extends WWWRoot {
		
	private $ShopDao;
	private $ImageCon;
	private $param;

	/**
	 * 
	 * ShopCon
	 * 
	 * @ClassName  : ShopCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->ShopDao 		= new ShopDao();
		$this->ImageCon		= new Imagecon();
	}

	/**
	 * 
	 * getShopCnt
	 * 
	 * @ClassName  : ShopCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function getShopCnt($param=array())
	{
		$result = $this->ShopDao->selectShopCnt($param);
		return $result;		
	}
	
	/**
	 * 
	 * getShopList
	 * 
	 * @ClassName  : ShopCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 */
	public function getShopList($param=array(), $start_num='', $end_num='')
	{
		$result = $this->ShopDao->selectShopList($param, $start_num, $end_num);
		return $result;			
	}
	
	/**
	 * 
	 * getParentShopCnt
	 * 
	 * @ClassName  : ShopCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 11. 3.
	 * @param unknown_type $param
	 * @return Ambigous <boolean, unknown>
	 * @return Ambigous <boolean, unknown>
	 */
	public function getParentShopCnt($param=array())
	{
		$result = $this->ShopDao->selectParentShopCnt($param);
		return $result;
	}
	
	/**
	 * 
	 * getParentShopList
	 * 
	 * @ClassName  : ShopCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 11. 3.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function getParentShopList($param=array(), $start_num='', $end_num='')
	{
		$result = $this->ShopDao->selectParentShopList($param, $start_num, $end_num);
		return $result;
	}
	
	/**
	 * 
	 * addShop
	 * 
	 * @ClassName  : ShopCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function addShop($param=array())
	{
		$result = $this->ShopDao->insertShop($param);
		return $result;			
	}
	
	/**
	 * 
	 * setShop
	 * 
	 * @ClassName  : ShopCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function setShop($param=array())
	{
		$result = 0;	
		if (isset($param['shop_id']) && !empty($param['shop_id']))
			$result = $this->ShopDao->updateShop($param);
		return $result;			
	}
	
	/**
	 * 
	 * delShop
	 * 
	 * @ClassName  : ShopCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $shop_id
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function delShop($shop_id='')
	{
		$result = 0;	
		if (!empty($shop_id))
			$result = $this->ShopDao->deleteShop($shop_id);
		return $result;			
	}
}
?>