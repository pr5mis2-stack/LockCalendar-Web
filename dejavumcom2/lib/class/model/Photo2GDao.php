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
class Photo2GDao {
	
	private $Dao;
	private $totalCnt;
	private $data_list;
	private $table_name;
	
	/**
	 * 
	 * Photo2GDao
	 * 
	 * @ClassName  : Photo2GDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 */
	public function __construct()
	{
		$this->Dao = new Dao;
		$this->Dao->transaction = false;
		$this->Dao->Connect();
		$this->table_name = "tb_2gimg";
	}
	
	/**
	 * 
	 * selectPhoto2GCnt
	 * 
	 * @ClassName  : Photo2GDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function selectPhoto2GCnt($main_id=0)
	{
		$query = sprintf("SELECT COUNT(main_id) FROM %s WHERE main_id = %d", $this->table_name, $main_id);
			
		$this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();			
		return $this->totalCnt;		
	}
		
	/**
	 * 
	 * insertPhoto2G
	 * 
	 * @ClassName  : Photo2GDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function insertPhoto2G($param=array())
	{
		$query = sprintf("
				INSERT INTO %s (
					main_id
					, photo_url
					, reg_date
					, edt_date
				)
				VALUES( %d, '%s',
				date_format(now(), '%%Y%%m%%d%%H%%i%%s'), date_format(now(), '%%Y%%m%%d%%H%%i%%s')
				) ",
				$this->table_name,
				$param['main_id'],
				$this->Dao->escapeParam($param['photo_url'])
		);
		
		$result = $this->Dao->executeQuery($query);
		$notice_id = $this->Dao->getLastInsertID();
		
		return $notice_id;		
	}
	
	/**
	 * 
	 * updatePhoto2G
	 * 
	 * @ClassName  : Photo2GDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function updatePhoto2G($param=array())
	{
		$query = sprintf("
				UPDATE %s 
				SET edt_date = date_format(now(), '%%Y%%m%%d%%H%%i%%s')
					, photo_url = '%s'
				WHERE main_id = %d", $this->table_name, $this->Dao->escapeParam($param['photo_url']), $param['main_id']);

		$result = $this->Dao->executeQuery($query);
		
		return $result;
		
	}
}
?>