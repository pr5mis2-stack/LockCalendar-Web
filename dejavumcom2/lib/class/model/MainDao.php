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
class MainDao {
	
	private $Dao;
	private $totalCnt;
	private $data_list;
	private $table_name;
	
	/**
	 * 
	 * MainDao
	 * 
	 * @ClassName  : MainDao
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
	 * selectMaxMainID
	 * 
	 * @ClassName  : MainDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 10. 21.
	 * @return return_type
	 */
	public function selectMaxMainID()
	{
		$query = sprintf("SELECT IFNULL(MAX(main_id), 0) + 1 FROM %s ", $this->table_name);

		$this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();
		return $this->totalCnt;
	}
	

	/**
	 * 
	 * checkEmail
	 * 
	 * @ClassName  : MainDao
	 * @Comment    : 등록된 이메일인지 체크
	 * @Author     : suya
	 * @Date       : 2013. 11. 9.
	 * @param unknown_type $email
	 * @param unknown_type $main_id
	 * @return return_type
	 */
	public function checkEmail($email='', $main_id=0)
	{
		$query = sprintf("SELECT COUNT(main_id) FROM %s WHERE email='%s' ", $this->table_name, $email);
		
		if (!empty($main_id))
			$query .= sprintf(" AND main_id <> %d ", $main_id);

		//new dBug($query);
		$this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();
		return $this->totalCnt;
	}
	
