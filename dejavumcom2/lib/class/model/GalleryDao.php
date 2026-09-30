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
class GalleryDao {
	
	private $Dao;
	private $totalCnt;
	private $data_list;
	private $table_name;
	
	/**
	 * 
	 * GalleryDao
	 * 
	 * @ClassName  : GalleryDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 */
	public function __construct()
	{
		$this->Dao = new Dao;
		$this->Dao->transaction = false;
		$this->Dao->Connect();
		$this->table_name = "tb_gallery";
	}

	public function selectGalleryCnt($param=array())
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
		//exit;		
		$this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();			
		return $this->totalCnt;
	}	
	
	/**
	 * 
	 * selectGalleryList
	 * 
	 * @ClassName  : GalleryDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function selectGalleryList($param=array())
	{
		$query = sprintf("SELECT * FROM %s ", $this->table_name);
		
		
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

		$this->data_list = array();						// 코드수정 : 모든 While loop 진입전에 초기화 할것
		while( $Rows = $this->Dao->getFetchArray() ) {
			$this->data_list[] = $Rows;					// 코드수정 : $this->data_list[] = $Rows;
		}
		return $this->data_list;						// 코드수정 : $this->data_list;
		
	}
	
	/**
	 * 
	 * insertGallery
	 * 
	 * @ClassName  : GalleryDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function insertGallery($param=array())
	{
		$query = sprintf("
				INSERT INTO %s (
					main_id
					, gallery_type
				)
				VALUES(%d , %d) ",
				$this->table_name,
				$param['main_id'],
				$param['gallery_type']
		);
		//new dBug($query);
		//exit;
		$result = $this->Dao->executeQuery($query);
		$notice_id = $this->Dao->getLastInsertID();
		//new dBug($query);
		return $notice_id;		
	}
	
	/**
	 * 
	 * updateGallery
	 * 
	 * @ClassName  : GalleryDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function updateGallery($param=array())
	{
		$upquery = "";

		if (!empty($param['gallery_type']))
			$upquery .= sprintf(", gallery_type = %d ", $param['gallery_type']);
		
		$query = sprintf("
				UPDATE %s 
				SET main_id = main_id
					%s
				WHERE main_id = %d", $this->table_name, $upquery, $param['main_id']);

		$result = $this->Dao->executeQuery($query);
		//new dBug($query);
		//exit;
		return $result;
		
	}
	
	/**
	 * 
	 * deleteGallery
	 * 
	 * @ClassName  : GalleryDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $adver_id
	 * @return return_type
	 */
	public function deleteGallery($main_id=0)
	{
		$query = sprintf("DELETE FROM %s WHERE main_id = %d", $this->table_name, $main_id);
		
		$result = $this->Dao->executeQuery($query);
		return $result;
	}
}
?>
