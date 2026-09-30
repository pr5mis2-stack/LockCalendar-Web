<?php
import("class.controller.WWWRoot");
import("class.controller.ImageCon");
import("class.model.GalleryDao");

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
class GalleryCon extends WWWRoot {
		
	private $GalleryDao;
	private $ImageCon;
	private $param;

	/**
	 * 
	 * GalleryCon
	 * 
	 * @ClassName  : GalleryCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->GalleryDao 		= new GalleryDao();
		$this->ImageCon		= new Imagecon();
	}

	/**
	 * 
	 * getGalleryCnt
	 * 
	 * @ClassName  : GalleryCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function getGalleryCnt($param=array())
	{
		$result = $this->GalleryDao->selectGalleryCnt($param);
		return $result;		
	}
	
	/**
	 * 
	 * getGalleryList
	 * 
	 * @ClassName  : GalleryCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 */
	public function getGalleryList($param=array(), $start_num='', $end_num='')
	{
		$result = $this->GalleryDao->selectGalleryList($param, $start_num, $end_num);
		return $result;			
	}
	
	/**
	 * 
	 * addGallery
	 * 
	 * @ClassName  : GalleryCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function addGallery($param=array())
	{
		$result = $this->GalleryDao->insertGallery($param);
		return $result;			
	}
	
	/**
	 * 
	 * setGallery
	 * 
	 * @ClassName  : GalleryCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function setGallery($param=array())
	{
		$result = 0;	
		if (isset($param['main_id']))
			$result = $this->GalleryDao->updateGallery($param);
		return $result;			
	}
	
	/**
	 * 
	 * delGallery
	 * 
	 * @ClassName  : GalleryCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $main_id
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function delGallery($main_id=0)
	{
		$result = 0;	
		if (!empty($main_id))
			$result = $this->GalleryDao->deleteGallery($main_id);
		return $result;			
	}
}
?>