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
class DataDao {
	
	private $Dao;
	private $totalCnt;
	private $data_list;
	private $table_name;
	
	/**
	 * 
	 * DataDao
	 * 
	 * @ClassName  : DataDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 */
	public function __construct()
	{
		$this->Dao = new Dao;
		$this->Dao->transaction = false;
		$this->Dao->Connect();
		$this->table_name = "tb_main";
	}

	/**
	 * 
	 * selectDataCnt
	 * 
	 * @ClassName  : MainDao
	 * @Comment    : 등록된 초대장 수량 조회
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function selectDataCnt($param=array())
	{
		$query = sprintf("
					SELECT 
						COUNT(m.main_id)
					FROM %s m LEFT JOIN tb_shop sh ON sh.shop_id = m.shop_id
							  LEFT JOIN tb_sample sa ON sa.sample_id = m.sample_id
				", $this->table_name);
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
				
			if(!empty($param['main_id'])){
				$query .= $and . sprintf ("m.main_id = %d ", $param['main_id']);
				$and = " and ";
			}
			if((isset($param['interval']) && $param['interval'] != "")){
				$query .= $and . sprintf("m.show_date < DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -%s  MONTH), '%%Y-%%m-%%d') ", $param['interval']);
				$and = " and ";
			}
			// 샘플 타입 (B:돌잔치/S:고희연/W:웨딩)
			if(!empty($param['sample_type'])){
				$query .= $and . sprintf ("sa.sample_type = '%s' ", $this->Dao->escapeParam($param['sample_type']));
				$and = " and ";
			}
		}
		
		//new dBug($query);
		$this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();			
		return $this->totalCnt;		
	}

	public function selectMainId($param=array())
	{
		$query = sprintf("
					SELECT
						main_id
					FROM %s m LEFT JOIN tb_shop sh ON sh.shop_id = m.shop_id
							  LEFT JOIN tb_sample sa ON sa.sample_id = m.sample_id
				", $this->table_name);		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
				
			if(!empty($param['main_id'])){
				$query .= $and . sprintf ("m.main_id = %d ", $param['main_id']);
				$and = " and ";
			}
			if((isset($param['interval']) && $param['interval'] != "")){
				$query .= $and . sprintf("m.show_date < DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -%d  MONTH), '%%Y-%%m-%%d') ", $param['interval']);
				$and = " and ";
			}
			// 샘플 타입 (B:돌잔치/S:고희연/W:웨딩)
			if(!empty($param['sample_type'])){
				$query .= $and . sprintf ("sa.sample_type = '%s' ", $this->Dao->escapeParam($param['sample_type']));
				$and = " and ";
			}
		}
		
		$query .= sprintf ( " ORDER BY m.order_id ASC " );
		
		//new dBug($query);
		$this->Dao->executeQuery($query);
		
		$this->data_list = array();						// 코드수정 : 모든 While loop 진입전에 초기화 할것
		while( $Rows = $this->Dao->getFetchArray() ) {
			$this->data_list[] = $Rows;					// 코드수정 : $this->data_list[] = $Rows;
		}
		return $this->data_list;						// 코드수정 : $this->data_list;		
	}
	
	/**
	 * 
	 * deleteData
	 * 
	 * @ClassName  : MainDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $main_id
	 * @return return_type
	 */
	public function deleteData($main_id=0)
	{
		if ($main_id > 0)
		{
			$query = sprintf("DELETE FROM tb_invitation WHERE main_id = %d", $main_id);
			$result = $this->Dao->executeQuery($query);
			
			$query = sprintf("DELETE FROM tb_guestbook WHERE main_id = %d", $main_id);
			$result = $this->Dao->executeQuery($query);
			$query = sprintf("DELETE FROM tb_gallery_photo WHERE main_id = %d", $main_id);
			$result = $this->Dao->executeQuery($query);
			
			$query = sprintf("DELETE FROM tb_gallery WHERE main_id = %d", $main_id);
			$result = $this->Dao->executeQuery($query);
			
			$query = sprintf("DELETE FROM tb_appreciation WHERE main_id = %d", $main_id);
			$result = $this->Dao->executeQuery($query);
	
			$query = sprintf("DELETE FROM tb_main WHERE main_id = %d", $main_id);
			$result = $this->Dao->executeQuery($query);
		}
		return $result;
	}
}
?>