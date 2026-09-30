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
class AdvertisementDao {
	
	private $Dao;
	private $totalCnt;
	private $data_list;
	private $table_name;
	
	/**
	 * 
	 * AdvertisementDao
	 * 
	 * @ClassName  : AdvertisementDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 */
	public function __construct()
	{
		$this->Dao = new Dao;
		$this->Dao->transaction = false;
		$this->Dao->Connect();
		$this->table_name = "tb_advertisement";
	}
	
	/**
	 *
	 * selectAdvertisementList
	 *
	 * @ClassName  : AdvertisementDao
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function selectRandBanner($shop_id)
	{
		$query = sprintf("
				SELECT * 
				FROM %s 
				WHERE st_date <= NOW() AND ed_date >= NOW() 
				and shop_id = %d
				ORDER BY RAND()
				LIMIT 1
				", $this->table_name, $shop_id);
	
		//new dBug($query);
		//exit;
		$this->Dao->executeQuery($query);
	
		$this->data_list = array();						// 코드수정 : 모든 While loop 진입전에 초기화 할것
		while( $Rows = $this->Dao->getFetchArray() ) {
			$this->data_list[] = $Rows;					// 코드수정 : $this->data_list[] = $Rows;
		}
		return $this->data_list;						// 코드수정 : $this->data_list;
	
	}
	
	
	/**
	 * 
	 * selectAdvertisementCnt
	 * 
	 * @ClassName  : AdvertisementDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function selectAdvertisementCnt($param=array())
	{
		$query = sprintf("SELECT COUNT(adver_id) FROM %s ", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
				
			if(!empty($param['adver_id'])){
				$query .= $and . sprintf ("adver_id = %d ", $param['adver_id']);
				$and = " and ";
			}
			if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("shop_id = %d ", $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['st_date']) && !empty($param['ed_date'])){
				$query .= $and . sprintf("reg_date BETWEEN  DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['st_date']), $this->Dao->escapeParam($param['ed_date']) );
				$and = " and ";
			}
		}
			
		$this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();			
		return $this->totalCnt;		
	}
	
	/**
	 * 
	 * selectAdvertisementList
	 * 
	 * @ClassName  : AdvertisementDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function selectAdvertisementList($param=array(), $start_num='', $end_num='')
	{
		$query = sprintf("SELECT * FROM %s ", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
		
			if(!empty($param['adver_id'])){
				$query .= $and . sprintf ("adver_id = %d ", $param['adver_id']);
				$and = " and ";
			}
					if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("shop_id = %d ", $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['st_date']) && !empty($param['ed_date'])){
				$query .= $and . sprintf("reg_date BETWEEN  DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['st_date']), $this->Dao->escapeParam($param['ed_date']) );
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
				$query .= sprintf ( " ORDER BY shop_id ASC " );
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
	 * insertAdvertisement
	 * 
	 * @ClassName  : AdvertisementDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function insertAdvertisement($param=array())
	{
		$query = sprintf("
				INSERT INTO %s (
					shop_id
					, file_url
					, site_url
					, view_flag
					, st_date
					, ed_date
					, reg_date
					, edt_date
				)
				VALUES(%d , '%s', '%s', '%s', '%s', '%s',
				date_format(now(), '%%Y%%m%%d%%H%%i%%s'), date_format(now(), '%%Y%%m%%d%%H%%i%%s')
				) ",
				$this->table_name,
				$param['shop_id'],
				$this->Dao->escapeParam($param['file_url']),
				$this->Dao->escapeParam($param['site_url']),
				$this->Dao->escapeParam($param['view_flag']),
				$this->Dao->escapeParam($param['st_date']),
				$this->Dao->escapeParam($param['ed_date'])
		);

		$result = $this->Dao->executeQuery($query);
		$notice_id = $this->Dao->getLastInsertID();
		
		return $notice_id;		
	}
	
	/**
	 * 
	 * updateAdvertisement
	 * 
	 * @ClassName  : AdvertisementDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function updateAdvertisement($param=array())
	{
		$upquery = "";
		
		if (!empty($param['shop_id']))
			$upquery .= sprintf(", shop_id = %d ", $param['shop_id']);
		if (!empty($param['view_flag']))
			$upquery .= sprintf(", view_flag = '%s' ", $this->Dao->escapeParam($param['view_flag']));
		if (!empty($param['file_url']))
			$upquery .= sprintf(", file_url = '%s' ", $this->Dao->escapeParam($param['file_url']));
		if (!empty($param['site_url']))
			$upquery .= sprintf(", site_url = '%s' ", $this->Dao->escapeParam($param['site_url']));
		if (!empty($param['st_date']))
			$upquery .= sprintf(", st_date = '%s' ", $this->Dao->escapeParam($param['st_date']));
		if (!empty($param['ed_date']))
			$upquery .= sprintf(", ed_date = '%s' ", $this->Dao->escapeParam($param['ed_date']));

		$query = sprintf("
				UPDATE %s 
				SET edt_date = date_format(now(), '%%Y%%m%%d%%H%%i%%s')
					%s
				WHERE adver_id = %d", $this->table_name, $upquery, $param['adver_id']);

		$result = $this->Dao->executeQuery($query);
		
		return $result;
		
	}
	
	/**
	 * 
	 * deleteAdvertisement
	 * 
	 * @ClassName  : AdvertisementDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $adver_id
	 * @return return_type
	 */
	public function deleteAdvertisement($adver_id=0)
	{
		$query = sprintf("DELETE FROM %s WHERE adver_id = %d", $this->table_name, $adver_id);
		
		$result = $this->Dao->executeQuery($query);
		return $result;
	}
}
?>