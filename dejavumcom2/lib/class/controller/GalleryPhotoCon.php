<?php
import("class.controller.WWWRoot");
import("class.controller.ImageCon");
import("class.model.GalleryPhotoDao");

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
class GalleryPhotoCon extends WWWRoot {
		
	private $GalleryPhotoDao;
	private $ImageCon;
	private $param;

	/**
	 * 
	 * GalleryPhotoCon
	 * 
	 * @ClassName  : GalleryPhotoCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->GalleryPhotoDao 		= new GalleryPhotoDao();
		$this->ImageCon		= new Imagecon();
	}

	/**
	 * 
	 * getGalleryPhotoCnt
	 * 
	 * @ClassName  : GalleryPhotoCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function getGalleryPhotoCnt($param=array())
	{
		$result = $this->GalleryPhotoDao->selectGalleryPhotoCnt($param);
		return $result;		
	}
	
	/**
	 * 
	 * getGalleryPhotoList
	 * 
	 * @ClassName  : GalleryPhotoCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 */
	public function getGalleryPhotoList($param=array(), $start_num='', $end_num='')
	{
		$result = $this->GalleryPhotoDao->selectGalleryPhotoList($param, $start_num, $end_num);
		return $result;			
	}
	
	/**
	 * 
	 * addGalleryPhoto
	 * 
	 * @ClassName  : GalleryPhotoCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function addGalleryPhoto($param=array())
	{
		$result = $this->GalleryPhotoDao->insertGalleryPhoto($param);
		return $result;			
	}
	
	/**
	 * 
	 * setGalleryPhoto
	 * 
	 * @ClassName  : GalleryPhotoCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function setGalleryPhoto($param=array())
	{
		$result = 0;	
		if (isset($param['photo_id']))
			$result = $this->GalleryPhotoDao->updateGalleryPhoto($param);
		return $result;			
	}
	
	/**
	 * 
	 * delGalleryPhoto
	 * 
	 * @ClassName  : GalleryPhotoCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $main_id
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function delGalleryPhoto($photo_id=0)
	{
		$result = 0;	
		if (!empty($photo_id))
			$result = $this->GalleryPhotoDao->deleteGalleryPhoto($photo_id);
		return $result;			
	}
	
	/**
	 * 
	 * delGalleryPhotoByMainID
	 * 
	 * @ClassName  : GalleryPhotoCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $main_id
	 * @return return_type
	 */
	public function delGalleryPhotoByMainID($main_id=0)
	{
		$result = 0;
		if (!empty($main_id))
			$result = $this->GalleryPhotoDao->deleteGalleryPhotoByMainID($main_id);
		return $result;
	}
	
	/**
	 * 
	 * deleteGalleryPhotoByOrderNo
	 * 
	 * @ClassName  : GalleryPhotoCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 11. 21.
	 * @param unknown_type $main_id
	 * @param unknown_type $order_no
	 * @return return_type
	 */
	public function deleteGalleryPhotoByOrderNo($main_id=0, $order_no=0)
	{
		$result = 0;
		if (!empty($main_id) && !empty($order_no))
			$result = $this->GalleryPhotoDao->deleteGalleryPhotoByOrderNo($main_id, $order_no);
		return $result;
	}
	
	
}
?>