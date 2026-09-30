<?php
import("php.database.DaoClass");

/**
 * 
 * 
 * @ClassName  : Text2ImgDao
 * @FileName   : file_name
 * @Package    : package_name
 * @Comment    : 
 * @Author     : suya
 * @Date       : 2013. 7. 29.
 */
class Text2ImgDao {
	
	private $Dao;
	private $totalCnt;
	private $data_list;
	private $table_name;
	
	/**
	 * 
	 * Text2ImgDao
	 * 
	 * @ClassName  : Text2ImgDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 */
	public function __construct()
	{
		$this->Dao = new Dao;
		$this->Dao->transaction = false;
		$this->Dao->Connect();
		$this->table_name = "tb_text2img";
	}

	/**
	 * 
	 * getLastImgId
	 * 
	 * @ClassName  : Text2ImgDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 9. 23.
	 * @return Ambigous <boolean, unknown>
	 * @return Ambigous <boolean, unknown>
	 */
	public function getLastImgId()
	{
		$query = sprintf("SELECT (IFNULL(MAX(img_id), 0) + 1) AS next_img_id FROM %s ", $this->table_name);

		$this->Dao->executeQuery($query);
		return $this->Dao->getResult();
	}
	
	/**
	 * 
	 * selectText2ImgCnt
	 * 
	 * @ClassName  : Text2ImgDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 29.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function selectText2ImgCnt($param=array())
	{
		$query = sprintf("SELECT COUNT(img_id) FROM %s ", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
			
			if(!empty($param['img_id'])){
				$query .= $and . sprintf ("img_id = %d ", $param['img_id']);
				$and = " and ";
			}
			if(!empty($param['main_id'])){
				$query .= $and . sprintf ("main_id = %d ", $param['main_id']);
				$and = " and ";
			}
			if(!empty($param['label'])){
				$query .= $and . sprintf ("label = '%s' ", $this->Dao->escapeParam($param['label']));
				$and = " and ";
			}
			if(!empty($param['font'])){
				$query .= $and . sprintf ("font = '%s' ", $this->Dao->escapeParam($param['font']));
				$and = " and ";
			}
			if(!empty($param['size'])){
				$query .= $and . sprintf ("size = %d ", $param['size']);
				$and = " and ";
			}
			if(!empty($param['color'])){
				$query .= $and . sprintf ("color = '%s' ", $this->Dao->escapeParam($param['color']));
				$and = " and ";
			}
			if(!empty($param['stroke'])){
				$query .= $and . sprintf ("stroke = '%s' ", $this->Dao->escapeParam($param['stroke']));
				$and = " and ";
			}
			if(!empty($param['stroke_width'])){
				$query .= $and . sprintf ("stroke_width = %d ", $param['stroke_width']);
				$and = " and ";
			}
		}
			
		$this->Dao->executeQuery($query);
		$this->totalCnt = $this->Dao->getResult();			
		return $this->totalCnt;		
	}
	
	/**
	 * 
	 * selectText2ImgList
	 * 
	 * @ClassName  : Text2ImgDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return return_type
	 */
	public function selectText2ImgList($param=array(), $start_num='', $end_num='')
	{
		$query = sprintf("SELECT * FROM %s ", $this->table_name);
		
		
		if (!empty($param) && count($param)>0){
			$query.=" WHERE	1 ";
			$and = " AND ";
		
			if(!empty($param['img_id'])){
				$query .= $and . sprintf ("img_id = %d ", $param['img_id']);
				$and = " and ";
			}
			if(!empty($param['main_id'])){
				$query .= $and . sprintf ("main_id = %d ", $param['main_id']);
				$and = " and ";
			}
			if(!empty($param['label'])){
				$query .= $and . sprintf ("label = '%s' ", $this->Dao->escapeParam($param['label']));
				$and = " and ";
			}
			if(!empty($param['font'])){
				$query .= $and . sprintf ("font = '%s' ", $this->Dao->escapeParam($param['font']));
				$and = " and ";
			}
			if(!empty($param['size'])){
				$query .= $and . sprintf ("size = %d ", $param['size']);
				$and = " and ";
			}
			if(!empty($param['color'])){
				$query .= $and . sprintf ("color = '%s' ", $this->Dao->escapeParam($param['color']));
				$and = " and ";
			}
			if(!empty($param['stroke'])){
				$query .= $and . sprintf ("stroke = '%s' ", $this->Dao->escapeParam($param['stroke']));
				$and = " and ";
			}
			if(!empty($param['stroke_width'])){
				$query .= $and . sprintf ("stroke_width = %d ", $param['stroke_width']);
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
				$query .= sprintf ( " ORDER BY img_id DESC " );
				break;
			case "20" :		// 제목순
				$query .= sprintf ( " ORDER BY main_id ASC " );
				break;
		
			default :
				$query .= sprintf ( " ORDER BY reg_date DESC " );
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
	 * insertText2Img
	 * 
	 * @ClassName  : Text2ImgDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function insertText2Img($param=array())
	{
		$query = sprintf("
				INSERT INTO %s (
					main_id
					, label
					, font
					, size
					, color
				
					, stroke
					, stroke_width
					, reg_date
					, edt_date
				)
				VALUES( %d , '%s' , '%s',  %d , '%s',
					   '%s', %d , date_format(now(), '%%Y%%m%%d%%H%%i%%s'), date_format(now(), '%%Y%%m%%d%%H%%i%%s')
				) ",
				$this->table_name,

				$param['main_id'],
				$this->Dao->escapeParam($param['label']),
				$this->Dao->escapeParam($param['font']),
				$param['size'],
				$this->Dao->escapeParam($param['color']),
				
				$this->Dao->escapeParam($param['stroke']),
				$param['stroke_width']
		);
		
		$result = $this->Dao->executeQuery($query);
		$notice_id = $this->Dao->getLastInsertID();
		
		return $notice_id;		
	}
	
	/**
	 * 
	 * deleteText2Img
	 * 
	 * @ClassName  : Text2ImgDao
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 7. 30.
	 * @param unknown_type $Text2Img_id
	 * @return return_type
	 */
	public function deleteText2Img($main_id=0)
	{
		$query = sprintf("DELETE FROM %s WHERE main_id = %d", $this->table_name, $main_id);
		
		$result = $this->Dao->executeQuery($query);
		return $result;
	}
}
?>