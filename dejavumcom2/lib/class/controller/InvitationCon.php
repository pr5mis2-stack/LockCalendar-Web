<?php
import("class.controller.WWWRoot");
import("class.controller.ImageCon");
import("class.model.InvitationDao");

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
class InvitationCon extends WWWRoot {
		
	private $InvitationDao;
	private $ImageCon;
	private $param;

	/**
	 * 
	 * InvitationCon
	 * 
	 * @ClassName  : InvitationCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->InvitationDao 		= new InvitationDao();
		$this->ImageCon		= new Imagecon();
	}

	/**
	 * 
	 * getInvitationCnt
	 * 
	 * @ClassName  : InvitationCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function getInvitationCnt($param=array())
	{
		$result = $this->InvitationDao->selectInvitationCnt($param);
		return $result;		
	}
	
	/**
	 * 
	 * getInvitationList
	 * 
	 * @ClassName  : InvitationCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @param unknown_type $start_num
	 * @param unknown_type $end_num
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 * @return Ambigous <return_type, multitype:, boolean, unknown>
	 */
	public function getInvitationList($param=array(), $start_num='', $end_num='')
	{
		$result = $this->InvitationDao->selectInvitationList($param, $start_num, $end_num);
		return $result;			
	}
	
	/**
	 * 
	 * addInvitation
	 * 
	 * @ClassName  : InvitationCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <return_type, boolean, unknown>
	 * @return Ambigous <return_type, boolean, unknown>
	 */
	public function addInvitation($param=array())
	{
		$result = $this->InvitationDao->insertInvitation($param);
		return $result;			
	}
	
	/**
	 * 
	 * setInvitation
	 * 
	 * @ClassName  : InvitationCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $param
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function setInvitation($param=array())
	{
		$result = 0;	
		if (isset($param['main_id']) && !empty($param['main_id']))
			$result = $this->InvitationDao->updateInvitation($param);
		return $result;			
	}
	
	/**
	 * 
	 * delInvitation
	 * 
	 * @ClassName  : InvitationCon
	 * @Comment    : 
	 * @Author     : suya
	 * @Date       : 2013. 8. 3.
	 * @param unknown_type $main_id
	 * @return Ambigous <number, return_type, NULL>
	 * @return Ambigous <number, return_type, NULL>
	 */
	public function delInvitation($main_id=0)
	{
		$result = 0;	
		if (!empty($main_id))
			$result = $this->InvitationDao->deleteInvitation($main_id);
		return $result;			
	}
}
?>