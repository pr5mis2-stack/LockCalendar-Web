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
class GuestbookDao {
	
	private $Dao;
	private $totalCnt;
	private $data_list;
	private $table_name;
	
	/**
	 * 
	 * GuestbookDao
	 * 
	 * @ClassName  : GuestbookDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 */
	public function __construct()
	{
		$this->Dao = new Dao;
		$this->Dao->transaction = false;
		$this->Dao->Connect();
		$this->table_name = "tb_guestbook";
	}
	
	/**
	 * 
	 * selectGuestbookCnt
	 * 
	 * @ClassName  : GuestbookDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function selectGuestbookCnt($param=array())
	{
		$query = sprintf("SELECT COUNT(guestbook_id) FROM %s ", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
				
			if(!empty($param['guestbook_id'])){
				$query .= $and . sprintf ("guestbook_id = %d ", $param['guestbook_id']);
				$and = " and ";
			}
			if(!empty($param['main_id'])){
				$query .= $and . sprintf ("main_id = %d ", $param['main_id']);
				$and = " and ";
			}
			if(!empty($param['writer_name'])){
				$query .= $and . sprintf ("writer_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['writer_name']));
				$and = " and ";
			}
			if(!empty($param['writer_ip'])){
				$query .= $and . sprintf ("writer_ip = '%s' ", $this->Dao->escapeParam($param['writer_ip']));
				$and = " and ";
			}
		}
			
		$this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();			
		return $this->totalCnt;		
	}
	
	/**
	 * 
	 * selectGuestbookList
	 * 
	 * @ClassName  : GuestbookDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function selectGuestbookList($param=array(), $start_num='', $end_num='')
	{
		$query = sprintf("SELECT * FROM %s ", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
		
			if(!empty($param['guestbook_id'])){
				$query .= $and . sprintf ("guestbook_id = %d ", $param['guestbook_id']);
				$and = " and ";
			}
			if(!empty($param['main_id'])){
				$query .= $and . sprintf ("main_id = %d ", $param['main_id']);
				$and = " and ";
			}
			if(!empty($param['writer_name'])){
				$query .= $and . sprintf ("writer_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['writer_name']));
				$and = " and ";
			}
			if(!empty($param['writer_ip'])){
				$query .= $and . sprintf ("writer_ip = '%s' ", $this->Dao->escapeParam($param['writer_ip']));
				$and = " and ";
			}
			if(!empty($param['passwd'])){
				$query .= $and . sprintf ("passwd = '%s' ", $this->Dao->escapeParam($param['passwd']));
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
		
			default :
				$query .= sprintf ( " ORDER BY guestbook_id DESC " );
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
	 * insertGuestbook
	 * 
	 * @ClassName  : GuestbookDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function insertGuestbook($param=array())
	{
		$query = sprintf("
				INSERT INTO %s (
					main_id
					, writer_name
					, passwd
					, writer_ip
					, memo
					, reg_date
				)
				VALUES( %d , '%s', '%s', '%s', '%s', date_format(now(), '%%Y%%m%%d%%H%%i%%s')
				) ",
				$this->table_name,
				$param['main_id'],
				$this->Dao->escapeParam($param['writer_name']),
				$this->Dao->escapeParam($param['passwd']),
				$this->Dao->escapeParam($param['writer_ip']),
				$this->Dao->escapeParam($param['memo'])
		);

		$result = $this->Dao->executeQuery($query);
		$notice_id = $this->Dao->getLastInsertID();
		
		return $notice_id;		
	}
	
	/**
	 * 
	 * updateGuestbook
	 * 
	 * @ClassName  : GuestbookDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function updateGuestbook($param=array())
	{
		$upquery = "";
		
		if (!empty($param['main_id']))
			$upquery .= sprintf(", main_id = %d ", $this->Dao->escapeParam($param['main_id']));
		if (!empty($param['writer_name']))
			$upquery .= sprintf(", writer_name = '%s' ", $this->Dao->escapeParam($param['writer_name']));
		if (!empty($param['writer_ip']))
			$upquery .= sprintf(", writer_ip = '%s' ", $this->Dao->escapeParam($param['writer_ip']));
		if (!empty($param['memo']))
			$upquery .= sprintf(", memo = '%s' ", $this->Dao->escapeParam($param['memo']));

		$query = sprintf("
				UPDATE %s 
				SET guestbook_id = guestbook_id
					%s
				WHERE guestbook_id = %d", $this->table_name, $upquery, $param['guestbook_id']);

		$result = $this->Dao->executeQuery($query);
		
		return $result;
		
	}
	
	/**
	 * 
	 * deleteGuestbook
	 * 
	 * @ClassName  : GuestbookDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $guestbook_id
	 * @return return_type
	 */
	public function deleteGuestbook($guestbook_id=0)
	{
		$query = sprintf("DELETE FROM %s WHERE guestbook_id = %d", $this->table_name, $guestbook_id);
		
		$result = $this->Dao->executeQuery($query);
		return $result;
	}
	
	/**
	 * 
	 * deleteGuestbookByMainID
	 * 
	 * @ClassName  : GuestbookDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 2.
	 * @param unknown_type $main_id
	 * @return return_type
	 */
	public function deleteGuestbookByMainID($main_id=0)
	{
		$query = sprintf("DELETE FROM %s WHERE main_id = %d", $this->table_name, $main_id);
		
		$result = $this->Dao->executeQuery($query);
		return $result;
	}
}
?>