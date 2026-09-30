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
class InvitationDao {
	
	private $Dao;
	private $totalCnt;
	private $data_list;
	private $table_name;
	
	/**
	 * 
	 * InvitationDao
	 * 
	 * @ClassName  : InvitationDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 */
	public function __construct()
	{
		$this->Dao = new Dao;
		$this->Dao->transaction = false;
		$this->Dao->Connect();
		$this->table_name = "tb_invitation";
	}
	
	public function selectInvitationCnt($param=array())
	{
		$query = sprintf("SELECT COUNT(*) FROM %s ", $this->table_name);
	
	
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
	
			if(!empty($param['main_id'])){
				$query .= $and . sprintf ("main_id = %d ", $param['main_id']);
				$and = " and ";
			}
		}
	//new dBug($query);
		$this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();			
		return $this->totalCnt;			
	}
	
	/**
	 * 
	 * selectInvitationList
	 * 
	 * @ClassName  : InvitationDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function selectInvitationList($param=array())
	{
		$query = sprintf("SELECT * FROM %s ", $this->table_name);
		
		//new dBug($param);
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
		
			if(!empty($param['main_id'])){
				$query .= $and . sprintf ("main_id = %d ", $param['main_id']);
				$and = " and ";
			}
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
	 * insertInvitation
	 * 
	 * @ClassName  : InvitationDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function insertInvitation($param=array())
	{
		$query = sprintf("
				INSERT INTO %s (
					main_id
					, memo
				)
				VALUES(%d , '%s') ",
				$this->table_name,
				$param['main_id'],
				$this->Dao->escapeParam($param['memo'])
		);
		
		$result = $this->Dao->executeQuery($query);
		//$notice_id = $this->Dao->getLastInsertID();
		
		return $result;		
	}
	
	/**
	 * 
	 * updateInvitation
	 * 
	 * @ClassName  : InvitationDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function updateInvitation($param=array())
	{
		$upquery = "";
		
		if (isset($param['memo']))
			$upquery .= sprintf(", memo = '%s' ", $this->Dao->escapeParam($param['memo']));

		$query = sprintf("
				UPDATE %s 
				SET main_id = main_id
					%s
				WHERE main_id = %d", $this->table_name, $upquery, $param['main_id']);

		$result = $this->Dao->executeQuery($query);
		
		return $result;
		
	}
	
	/**
	 * 
	 * deleteInvitation
	 * 
	 * @ClassName  : InvitationDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $adver_id
	 * @return return_type
	 */
	public function deleteInvitation($main_id=0)
	{
		$query = sprintf("DELETE FROM %s WHERE main_id = %d", $this->table_name, $main_id);
		
		$result = $this->Dao->executeQuery($query);
		return $result;
	}
}
?>