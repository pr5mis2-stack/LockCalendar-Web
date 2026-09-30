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
class SampleDao {
	
	private $Dao;
	private $totalCnt;
	private $data_list;
	private $table_name;
	
	/**
	 * 
	 * SampleDao
	 * 
	 * @ClassName  : SampleDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 */
	public function __construct()
	{
		$this->Dao = new Dao;
		$this->Dao->transaction = false;
		$this->Dao->Connect();
		$this->table_name = "tb_sample";
	}
	
	/**
	 * 
	 * selectSampleCnt
	 * 
	 * @ClassName  : SampleDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function selectSampleCnt($param=array())
	{
		$query = sprintf("SELECT COUNT(sample_id) FROM %s ", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
				
			if(!empty($param['sample_id'])){
				$query .= $and . sprintf ("sample_id = %d ", $param['sample_id']);
				$and = " and ";
			}
			if(!empty($param['sample_name'])){
				$query .= $and . sprintf ("sample_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['sample_name']));
				$and = " and ";
			}
			if((isset($param['is_use']) && $param['is_use'] != "")){
				$query .= $and . sprintf ("is_use = '%s' ", $this->Dao->escapeParam($param['is_use']));
				$and = " and ";
			}
			if(!empty($param['st_date']) && !empty($param['ed_date'])){
				$query .= $and . sprintf("reg_date BETWEEN  DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['st_date']), $this->Dao->escapeParam($param['ed_date']) );
				$and = " and ";
			}
			if(!empty($param['reg_date'])){
				$query .= $and . sprintf("reg_date BETWEEN DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['reg_date']), $this->Dao->escapeParam($param['reg_date']) );
				$and = " and ";
			}
			if((isset($param['sample_type']) && $param['sample_type'] != "")){
				$query .= $and . sprintf ("sample_type = '%s' ", $this->Dao->escapeParam($param['sample_type']));
				$and = " and ";
			}
		}
			
		$this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();			
		return $this->totalCnt;		
	}
	
	/**
	 * 
	 * selectSampleList
	 * 
	 * @ClassName  : SampleDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function selectSampleList($param=array(), $start_num='', $end_num='')
	{
		$query = sprintf("
				SELECT 
					* 
				, CASE 
			    	WHEN sample_type = 'B' THEN '돌잔치'
			    	WHEN sample_type = 'W' THEN '웨딩'
			    	WHEN sample_type = 'S' THEN '고희연'
			    END as sample_type_name
				FROM %s ", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
		
			if(!empty($param['sample_id'])){
				$query .= $and . sprintf ("sample_id = %d ", $param['sample_id']);
				$and = " and ";
			}
			if(!empty($param['sample_name'])){
				$query .= $and . sprintf ("sample_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['sample_name']));
				$and = " and ";
			}
			if((isset($param['is_use']) && $param['is_use'] != "")){
				$query .= $and . sprintf ("is_use = '%s' ", $this->Dao->escapeParam($param['is_use']));
				$and = " and ";
			}
			if(!empty($param['st_date']) && !empty($param['ed_date'])){
				$query .= $and . sprintf("reg_date BETWEEN  DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['st_date']), $this->Dao->escapeParam($param['ed_date']) );
				$and = " and ";
			}
			if(!empty($param['reg_date'])){
				$query .= $and . sprintf("reg_date BETWEEN DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['reg_date']), $this->Dao->escapeParam($param['reg_date']) );
				$and = " and ";
			}
			if((isset($param['sample_type']) && $param['sample_type'] != "")){
				$query .= $and . sprintf ("sample_type = '%s' ", $this->Dao->escapeParam($param['sample_type']));
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
				$query .= sprintf ( " ORDER BY sample_id DESC " );
				break;
			case "20" :		// 제목순
				$query .= sprintf ( " ORDER BY sample_name ASC " );
				break;
		
			default :
				$query .= sprintf ( " ORDER BY reg_date DESC " );
				break;
		}
		
		if($end_num != ''){
			$start_num = empty($start_num)? 0:$start_num;
			$query.= sprintf(" LIMIT %d, %d", $start_num, $end_num);
		}
		
		$this->Dao->executeQuery($query);
		//new dBug($query);
		$this->data_list = array();						// 코드수정 : 모든 While loop 진입전에 초기화 할것
		while( $Rows = $this->Dao->getFetchArray() ) {
			$this->data_list[] = $Rows;					// 코드수정 : $this->data_list[] = $Rows;
		}
		return $this->data_list;						// 코드수정 : $this->data_list;
		
	}
	
	/**
	 * 
	 * insertSample
	 * 
	 * @ClassName  : SampleDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function insertSample($param=array())
	{
		$query = sprintf("
				INSERT INTO %s (
					sample_name
					, is_use
					, sample_type
					, reg_date
					, edt_date
				)
				VALUES( '%s', %d, '%s',
				date_format(now(), '%%Y%%m%%d%%H%%i%%s'), date_format(now(), '%%Y%%m%%d%%H%%i%%s')
				) ",
				$this->table_name,
				$this->Dao->escapeParam($param['sample_name']),
				$param['is_use'],
				$param['sample_type']
		);
		
		$result = $this->Dao->executeQuery($query);
		$notice_id = $this->Dao->getLastInsertID();
		
		return $notice_id;		
	}
	
	/**
	 * 
	 * updateSample
	 * 
	 * @ClassName  : SampleDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function updateSample($param=array())
	{
		$upquery = "";
		
		if (!empty($param['sample_name']))
			$upquery .= sprintf(", sample_name = '%s' ", $this->Dao->escapeParam($param['sample_name']));
		if (isset($param['is_use']) && $param['is_use'] != "")
			$upquery .= sprintf(", is_use = %d ", $param['is_use']);
		if (!empty($param['sample_type']))
			$upquery .= sprintf(", sample_type = '%s' ", $this->Dao->escapeParam($param['sample_type']));
		
		$query = sprintf("
				UPDATE %s 
				SET edt_date = date_format(now(), '%%Y%%m%%d%%H%%i%%s')
					%s
				WHERE sample_id = %d", $this->table_name, $upquery, $param['sample_id']);

		$result = $this->Dao->executeQuery($query);
		
		return $result;
		
	}
	
	/**
	 * 
	 * deleteSample
	 * 
	 * @ClassName  : SampleDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $sample_id
	 * @return return_type
	 */
	public function deleteSample($sample_id=0)
	{
		$query = sprintf("DELETE FROM %s WHERE sample_id = %d", $this->table_name, $sample_id);
		
		$result = $this->Dao->executeQuery($query);
		return $result;
	}
}
?>