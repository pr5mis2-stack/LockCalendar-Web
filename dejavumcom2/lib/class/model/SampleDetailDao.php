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
class SampleDetailDao {
	
	private $Dao;
	private $totalCnt;
	private $data_list;
	private $table_name;
	
	/**
	 * 
	 * SampleDetailDao
	 * 
	 * @ClassName  : SampleDetailDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 */
	public function __construct()
	{
		$this->Dao = new Dao;
		$this->Dao->transaction = false;
		$this->Dao->Connect();
		$this->table_name = "tb_sample_detail";
	}
	
	/**
	 * 
	 * selectSampleDetailCnt
	 * 
	 * @ClassName  : SampleDetailDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function selectSampleDetailCnt($param=array())
	{
		$query = sprintf("SELECT COUNT(detail_id) FROM %s ", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
				
			if(!empty($param['detail_id'])){
				$query .= $and . sprintf ("detail_id = %d ", $param['detail_id']);
				$and = " and ";
			}
			if(!empty($param['sample_id'])){
				$query .= $and . sprintf ("sample_id = %d ", $param['sample_id']);
				$and = " and ";
			}
			if(!empty($param['part'])){
				$query .= $and . sprintf ("part = '%s' ", $this->Dao->escapeParam($param['part']));
				$and = " and ";
			}
			if(!empty($param['detail_name'])){
				$query .= $and . sprintf ("detail_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['detail_name']));
				$and = " and ";
			}
		}
			
		$this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();			
		return $this->totalCnt;		
	}
	
	/**
	 * 
	 * selectSampleDetailList
	 * 
	 * @ClassName  : SampleDetailDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function selectSampleDetailList($param=array(), $start_num='', $end_num='')
	{
		$query = sprintf("SELECT *,
							CASE 
								WHEN part = 'M' THEN '메인'
								WHEN part = 'I' THEN '초대글' 
								WHEN part = 'G' THEN '갤러리' 
								WHEN part = 'B' THEN '덕담게시판' 
								WHEN part = 'Q' THEN '퀵메뉴' 
								WHEN part = 'A' THEN '감사장' 
								ELSE part
							END AS part_name
						FROM %s ", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
		
			if(!empty($param['detail_id'])){
				$query .= $and . sprintf ("detail_id = %d ", $param['detail_id']);
				$and = " and ";
			}
			if(!empty($param['sample_id'])){
				$query .= $and . sprintf ("sample_id = %d ", $param['sample_id']);
				$and = " and ";
			}
			if(!empty($param['part'])){
				$query .= $and . sprintf ("part = '%s' ", $this->Dao->escapeParam($param['part']));
				$and = " and ";
			}
			if(!empty($param['detail_name'])){
				$query .= $and . sprintf ("detail_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['detail_name']));
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
				$query .= sprintf ( " ORDER BY detail_id DESC " );
				break;
			case "20" :		// 제목순
				$query .= sprintf ( " ORDER BY detail_name ASC " );
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
		//echo $query;
		$this->data_list = array();						// 코드수정 : 모든 While loop 진입전에 초기화 할것
		while( $Rows = $this->Dao->getFetchArray() ) {
			$this->data_list[] = $Rows;					// 코드수정 : $this->data_list[] = $Rows;
		}
		return $this->data_list;						// 코드수정 : $this->data_list;
		
	}
	
	/**
	 * 
	 * insertSampleDetail
	 * 
	 * @ClassName  : SampleDetailDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function insertSampleDetail($param=array())
	{
		$query = sprintf("
				INSERT INTO %s (
					sample_id	
					, part
					, detail_name
					, detail_html
					, img_zipfile
					, reg_date
					, edt_date
				)
				VALUES( %d, '%s', '%s', '%s','%s',
				date_format(now(), '%%Y%%m%%d%%H%%i%%s'), date_format(now(), '%%Y%%m%%d%%H%%i%%s')
				) ",
				$this->table_name,
				$param['sample_id'],
				$this->Dao->escapeParam($param['part']),
				$this->Dao->escapeParam($param['detail_name']),
				$this->Dao->escapeParam($param['detail_html']),
				$this->Dao->escapeParam($param['img_zipfile'])
		);
		
		$result = $this->Dao->executeQuery($query);
		$notice_id = $this->Dao->getLastInsertID();
		
		return $notice_id;		
	}
	
	/**
	 * 
	 * updateSampleDetail
	 * 
	 * @ClassName  : SampleDetailDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function updateSampleDetail($param=array())
	{
		$upquery = "";
		
		$upquery .= sprintf(", detail_html = '%s' ", $this->Dao->escapeParam($param['detail_html']));
		if (!empty($param['sample_id']))
			$upquery .= sprintf(", sample_id = %d ", $param['sample_id']);
		if (!empty($param['part']))
			$upquery .= sprintf(", part = '%s' ", $this->Dao->escapeParam($param['part']));
		if (!empty($param['detail_name']))
			$upquery .= sprintf(", detail_name = '%s' ", $this->Dao->escapeParam($param['detail_name']));
		if (!empty($param['img_zipfile']))
			$upquery .= sprintf(", img_zipfile = '%s' ", $this->Dao->escapeParam($param['img_zipfile']));
		
		$query = sprintf("
				UPDATE %s 
				SET edt_date = date_format(now(), '%%Y%%m%%d%%H%%i%%s')
					%s
				WHERE detail_id = %d", $this->table_name, $upquery, $param['detail_id']);
		//new dBug($query);
		$result = $this->Dao->executeQuery($query);
		
		return $result;
		
	}
	
	/**
	 * 
	 * deleteSampleDetail
	 * 
	 * @ClassName  : SampleDetailDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $detail_id
	 * @return return_type
	 */
	public function deleteSampleDetail($detail_id=0)
	{
		$query = sprintf("DELETE FROM %s WHERE detail_id = %d", $this->table_name, $detail_id);
		
		$result = $this->Dao->executeQuery($query);
		return $result;
	}
	
	/**
	 * 
	 * deleteSampleDetailBySampleID
	 * 
	 * @ClassName  : SampleDetailDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 31.
	 * @param unknown_type $sample_id
	 * @return return_type
	 */
	public function deleteSampleDetailBySampleID($sample_id=0)
	{
		$query = sprintf("DELETE FROM %s WHERE sample_id = %d", $this->table_name, $sample_id);
		
		$result = $this->Dao->executeQuery($query);
		return $result;		
	}
}
?>