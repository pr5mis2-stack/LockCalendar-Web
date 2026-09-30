<?php
import("php.util.InputDataValidationClass");		// log4php 임포트 포함되어 있음

/**
 * 
 *  WWWRoot
 *
 *  @Desc     : WEB서비스 컨트롤러 루트 클래스 (WEB서비스의 모든 컨트롤러 클래스는 WWWRoot를 상속받는다.)
 *  @Author   : 손명석
 *  @Date     : 2010. 11. 24. 오후 19:41:08
 *  @Version  :
 *  
 */
class WWWRoot {

	protected $dejave_logger;
	protected $InputDataValidation;
	
	/**
	 * 
	 *  WWWRoot
	 *
	 *  @Desc      : constructor
	 *  @Author    : 손명석
	 *  @Date      : 2010. 11. 24. 오후 20:41:31
	 *  @Return    : no
	 */
	public function __construct()
	{
		global $conf_config_dir;											// 로그 홈디렉토리 전역변수 선언
		global $conf_dejavu_logger;											// 로그 객체 전역변수 선언
		
		if(empty($conf_dejavu_logger))										// 로그 객체 최초 생성
		{
			Logger::configure($conf_config_dir . '/DejavuLog.ini');		// 로그 객체 환경설정
			$this->dejave_logger	= Logger::getLogger("dejavu_Logger");	// 로그 객체 생성
			$conf_dejavu_logger = $this->dejave_logger;
		}
		else
		{
			$this->dejave_logger = $conf_dejavu_logger;					// 로그 객체 재사용 (공유)
		}
		
		$this->InputDataValidation = new InputDataValidation();
	}
}
?>