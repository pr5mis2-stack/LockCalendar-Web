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
class ShopDao {

	private $Dao;
	private $totalCnt;
	private $data_list;
	private $table_name;

	/**
	 *
	 * ShopDao
	 *
	 * @ClassName  : ShopDao
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 */
	public function __construct()
	{
		$this->Dao = new Dao;
		$this->Dao->transaction = false;
		$this->Dao->Connect();
		$this->table_name = "tb_shop";
	}

	/**
	 *
	 * selectShopCnt
	 *
	 * @ClassName  : ShopDao
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function selectShopCnt($param=array())
	{
		$query = sprintf("SELECT COUNT(shop_id) FROM %s ", $this->table_name);


		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";

			if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("shop_id = %d ", $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['parent_shop_id'])){
				$query .= $and . sprintf ("parent_shop_id = %d ", $param['parent_shop_id']);
				$and = " and ";
			}
			if(!empty($param['shop_name'])){
				$query .= $and . sprintf ("shop_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['shop_name']));
				$and = " and ";
			}
			if(!empty($param['ceo_name'])){
				$query .= $and . sprintf ("ceo_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['ceo_name']));
				$and = " and ";
			}
			if(!empty($param['staff_name'])){
				$query .= $and . sprintf ("staff_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['staff_name']));
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
			if ((isset($param['gallery_type']) && $param['gallery_type'] != "")){
				$query .= $and . sprintf ("gallery_type = %d ", $param['gallery_type']);
				$and = " and ";
			}
			if ((isset($param['contract_end']) && $param['contract_end'] != "")){
				$query .= $and . sprintf ("contract_end = %d ", $param['contract_end']);
				$and = " and ";
			}
			if(!empty($param['memo'])){
				$query .= $and . sprintf ("memo LIKE '%%%s%%' ", $this->Dao->escapeParam($param['memo']));
				$and = " and ";
			}
		}

		$this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();
		return $this->totalCnt;
	}

	/**
	 *
	 * selectShopList
	 *
	 * @ClassName  : ShopDao
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function selectShopList($param=array(), $start_num='', $end_num='')
	{
		$query = sprintf("SELECT
								*
								, fn_get_shop_name(parent_shop_id) AS parent_shop_name
								, DATE_FORMAT(reg_date, '%%Y-%%m-%%d') AS short_reg_date
								, DATE_FORMAT(edt_date, '%%Y-%%m-%%d') AS short_edt_date
								, CASE contract_end WHEN 1 THEN '계약종료' ELSE '계약중' END AS contract
							FROM %s ", $this->table_name);


		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";

			if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("shop_id = %d ", $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['parent_shop_id'])){
				$query .= $and . sprintf ("parent_shop_id = %d ", $param['parent_shop_id']);
				$and = " and ";
			}
			if(!empty($param['shop_name'])){
				$query .= $and . sprintf ("shop_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['shop_name']));
				$and = " and ";
			}
			if(!empty($param['ceo_name'])){
				$query .= $and . sprintf ("ceo_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['ceo_name']));
				$and = " and ";
			}
			if(!empty($param['staff_name'])){
				$query .= $and . sprintf ("staff_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['staff_name']));
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
			if ((isset($param['gallery_type']) && $param['gallery_type'] != "")){
				$query .= $and . sprintf ("gallery_type = %d ", $param['gallery_type']);
				$and = " and ";
			}
			if ((isset($param['contract_end']) && $param['contract_end'] != "")){
				$query .= $and . sprintf ("contract_end = %d ", $param['contract_end']);
				$and = " and ";
			}
			if(!empty($param['memo'])){
				$query .= $and . sprintf ("memo LIKE '%%%s%%' ", $this->Dao->escapeParam($param['memo']));
				$and = " and ";
			}
			if((isset($param['is_wedding']) && $param['is_wedding'] != "")){
				$query .= $and . sprintf ("is_wedding = %d ", $param['is_wedding']);
				$and = " and ";
			}
			if((isset($param['is_baby']) && $param['is_baby'] != "")){
				$query .= $and . sprintf ("is_baby = %d ", $param['is_baby']);
				$and = " and ";
			}
			if((isset($param['is_silver']) && $param['is_silver'] != "")){
				$query .= $and . sprintf ("is_silver = %d ", $param['is_silver']);
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
				$query .= sprintf ( " ORDER BY shop_name ASC " );
				break;

			default :
				$query .= sprintf ( " ORDER BY shop_id DESC " );
				break;
		}

		if($end_num != ''){
			$start_num = empty($start_num)? 0:$start_num;
			$query.= sprintf(" LIMIT %d, %d", $start_num, $end_num);
		}
		//echo "<!--\n{$query}\n-->";
		$this->Dao->executeQuery($query);

		$this->data_list = array();						// 코드수정 : 모든 While loop 진입전에 초기화 할것
		while( $Rows = $this->Dao->getFetchArray() ) {
			$this->data_list[] = $Rows;					// 코드수정 : $this->data_list[] = $Rows;
		}
		return $this->data_list;						// 코드수정 : $this->data_list;

	}

	public function selectParentShopCnt($param=array())
	{
		$query = sprintf("SELECT COUNT(shop_id) FROM %s ", $this->table_name);
		$query.=" WHERE	parent_shop_id = 0 ";

		if (!empty($param) && count($param)>0){
			$and = " AND ";

			if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("shop_id = %d ", $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['parent_shop_id'])){
				$query .= $and . sprintf ("parent_shop_id = %d ", $param['parent_shop_id']);
				$and = " and ";
			}
			if(!empty($param['shop_name'])){
				$query .= $and . sprintf ("shop_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['shop_name']));
				$and = " and ";
			}
			if(!empty($param['ceo_name'])){
				$query .= $and . sprintf ("ceo_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['ceo_name']));
				$and = " and ";
			}
			if(!empty($param['staff_name'])){
				$query .= $and . sprintf ("staff_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['staff_name']));
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
			if ((isset($param['gallery_type']) && $param['gallery_type'] != "")){
				$query .= $and . sprintf ("gallery_type = %d ", $param['gallery_type']);
				$and = " and ";
			}
			if ((isset($param['contract_end']) && $param['contract_end'] != "")){
				$query .= $and . sprintf ("contract_end = %d ", $param['contract_end']);
				$and = " and ";
			}
			if(!empty($param['memo'])){
				$query .= $and . sprintf ("memo LIKE '%%%s%%' ", $this->Dao->escapeParam($param['memo']));
				$and = " and ";
			}
		}

		$this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();
		return $this->totalCnt;
	}

	/**
	 *
	 * selectShopList
	 *
	 * @ClassName  : ShopDao
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function selectParentShopList($param=array(), $start_num='', $end_num='')
	{
		$query = sprintf("SELECT
								*
								, fn_get_shop_name(parent_shop_id) AS parent_shop_name
								, DATE_FORMAT(reg_date, '%%Y-%%m-%%d') AS short_reg_date
								, DATE_FORMAT(edt_date, '%%Y-%%m-%%d') AS short_edt_date
								, CASE contract_end WHEN 1 THEN '계약종료' ELSE '계약중' END AS contract
							FROM %s ", $this->table_name);
		$query.=" WHERE	parent_shop_id = 0 ";

		if (!empty($param) && count($param)>0){
			$and = " AND ";

			if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("shop_id = %d ", $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['parent_shop_id'])){
				$query .= $and . sprintf ("parent_shop_id = %d ", $param['parent_shop_id']);
				$and = " and ";
			}
			if(!empty($param['shop_name'])){
				$query .= $and . sprintf ("shop_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['shop_name']));
				$and = " and ";
			}
			if(!empty($param['ceo_name'])){
				$query .= $and . sprintf ("ceo_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['ceo_name']));
				$and = " and ";
			}
			if(!empty($param['staff_name'])){
				$query .= $and . sprintf ("staff_name LIKE '%%%s%%' ", $this->Dao->escapeParam($param['staff_name']));
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
			if ((isset($param['gallery_type']) && $param['gallery_type'] != "")){
				$query .= $and . sprintf ("gallery_type = %d ", $param['gallery_type']);
				$and = " and ";
			}
			if ((isset($param['contract_end']) && $param['contract_end'] != "")){
				$query .= $and . sprintf ("contract_end = %d ", $param['contract_end']);
				$and = " and ";
			}
			if(!empty($param['memo'])){
				$query .= $and . sprintf ("memo LIKE '%%%s%%' ", $this->Dao->escapeParam($param['memo']));
				$and = " and ";
			}
			if((isset($param['is_wedding']) && $param['is_wedding'] != "")){
				$query .= $and . sprintf ("is_wedding = %d ", $param['is_wedding']);
				$and = " and ";
			}
			if((isset($param['is_baby']) && $param['is_baby'] != "")){
				$query .= $and . sprintf ("is_baby = %d ", $param['is_baby']);
				$and = " and ";
			}
			if((isset($param['is_silver']) && $param['is_silver'] != "")){
				$query .= $and . sprintf ("is_silver = %d ", $param['is_silver']);
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
				$query .= sprintf ( " ORDER BY shop_name ASC " );
				break;

			default :
				$query .= sprintf ( " ORDER BY shop_id DESC " );
				break;
		}

		if($end_num != ''){
			$start_num = empty($start_num)? 0:$start_num;
			$query.= sprintf(" LIMIT %d, %d", $start_num, $end_num);
		}
		//echo "<!--\n{$query}\n-->";
		$this->Dao->executeQuery($query);

		$this->data_list = array();						// 코드수정 : 모든 While loop 진입전에 초기화 할것
		while( $Rows = $this->Dao->getFetchArray() ) {
			$this->data_list[] = $Rows;					// 코드수정 : $this->data_list[] = $Rows;
		}
		return $this->data_list;						// 코드수정 : $this->data_list;

	}

	/**
	 *
	 * insertShop
	 *
	 * @ClassName  : ShopDao
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function insertShop($param=array())
	{
		$query = sprintf("
				INSERT INTO %s (
					parent_shop_id
					, shop_name
					, city
					, zone
					, tel

					, fax
					, address
					, address_etc
					, xlocation
					, ylocation

					, ceo_name
					, staff_name
					, staff_tel
					, staff_hp
					, staff_email

					, gallery_type
					, contract_end
					, time_week
					, time_sat
					, time_sun

					, memo
					, is_baby
					, is_wedding
					, is_silver
					, map_url

					, reg_date
					, edt_date
				)
				VALUES( %d , '%s', '%s', '%s', '%s',
					   '%s', '%s', '%s', '%s', '%s',
					   '%s', '%s', '%s', '%s', '%s',
					    %d ,  %d , '%s', '%s', '%s',
					   '%s',  %d ,  %d ,  %d , '%s',
					   date_format(now(), '%%Y%%m%%d%%H%%i%%s'), date_format(now(), '%%Y%%m%%d%%H%%i%%s')
				) ",
				$this->table_name,
				$param['parent_shop_id'],
				$this->Dao->escapeParam($param['shop_name']),
				$this->Dao->escapeParam($param['city']),
				$this->Dao->escapeParam($param['zone']),
				$this->Dao->escapeParam($param['tel']),

				$this->Dao->escapeParam($param['fax']),
				$this->Dao->escapeParam($param['address']),
				$this->Dao->escapeParam($param['address_etc']),
				$this->Dao->escapeParam($param['xlocation']),
				$this->Dao->escapeParam($param['ylocation']),

				$this->Dao->escapeParam($param['ceo_name']),
				$this->Dao->escapeParam($param['staff_name']),
				$this->Dao->escapeParam($param['staff_tel']),
				$this->Dao->escapeParam($param['staff_hp']),
				$this->Dao->escapeParam($param['staff_email']),

				($param['gallery_type'] ?? 0),
				($param['contract_end'] ?? 0),
				$this->Dao->escapeParam($param['time_week']),
				$this->Dao->escapeParam($param['time_sat']),
				$this->Dao->escapeParam($param['time_sun']),

				$this->Dao->escapeParam($param['memo']),
				($param['is_baby'] ?? 0),
				($param['is_wedding'] ?? 0),
				($param['is_silver'] ?? 0),
				$param['map_url']
		);

		$result = $this->Dao->executeQuery($query);
		$notice_id = $this->Dao->getLastInsertID();

		return $notice_id;
	}

	/**
	 *
	 * updateShop
	 *
	 * @ClassName  : ShopDao
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function updateShop($param=array())
	{
		$upquery = "";

		if (!empty($param['parent_shop_id']))
			$upquery .= sprintf(", parent_shop_id = %d ", $param['parent_shop_id']);
		if (!empty($param['shop_name']))
			$upquery .= sprintf(", shop_name = '%s' ", $this->Dao->escapeParam($param['shop_name']));
		if (!empty($param['city']))
			$upquery .= sprintf(", city = '%s' ", $this->Dao->escapeParam($param['city']));
		if (!empty($param['zone']))
			$upquery .= sprintf(", zone = '%s' ", $this->Dao->escapeParam($param['zone']));
		if (!empty($param['tel']))
			$upquery .= sprintf(", tel = '%s' ", $this->Dao->escapeParam($param['tel']));
		if (!empty($param['fax']))
			$upquery .= sprintf(", fax = '%s' ", $this->Dao->escapeParam($param['fax']));
		if (!empty($param['address']))
			$upquery .= sprintf(", address = '%s' ", $this->Dao->escapeParam($param['address']));
		if (!empty($param['address_etc']))
			$upquery .= sprintf(", address_etc = '%s' ", $this->Dao->escapeParam($param['address_etc']));
		if (!empty($param['xlocation']))
			$upquery .= sprintf(", xlocation = '%s' ", $this->Dao->escapeParam($param['xlocation']));
		if (!empty($param['ylocation']))
			$upquery .= sprintf(", ylocation = '%s' ", $this->Dao->escapeParam($param['ylocation']));
		if (!empty($param['ceo_name']))
			$upquery .= sprintf(", ceo_name = '%s' ", $this->Dao->escapeParam($param['ceo_name']));
		if (!empty($param['staff_name']))
			$upquery .= sprintf(", staff_name = '%s' ", $this->Dao->escapeParam($param['staff_name']));
		if (!empty($param['staff_tel']))
			$upquery .= sprintf(", staff_tel = '%s' ", $this->Dao->escapeParam($param['staff_tel']));
		if (!empty($param['staff_hp']))
			$upquery .= sprintf(", staff_hp = '%s' ", $this->Dao->escapeParam($param['staff_hp']));
		if (!empty($param['staff_email']))
			$upquery .= sprintf(", staff_email = '%s' ", $this->Dao->escapeParam($param['staff_email']));
		if ((isset($param['gallery_type']) && $param['gallery_type'] != ""))
			$upquery .= sprintf(", gallery_type = %d ", $param['gallery_type']);
		if ((isset($param['contract_end']) && $param['contract_end'] != ""))
			$upquery .= sprintf(", contract_end = %d ", $param['contract_end']);
		if ((isset($param['is_baby']) && $param['is_baby'] != ""))
			$upquery .= sprintf(", is_baby = %d ", $param['is_baby']);
		if ((isset($param['is_wedding']) && $param['is_wedding'] != ""))
			$upquery .= sprintf(", is_wedding = %d ", $param['is_wedding']);
		if ((isset($param['is_silver']) && $param['is_silver'] != ""))
			$upquery .= sprintf(", is_silver = %d ", $param['is_silver']);

		//if ($param['time_week'])
			$upquery .= sprintf(", time_week = '%s' ", $this->Dao->escapeParam($param['time_week']));
		//if ($param['time_sat'])
			$upquery .= sprintf(", time_sat = '%s' ", $this->Dao->escapeParam($param['time_sat']));
		//if ($param['time_sun'])
			$upquery .= sprintf(", time_sun = '%s' ", $this->Dao->escapeParam($param['time_sun']));
		//if ($param['memo'])
			$upquery .= sprintf(", memo = '%s' ", $this->Dao->escapeParam($param['memo']));
			$upquery .= sprintf(", map_url = '%s' ", $param['map_url']);

		$query = sprintf("
				UPDATE %s
				SET edt_date = date_format(now(), '%%Y%%m%%d%%H%%i%%s')
					%s
				WHERE shop_id = %d", $this->table_name, $upquery, $param['shop_id']);

		$result = $this->Dao->executeQuery($query);

		return $result;

	}

	/**
	 *
	 * deleteShop
	 *
	 * @ClassName  : ShopDao
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $shop_id
	 * @return return_type
	 */
	public function deleteShop($shop_id=0)
	{
		$query = sprintf("DELETE FROM %s WHERE shop_id = %d", $this->table_name, $shop_id);

		$result = $this->Dao->executeQuery($query);
		return $result;
	}
}
?>