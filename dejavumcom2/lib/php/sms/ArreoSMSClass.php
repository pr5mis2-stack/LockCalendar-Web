<?php
import("log4php.Logger");

/**
 * 
 *  ArreoSMSClass
 *
 *  @Desc     : 아레오 활용한 SMS 발송
 *  @Author   : 이정수
 *  @Date     : 2011. 04. 04
 *  @Version  :
 *  
 */  
class ArreoSMSClass {

	private $Conn			= null;
	private $query			= '';
	private $result			= null;

	private $dream_mcp_logger = null;
	public $transaction 	= true;

	// 아레오 정보
	private $arreoInfo = array("host"=>"114.108.171.198", "database"=>"mob_sms", "table"=>"ARREO_SMS"
							, "user"=>"kdhdb", "passwd"=>"gkdntmelql_\$", "usr_id"=>"00000"
							, "site"=>"web", "service"=>"nmarket", "menu"=>"");
	
	/**
	 * 
	 *  ArreoSMSClass
	 *
	 *  @Desc      : 
	 *  @Author    : 이정수
	 *  @Date      : 2011. 4. 4. 오후 3:55:54
	 *  @Return    :
	 */
	public function __construct()
	{
		global $conf_config_home_dir;											// 로그 홈디렉토리 전역변수 선언
		global $conf_nmarket_logger;											// 로그 객체 전역변수 선언
				
		if(empty($conf_nmarket_logger))										// 로그 객체 최초 생성
		{
			Logger::configure($conf_config_home_dir . '/NmarketLog.ini');		// 로그 객체 환경설정
			$this->dream_mcp_logger	= Logger::getLogger("nmarket_logger");	// 로그 객체 생성
			$conf_nmarket_logger = $this->dream_mcp_logger;
		}
		else
		{
			$this->dream_mcp_logger = $conf_nmarket_logger;					// 로그 객체 재사용 (공유)
		}
		
		$this->Connect();
	}

	/**
	 * 
	 *  AddSMS
	 *
	 *  @Desc      : sms 전송 입력 
	 *  @Author    : 이정수
	 *  @Date      : 2011. 4. 4. 오후 4:18:15
	 *  @param unknown_type $sender		: 보내는 사람
	 *  @param unknown_type $receiver	: 받는 사람
	 *  @param unknown_type $sms_msg	: 전송 메세지
	 *  @param unknown_type $sms_time	: 예약시간
	 *  @Return    : 전송결과 (성공 : 1/실패 : 0/오류 : -1)
	 */
	public function AddSMS($sender='', $receiver='', $sms_msg='', $reser_date='', $odr_fg='2')
	{
		if (empty($sender) || empty($receiver) || empty($sms_msg))
			return -1;
		
		$snd_date = date("YmdHis");
		// 예약시간 없을시 현재 시간과 동일처리
		if (empty($reser_date))
			$reser_date = $snd_date;

		if (empty($odr_fg))
			$odr_fg = "2";

		if (!empty($sms_msg))
			$sms_msg = iconv("UTF-8", "EUC-KR", $sms_msg);
			
		$query = sprintf("INSERT INTO %s 
								(CMP_MSG_ID	, CMP_USR_ID, ODR_FG	, SMS_GB	, USED_CD
							   , MSG_GB		, WRT_DTTM	, SND_DTTM	, SND_PHN_ID, RCV_PHN_ID
							   , SND_MSG	, EXPIRE_VAL, SMS_ST	, RSLT_VAL	, site
							   , service	, menu
								)
							VALUES
								(CONCAT(DATE_FORMAT(NOW(), '%%Y%%m%%d%%H%%i%%s'), SUBSTR(RAND(), 3, 8)), '%s', '2', '1', '00'
							   , 'A', '%s', '%s', '%s', '%s'
							   , '%s', '0', '0','99','%s' 
							   , '%s', '%s'
								) "
							, $this->arreoInfo['table']
							, $this->arreoInfo['usr_id']
							, $reser_date
							, $snd_date
							, $sender
							, $receiver
							, $sms_msg
							, $this->arreoInfo['site']
							, $this->arreoInfo['service']
							, $this->arreoInfo['menu']);

		//new dBug($query);
		//exit;
		$this->Connect();
		$result = $this->executeQuery($query);
		//$this->free();
		//$this->Close();
		
		return $result;
	}