	/**
	 * 
	 * selectMainCnt
	 * 
	 * @ClassName  : MainDao
	 * @Comment    : 등록된 초대장 수량 조회
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function selectMainCnt($param=array())
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
			if((isset($param['view_type']) && $param['view_type'] != "")){
				$query .= $and . sprintf ("m.view_type = %d ", $param['view_type']);
				$and = " and ";
			}
			if(!empty($param['email'])){
				$query .= $and . sprintf ("m.email = '%s' ", $this->Dao->escapeParam($param['email']));
				$and = " and ";
			}
			if(!empty($param['passwd'])){
				$query .= $and . sprintf ("m.passwd = '%s' ", $this->Dao->escapeParam($param['passwd']));
				$and = " and ";
			}
			if(!empty($param['father_name'])){
				$query .= $and . sprintf ("m.father_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['father_name']));
				$and = " and ";
			}
			if(!empty($param['mother_name'])){
				$query .= $and . sprintf ("m.mother_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['mother_name']));
				$and = " and ";
			}
			if(!empty($param['baby_name'])){
				$query .= $and . sprintf ("m.baby_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['baby_name']));
				$and = " and ";
			}
			if((isset($param['end_flag']) && $param['end_flag'] != "")){
				$query .= $and . sprintf ("m.end_flag = %d ", $param['end_flag']);
				$and = " and ";
			}
			if(!empty($param['email'])){
				$query .= $and . sprintf ("m.email = '%s' ", $this->Dao->escapeParam($param['email']));
				$and = " and ";
			}
			if(!empty($param['show_date'])){
				$query .= $and . sprintf ("m.show_date = '%s' ", $this->Dao->escapeParam($param['show_date']));
				$and = " and ";
			}
			if((isset($param['show_end']) && $param['show_end'] != "")){
				if($param['show_end'] == "1")
					$query .= $and . sprintf("m.show_date < DATE_FORMAT('%s', '%%Y-%%m-%%d') ", date("Y-m-d") );
				else 
					$query .= $and . sprintf("m.show_date >= DATE_FORMAT('%s', '%%Y-%%m-%%d') ", date("Y-m-d") );
				$and = " and ";
			}
			if(!empty($param['show_st_date']) && !empty($param['show_ed_date'])){
				$query .= $and . sprintf("m.show_date BETWEEN  DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['show_st_date']), $this->Dao->escapeParam($param['show_ed_date']) );
				$and = " and ";
			}
			if(!empty($param['st_date']) && !empty($param['ed_date'])){
				$query .= $and . sprintf("m.reg_date BETWEEN  DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['st_date']), $this->Dao->escapeParam($param['ed_date']) );
				$and = " and ";
			}
			if(!empty($param['reg_date'])){
				$query .= $and . sprintf("m.reg_date BETWEEN DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['reg_date']), $this->Dao->escapeParam($param['reg_date']) );
				$and = " and ";
			}
			if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("m.shop_id = %d ", $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['shop_name'])){
				$query .= $and . sprintf ("sh.shop_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['shop_name']));
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
	
	/**
	 * 
	 * selectMainList
	 * 
	 * @ClassName  : MainDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function selectMainList($param=array(), $start_num='', $end_num='')
	{
		$query = sprintf("
				SELECT 
					m.main_id
				    , m.shop_id
					, m.parent_shop_id
					, m.sample_id
					, m.view_type
					, m.email
					, m.passwd
				
					, m.father_name
					, m.father_hp
					, m.mother_name
					, m.mother_hp
					, m.baby_name
				
					, m.show_date
					, m.show_time
					, m.holl_name
					, m.main_photo_url
					, m.end_flag
					, m.readcnt
				
					, m.is_invitation
					, m.is_gallery
					, m.is_guestbook
					, m.reg_date
					, m.edt_date
					, sh.shop_name AS shop_name
					, fn_get_shop_name(m.parent_shop_id) AS parent_shop_name
					, sa.sample_name AS sample_name
					, fn_get_dday(m.show_date) AS dday
					, fn_get_2gimg_url(%d) AS photo_2g_url
					, CASE WHEN sa.sample_type = 'B' THEN '돌잔치' WHEN sa.sample_type = 'W' THEN '웨딩' WHEN sa.sample_type = 'S' THEN '고희연' END AS type_name
					, sa.sample_type AS type_value

					, m.is_bank
					, m.bank_memo
				FROM %s m LEFT JOIN tb_shop sh ON sh.shop_id = m.shop_id
						  LEFT JOIN tb_sample sa ON sa.sample_id = m.sample_id
				", ($param['main_id'] ?? 0), $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
		
			if(!empty($param['main_id'])){
				$query .= $and . sprintf ("m.main_id = %d ", $param['main_id']);
				$and = " and ";
			}
			if((isset($param['view_type']) && $param['view_type'] != "")){
				$query .= $and . sprintf ("m.view_type = %d ", $param['view_type']);
				$and = " and ";
			}
			if(!empty($param['email'])){
				$query .= $and . sprintf ("m.email = '%s' ", $this->Dao->escapeParam($param['email']));
				$and = " and ";
			}
			if(!empty($param['passwd'])){
				$query .= $and . sprintf ("m.passwd = '%s' ", $this->Dao->escapeParam($param['passwd']));
				$and = " and ";
			}
			if(!empty($param['father_name'])){
				$query .= $and . sprintf ("m.father_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['father_name']));
				$and = " and ";
			}
			if(!empty($param['mother_name'])){
				$query .= $and . sprintf ("m.mother_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['mother_name']));
				$and = " and ";
			}
			if(!empty($param['baby_name'])){
				$query .= $and . sprintf ("m.baby_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['baby_name']));
				$and = " and ";
			}
			if((isset($param['end_flag']) && $param['end_flag'] != "")){
				$query .= $and . sprintf ("m.end_flag = %d ", $param['end_flag']);
				$and = " and ";
			}
			if(!empty($param['email'])){
				$query .= $and . sprintf ("m.email = '%s' ", $this->Dao->escapeParam($param['email']));
				$and = " and ";
			}
			if(!empty($param['show_date'])){
				$query .= $and . sprintf ("m.show_date = '%s' ", $this->Dao->escapeParam($param['show_date']));
				$and = " and ";
			}
			if((isset($param['show_end']) && $param['show_end'] != "")){
				if($param['show_end'] == "1")
					$query .= $and . sprintf("m.show_date < DATE_FORMAT('%s', '%%Y-%%m-%%d') ", date("Y-m-d") );
				else
					$query .= $and . sprintf("m.show_date >= DATE_FORMAT('%s', '%%Y-%%m-%%d') ", date("Y-m-d") );
				$and = " and ";
			}
			if(!empty($param['show_st_date']) && !empty($param['show_ed_date'])){
				$query .= $and . sprintf("m.show_date BETWEEN  DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['show_st_date']), $this->Dao->escapeParam($param['show_ed_date']) );
				$and = " and ";
			}
			if(!empty($param['st_date']) && !empty($param['ed_date'])){
				$query .= $and . sprintf("m.reg_date BETWEEN  DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['st_date']), $this->Dao->escapeParam($param['ed_date']) );
				$and = " and ";
			}
			if(!empty($param['reg_date'])){
				$query .= $and . sprintf("m.reg_date BETWEEN DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['reg_date']), $this->Dao->escapeParam($param['reg_date']) );
				$and = " and ";
			}
			if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("m.shop_id = %d ", $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['shop_name'])){
				$query .= $and . sprintf ("sh.shop_name  LIKE '%%%s%%' ", $this->Dao->escapeParam($param['shop_name']));
				$and = " and ";
			}
			// 샘플 타입 (B:돌잔치/S:고희연/W:웨딩)
			if(!empty($param['sample_type'])){
				$query .= $and . sprintf ("sa.sample_type = '%s' ", $this->Dao->escapeParam($param['sample_type']));
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
				$query .= sprintf ( " ORDER BY m.reg_date DESC " );
				break;
			case "20" :		// 제목순
				$query .= sprintf ( " ORDER BY m.baby_name ASC " );
				break;
		
			default :
				$query .= sprintf ( " ORDER BY m.order_id ASC " );
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
	
	/**
	 *
	 * selectFphCnt
	 *
	 * @ClassName  : MainDao
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function selectFphCnt($param=array())
	{
		$query = sprintf("
					SELECT 
						COUNT(m.main_id) 
					FROM %s m LEFT JOIN tb_shop sh ON s.shop_id = m.shop_id 
							  LEFT JOIN tb_sample sa ON sa.sample_id = m.sample_id
				", $this->table_name);
	
	
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
	
			if(!empty($param['main_id'])){
				$query .= $and . sprintf ("m.main_id = %d ", $param['main_id']);
				$and = " and ";
			}
			if((isset($param['view_type']) && $param['view_type'] != "")){
				$query .= $and . sprintf ("m.view_type = %d ", $param['view_type']);
				$and = " and ";
			}
			if(!empty($param['email'])){
				$query .= $and . sprintf ("m.email = '%s' ", $this->Dao->escapeParam($param['email']));
				$and = " and ";
			}
			if(!empty($param['passwd'])){
				$query .= $and . sprintf ("m.passwd = '%s' ", $this->Dao->escapeParam($param['passwd']));
				$and = " and ";
			}
			if(!empty($param['father_name'])){
				$query .= $and . sprintf ("m.father_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['father_name']));
				$and = " and ";
			}
			if(!empty($param['mother_name'])){
				$query .= $and . sprintf ("m.mother_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['mother_name']));
				$and = " and ";
			}
			if(!empty($param['baby_name'])){
				$query .= $and . sprintf ("m.baby_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['baby_name']));
				$and = " and ";
			}
			if((isset($param['end_flag']) && $param['end_flag'] != "")){
				$query .= $and . sprintf ("m.end_flag = %d ", $param['end_flag']);
				$and = " and ";
			}
			if(!empty($param['email'])){
				$query .= $and . sprintf ("m.email = '%s' ", $this->Dao->escapeParam($param['email']));
				$and = " and ";
			}
			if(!empty($param['show_date'])){
				$query .= $and . sprintf ("m.show_date = '%s' ", $this->Dao->escapeParam($param['show_date']));
				$and = " and ";
			}
			if((isset($param['show_end']) && $param['show_end'] != "")){
				if($param['show_end'] == "1")
					$query .= $and . sprintf("m.show_date < DATE_FORMAT('%s', '%%Y-%%m-%%d') ", date("Y-m-d") );
				else
					$query .= $and . sprintf("m.show_date >= DATE_FORMAT('%s', '%%Y-%%m-%%d') ", date("Y-m-d") );
				$and = " and ";
			}
			if(!empty($param['show_st_date']) && !empty($param['show_ed_date'])){
				$query .= $and . sprintf("m.show_date BETWEEN  DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['show_st_date']), $this->Dao->escapeParam($param['show_ed_date']) );
				$and = " and ";
			}
			if(!empty($param['st_date']) && !empty($param['ed_date'])){
				$query .= $and . sprintf("m.reg_date BETWEEN  DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['st_date']), $this->Dao->escapeParam($param['ed_date']) );
				$and = " and ";
			}
			if(!empty($param['reg_date'])){
				$query .= $and . sprintf("m.reg_date BETWEEN DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['reg_date']), $this->Dao->escapeParam($param['reg_date']) );
				$and = " and ";
			}
			if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("(m.shop_id = %d OR m.parent_shop_id = %d)", $param['shop_id'], $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['shop_name'])){
				$query .= $and . sprintf ("sh.shop_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['shop_name']));
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
	 * selectFphList
	 *
	 * @ClassName  : MainDao
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function selectFphList($param=array(), $start_num='', $end_num='')
	{
		$query = sprintf("
				SELECT
					m.main_id
				    , m.shop_id
					, m.parent_shop_id
					, m.sample_id
					, m.view_type
					, m.email
					, m.passwd
				
					, m.father_name
					, m.father_hp
					, m.mother_name
					, m.mother_hp
					, m.baby_name
				
					, m.show_date
					, m.show_time
					, m.holl_name
					, m.main_photo_url
					, m.end_flag
					, m.readcnt
				
					, m.is_invitation
					, m.is_gallery
					, m.is_guestbook
					, m.reg_date
					, m.edt_date
					, sh.shop_name AS shop_name
					, fn_get_shop_name(m.parent_shop_id) AS parent_shop_name
					, sa.sample_name AS sample_name
					, fn_get_dday(m.show_date) AS dday
					, fn_get_2gimg_url(%d) AS photo_2g_url

					, m.is_bank
					, m.bank_memo					
				FROM %s m LEFT JOIN tb_shop sh ON sh.shop_id = m.shop_id 
						  LEFT JOIN tb_sample sa ON sa.sample_id = m.sample_id
				", ($param['main_id'] ?? 0), $this->table_name);
	
	
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
	
			if(!empty($param['main_id'])){
				$query .= $and . sprintf ("m.main_id = %d ", $param['main_id']);
				$and = " and ";
			}
			if((isset($param['view_type']) && $param['view_type'] != "")){
				$query .= $and . sprintf ("m.view_type = %d ", $param['view_type']);
				$and = " and ";
			}
			if(!empty($param['email'])){
				$query .= $and . sprintf ("m.email = '%s' ", $this->Dao->escapeParam($param['email']));
				$and = " and ";
			}
			if(!empty($param['passwd'])){
				$query .= $and . sprintf ("m.passwd = '%s' ", $this->Dao->escapeParam($param['passwd']));
				$and = " and ";
			}
			if(!empty($param['father_name'])){
				$query .= $and . sprintf ("m.father_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['father_name']));
				$and = " and ";
			}
			if(!empty($param['mother_name'])){
				$query .= $and . sprintf ("m.mother_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['mother_name']));
				$and = " and ";
			}
			if(!empty($param['baby_name'])){
				$query .= $and . sprintf ("m.baby_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['baby_name']));
				$and = " and ";
			}
			if((isset($param['end_flag']) && $param['end_flag'] != "")){
				$query .= $and . sprintf ("m.end_flag = %d ", $param['end_flag']);
				$and = " and ";
			}
			if(!empty($param['email'])){
				$query .= $and . sprintf ("m.email = '%s' ", $this->Dao->escapeParam($param['email']));
				$and = " and ";
			}
			if(!empty($param['show_date'])){
				$query .= $and . sprintf ("m.show_date = '%s' ", $this->Dao->escapeParam($param['show_date']));
				$and = " and ";
			}
			if((isset($param['show_end']) && $param['show_end'] != "")){
				if($param['show_end'] == "1")
					$query .= $and . sprintf("m.show_date < DATE_FORMAT('%s', '%%Y-%%m-%%d') ", date("Y-m-d") );
				else
					$query .= $and . sprintf("m.show_date >= DATE_FORMAT('%s', '%%Y-%%m-%%d') ", date("Y-m-d") );
				$and = " and ";
			}
			if(!empty($param['show_st_date']) && !empty($param['show_ed_date'])){
				$query .= $and . sprintf("m.show_date BETWEEN  DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['show_st_date']), $this->Dao->escapeParam($param['show_ed_date']) );
				$and = " and ";
			}
			if(!empty($param['st_date']) && !empty($param['ed_date'])){
				$query .= $and . sprintf("m.reg_date BETWEEN  DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['st_date']), $this->Dao->escapeParam($param['ed_date']) );
				$and = " and ";
			}
			if(!empty($param['reg_date'])){
				$query .= $and . sprintf("m.reg_date BETWEEN DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['reg_date']), $this->Dao->escapeParam($param['reg_date']) );
				$and = " and ";
			}
			if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("(m.shop_id = %d OR m.parent_shop_id = %d)", $param['shop_id'], $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['shop_name'])){
				$query .= $and . sprintf ("sh.shop_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['shop_name']));
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
				$query .= sprintf ( " ORDER BY m.reg_date DESC " );
				break;
			case "20" :		// 제목순
				$query .= sprintf ( " ORDER BY m.baby_name ASC " );
				break;
	
			default :
				$query .= sprintf ( " ORDER BY m.order_id ASC " );
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
	
	/**
	 * 
	 * insertMain
	 * 
	 * @ClassName  : MainDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function insertMain($param=array())
	{
		$query = sprintf("
				INSERT INTO %s (
					shop_id
					, parent_shop_id
					, sample_id
					, view_type
					, email
					, passwd
				
					, father_name
					, father_hp
					, mother_name
					, mother_hp
					, baby_name
				
					, show_date
					, show_time
					, holl_name
					, main_photo_url
					, end_flag
					, readcnt
				
					, is_invitation
					, is_gallery
					, is_guestbook
					, is_bank
					, bank_memo
					
					, reg_date
					, edt_date
				)
				VALUES( %d ,  %d ,  %d ,  %d , '%s', '%s',
					   '%s', '%s', '%s', '%s', '%s',
					   '%s', '%s', '%s', '%s',  %d ,  %d ,
					    %d ,  %d ,  %d ,  %d , '%s',
					    
					    date_format(now(), '%%Y%%m%%d%%H%%i%%s'), date_format(now(), '%%Y%%m%%d%%H%%i%%s')
				) ",
				$this->table_name,
				$param['shop_id'],
				$param['parent_shop_id'],
				$param['sample_id'],
				$param['view_type'],
				$this->Dao->escapeParam($param['email']),
				$this->Dao->escapeParam($param['passwd']),
				
				$this->Dao->escapeParam($param['father_name']),
				$this->Dao->escapeParam($param['father_hp']),
				$this->Dao->escapeParam($param['mother_name']),
				$this->Dao->escapeParam($param['mother_hp']),
				$this->Dao->escapeParam($param['baby_name']),
				
				$this->Dao->escapeParam($param['show_date']),
				$this->Dao->escapeParam($param['show_time']),
				$this->Dao->escapeParam($param['holl_name']),
				$this->Dao->escapeParam($param['main_photo_url'] ?? ''),
				($param['end_flag'] ?? 0),
				($param['readcnt'] ?? 0),
				
				($param['is_invitation'] ?? 0),
				($param['is_gallery'] ?? 0),
				($param['is_guestbook'] ?? 0),
				$param['is_bank'],
				$this->Dao->escapeParam($param['bank_memo'])
		);
		
		$result = $this->Dao->executeQuery($query);
		#new dBug($query);
		#exit;
		$notice_id = $this->Dao->getLastInsertID();
		
		$query2 = sprintf("UPDATE %s SET order_id = %d * -1 WHERE main_id = %d", 
				$this->table_name,
				$notice_id, 
				$notice_id);
		$result = $this->Dao->executeQuery($query2);
		
		return $notice_id;		
	}
	
	/**
	 * 
	 * updateMain
	 * 
	 * @ClassName  : MainDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function updateMain($param=array())
	{
		$upquery = "";
		
		if (!empty($param['shop_id']))
			$upquery .= sprintf(", shop_id = %d ", $param['shop_id']);
		if (!empty($param['parent_shop_id']))
			$upquery .= sprintf(", parent_shop_id = %d ", $param['parent_shop_id']);
		if (!empty($param['sample_id']))
			$upquery .= sprintf(", sample_id = %d ", $param['sample_id']);
		if ((isset($param['view_type']) && $param['view_type'] != ""))
			$upquery .= sprintf(", view_type = %d ", $param['view_type']);
		if (!empty($param['email']))
			$upquery .= sprintf(", email = '%s' ", $this->Dao->escapeParam($param['email']));
		if (!empty($param['passwd']))
			$upquery .= sprintf(", passwd = '%s' ", $this->Dao->escapeParam($param['passwd']));
		
		if (!empty($param['father_name']))
			$upquery .= sprintf(", father_name = '%s' ", $this->Dao->escapeParam($param['father_name']));
		if (!empty($param['father_hp']))
			$upquery .= sprintf(", father_hp = '%s' ", $this->Dao->escapeParam($param['father_hp']));
		if (!empty($param['mother_name']))
			$upquery .= sprintf(", mother_name = '%s' ", $this->Dao->escapeParam($param['mother_name']));
		if (!empty($param['mother_hp']))
			$upquery .= sprintf(", mother_hp = '%s' ", $this->Dao->escapeParam($param['mother_hp']));
		if (!empty($param['baby_name']))
			$upquery .= sprintf(", baby_name = '%s' ", $this->Dao->escapeParam($param['baby_name']));
		
		if (!empty($param['show_date']))
			$upquery .= sprintf(", show_date = '%s' ", $this->Dao->escapeParam($param['show_date']));
		if (!empty($param['show_time']))
			$upquery .= sprintf(", show_time = '%s' ", $this->Dao->escapeParam($param['show_time']));
		if (!empty($param['holl_name']))
			$upquery .= sprintf(", holl_name = '%s' ", $this->Dao->escapeParam($param['holl_name']));
		if (!empty($param['main_photo_url']))
			$upquery .= sprintf(", main_photo_url = '%s' ", $this->Dao->escapeParam($param['main_photo_url']));
		if ((isset($param['end_flag']) && $param['end_flag'] != ""))
			$upquery .= sprintf(", end_flag = %d ", $param['end_flag']);
		if (!empty($param['readcnt']))
			$upquery .= sprintf(", readcnt = %d ", $param['readcnt']);

		if (isset($param['is_invitation']) && $param['is_invitation'] != "")
			$upquery .= sprintf(", is_invitation = %d ", $param['is_invitation']);
		if (isset($param['is_gallery']) && $param['is_gallery'] != "")
			$upquery .= sprintf(", is_gallery = %d ", $param['is_gallery']);
		if (isset($param['is_guestbook']) && $param['is_guestbook'] != "")
			$upquery .= sprintf(", is_guestbook = %d ", $param['is_guestbook']);
		
		if (isset($param['is_bank']) && $param['is_bank'] != "")
			$upquery .= sprintf(", is_bank = %d ", $param['is_bank']);
		if (!empty($param['bank_memo']))
			$upquery .= sprintf(", bank_memo = '%s' ", $this->Dao->escapeParam($param['bank_memo']));

		$query = sprintf("
				UPDATE %s 
				SET edt_date = date_format(now(), '%%Y%%m%%d%%H%%i%%s')
					%s
				WHERE main_id = %d", $this->table_name, $upquery, $param['main_id']);

		$result = $this->Dao->executeQuery($query);
		//echo"<!-- $query -->";
		//new dBug($query);
		return $result;
		
	}
	
	/**
	 * 
	 * deleteMain
	 * 
	 * @ClassName  : MainDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $main_id
	 * @return return_type
	 */
	public function deleteMain($main_id=0)
	{
		$query = sprintf("DELETE FROM %s WHERE main_id = %d", $this->table_name, $main_id);
		
		$result = $this->Dao->executeQuery($query);
		return $result;
	}
	
	/**
	 * 
	 * upCountMain
	 * 
	 * @ClassName  : MainDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 10. 29.
	 * @param unknown_type $main_id
	 * @return return_type
	 */
	public function upCountMain($main_id=0)
	{
		$query = sprintf("UPDATE %s SET readcnt = readcnt + 1 WHERE main_id = %d", $this->table_name, $main_id);
		
		$result = $this->Dao->executeQuery($query);
		return $result;
	}
	
	/**
	 * 
	 * deleteMainPhoto
	 * 
	 * @ClassName  : MainDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2014. 1. 7.
	 * @param unknown_type $main_id
	 * @return return_type
	 */
	public function deleteMainPhoto($main_id=0)
	{
		$query = sprintf("UPDATE %s SET main_photo_url = '' WHERE main_id = %d", $this->table_name, $main_id);
		
		$result = $this->Dao->executeQuery($query);
		return $result;
	}
}
?>