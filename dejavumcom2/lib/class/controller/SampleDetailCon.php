<?php
import("class.controller.WWWRoot");
import("class.controller.ImageCon");
import("class.model.SampleDetailDao");

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
class SampleDetailCon extends WWWRoot {
		
	private $SampleDetailDao;
	private $ImageCon;
	private $param;

	/**
	 * 
	 * SampleDetailCon
	 * 
	 * @ClassName  : SampleDetailCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->SampleDetailDao 		= new SampleDetailDao();
		$this->ImageCon		= new Imagecon();
	}

	/**
	 * 
	 * getSampleDetailCnt
	 * 
	 * @ClassName  : SampleDetailCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function getSampleDetailCnt($param=array())
	{
		$result = $this->SampleDetailDao->selectSampleDetailCnt($param);
		return $result;		
	}
	
	/**
	 * 
	 * getSampleDetailList
	 * 
	 * @ClassName  : SampleDetailCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 */
	public function getSampleDetailList($param=array(), $start_num='', $end_num='')
	{
		$result = $this->SampleDetailDao->selectSampleDetailList($param, $start_num, $end_num);
		return $result;			
	}
	
	/**
	 * 
	 * addSampleDetail
	 * 
	 * @ClassName  : SampleDetailCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function addSampleDetail($param=array())
	{
		$result = $this->SampleDetailDao->insertSampleDetail($param);
		return $result;			
	}
	
	/**
	 * 
	 * setSampleDetail
	 * 
	 * @ClassName  : SampleDetailCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function setSampleDetail($param=array())
	{
		$result = 0;	
		if (isset($param['detail_id']) && !empty($param['detail_id']))
			$result = $this->SampleDetailDao->updateSampleDetail($param);
		return $result;			
	}
	
	/**
	 * 
	 * delSampleDetail
	 * 
	 * @ClassName  : SampleDetailCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $detail_id
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function delSampleDetail($detail_id=0)
	{
		$result = 0;	
		if (!empty($detail_id))
			$result = $this->SampleDetailDao->deleteSampleDetail($detail_id);
		return $result;			
	}
	
	/**
	 * 
	 * delSampleDetailBySampleID
	 * 
	 * @ClassName  : SampleDetailCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $sample_id
	 * @return return_type
	 */
	public function delSampleDetailBySampleID($sample_id=0)
	{
		$result = 0;
		if (!empty($sample_id))
			$result = $this->SampleDetailDao->deleteSampleDetailBySampleID($sample_id);
		return $result;
	}
}
?>