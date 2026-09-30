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
class ShopMultimediaDao {

	private $Dao;
	private $totalCnt;
	private $data_list;
	private $table_name;

	/**
	 *
	 * ShopMultimediaDao
	 *
	 * @ClassName  : ShopMultimediaDao
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 */
	public function __construct()
	{
		$this->Dao = new Dao;
		$this->Dao->transaction = false;
		$this->Dao->Connect();
		$this->table_name = "tb_shop_multimedia";
	}

	/**
	 *
	 * selectShopMultimediaCnt
	 *
	 * @ClassName  : ShopMultimediaDao
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function selectShopMultimediaCnt($param=array())
	{
		$query = sprintf("SELECT COUNT(media_id) FROM %s ", $this->table_name);


		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";

			if(!empty($param['media_id'])){
				$query .= $and . sprintf ("media_id = %d ", $param['media_id']);
				$and = " and ";
			}
			if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("shop_id = %d ", $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['media_type'])){
				$query .= $and . sprintf ("media_type IN ( %s ) ", $param['media_type']);
				$and = " and ";
			}
			else
			{
				$query .= $and . sprintf ("media_type IN (1, 2) ");	// 선택 옵션 없을경우 1:약도,2:식장 이미지만 선택
				$and = " and ";
			}
		}

		$this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();
		return $this->totalCnt;
	}

	/**
	 *
	 * selectShopMultimediaList
	 *
	 * @ClassName  : ShopMultimediaDao
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function selectShopMultimediaList($param=array(), $start_num='', $end_num='')
	{
		$query = sprintf("SELECT * FROM %s ", $this->table_name);


		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";

			if(!empty($param['media_id'])){
				$query .= $and . sprintf ("media_id = %d ", $param['media_id']);
				$and = " and ";
			}
			if(!empty($param['shop_id'])){
				$query .= $and . sprintf ("shop_id = %d ", $param['shop_id']);
				$and = " and ";
			}
			if(!empty($param['media_type'])){
				$query .= $and . sprintf ("media_type IN ( %s ) ", $param['media_type']);
				$and = " and ";
			}
			else
			{
				$query .= $and . sprintf ("media_type IN (1, 2) ");	// 선택 옵션 없을경우 1:약도,2:식장 이미지만 선택
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
				$query .= sprintf ( " ORDER BY file_name ASC " );
				break;

			default :
				$query .= sprintf ( " ORDER BY media_id DESC " );
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
	 * insertShopMultimedia
	 *
	 * @ClassName  : ShopMultimediaDao
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function insertShopMultimedia($param=array())
	{
		$query = sprintf("
				INSERT INTO %s (
					shop_id
					, media_type
					, file_name
					, file_ext
					, file_url
					, file_size
					, photo_width
					, photo_height
					, reg_date
					, edt_date
				)
				VALUES( %d ,  %d , '%s', '%s', '%s',
					    %d ,  %d ,  %d ,
				date_format(now(), '%%Y%%m%%d%%H%%i%%s'), date_format(now(), '%%Y%%m%%d%%H%%i%%s')
				) ",
				$this->table_name,
				$param['shop_id'],
				$param['media_type'],
				$this->Dao->escapeParam($param['file_name']),
				$this->Dao->escapeParam($param['file_ext']),
				$this->Dao->escapeParam($param['file_url']),
				$param['file_size'],
				$param['photo_width'],
				$param['photo_height']
		);
		//new dBug($query);
		//exit;
		$result = $this->Dao->executeQuery($query);
		$notice_id = $this->Dao->getLastInsertID();

		return $notice_id;
	}

	/**
	 *
	 * updateShopMultimedia
	 *
	 * @ClassName  : ShopMultimediaDao
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function updateShopMultimedia($param=array())
	{
		$upquery = "";

		if (!empty($param['shop_id']))
			$upquery .= sprintf(", shop_id = %d ", $param['shop_id']);
		if (!empty($param['media_type']))
			$upquery .= sprintf(", media_type = %d ", $param['media_type']);
		if (!empty($param['file_name']))
			$upquery .= sprintf(", file_name = '%s' ", $this->Dao->escapeParam($param['file_name']));
		if (!empty($param['file_ext']))
			$upquery .= sprintf(", file_ext = '%s' ", $this->Dao->escapeParam($param['file_ext']));
		if (!empty($param['file_url']))
			$upquery .= sprintf(", file_url = '%s' ", $this->Dao->escapeParam($param['file_url']));
		if (!empty($param['file_size']))
			$upquery .= sprintf(", file_size = %d ", $param['file_size']);
		if (!empty($param['photo_width']))
			$upquery .= sprintf(", photo_width = %d ", $param['photo_width']);
		if (!empty($param['photo_height']))
			$upquery .= sprintf(", photo_height = %d ", $param['photo_height']);

		$query = sprintf("
				UPDATE %s
				SET edt_date = date_format(now(), '%%Y%%m%%d%%H%%i%%s')
					%s
				WHERE media_id = %d", $this->table_name, $upquery, $param['media_id']);

		$result = $this->Dao->executeQuery($query);

		return $result;

	}

	/**
	 *
	 * deleteShopMultimedia
	 *
	 * @ClassName  : ShopMultimediaDao
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $media_id
	 * @return return_type
	 */
	public function deleteShopMultimedia($media_id=0)
	{
		$query = sprintf("DELETE FROM %s WHERE media_id = %d", $this->table_name, $media_id);

		$result = $this->Dao->executeQuery($query);
		return $result;
	}

	/**
	 *
	 * deleteShopMultimediaByShopID
	 *
	 * @ClassName  : ShopMultimediaDao
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2013. 8. 1.
	 * @param unknown_type $shop_id
	 * @return return_type
	 */
	public function deleteShopMultimediaByShopID($shop_id=0)
	{
		$query = sprintf("DELETE FROM %s WHERE shop_id = %d", $this->table_name, $shop_id);

		$result = $this->Dao->executeQuery($query);
		return $result;
	}
}
?>