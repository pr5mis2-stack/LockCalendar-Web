<?php
import("php.database.DaoClass");
/**
 * 
 *  CommonCodeDao
 *
 *  @Desc     : 메타정보 코드데이블 (tb_common_code)
 *  @Author   : 조오성
 *  @Date     : 2010. 11. 16. 오전 10:42:11
 *  @Version  :
 */
class CommonCodeDao {
	private $Dao;
	private $totalCnt;
	private $data_list;
	private $table_name;

	/**
	 * 
	 *  CommonCodeDao
	 *
	 *  @Desc      : constructor
	 *  @Author    :  조오성
	 *  @Date      : 2010. 11. 16. 오전 10:42:27
	 *  @Return    : no
	 */
	public function __construct()
	{
		$this->Dao = new Dao;
		$this->Dao->transaction = false;
		$this->Dao->Connect();
		$this->table_name = "tb_common_code";
	}

	/**
	 * 
	 * selectCommonCodeCnt
	 * 
	 * @ClassName  : CommonCodeDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 4.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function selectCommonCodeCnt($param=array())
	{
		$query = sprintf("SELECT COUNT(*) FROM %s ", $this->table_name);
	
	
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
	
					if(!empty($param['code_tbl']))
			{
				$query .= $and . sprintf( "code_tbl = '%s' ", $this->Dao->escapeParam($param['code_tbl']));
				$and = " and ";
			}
				
			if(!empty($param['code_fld']))
			{
				$query .= $and . sprintf ( "code_fld = '%s' ", $this->Dao->escapeParam($param['code_fld']));
				$and = " and ";
			}
		}
			
		$this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();
		return $this->totalCnt;
	}
	
	/**
	 * 
	 * selectCommonCodeList
	 * 
	 * @ClassName  : CommonCodeDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 4.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function selectCommonCodeList($param=array(), $start_num='', $end_num='')
	{
		$query = sprintf("SELECT * FROM %s ", $this->table_name);
	
	
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
	
			if(!empty($param['code_tbl']))
			{
				$query .= $and . sprintf( "code_tbl = '%s' ", $this->Dao->escapeParam($param['code_tbl']));
				$and = " and ";
			}
				
			if(!empty($param['code_fld']))
			{
				$query .= $and . sprintf ( "code_fld = '%s' ", $this->Dao->escapeParam($param['code_fld']));
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
				$query .= sprintf ( " ORDER BY reg_date DESC " );
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
	 *  insertCommonCode
	 *
	 *  @Desc      : insert common code
	 *  @Author    :  조오성
	 *  @Date      : 2010. 11. 16. 오전 10:42:39
	 *  @param     : $param
	 *  @Return    : $result
	 */
	public function insertCommonCode($param)
	{
		$query = sprintf("INSERT INTO %s (
														code_tbl,
														code_fld,
														code_val,
														code_lbl,
														description,
														reg_date)
							VALUES('%s', '%s', '%s', '%s', '%s', '%s') ",
		 							$this->table_name,
									$this->Dao->escapeParam($param['code_tbl']), 
									$this->Dao->escapeParam($param['code_fld']), 
									$this->Dao->escapeParam($param['code_val']), 
									$this->Dao->escapeParam($param['code_lbl']), 
									$this->Dao->escapeParam($param['description']), 
									$this->Dao->escapeParam($param['reg_date'])
						);
						
		$result = $this->Dao->executeQuery($query);

		return $result;
	}

	/**
	 * 
	 *  updateCommonCodeByCodeTbl
	 *
	 *  @Desc      : update by code_tbl
	 *  @Author    :  조오성
	 *  @Date      : 2010. 11. 16. 오전 10:42:42
	 *  @param     : $param (code_tbl : 테이블명, code_fld : 필드명, code_val : 필드값)
	 *  @Return    : $result
	 */
	public function updateCommonCodeByCodeTbl($param)
	{
		$query = sprintf("UPDATE %s SET code_lbl='%s', description='%s'
							WHERE code_tbl = '%s' and code_fld='%s' and code_val='%s' ",  
									$this->table_name,
									$this->Dao->escapeParam($param['code_lbl']), 
									$this->Dao->escapeParam($param['description']), 
									$this->Dao->escapeParam($param['code_tbl']),
									$this->Dao->escapeParam($param['code_fld']), 
									$this->Dao->escapeParam($param['code_val']));
							
		$result = $this->Dao->executeQuery($query);

		return $result;
	}
	
	/**
	 * 
	 * deleteCommonCode
	 * 
	 * @ClassName  : CommonCodeDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 4.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function deleteCommonCode($param=array())
	{
		$query = sprintf("DELETE FROM %s 
				WHERE code_tbl = '%s' 
				  AND code_fla = '%s'
				  AND code_val = '%s' ", 
				$this->table_name, 
				$this->Dao->escapeParam($param['code_tbl']),
				$this->Dao->escapeParam($param['code_fld']),
				$this->Dao->escapeParam($param['code_val'])
				);
		
		$result = $this->Dao->executeQuery($query);
		return $result;
	}
}
?>