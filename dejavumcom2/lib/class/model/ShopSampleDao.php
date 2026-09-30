<?php
import("php.database.DaoClass");

/**
 * 
 * 
 * @ClassName  :
 * @FileName   : file_name
 * @Package    : package_name
 * @Comment    : 
 * @Author     : suya
 * @Date       : 2013. 7. 29.
 */
class ShopSampleDao {
	
	private $Dao;
	private $totalCnt;
	private $data_list;
	private $table_name;
	
	/**
	 * 
	 * ShopSampleDao
	 * 
	 * @ClassName  : ShopSampleDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 */
	public function __construct()
	{
		$this->Dao = new Dao;
		$this->Dao->transaction = false;
		$this->Dao->Connect();
		$this->table_name = "tb_shop_sample";
	}
	
	/**
	 * 
	 * selectShopSampleCnt
	 * 
	 * @ClassName  : ShopSampleDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function selectShopSampleCnt($param=array())
	{
		$query = sprintf("
				SELECT 
					COUNT(S.sample_id) 
				FROM %s SS
				LEFT JOIN tb_sample S 
				ON S.sample_id = SS.sample_id", $this->table_name);
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
				
			if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("SS.shop_id = %d ", $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['sample_id'])){
				$query .= $and . sprintf ("SS.sample_id = %d ", $param['sample_id']);
				$and = " and ";
			}
			if((isset($param['is_use']) && $param['is_use'] != "")){
				$query .= $and . sprintf ("S.is_use = '%s' ", $this->Dao->escapeParam($param['is_use']));
				$and = " and ";
			}
			if((isset($param['sample_type']) && $param['sample_type'] != "")){
				$query .= $and . sprintf ("S.sample_type = '%s' ", $this->Dao->escapeParam($param['sample_type']));
				$and = " and ";
			}			
		}
			
		$this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();			
		return $this->totalCnt;		
	}
	
	/**
	 * 
	 * selectShopSampleList
	 * 
	 * @ClassName  : ShopSampleDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function selectShopSampleList($param=array(), $start_num='', $end_num='')
	{
		$query = sprintf("
				SELECT
					SS.shop_id 
					, S.sample_id
					, S.sample_name
					, CASE 
				    	WHEN S.sample_type = 'B' THEN '돌잔치'
				    	WHEN S.sample_type = 'W' THEN '웨딩'
				    	WHEN S.sample_type = 'S' THEN '고희연'
				    END as sample_type_name
					, SS.reg_date
				FROM %s SS
				LEFT JOIN tb_sample S
					ON S.sample_id = SS.sample_id", $this->table_name);
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
		
			if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("SS.shop_id = %d ", $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['sample_id'])){
				$query .= $and . sprintf ("SS.sample_id = %d ", $param['sample_id']);
				$and = " and ";
			}
			if((isset($param['is_use']) && $param['is_use'] != "")){
				$query .= $and . sprintf ("S.is_use = '%s' ", $this->Dao->escapeParam($param['is_use']));
				$and = " and ";
			}
			if((isset($param['sample_type']) && $param['sample_type'] != "")){
				$query .= $and . sprintf ("S.sample_type = '%s' ", $this->Dao->escapeParam($param['sample_type']));
				$and = " and ";
			}
		}

		/**
		 * 정렬 기준 필드와 오름차순/내림차순 지정
		 */
		//echo "aaa =".$param['work_type'];
		
		switch(isset($param['order_by']) ? $param['order_by'] : '')
		{
			case "10" :		// 등록순 (최근 등록)
				$query .= sprintf ( " ORDER BY SS.reg_date DESC " );
				break;
			case "20" :
				$query .= sprintf ( " ORDER BY S.sample_name ASC " );
				break;
			default :
				$query .= sprintf ( " ORDER BY SS.reg_date DESC " );
				break;
		}
		
		if($end_num != ''){
			$start_num = empty($start_num)? 0:$start_num;
			$query.= sprintf(" LIMIT %d, %d", $start_num, $end_num);
		}
		
		$this->Dao->executeQuery($query);

		$this->data_list = array();						// 코드수정 : 모든 While loop 진입전에 초기화 할것
		while( $Rows = $this->Dao->getFetchArray() ) {
			$this->data_list[] = $Rows;					// 코드수정 : $this->data_list[] = $Rows;
		}
		return $this->data_list;						// 코드수정 : $this->data_list;
		
	}
	
	/**
	 * 
	 * insertShopSample
	 * 
	 * @ClassName  : ShopSampleDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function insertShopSample($param=array())
	{
		$query = sprintf("
				INSERT INTO %s (
					shop_id
					, sample_id
					, reg_date
				)
				VALUES( %d, %d, 
				date_format(now(), '%%Y%%m%%d%%H%%i%%s')
				) ",
				$this->table_name,
				$param['shop_id'],
				$param['sample_id']
		);
		//new dBug($query);
		//exit;
		$result = $this->Dao->executeQuery($query);
		
		return $result;		
	}
	
	/**
	 * 
	 * deleteShopSample
	 * 
	 * @ClassName  : ShopSampleDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 31.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function deleteShopSample($param=array())
	{
		$query = sprintf("DELETE FROM %s WHERE shop_id = %d AND sample_id = %d", $this->table_name, $param['shop_id'], $param['sample_id']);
		
		$result = $this->Dao->executeQuery($query);
		return $result;
		
	}
	
	/**
	 * 
	 * deleteShopSampleByShopID
	 * 
	 * @ClassName  : ShopSampleDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 31.
	 * @param unknown_type $shop_id
	 * @return return_type
	 */
	public function deleteShopSampleByShopID($shop_id=0)
	{
		$query = sprintf("DELETE FROM %s WHERE shop_id = %d", $this->table_name, $shop_id);
		
		$result = $this->Dao->executeQuery($query);
		return $result;
	}
	
	/**
	 * 
	 * deleteShopSampleBySampleID
	 * 
	 * @ClassName  : ShopSampleDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 31.
	 * @param unknown_type $sample_id
	 * @return return_type
	 */
	public function deleteShopSampleBySampleID($sample_id=0)
	{
		$query = sprintf("DELETE FROM %s WHERE sample_id = %d", $this->table_name, $sample_id);
	
		$result = $this->Dao->executeQuery($query);
		return $result;
	}
}
?>