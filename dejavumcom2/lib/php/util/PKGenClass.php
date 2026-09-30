<?php
import("class.model.CommonCodeDao");
import("php.util.InputDataValidationClass");

/**
 *  PKGenClass
 *
 *  @Desc      : VARCHAR 타입의 PK를 생성해서 리턴한다.
 *  @Author    : 손명석
 *  @Date      : 
 */

class PKGen {

	private $Dao;
	private $InputDataValidation;
	private $CommonCodeDao;
	
	private $pk;
	private $pk_min_length		= 30;								// VARCHAR 타입의 PK 길이 정의
	private $pk_max_length		= 50;								// VARCHAR 타입의 PK 길이 정의
	private $pk_initial_length	= 2;								// VARCHAR 타입의 PK 이니셜 코드 길이 정의

	/**
 	*  PKGen	  : 생성자 (Dao, InputDataValidation 객체 생성)
 	*  @Desc      : 
 	*  @Author    : 손명석
 	*  @Date      : 2010.11.20
 	*  @Return    : no
 	*/
	
	public function __construct()
	{
		$this->CommonCodeDao = new CommonCodeDao();
		$this->InputDataValidation = new InputDataValidation();
	}
	
	
	/**
	 *  getPrimaryKey
	 *
	 *  @Desc      : DB 테이블에서 VARCHAR 타입의 Primary Key를 생성해서 리턴한다. PK 생성에 실패한 경우 FALSE를 반환한다.
	 *  @Author    : 손명석
	 *  @Date      : 2010. 11. 18. 13:33:19
	 *  @param     : $table_name (PK를 생성할 테이블명), $old_pk (구시스템 PK -> 디폴트 : NULL)
	 *  @Return    : $pk (최소 30자리, 최대 50자리)
	 *  					- 신규 발급코드 30 자리
	 *						   	> PK 구분코드(2자리),
	 *   						> 날짜시간 : 14자리 (YYYYMMDDHHMMSS),
	 *   						> usec : 8자리 (자연수로 변환),
	 *   						> random number : 6자리 (seed는 usec로 지정)
	 *   					- 구분자 : 하이픈 ('-') => 구 시스템 PK 가 존재하는 경우에만 구분자로 사용함
	 *   					- 구시스템 PK (신규 데이터인 경우 Max + 1로 산정) => 신규 등록 데이터에서는 NULL로 처리 
	 *  @Code      : PK 구분 코드 (2자리, 영문대문자)  -> DB 코드테이블 (tb_common_code) 참조    
	 */
	
	public function getPrimaryKey($param)
	{
		/**
		 *  파라미터 배열 예시
		 * 	$param = array();
			$param['code_tbl'] = "tb_work";
			$param['code_fld'] = 'pk';
			$param['old_pk'] = '20842';

		 */
		
		/**
		 * PK 이니셜 코드를 얻는다.
		*/
		
		$pk_initial_list = array();
		$pk_initial_list = $this->CommonCodeDao->getCommonCodeList($param);
		$pk_initial = strtoupper(trim($pk_initial_list[0]['code_val']));

		$log_msg = $param['code_tbl'] . " [" . __METHOD__ . "]";

		if(!$this->InputDataValidation->checkEmpty($log_msg, $pk_initial)
				|| !$this->InputDataValidation->checkLength($log_msg, $pk_initial, $this->pk_initial_length,$this->pk_initial_length))
		{
			exit;
		}
		
		/**
		 * Unix Timestamp를 얻어 PK를 생성한다.
		 */
		list($usec, $sec) = explode(" ", microtime());
		$usec *= 100000000;
		srand ($usec);
		$randval = rand(0, 999999);
		
		$old_pk = trim($param['old_pk']);
		
		if(!empty($old_pk))
			$this->pk = sprintf ("%02s%14s%08s%06s-%s", $pk_initial, date("YmdHis", $sec), $usec, $randval, $old_pk);
		else
			$this->pk = sprintf ("%02s%14s%08s%06s", $pk_initial, date("YmdHis", $sec), $usec, $randval);
		
		$this->pk = trim($this->pk);

		/**
		 * 생성된 PK의 길이를 체크한다. (최소 30, 최대 50)
		 */
		if(!$this->InputDataValidation->checkLength($log_msg, $this->pk, $this->pk_min_length, $this->pk_max_length))
		{
			exit;
		}

		return $this->pk;
	}
	
	/**
 	*  getOldNewPK	  : 생성자 (Dao, InputDataValidation 객체 생성)
 	*
 	*  @Desc      : 구시스템에서 이관한 데이터의 PK 인지 신시스템 고유의 PK 인지 판별하여 리턴한다.
 	*  @Author    : 손명석
 	*  @Date      : 2010.11.20
 	*  @param     : $pk 
 	*  @Return    : $old_pk or $new_pk
 	*/
	public function getOldNewPK($pk)
	{
		list($new_pk, $old_pk) = explode("-", $pk);
		
		if(!empty($old_pk))
			return $old_pk;
		else
			return $new_pk;
	}
}
?>