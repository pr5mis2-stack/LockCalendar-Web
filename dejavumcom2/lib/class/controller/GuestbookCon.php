<?php
import("class.controller.WWWRoot");
import("class.controller.ImageCon");
import("class.model.GuestbookDao");

/**
 * 
 * 
 * @ClassName  :
 * @FileName   : file_name
 * @Package    : package_name
 * @Comment    : 
 * @Author     : suya
 * @Date       : 2013. 8. 3.
 */
class GuestbookCon extends WWWRoot {
		
	private $GuestbookDao;
	private $ImageCon;
	private $param;

	/**
	 * 
	 * GuestbookCon
	 * 
	 * @ClassName  : GuestbookCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->GuestbookDao 		= new GuestbookDao();
		$this->ImageCon		= new Imagecon();
	}

	/**
	 * 
	 * getGuestbookCnt
	 * 
	 * @ClassName  : GuestbookCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function getGuestbookCnt($param=array())
	{
		$result = $this->GuestbookDao->selectGuestbookCnt($param);
		return $result;		
	}
	
	/**
	 * 
	 * getGuestbookList
	 * 
	 * @ClassName  : GuestbookCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 */
	public function getGuestbookList($param=array(), $start_num='', $end_num='')
	{
		$result = $this->GuestbookDao->selectGuestbookList($param, $start_num, $end_num);
		return $result;			
	}
	
	/**
	 * 
	 * addGuestbook
	 * 
	 * @ClassName  : GuestbookCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function addGuestbook($param=array())
	{
		$result = $this->GuestbookDao->insertGuestbook($param);
		return $result;			
	}
	
	/**
	 * 
	 * setGuestbook
	 * 
	 * @ClassName  : GuestbookCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function setGuestbook($param=array())
	{
		$result = 0;	
		if (isset($param['Guestbook_id']) && !empty($param['Guestbook_id']))
			$result = $this->GuestbookDao->updateGuestbook($param);
		return $result;			
	}
	
	/**
	 * 
	 * delGuestbook
	 * 
	 * @ClassName  : GuestbookCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $guestbook_id
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function delGuestbook($guestbook_id=0)
	{
		$result = 0;	
		if (!empty($guestbook_id))
			$result = $this->GuestbookDao->deleteGuestbook($guestbook_id);
		return $result;			
	}
	
	/**
	 * 
	 * delGuestbookByMainID
	 * 
	 * @ClassName  : GuestbookCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $main_id
	 * @return return_type
	 */
	public function delGuestbookByMainID($main_id=0)
	{
		$result = 0;
		if (!empty($main_id))
			$result = $this->GuestbookDao->deleteGuestbookByMainID($main_id);
		return $result;
	}
}
?>