<?php
import("class.controller.WWWRoot");
import("class.controller.ImageCon");
import("class.model.Text2ImgDao");

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
class Text2ImgCon extends WWWRoot {
		
	private $Text2ImgDao;
	private $ImageCon;
	private $param;

	/**
	 * 
	 * Text2ImgCon
	 * 
	 * @ClassName  : Text2ImgCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->Text2ImgDao 		= new Text2ImgDao();
		$this->ImageCon		= new Imagecon();
	}

	/**
	 * 
	 * getLastImgId
	 * 
	 * @ClassName  : Text2ImgCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 9. 23.
	 * @return return_type
	 */
	public function getLastImgId()
	{
		$result = $this->Text2ImgDao->getLastImgId();
		return $result;
	}
	
	/**
	 * 
	 * getText2ImgCnt
	 * 
	 * @ClassName  : Text2ImgCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function getText2ImgCnt($param=array())
	{
		$result = $this->Text2ImgDao->selectText2ImgCnt($param);
		return $result;		
	}
	
	/**
	 * 
	 * getText2ImgList
	 * 
	 * @ClassName  : Text2ImgCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 */
	public function getText2ImgList($param=array(), $start_num='', $end_num='')
	{
		$result = $this->Text2ImgDao->selectText2ImgList($param, $start_num, $end_num);
		return $result;			
	}
	
	/**
	 * 
	 * addText2Img
	 * 
	 * @ClassName  : Text2ImgCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function addText2Img($param=array())
	{
		$result = $this->Text2ImgDao->insertText2Img($param);
		return $result;			
	}
	
	/**
	 * 
	 * delText2Img
	 * 
	 * @ClassName  : Text2ImgCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $Text2Img_id
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function delText2Img($main_id='')
	{
		$result = 0;	
		if (!empty($main_id))
			$result = $this->Text2ImgDao->deleteText2Img($main_id);
		return $result;			
	}
}
?>