	/**
	 * 
	 *  getSMSLogCount
	 *
	 *  @Desc      : 
	 *  @Author    : 이정수
	 *  @Date      : 2011. 4. 4. 오후 7:53:13
	 *  @param unknown_type $param
	 *  @Return    :
	 */
	public function getSMSLogCount($param=array())
	{
		$query = " SELECT
						COUNT(CMP_MSG_ID) AS cnt
					FROM
						ARREO_SMS
					WHERE RSLT_VAL = -100 
					AND site='web'
					AND service='dream'
				 ";

		if (!empty($param) && count($param)>0)
		{
			if(!empty($param['begin_date']) && $param['end_date'])
				$query .= sprintf(" AND SND_DTTM BETWEEN '%s' AND '%s' ", $param['begin_date'], $param['end_date'] );
		}
		//new dBug($query);
		$this->Connect();
		//new dBug($this->Conn);
		$this->executeQuery($query);
		$this->totalCnt = $this->getResult();
		//new dBug($result);
		//$this->free();
		//$this->Close();
		
		return $this->totalCnt;
	}
	
	/**
	 * 
	 *  getSMSLogList
	 *
	 *  @Desc      : 
	 *  @Author    : 이정수
	 *  @Date      : 2011. 4. 4. 오후 7:53:17
	 *  @param unknown_type $param
	 *  @param unknown_type $start_num
	 *  @param unknown_type $end_num
	 *  @Return    :
	 */
	public function getSMSLogList($param=array(), $start_num='', $end_num='')
	{
		$query = sprintf("	SELECT
								*
								, DATE_FORMAT(REG_RCV_DTTM, '%%Y-%%m-%%d %%H:%%i:%%s') AS RECEIVE_DATETIME
							FROM
								ARREO_SMS
							WHERE RSLT_VAL = -100
							AND site='web'
							AND service='dream'							
						");

		if (!empty($param) && count($param)>0)
		{
			if(!empty($param['begin_date']) && $param['end_date'])
				$query .= sprintf(" AND SND_DTTM BETWEEN '%s' AND '%s' ", $param['begin_date'], $param['end_date'] );
		}
		
		$query .= sprintf ( " ORDER BY CMP_MSG_ID DESC " );
			
		if($start_num !== "" && $end_num !== ""){
			$query.= sprintf(" LIMIT %d, %d", $start_num, $end_num);
		}

		//new dBug($query);
		$this->Connect();
		$result = $this->executeQuery($query);
		
		$this->data_list = array();
		while( $Rows = $this->getFetchArray() ) {
			$this->data_list[] = $Rows;
		}
		
		//$this->free();
		//$this->Close();		

		return $this->data_list;
	}
	
	/**
	 * 
	 *  Connect
	 *
	 *  @Desc      : 
	 *  @Author    : 이정수
	 *  @Date      : 2011. 4. 4. 오후 3:55:57
	 *  @Return    :
	 */
	public function Connect()
	{
		global $conf_arreo_db_conn;			// 전역 환경변수 선언
		
		//new dBug($conf_arreo_db_conn);
		/**
		 * db connection start 
		 */
		if(empty($conf_arreo_db_conn))		// 최초 DB 접속
		{
			$this->Conn				= @mysqli_connect($this->arreoInfo['host'], $this->arreoInfo['user'], $this->arreoInfo['passwd'], $this->arreoInfo['database']);
			if(!$this->Conn)		$this->writeLog();
				
			unset($connectionInfo);
	

			register_shutdown_function(array($this, 'Close'));
			$this->executeQuery("SET NAMES euckr");

			$conf_arreo_db_conn =  $this->Conn;		// 최초 DB 접속시  전역 변수에 저장하여 이후 호출시 공유
			//new dbug($this->Conn);
		}
		else
			$this->Conn = $conf_arreo_db_conn;		// 직전 DB 접속이 존재하는 경우 재사용
		/**
		 * db connection end
		 */
	}

	/**
	 * 
	 *  executeQuery
	 *
	 *  @Desc      : 
	 *  @Author    : 이정수
	 *  @Date      : 2011. 4. 4. 오후 7:39:36
	 *  @param unknown_type $query
	 *  @Return    :
	 */
	public function executeQuery($query)
	{
		$this->query	= $query;

		$time_start = time();
		$this->result = @mysqli_query($this->Conn, $this->query);
		$time_end = time();
		$query_exec_time = $time_end - $time_start;					// 쿼리 실행시간 측정 (seconds)

		$this->writeLog($query_exec_time);
		return $this->result;
	}

	/**
	 * 
	 *  getResult
	 *
	 *  @Desc      : 
	 *  @Author    : 이정수
	 *  @Date      : 2011. 4. 4. 오후 8:33:36
	 *  @param unknown_type $row_num
	 *  @param unknown_type $col_num
	 *  @Return    :
	 */
	public function getResult($row_num = 0,$col_num = 0)
	{
		if (!($this->result instanceof mysqli_result))
		{
			$this->writeLog();
			return FALSE;
		}

		if (!@mysqli_data_seek($this->result, $row_num))
		{
			$this->writeLog();
			return FALSE;
		}

		$row = @mysqli_fetch_row($this->result);

		if ($row === null || $row === false || !array_key_exists($col_num, $row))
		{
			$this->writeLog();
			return FALSE;
		}

		return $row[$col_num];
	}	
	
	/**
	 * 
	 *  free
	 *
	 *  @Desc      : 
	 *  @Author    : 이정수
	 *  @Date      : 2011. 4. 4. 오후 7:39:43
	 *  @Return    :
	 */
	public function free()
	{
		$result = @mysqli_free_result($this->result);
		if(!$result)	$this->writeLog();

		return $result;
	}
	
	/**
	 * 
	 *  Close
	 *
	 *  @Desc      : 
	 *  @Author    : 이정수
	 *  @Date      : 2011. 4. 4. 오후 7:39:50
	 *  @Return    :
	 */
	public function Close()
	{
		$result = @mysqli_close($this->Conn);
		if(!$result)	$this->writeLog();
	}
	
	/**
	 * 
	 *  getFetchArray
	 *
	 *  @Desc      : 
	 *  @Author    : 이정수
	 *  @Date      : 2011. 4. 4. 오후 7:49:23
	 *  @Return    :
	 */
	public function getFetchArray()
	{
		$result = @mysqli_fetch_array($this->result);
		
		if(!$result)
		{
			$this->writeLog();
			return FALSE;
		}
		else
			return $result;
	}	
	
	/**
	 * 
	 *  writeLog
	 *
	 *  @Desc      : 
	 *  @Author    : 이정수
	 *  @Date      : 2011. 4. 4. 오후 7:39:55
	 *  @param unknown_type $query_exec_time
	 *  @Return    :
	 */
	private function writeLog($query_exec_time = '')
	{
		$errno = @mysqli_errno($this->Conn);
		$errmsg = @mysqli_error($this->Conn);
		
		if($errno)												// DB 에러가 발생한 경우
		{
			if(!empty($this->query))
				$db_err_log = "[SQL ERROR] : {$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']} [" . $this->query . "] -> <" . $errno . "> : " . $errmsg;
			else
				$db_err_log = "[DB ERROR] : <" . $errno . "> " . $errmsg;

			$this->dream_mcp_logger->debug($db_err_log);
			//exit;												// DB 에러가 발생할 경우 에러발생 지점에서 스크립트 실행을 중지시킨다.
		}
		else													// 정상인 경우
		{
			if(DEBUG_MODE == "ON" && !empty($this->query))		// 서비스 전역 환경설정에서 디버그 모드가 ON으로 설정된 경우 모든 쿼리를 로깅한다.
			{
				$sql_log = "[SQL DEBUG] : {$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']} [" . $query_exec_time ." sec][" . $this->query . "]";
				$this->dream_mcp_logger->debug($sql_log);
				$this->query = "";								// 쿼리변수 초기화
			}
		}
	}
}
?>