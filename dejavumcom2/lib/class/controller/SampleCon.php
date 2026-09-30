<?php
import("class.controller.WWWRoot");
import("class.controller.ImageCon");
import("class.model.SampleDao");

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
class SampleCon extends WWWRoot {
		
	private $SampleDao;
	private $ImageCon;
	private $param;

	/**
	 * 
	 * SampleCon
	 * 
	 * @ClassName  : SampleCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->SampleDao 		= new SampleDao();
		$this->ImageCon		= new Imagecon();
	}

	/**
	 * 
	 * getSampleCnt
	 * 
	 * @ClassName  : SampleCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function getSampleCnt($param=array())
	{
		$result = $this->SampleDao->selectSampleCnt($param);
		return $result;		
	}
	
	/**
	 * 
	 * getSampleList
	 * 
	 * @ClassName  : SampleCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 */
	public function getSampleList($param=array(), $start_num='', $end_num='')
	{
		$result = $this->SampleDao->selectSampleList($param, $start_num, $end_num);
		return $result;			
	}
	
	/**
	 * 
	 * addSample
	 * 
	 * @ClassName  : SampleCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function addSample($param=array())
	{
		$result = $this->SampleDao->insertSample($param);
		return $result;			
	}
	
	/**
	 * 
	 * setSample
	 * 
	 * @ClassName  : SampleCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function setSample($param=array())
	{
		$result = 0;	
		if (isset($param['sample_id']) && !empty($param['sample_id']))
			$result = $this->SampleDao->updateSample($param);
		return $result;			
	}
	
	/**
	 * 
	 * delSample
	 * 
	 * @ClassName  : SampleCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $sample_id
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function delSample($sample_id='')
	{
		$result = 0;	
		if (!empty($sample_id))
			$result = $this->SampleDao->deleteSample($sample_id);
		return $result;			
	}
}
?>