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
class GalleryPhotoDao {
	
	private $Dao;
	private $totalCnt;
	private $data_list;
	private $table_name;
	
	/**
	 * 
	 * GalleryPhotoDao
	 * 
	 * @ClassName  : GalleryPhotoDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 */
	public function __construct()
	{
		$this->Dao = new Dao;
		$this->Dao->transaction = false;
		$this->Dao->Connect();
		$this->table_name = "tb_gallery_photo";
	}
	
	/**
	 * 
	 * selectGalleryPhotoCnt
	 * 
	 * @ClassName  : GalleryPhotoDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function selectGalleryPhotoCnt($param=array())
	{
		$query = sprintf("SELECT COUNT(photo_id) FROM %s ", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
				
			if(!empty($param['photo_id'])){
				$query .= $and . sprintf ("photo_id = %d ", $param['photo_id']);
				$and = " and ";
			}
			if(!empty($param['main_id'])){
				$query .= $and . sprintf ("main_id = %d ", $param['main_id']);
				$and = " and ";
			}
		}
			
		$this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();			
		return $this->totalCnt;		
	}
	
	/**
	 * 
	 * selectGalleryPhotoList
	 * 
	 * @ClassName  : GalleryPhotoDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function selectGalleryPhotoList($param=array(), $start_num='', $end_num='')
	{
		$query = sprintf("SELECT * FROM %s ", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
		
					if(!empty($param['photo_id'])){
				$query .= $and . sprintf ("photo_id = %d ", $param['photo_id']);
				$and = " and ";
			}
			if(!empty($param['main_id'])){
				$query .= $and . sprintf ("main_id = %d ", $param['main_id']);
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
			case "20" :		// 랜덤
				$query .= sprintf ( " ORDER BY RAND() DESC " );
				break;
			case "30" :
				$query .= sprintf (" ORDER BY photo_id ASC ");
				break;
				
			default :
				$query .= sprintf ( " ORDER BY order_no, photo_id ASC" );
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
	 * insertGalleryPhoto
	 * 
	 * @ClassName  : GalleryPhotoDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function insertGalleryPhoto($param=array())
	{
		$query = sprintf("
				INSERT INTO %s (
					main_id
					, photo_name
					, photo_ext
					, photo_url
					, photo_size

					, photo_width
					, photo_height
					, photo_memo
					, order_no
					, reg_date
					, edt_date
				)
				VALUES(  %d , '%s', '%s', '%s', %d ,
						 %d ,  %d , '%s', %d,
				date_format(now(), '%%Y%%m%%d%%H%%i%%s'), date_format(now(), '%%Y%%m%%d%%H%%i%%s')
				) ",
				$this->table_name,
				$param['main_id'],
				$this->Dao->escapeParam($param['photo_name']),
				$this->Dao->escapeParam($param['photo_ext']),
				$this->Dao->escapeParam($param['photo_url']),
				$param['photo_size'],
				
				$param['photo_width'],
				$param['photo_height'],
				$this->Dao->escapeParam($param['photo_memo']),
				$param['order_no']);
		//new dBug($query);
		$result = $this->Dao->executeQuery($query);
		$notice_id = $this->Dao->getLastInsertID();
		
		return $notice_id;		
	}
	
	/**
	 * 
	 * updateGalleryPhoto
	 * 
	 * @ClassName  : GalleryPhotoDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function updateGalleryPhoto($param=array())
	{
		$upquery = "";
		
		if (!empty($param['photo_name']))
			$upquery .= sprintf(", photo_name = '%s' ", $this->Dao->escapeParam($param['photo_name']));
		if (!empty($param['photo_ext']))
			$upquery .= sprintf(", photo_ext = '%s' ", $this->Dao->escapeParam($param['photo_ext']));
		if (!empty($param['photo_url']))
			$upquery .= sprintf(", photo_url = '%s' ", $this->Dao->escapeParam($param['photo_url']));
		if (!empty($param['photo_size']))
			$upquery .= sprintf(", photo_size = %d ", $param['photo_size']);

		if (!empty($param['photo_width']))
			$upquery .= sprintf(", photo_width = %d ", $param['photo_width']);
		if (!empty($param['photo_height']))
			$upquery .= sprintf(", photo_height = %d ", $param['photo_height']);
		if (!empty($param['photo_memo']))
			$upquery .= sprintf(", photo_memo = '%s' ", $this->Dao->escapeParam($param['photo_memo']));
		
		
		$query = sprintf("
				UPDATE %s 
				SET edt_date = date_format(now(), '%%Y%%m%%d%%H%%i%%s')
					%s
				WHERE photo_id = %d", $this->table_name, $upquery, $param['photo_id']);

		$result = $this->Dao->executeQuery($query);
		
		return $result;
		
	}
	
	/**
	 * 
	 * deleteGalleryPhoto
	 * 
	 * @ClassName  : GalleryPhotoDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $photo_id
	 * @return return_type
	 */
	public function deleteGalleryPhoto($photo_id=0)
	{
		$query = sprintf("DELETE FROM %s WHERE photo_id = %d", $this->table_name, $photo_id);
		
		$result = $this->Dao->executeQuery($query);
		return $result;
	}

	/**
	 * 
	 * deleteGalleryPhotoByMainID
	 * 
	 * @ClassName  : GalleryPhotoDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $main_id
	 * @return return_type
	 */
	public function deleteGalleryPhotoByMainID($main_id=0)
	{
		$query = sprintf("DELETE FROM %s WHERE main_id = %d", $this->table_name, $main_id);
	
		$result = $this->Dao->executeQuery($query);
		return $result;
	}
	
	/**
	 * 
	 * deleteGalleryPhotoByOrderNo
	 * 
	 * @ClassName  : GalleryPhotoDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 11. 21.
	 * @param unknown_type $main_id
	 * @param unknown_type $order_no
	 * @return return_type
	 */
	public function deleteGalleryPhotoByOrderNo($main_id=0, $order_no=0)
	{
		$query = sprintf("DELETE FROM %s WHERE main_id = %d AND order_no = %d", $this->table_name, $main_id, $order_no);
		
		$result = $this->Dao->executeQuery($query);
		return $result;
	}
}
?>