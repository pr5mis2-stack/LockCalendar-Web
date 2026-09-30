<?php
/**
 *  InputDataValidation
 *
 *  @Desc      : 사용자가 입력한 데이터의 유효성을 체크한다.
 *  @Author    : 손명석
 *  @Date      : 2010.11.20
 */

import("log4php.Logger");

class InputDataValidation {

	private $input_data_validation_log;
	private $dejavu_logger;
		
	public function __construct()
	{
		global $conf_config_dir;											// 로그 홈디렉토리 전역변수 선언
		global $conf_dejavu_logger;											// 로그 객체 전역변수 선언
		
		if(empty($conf_dejavu_logger))										// 로그 객체 최초 생성
		{
			Logger::configure($conf_config_dir . '/DejavuLog.ini');		// 로그 객체 환경설정
			$this->dejavu_logger	= Logger::getLogger("dejavu_Logger");	// 로그 객체 생성
			$conf_dejavu_logger = $this->dejavu_logger;
		}
		else
		{
			$this->dejavu_logger = $conf_dejavu_logger;					// 로그 객체 재사용 (공유)
		}

		$this->input_data_validation_log = "";									// 로그 메시지 초기화
	}
	
	/**
 	*  checkEmpty
 	*
 	*  @Desc      : 사용자 입력 값의 Empty (NULL, 0 등) 여부 체크
 	*  @Author    : 손명석
 	*  @Date      : 2010.11.20
 	*  @param     : $field_name (필드명) -> 필드명 규칙 : 필드명<클래스명:메소드명:요약설명>
 	*  @param     : $field_value (필드값)
 	*  @Return    : 유효성 체크 결과를 BOOL 타입으로 리턴
 	*/
	
	public function checkEmpty($field_name, $field_value)
	{
		if(!empty($field_value))
			return TRUE;
		else
		{
			$this->input_data_validation_log = "[Data Validation] : [{$field_name} - {$_SERVER['PHP_SELF']}] -> Data is empty";
			$this->dejavu_logger->debug($this->input_data_validation_log);
			return FALSE;
		}
	}

	/**
 	*  checkDataType
 	*
 	*  @Desc      : 사용자 입력 값의 데이터 타입 일치 여부 체크
 	*  @Author    : 손명석
 	*  @Date      : 2010.11.20
 	*  @param     : $field_name (필드명) -> 필드명 규칙 : 필드명<클래스명:메소드명:요약설명>
 	*  @param     : $field_value (필드값)
 	*  @param     : $field_type (데이터 타입)
 	*  @Return    : 유효성 체크 결과를 BOOL 타입으로 리턴
 	*/
	
	public function checkDataType($field_name, $field_value, $field_type)
	{
		$field_type = strtolower($field_type);	// 데이터 타입 문자열을 소문자로 변환
		$field_type = 'is_' . $field_type;		// 변수 데이터 타입 체크함수 지정
		
		if($field_type($field_value))
			return TRUE;
		else
		{
			$this->input_data_validation_log = "[Data Validation] : [" . $field_name . "] = [" . $field_value . "] -> Data Type Mismatched";
			$this->dejavu_logger->debug($this->input_data_validation_log);
			return FALSE;
		}
	}

	/**
 	*  checkLength
 	*
 	*  @Desc      : 사용자 입력 값의 데이터 길이  체크 (주어진 범위 내의 길이 인지 여부)
 	*  @Author    : 손명석
 	*  @Date      : 2010.11.20
  	*  @param     : $field_name (필드명) -> 필드명 규칙 : 필드명<클래스명:메소드명:요약설명>
 	*  @param     : $field_value (필드값)
 	*  @param     : $field_minlength (데이터 최소 길이)
 	*  @param     : $field_maxlength (데이터 최대 길이)
 	*  @Return    : 유효성 체크 결과를 BOOL 타입으로 리턴
 	*/
	
	public function checkLength($field_name, $field_value, $field_minlength, $field_maxlength)
	{
		if(is_array($field_value))
			$field_length = count($field_value);
		else
			$field_length = strlen($field_value);

		$field_value = print_r($field_value, TRUE);					// 배열인 경우 출력 결과가 변수에 키와 원소로 출력됨
			
		if($field_length >= $field_minlength && $field_length <= $field_maxlength)
			return TRUE;
		else
		{
			if($field_length < $field_minlength)
			{
				$this->input_data_validation_log = "[Data Validation] : [" . $field_name . "] = [" . $field_value . "]" .
													" -> Current Data Length(" . $field_length . ") is short";
			}
			else if($field_length > $field_maxlength)
			{
				$this->input_data_validation_log = "[Data Validation] : [" . $field_name . "] = [" . $field_value . "]" .
													" -> Current Data Length(" . $field_length . ") is long";
			}
				
			$this->dejavu_logger->debug($this->input_data_validation_log);
			return FALSE;
		}
	}
}