<?php
import("class.controller.WWWRoot");
import("class.controller.ImageCon");
import("class.model.PromotionDao");
import("class.model.PromotionLogDao");

/**
 * 
 * 
 * @ClassName  :
 * @FileName   : file_name
 * @Package    : package_name
 * @Comment    : 
 * @Author     : suya
 * @Date       : 2018.10.28.
 */
class PromotionCon extends WWWRoot {
		
	private $PromotionDao;
	private $PromotionLogDao;
	private $ImageCon;
	private $param;

	/**
	 * 
	 * PromotionCon
	 * 
	 * @ClassName  : PromotionCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2018.10.28.
	 */
	public function __construct()
	{
		parent::__construct();
		
        $this->PromotionDao     = new PromotionDao();
        $this->PromotionLogDao  = new PromotionLogDao();
		$this->ImageCon         = new Imagecon();
	}

	/**
	 * 
	 * getPromotionCnt
	 * 
	 * @ClassName  : PromotionCon
	 * @Comment    : 등록된 프로모션 수량 조회
	 * @Author     : suya
	 * @Date       : 2018.10.28.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function getPromotionCnt($param=array())
	{
		$result = $this->PromotionDao->selectPromotionCnt($param);
		return $result;		
	}
	
	/**
	 * 
	 * getPromotionList
	 * 
	 * @ClassName  : PromotionCon
	 * @Comment    : 등록된 프로모션 목록 조회
	 * @Author     : suya
	 * @Date       : 2018.10.28.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 */
	public function getPromotionList($param=array(), $start_num='', $end_num='')
	{
		$result = $this->PromotionDao->selectPromotionList($param, $start_num, $end_num);
		return $result;			
	}

    	/**
	 * 
	 * getNonAddedShopList
	 * 
	 * @ClassName  : PromotionCon
	 * @Comment    : 프로모션 미등록 업체 목록 조회
	 * @Author     : suya
	 * @Date       : 2018.10.28.
	 */
	public function getNonAddedShopList()
	{
		$result = $this->PromotionDao->selectNonAddedShopList();
		return $result;			
    }
    
	/**
	 * 
	 * getPromotionLogCnt
	 * 
	 * @ClassName  : PromotionCon
	 * @Comment    : 등록된 프로모션 참여 수량
	 * @Author     : suya
	 * @Date       : 2018.10.28.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function getPromotionLogCnt($param=array())
	{
		$result = $this->PromotionLogDao->selectPromotionLogCnt($param);
		return $result;		
	}
	
	/**
	 * 
	 * getPromotionLogList
	 * 
	 * @ClassName  : PromotionCon
	 * @Comment    : 등록된 프로모션 참여 수량
	 * @Author     : suya
	 * @Date       : 2018.10.28.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 */
	public function getPromotionLogList($param=array(), $start_num='', $end_num='')
	{
		//new dBug($param);
		$result = $this->PromotionLogDao->selectPromotionLogList($param, $start_num, $end_num);
		return $result;			
	}

	public function getPromotionLogExcel($param=array())
	{
		//new dBug($param);
		$result = $this->PromotionLogDao->selectPromotionLogExcel($param);
		return $result;			
	}

	/**
	 * 
	 * addPromotion
	 * 
	 * @ClassName  : PromotionCon
	 * @Comment    : 프로모션 추가
	 * @Author     : suya
	 * @Date       : 2018.10.28.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function addPromotion($param=array())
	{
		$result = $this->PromotionDao->insertPromotion($param);
		return $result;			
	}
	
	/**
	 * 
	 * setPromotion
	 * 
	 * @ClassName  : PromotionCon
	 * @Comment    : 프로모션 수정
	 * @Author     : suya
	 * @Date       : 2018.10.28.
	 * @param unknown_type $param
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function setPromotion($param=array())
	{
		$result = 0;	
		if (isset($param['shop_id']) && !empty($param['shop_id']))
			$result = $this->PromotionDao->updatePromotion($param);
		return $result;			
	}
	
	/**
	 * 
	 * delPromotion
	 * 
	 * @ClassName  : PromotionCon
	 * @Comment    : 프로모션 삭제
	 * @Author     : suya
	 * @Date       : 2018.10.28.
	 * @param unknown_type $shop_id
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function delPromotion($shop_id=0)
	{
		$result = 0;	
		if (!empty($shop_id))
			$result = $this->PromotionDao->deletePromotion($shop_id);
		return $result;			
	}

	/**
	 * 
	 * isAddedPromotionLog
	 * 
	 * @ClassName  : PromotionCon
	 * @Comment    : 프로모션 참여로그 체크
	 * @Author     : suya
	 * @Date       : 2018.10.28.
	 * @param unknown_type $main_id
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function isAddedPromotionLog($main_id)
	{
		$result = 0;	
		if (!empty($main_id))	
		$result = $this->PromotionLogDao->isAddedPromotionLog($main_id);
		return $result;		
	}

	/**
	 * 
	 * addPromotionLog
	 * 
	 * @ClassName  : PromotionCon
	 * @Comment    : 프로모션 참여 추가
	 * @Author     : suya
	 * @Date       : 2018.10.28.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function addPromotionLog($param=array())
	{
		$result = $this->PromotionLogDao->insertPromotionLog($param);
		return $result;			
	}
}
?>