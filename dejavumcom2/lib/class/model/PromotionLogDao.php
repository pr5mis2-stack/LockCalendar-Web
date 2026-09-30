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
 * @Date       : 2018.10.28.
 */
class PromotionLogDao {
	
	private $Dao;
	private $totalCnt;
	private $data_list;
	private $table_name;
	
	/**
	 * 
	 * PromotionLogDao
	 * 
	 * @ClassName  : PromotionDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2018.10.28.
	 */
	public function __construct()
	{
		$this->Dao = new Dao;
		$this->Dao->transaction = false;
		$this->Dao->Connect();
		$this->table_name = "tb_promotion_log";
	}
	
	/**
	 * 
	 * selectPromotionCnt
	 * 
	 * @ClassName  : PromotionDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2018.10.28.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function selectPromotionLogCnt($param=array())
	{
		$query = sprintf("
                SELECT
                    COUNT(L.log_id) 
                FROM %s L LEFT JOIN tb_main M ON M.main_id = L.main_id 
                LEFT JOIN tb_shop S ON S.shop_id = L.shop_id ", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
				
			if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("L.shop_id = %d ", $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['shop_name'])){
				$query .= $and . sprintf ("S.shop_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['shop_name']));
				$and = " and ";
			}
			if(!empty($param['email'])){
				$query .= $and . sprintf ("M.emaile LIKE '%%%s%%' ", $this->Dao->escapeParam($param['email']));
				$and = " and ";
            }
			if(!empty($param['father_name'])){
				$query .= $and . sprintf ("M.father_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['father_name']));
				$and = " and ";
            }
			if(!empty($param['mother_name'])){
				$query .= $and . sprintf ("M.mother_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['mother_name']));
				$and = " and ";
            }
			if(!empty($param['baby_name'])){
				$query .= $and . sprintf ("M.baby_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['baby_name']));
				$and = " and ";
			}                                    
			if(!empty($param['st_date']) && !empty($param['ed_date'])){
				$query .= $and . sprintf("L.reg_date BETWEEN  DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['st_date']), $this->Dao->escapeParam($param['ed_date']) );
				$and = " and ";
			}
			if(!empty($param['reg_date'])){
				$query .= $and . sprintf("L.reg_date BETWEEN DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['reg_date']), $this->Dao->escapeParam($param['reg_date']) );
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
	 * selectPromotionLogList
	 * 
	 * @ClassName  : PromotionDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function selectPromotionLogList($param=array(), $start_num='', $end_num='')
	{
		$query = sprintf("
				SELECT 
                    S.shop_id
                    , S.shop_name
                    , L.main_id
                    , M.email
                    , M.father_name
                    , M.father_hp
                    , M.mother_name
                    , M.mother_hp
					, M.baby_name
					, M.show_date
					, M.show_time
                    , L.reg_date
                FROM %s L LEFT JOIN tb_main M ON M.main_id = L.main_id 
                LEFT JOIN tb_shop S ON S.shop_id = L.shop_id ", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
		
			if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("L.shop_id = %d ", $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['shop_name'])){
				$query .= $and . sprintf ("S.shop_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['shop_name']));
				$and = " and ";
			}
			if(!empty($param['email'])){
				$query .= $and . sprintf ("M.emaile LIKE '%%%s%%' ", $this->Dao->escapeParam($param['email']));
				$and = " and ";
            }
			if(!empty($param['father_name'])){
				$query .= $and . sprintf ("M.father_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['father_name']));
				$and = " and ";
            }
			if(!empty($param['mother_name'])){
				$query .= $and . sprintf ("M.mother_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['mother_name']));
				$and = " and ";
            }
			if(!empty($param['baby_name'])){
				$query .= $and . sprintf ("M.baby_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['baby_name']));
				$and = " and ";
			}                                    
			if(!empty($param['st_date']) && !empty($param['ed_date'])){
				$query .= $and . sprintf("L.reg_date BETWEEN  DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['st_date']), $this->Dao->escapeParam($param['ed_date']) );
				$and = " and ";
			}
			if(!empty($param['reg_date'])){
				$query .= $and . sprintf("L.reg_date BETWEEN DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['reg_date']), $this->Dao->escapeParam($param['reg_date']) );
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
				$query .= sprintf ( " ORDER BY L.reg_date DESC " );
				break;
			case "20" :		// 제목순
				$query .= sprintf ( " ORDER BY M.father_name ASC " );
				break;
		
			default :
				$query .= sprintf ( " ORDER BY L.reg_date DESC " );
				break;
		}
		
		if($end_num != ''){
			$start_num = empty($start_num)? 0:$start_num;
			$query.= sprintf(" LIMIT %d, %d", $start_num, $end_num);
		}
		
		//new dBug($query);
		$this->Dao->executeQuery($query);

		$this->data_list = array();						// 코드수정 : 모든 While loop 진입전에 초기화 할것
		while( $Rows = $this->Dao->getFetchArray() ) {
			$this->data_list[] = $Rows;					// 코드수정 : $this->data_list[] = $Rows;
		}
		return $this->data_list;						// 코드수정 : $this->data_list;
		
	}

	public function selectPromotionLogExcel($param=array())
	{
		$query = sprintf("
				SELECT 
                    S.shop_id
                    , S.shop_name
                    , L.main_id
                    , M.email
                    , M.father_name
                    , M.father_hp
                    , M.mother_name
                    , M.mother_hp
					, M.baby_name
					, M.show_date
					, M.show_time
                    , L.reg_date
                FROM %s L LEFT JOIN tb_main M ON M.main_id = L.main_id 
                LEFT JOIN tb_shop S ON S.shop_id = L.shop_id ", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
		
			if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("L.shop_id = %d ", $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['shop_name'])){
				$query .= $and . sprintf ("S.shop_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['shop_name']));
				$and = " and ";
			}
			if(!empty($param['email'])){
				$query .= $and . sprintf ("M.emaile LIKE '%%%s%%' ", $this->Dao->escapeParam($param['email']));
				$and = " and ";
            }
			if(!empty($param['father_name'])){
				$query .= $and . sprintf ("M.father_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['father_name']));
				$and = " and ";
            }
			if(!empty($param['mother_name'])){
				$query .= $and . sprintf ("M.mother_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['mother_name']));
				$and = " and ";
            }
			if(!empty($param['baby_name'])){
				$query .= $and . sprintf ("M.baby_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['baby_name']));
				$and = " and ";
			}                                    
			if(!empty($param['st_date']) && !empty($param['ed_date'])){
				$query .= $and . sprintf("L.reg_date BETWEEN  DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['st_date']), $this->Dao->escapeParam($param['ed_date']) );
				$and = " and ";
			}
			if(!empty($param['reg_date'])){
				$query .= $and . sprintf("L.reg_date BETWEEN DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['reg_date']), $this->Dao->escapeParam($param['reg_date']) );
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
				$query .= sprintf ( " ORDER BY L.reg_date DESC " );
				break;
			case "20" :		// 제목순
				$query .= sprintf ( " ORDER BY M.father_name ASC " );
				break;
		
			default :
				$query .= sprintf ( " ORDER BY L.reg_date DESC " );
				break;
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
     * isAddedPromotionLog
	 * 
	 * @ClassName  : PromotionDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $main_id
	 * @return return_type
     */
	public function isAddedPromotionLog($main_id=0)
	{
		$query = sprintf("
                SELECT
                    COUNT(log_id) 
                FROM %s 
                WHERE main_id = %d ", $this->table_name, $main_id);

        $this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();			
		return $this->totalCnt;		
	}
    
	/**
	 * 
	 * insertPromotionLog
	 * 
	 * @ClassName  : PromotionDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function insertPromotionLog($param=array())
	{
		$query = sprintf("
				INSERT INTO %s (
					shop_id
					, main_id
                    , reg_date
				)
				VALUES( '%d', %d, date_format(now(), '%%Y%%m%%d%%H%%i%%s')
				) ",
				$this->table_name,
				$param['shop_id'],
				$param['main_id']
		);
		
		$result = $this->Dao->executeQuery($query);
		$notice_id = $this->Dao->getLastInsertID();
		
		return $notice_id;		
	}
}
?>