<?php
import("class.controller.WWWRoot");
import("class.controller.ImageCon");
import("class.model.AdvertisementDao");

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
class AdvertisementCon extends WWWRoot {
		
	private $AdvertisementDao;
	private $ImageCon;
	private $param;

	/**
	 * 
	 * AdvertisementCon
	 * 
	 * @ClassName  : AdvertisementCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->AdvertisementDao 	= new AdvertisementDao();
		$this->ImageCon				= new Imagecon();
	}

	public function getRandBanner($shop_id)
	{
		$result = $this->AdvertisementDao->selectRandBanner($shop_id);
		return $result;
	}
	
	/**
	 * 
	 * getAdvertisementCnt
	 * 
	 * @ClassName  : AdvertisementCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function getAdvertisementCnt($param=array())
	{
		$result = $this->AdvertisementDao->selectAdvertisementCnt($param);
		return $result;		
	}
	
	/**
	 * 
	 * getAdvertisementList
	 * 
	 * @ClassName  : AdvertisementCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 */
	public function getAdvertisementList($param=array(), $start_num='', $end_num='')
	{
		$result = $this->AdvertisementDao->selectAdvertisementList($param, $start_num, $end_num);
		return $result;			
	}
	
	/**
	 * 
	 * addAdvertisement
	 * 
	 * @ClassName  : AdvertisementCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function addAdvertisement($param=array())
	{
		$result = $this->AdvertisementDao->insertAdvertisement($param);
		return $result;			
	}
	
	/**
	 * 
	 * setAdvertisement
	 * 
	 * @ClassName  : AdvertisementCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function setAdvertisement($param=array())
	{
		$result = 0;	
		if (isset($param['adver_id']) && !empty($param['adver_id']))
			$result = $this->AdvertisementDao->updateAdvertisement($param);
		return $result;			
	}
	
	/**
	 * 
	 * delAdvertisement
	 * 
	 * @ClassName  : AdvertisementCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $adver_id
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function delAdvertisement($adver_id='')
	{
		$result = 0;	
		if (!empty($adver_id))
			$result = $this->AdvertisementDao->deleteAdvertisement($adver_id);
		return $result;			
	}
}
?>