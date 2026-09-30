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
class ManagerDao {
	
	private $Dao;
	private $totalCnt;
	private $data_list;
	private $table_name;
	
	/**
	 * 
	 * ManagerDao
	 * 
	 * @ClassName  : ManagerDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 */
	public function __construct()
	{
		$this->Dao = new Dao;
		$this->Dao->transaction = false;
		$this->Dao->Connect();
		$this->table_name = "tb_manager";
	}
	
	/**
	 * 
	 * selectManagerCnt
	 * 
	 * @ClassName  : ManagerDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function selectManagerCnt($param=array())
	{
		$query = sprintf("SELECT COUNT(manager_id) FROM %s ", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
				
			if(!empty($param['manager_id'])){
				$query .= $and . sprintf ("manager_id = '%s' ", $this->Dao->escapeParam($param['manager_id']));
				$and = " and ";
			}
			if(!empty($param['passwd'])){
				$query .= $and . sprintf ("passwd = '%s' ", $this->Dao->escapeParam($param['passwd']));
				$and = " and ";
			}
			if(!empty($param['manager_name'])){
				$query .= $and . sprintf ("manager_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['manager_name']));
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
			if((isset($param['is_use']) && $param['is_use'] != "")){
				$query .= $and . sprintf ("is_use = %d ", $param['is_use']);
				$and = " and ";
			}
		}
			
		$this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();			
		return $this->totalCnt;		
	}
	
	/**
	 * 
	 * selectManagerList
	 * 
	 * @ClassName  : ManagerDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function selectManagerList($param=array(), $start_num='', $end_num='')
	{
		$query = sprintf("
				SELECT 
					*
				FROM %s ", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
		
			if(!empty($param['manager_id'])){
				$query .= $and . sprintf ("manager_id = '%s' ", $this->Dao->escapeParam($param['manager_id']));
				$and = " and ";
			}
			if(!empty($param['passwd'])){
				$query .= $and . sprintf ("passwd = '%s' ", $this->Dao->escapeParam($param['passwd']));
				$and = " and ";
			}
			if(!empty($param['manager_name'])){
				$query .= $and . sprintf ("manager_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['manager_name']));
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
			if((isset($param['is_use']) && $param['is_use'] != "")){
				$query .= $and . sprintf ("is_use = %d ", $param['is_use']);
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
				$query .= sprintf ( " ORDER BY reg_date DESC " );
				break;
			case "20" :		// 제목순
				$query .= sprintf ( " ORDER BY manager_name ASC " );
				break;
		
			default :
				$query .= sprintf ( " ORDER BY manager_id DESC " );
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
	 * insertManager
	 * 
	 * @ClassName  : ManagerDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function insertManager($param=array())
	{
		$query = sprintf("
				INSERT INTO %s (
					manager_id
					, passwd
					, manager_name
					, is_use	
					, reg_date
					, edt_date
				)
				VALUES( '%s', '%s', '%s', %d, date_format(now(), '%%Y%%m%%d%%H%%i%%s'), date_format(now(), '%%Y%%m%%d%%H%%i%%s')
				) ",
				$this->table_name,
				$this->Dao->escapeParam($param['manager_id']),
				$this->Dao->escapeParam($param['passwd']),
				$this->Dao->escapeParam($param['manager_name']),
				$param['is_use']
		);
		
		$result = $this->Dao->executeQuery($query);
		//$notice_id = $this->Dao->getLastInsertID();
		//new dBug($query);
		return $result;		
	}
	
	/**
	 * 
	 * updateManager
	 * 
	 * @ClassName  : ManagerDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function updateManager($param=array())
	{
		$upquery = "";
		
		if (!empty($param['passwd']))
			$upquery .= sprintf(", passwd = '%s' ", $this->Dao->escapeParam($param['passwd']));
		if (!empty($param['manager_name']))
			$upquery .= sprintf(", manager_name = '%s' ", $this->Dao->escapeParam($param['manager_name']));
		if (isset($param['is_use']) && $param['is_use'] != "")
			$upquery .= sprintf(", is_use = %d ", $param['is_use']);
				
		$query = sprintf("
				UPDATE %s 
				SET edt_date = date_format(now(), '%%Y%%m%%d%%H%%i%%s')
					%s
				WHERE manager_id = '%s'", $this->table_name, $upquery, $this->Dao->escapeParam($param['manager_id']));

		$result = $this->Dao->executeQuery($query);
		
		return $result;
		
	}
	
	/**
	 * 
	 * deleteManager
	 * 
	 * @ClassName  : ManagerDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $Manager_id
	 * @return return_type
	 */
	public function deleteManager($manager_id='')
	{
		$query = sprintf("DELETE FROM %s WHERE manager_id = '%s'", $this->table_name, $this->Dao->escapeParam($manager_id));
		
		$result = $this->Dao->executeQuery($query);
		return $result;
	}
}
?>