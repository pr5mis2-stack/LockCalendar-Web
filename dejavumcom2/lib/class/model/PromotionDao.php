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
class PromotionDao {
	
	private $Dao;
	private $totalCnt;
	private $data_list;
	private $table_name;
	
	/**
	 * 
	 * PromotionDao
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
		$this->table_name = "tb_promotion";
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
	public function selectPromotionCnt($param=array())
	{
		$query = sprintf("SELECT COUNT(P.shop_id) FROM %s P", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
				
			if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("P.shop_id = %d ", $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['shop_name'])){
				$query .= $and . sprintf ("S.shop_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['shop_name']));
				$and = " and ";
			}
			if((isset($param['is_popup']) && $param['is_popup'] != "")){
				$query .= $and . sprintf ("P.is_popup = '%s' ", $this->Dao->escapeParam($param['is_popup']));
				$and = " and ";
			}
			if(!empty($param['st_date']) && !empty($param['ed_date'])){
				$query .= $and . sprintf("P.reg_date BETWEEN  DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['st_date']), $this->Dao->escapeParam($param['ed_date']) );
				$and = " and ";
			}
			if(!empty($param['reg_date'])){
				$query .= $and . sprintf("P.reg_date BETWEEN DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['reg_date']), $this->Dao->escapeParam($param['reg_date']) );
				$and = " and ";
			}
		}
			
		$this->Dao->executeQuery($query);
		// new dBug($query);
		$this->totalCnt = $this->Dao->getResult();			
		return $this->totalCnt;		
	}
	
	/**
	 * 
	 * selectPromotionList
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
	public function selectPromotionList($param=array(), $start_num='', $end_num='')
	{
		$query = sprintf("
				SELECT 
                    P.shop_id
                    , S.shop_name
                    , P.is_popup
                    , P.img_width
                    , P.img_height
                    , P.file_name
                    , P.file_ext
                    , P.file_url
                    , P.file_size
                    , P.reg_date
                    , P.edt_date
				FROM %s P LEFT JOIN tb_shop S ON P.shop_id = S.shop_id ", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
		
			if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("P.shop_id = %d ", $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['shop_name'])){
				$query .= $and . sprintf ("S.shop_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['shop_name']));
				$and = " and ";
			}
			if((isset($param['is_popup']) && $param['is_popup'] != "")){
				$query .= $and . sprintf ("P.is_popup = '%s' ", $this->Dao->escapeParam($param['is_popup']));
				$and = " and ";
			}
			if(!empty($param['st_date']) && !empty($param['ed_date'])){
				$query .= $and . sprintf("P.reg_date BETWEEN  DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['st_date']), $this->Dao->escapeParam($param['ed_date']) );
				$and = " and ";
			}
			if(!empty($param['reg_date'])){
				$query .= $and . sprintf("P.reg_date BETWEEN DATE_FORMAT('%s', '%%Y-%%m-%%d') AND DATE_FORMAT(DATE_ADD('%s', INTERVAL 1 DAY), '%%Y-%%m-%%d') ", $this->Dao->escapeParam($param['reg_date']), $this->Dao->escapeParam($param['reg_date']) );
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
				$query .= sprintf ( " ORDER BY P.reg_date DESC " );
				break;
			case "20" :		// 제목순
				$query .= sprintf ( " ORDER BY S.shop_name ASC " );
				break;
		
			default :
				$query .= sprintf ( " ORDER BY P.reg_date DESC " );
				break;
		}
		
		if($end_num != ''){
			$start_num = empty($start_num)? 0:$start_num;
			$query.= sprintf(" LIMIT %d, %d", $start_num, $end_num);
		}
		
		$this->Dao->executeQuery($query);
		// new dBug($query);
		$this->data_list = array();						// 코드수정 : 모든 While loop 진입전에 초기화 할것
		while( $Rows = $this->Dao->getFetchArray() ) {
			$this->data_list[] = $Rows;					// 코드수정 : $this->data_list[] = $Rows;
		}
		return $this->data_list;						// 코드수정 : $this->data_list;
		
	}

    /**
	 * 
	 * selectNonAddedShopList
	 * 
	 * @ClassName  : PromotionDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
     */
    public function selectNonAddedShopList()
	{
		$query = sprintf("
        SELECT 
            S.shop_id
            , S.shop_name 
        FROM tb_shop S LEFT OUTER JOIN %s P
        ON P.shop_id = S.shop_id
        WHERE P.shop_id IS NULL 
        ORDER BY S.shop_name ASC", $this->table_name);
		
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
	 * insertPromotion
	 * 
	 * @ClassName  : PromotionDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function insertPromotion($param=array())
	{
		$query = sprintf("
				INSERT INTO %s (
					shop_id
					, is_popup
                    , img_width
                    , img_height
                    , file_name
                    , file_ext
                    , file_url
                    , file_size
					, reg_date
					, edt_date
				)
				VALUES( '%d', %d, '%d', '%d', '%s', '%s', '%s', '%d', 
				date_format(now(), '%%Y%%m%%d%%H%%i%%s'), date_format(now(), '%%Y%%m%%d%%H%%i%%s')
				) ",
				$this->table_name,
				$param['shop_id'],
				$param['is_popup'],
				$param['img_width'],
				$param['img_height'],
				$param['file_name'],
				$param['file_ext'],
				$param['file_url'],
				$param['file_size']
		);
		
		$result = $this->Dao->executeQuery($query);
		
		return $result;		
	}
	
	/**
	 * 
	 * updatePromotion
	 * 
	 * @ClassName  : PromotionDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function updatePromotion($param=array())
	{
		$upquery = "";
		
		if (isset($param['is_popup']) && $param['is_popup'] != "")
			$upquery .= sprintf(", is_popup = %d ", $param['is_popup']);
		if (isset($param['img_width']) && $param['img_width'] != "")
			$upquery .= sprintf(", img_width = %d ", $param['img_width']);
        if (isset($param['img_height']) && $param['img_height'] != "")
			$upquery .= sprintf(", img_height = %d ", $param['img_height']);
		if (!empty($param['file_name']))
			$upquery .= sprintf(", file_name = '%s' ", $param['file_name']);
        if (!empty($param['file_ext']))
			$upquery .= sprintf(", file_ext = '%s' ", $param['file_ext']);
        if (!empty($param['file_url']))
			$upquery .= sprintf(", file_url = '%s' ", $param['file_url']);
        if (isset($param['file_size']) && $param['file_size'] != "")
			$upquery .= sprintf(", file_size = %d ", $param['file_size']);
		
		$query = sprintf("
				UPDATE %s 
				SET edt_date = date_format(now(), '%%Y%%m%%d%%H%%i%%s')
					%s
				WHERE shop_id = %d", $this->table_name, $upquery, $param['shop_id']);

		//new dBug($query);
		$result = $this->Dao->executeQuery($query);
		
		return $result;
	}
	
	/**
	 * 
	 * deletePromotion
	 * 
	 * @ClassName  : PromotionDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $Promotion_id
	 * @return return_type
	 */
	public function deletePromotion($shop_id=0)
	{
		$query = sprintf("DELETE FROM %s WHERE shop_id = %d", $this->table_name, $shop_id);
		
		$result = $this->Dao->executeQuery($query);
		return $result;
	}
}
?>