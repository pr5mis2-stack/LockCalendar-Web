<?php
import("class.controller.WWWRoot");
import("class.controller.ImageCon");
import("class.model.ShopMultimediaDao");

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
class ShopMultimediaCon extends WWWRoot {
		
	private $ShopMultimediaDao;
	private $ImageCon;
	private $param;

	/**
	 * 
	 * ShopMultimediaCon
	 * 
	 * @ClassName  : ShopMultimediaCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->ShopMultimediaDao 		= new ShopMultimediaDao();
		$this->ImageCon		= new Imagecon();
	}

	/**
	 * 
	 * getShopMultimediaCnt
	 * 
	 * @ClassName  : ShopMultimediaCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function getShopMultimediaCnt($param=array())
	{
		$result = $this->ShopMultimediaDao->selectShopMultimediaCnt($param);
		return $result;		
	}
	
	/**
	 * 
	 * getShopMultimediaList
	 * 
	 * @ClassName  : ShopMultimediaCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 */
	public function getShopMultimediaList($param=array(), $start_num='', $end_num='')
	{
		$result = $this->ShopMultimediaDao->selectShopMultimediaList($param, $start_num, $end_num);
		return $result;			
	}

	
	/**
	 * 
	 * getShopVideoCnt
	 * 
	 * @ClassName  : ShopMultimediaCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2014. 1. 18.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function getShopVideoCnt($param=array())
	{
		$param['media_type'] = "3";
		$result = $this->ShopMultimediaDao->selectShopMultimediaCnt($param);
		return $result;
	}
	
	/**
	 * 
	 * getShopVideoList
	 * 
	 * @ClassName  : ShopMultimediaCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2014. 1. 18.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function getShopVideoList($param=array(), $start_num='', $end_num='')
	{
		$param['media_type'] = "3";
		$result = $this->ShopMultimediaDao->selectShopMultimediaList($param, $start_num, $end_num);
		return $result;
	}
	
	/**
	 * 
	 * addShopMultimedia
	 * 
	 * @ClassName  : ShopMultimediaCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function addShopMultimedia($param=array())
	{
		$result = $this->ShopMultimediaDao->insertShopMultimedia($param);
		return $result;			
	}
	
	/**
	 * 
	 * setShopMultimedia
	 * 
	 * @ClassName  : ShopMultimediaCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function setShopMultimedia($param=array())
	{
		$result = 0;	
		if (isset($param['media_id']) && !empty($param['media_id']))
			$result = $this->ShopMultimediaDao->updateShopMultimedia($param);
		return $result;			
	}
	
	/**
	 * 
	 * delShopMultimedia
	 * 
	 * @ClassName  : ShopMultimediaCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $media_id
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function delShopMultimedia($media_id=0)
	{
		$result = 0;	
		if (!empty($media_id))
			$result = $this->ShopMultimediaDao->deleteShopMultimedia($media_id);
		return $result;			
	}

	/**
	 * 
	 * delShopMultimediaByShopID
	 * 
	 * @ClassName  : ShopMultimediaCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $shop_id
	 * @return return_type
	 */
	public function delShopMultimediaByShopID($shop_id=0)
	{
		$result = 0;
		if (!empty($shop_id))
			$result = $this->ShopMultimediaDao->deleteShopMultimediaByShopID($shop_id);
		return $result;
	}
		
}
?>