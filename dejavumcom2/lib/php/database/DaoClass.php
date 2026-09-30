<?php
import("log4php.Logger");

/**===========================================================================
 * 용도	: ActionClass 사용시 Database의 연결 및 자료의 사용을 용이하게 해준다.
 * 연락처	: spacer.ha@gmail.com
 *
 * ※ 2026-09 PHP 8.4 마이그레이션을 위해 mysql_* (PHP7에서 제거된 확장) →
 *    mysqli_* 로 내부 구현을 교체함. 외부에 노출되는 public 메서드 이름/
 *    인자/반환값의 의미는 원본과 100% 동일하게 유지했으므로, 이 클래스를
 *    사용하는 다른 코드는 전혀 수정할 필요 없음.
 ============================================================================*/

class Dao {
	// 상대경로 문제 방지를 위해 이 파일이 있는 절대경로로 고정 (원본은 빈 문자열이었음)
	private $daoPath		= __DIR__ . '/';

	private $dbConfig		= null;
	private $tables			= null;
	private $siteConfig 	= null;
	private $ConnSel		= null;		// mysqli 커넥션 객체 (원본은 mysql resource)
	private $ConnAdd		= null;		// mysqli 커넥션 객체 (원본은 mysql resource)
	private $query			= '';
	private $result			= null;		// mysqli_result 객체 (원본은 mysql resource)
	private $stmt			= null;
	private $sqlParamNameArray = array();

	private $guiguiland_logger = null;
	public $transaction 	= true;

	public function __construct()
	{
		global $conf_config_dir;											// 로그 홈디렉토리 전역변수 선언
		global $conf_dejavu_logger;											// 로그 객체 전역변수 선언

		// PHP 8.1+ 는 mysqli 에러를 기본적으로 예외로 던지므로,
		// 이 클래스의 기존 동작(에러시 false 반환 + writeLog로 로깅)을
		// 그대로 유지하기 위해 예외 모드를 명시적으로 끈다.
		mysqli_report(MYSQLI_REPORT_OFF);

		if(empty($conf_dejavu_logger))										// 로그 객체 최초 생성
		{
			Logger::configure($conf_config_dir . '/DejavuLog.ini');		// 로그 객체 환경설정
			$this->guiguiland_logger	= Logger::getLogger("guiguiland_Logger");	// 로그 객체 생성
			$conf_dejavu_logger = $this->guiguiland_logger;
		}
		else
		{
			$this->guiguiland_logger = $conf_dejavu_logger;					// 로그 객체 재사용 (공유)
		}
	}

	private function initDao() {

		$conf_db				= parse_ini_file($this->daoPath."Dao.ini");
		$conf_table				= parse_ini_file($this->daoPath."DaoTables.ini");

		$this->dbConfig			= (object)$conf_db;
		$this->tables			= (object)$conf_table;
	}

	/**
	 * 랜덤 DB Connection
	 * Select Query인경우 사용할것
	 */
	public function Connect()
	{
		global $conf_sel_db_conn;			// 전역 환경변수 선언
		global $conf_add_db_conn;			// 전역 환경변수 선언

		// Select용 Connection
		if(empty($conf_sel_db_conn))		// 최초 DB 접속
		{
			$this->initDao();

			if (strpos(strtoupper($_SERVER['DOCUMENT_ROOT']), "C:/") === false)
			{
				if (empty($_SERVER['SERVER_ADDR']))
					$connectionInfo	= parse_ini_file($this->daoPath."DaoConnectionDev.ini");	// 서버내 php실행
				else
					$connectionInfo	= parse_ini_file($this->daoPath."DaoConnection.ini");		// 상용 DB서버 (단일 서버 구성)
			}
			else
			{
				$connectionInfo	= parse_ini_file($this->daoPath."DaoConnectionDev.ini");	// 개발 환경 (로컬 PC)
			}

			// 랜덤 host정보 설정 (host2가 없으면 host로 대체)
			$host2 = !empty($connectionInfo['host2']) ? $connectionInfo['host2'] : $connectionInfo['host'];
			$arrHost = array($connectionInfo['host'], $host2);
			$rand_key = rand(0, 1);
			$selHost = $arrHost[$rand_key];

			$this->ConnSel			= @mysqli_connect($selHost, $connectionInfo['user'], $connectionInfo['passwd'], $connectionInfo['database']);
			if(!$this->ConnSel)		$this->writeLog($this->ConnSel);

			unset($connectionInfo);

			$conf_sel_db_conn =  $this->ConnSel;		// 최초 DB 접속시  전역 변수에 저장하여 이후 호출시 공유

			register_shutdown_function(array($this, 'Close'));
			$this->executeQuery("SET NAMES utf8", $conf_sel_db_conn);
			// 예전 MySQL 5.1은 non-strict 모드(sql_mode='')로 동작해 컬럼 길이 초과 데이터를 조용히 잘라 저장했음.
			// 새 MariaDB의 strict 모드에서는 같은 데이터가 에러(1406 등)가 되므로 예전 동작과 동일하게 맞춘다.
			$this->executeQuery("SET SESSION sql_mode = ''", $conf_sel_db_conn);
		}
		else
			$this->ConnSel = $conf_sel_db_conn;		// 직전 DB 접속이 존재하는 경우 재사용

		// Insert/Update/Delete용 Connection
		if(empty($conf_add_db_conn))		// 최초 DB 접속
		{
			$this->initDao();

			if (strpos(strtoupper($_SERVER['DOCUMENT_ROOT']), "C:/") === false)
			{
				if (empty($_SERVER['SERVER_ADDR']))
					$connectionInfo	= parse_ini_file($this->daoPath."DaoConnectionDev.ini");	// 서버내 php실행
				else
					$connectionInfo	= parse_ini_file($this->daoPath."DaoConnection.ini");		// 상용 DB서버 (단일 서버 구성)
			}
			else
			{
				$connectionInfo	= parse_ini_file($this->daoPath."DaoConnectionDev.ini");	// 개발 환경 (로컬 PC)
			}

			$this->ConnAdd			= @mysqli_connect($connectionInfo['host'], $connectionInfo['user'], $connectionInfo['passwd'], $connectionInfo['database']);
			if(!$this->ConnAdd)		$this->writeLog($this->ConnAdd);

			unset($connectionInfo);

			$conf_add_db_conn =  $this->ConnAdd;		// 최초 DB 접속시  전역 변수에 저장하여 이후 호출시 공유
			register_shutdown_function(array($this, 'Close'));
			$this->executeQuery("SET NAMES utf8", $conf_add_db_conn);
			$this->executeQuery("SET SESSION sql_mode = ''", $conf_add_db_conn);
		}
		else
			$this->ConnAdd = $conf_add_db_conn;		// 직전 DB 접속이 존재하는 경우 재사용
	}

	public function Close()
	{
		// 여러 Dao 인스턴스(MainDao, GuestbookDao 등)가 같은 전역 커넥션을 공유하는 구조라,
		// 요청 종료 시 Close()가 여러 번 호출될 수 있음. 예전 mysql_* 확장은 이미 닫힌
		// 연결을 다시 닫아도 조용히 무시했지만, mysqli는 Error를 던지므로 명시적으로 흡수한다.
		if ($this->ConnSel instanceof mysqli) {
			try {
				@mysqli_close($this->ConnSel);
			} catch (\Throwable $e) {
				// 이미 닫힌 연결 - 무시
			}
		}
		if ($this->ConnAdd instanceof mysqli) {
			try {
				@mysqli_close($this->ConnAdd);
			} catch (\Throwable $e) {
				// 이미 닫힌 연결 - 무시
			}
		}
	}

	public function executeQuery($query, $conn='')
	{
		if (empty($conf_sel_db_conn) || empty($conf_add_db_conn))
			$this->Connect();

		$this->query	= $query;

		$time_start = time();

		// connection을 직접 지정한 경우는 직접 지정한 connection으로 이용
		if (!empty($conn))
		{
			$this->result = @mysqli_query($conn, $this->query);

			$time_end = time();
			$query_exec_time = $time_end - $time_start;					// 쿼리 실행시간 측정 (seconds)

			$this->writeLog($conn, $query_exec_time);
		}
		else
		{
			if (( preg_match("/^UPDATE/", strtoupper(trim($query))) || preg_match("/^INSERT/", strtoupper(trim($query))) || preg_match("/^DELETE/", strtoupper(trim($query))) )
			||  ( preg_match("/^SELECT LAST_INSERT_ID/", strtoupper(trim($query)))) )
			{
				$this->result = @mysqli_query($this->ConnAdd, $this->query);

				$time_end = time();
				$query_exec_time = $time_end - $time_start;					// 쿼리 실행시간 측정 (seconds)

				$this->writeLog($this->ConnAdd, $query_exec_time);
			}
			else
			{
				$this->result = @mysqli_query($this->ConnSel, $this->query);

				$time_end = time();
				$query_exec_time = $time_end - $time_start;					// 쿼리 실행시간 측정 (seconds)

				$this->writeLog($this->ConnSel, $query_exec_time);
			}
		}

		return $this->result;
	}

	public function getFetchObject()
	{
		$result = @mysqli_fetch_object($this->result);

		if(!$result)
		{
			$this->writeLog($this->ConnSel);
			return FALSE;
		}
		else
			return $result;
	}

	public function getFetchArray()
	{
		$result = @mysqli_fetch_array($this->result);

		if(!$result)
		{
			$this->writeLog($this->ConnSel);
			return FALSE;
		}
		else
			return $result;
	}

	public function getFetchRow()
	{
		$result = @mysqli_fetch_row($this->result);

		if(!$result)
		{
			$this->writeLog($this->ConnSel);
			return FALSE;
		}
		else
			return $result;
	}

	public function getNumRows()
	{
		$result = @mysqli_num_rows($this->result);

		if(!$result)
		{
			$this->writeLog($this->ConnSel);
			return FALSE;
		}
		else
			return $result;
	}

	public function getResult($row_num = 0, $col_num = 0)
	{
		// mysqli에는 mysql_result()에 해당하는 직접적인 함수가 없어
		// data_seek + fetch_row 조합으로 동일하게 동작하도록 구현
		if (!($this->result instanceof mysqli_result))
		{
			$this->writeLog($this->ConnSel);
			return FALSE;
		}

		if (!@mysqli_data_seek($this->result, $row_num))
		{
			$this->writeLog($this->ConnSel);
			return FALSE;
		}

		$row = @mysqli_fetch_row($this->result);

		if ($row === null || $row === false || !array_key_exists($col_num, $row))
		{
			$this->writeLog($this->ConnSel);
			return FALSE;
		}

		return $row[$col_num];
	}

	public function getLastInsertID()
	{
		$this->executeQuery("SELECT LAST_INSERT_ID()");
		return $this->getResult();
	}

	public function free()
	{
		if ($this->result instanceof mysqli_result) {
			@mysqli_free_result($this->result);
			return true;
		}
		$this->writeLog();
		return false;
	}


	public function prepareStatement($query)
	{
		$this->query = $query;

		$this->stmt 	= 'spac_stmt';
		$query 			= "PREPARE ".$this->stmt." FROM \"".$this->query."\";";
		$this->executeQuery($query);
	}

	public function escapeParam($param)
	{
		// PHP8.4: 배열 키가 없어서 null이 넘어와도 안전하게 문자열로 변환 후 처리
		$param = trim((string)$param);
		$result = addslashes($param);

		if(!$result)
		{
			$this->writeLog();
			return FALSE;
		}
		else
			return $result;
	}

	public function setParam($param)
	{
		$sqlParamName 		= '';
		$this->sqlParamNameArray 	= array();
		$bindQuery 			= '';

		if(!is_array($param)) {
			$param = array($param);
		}

		// escaping에 쓸 커넥션 확보 (원본은 커넥션 없이 mysql_real_escape_string 호출 - 레거시 동작)
		if (empty($this->ConnAdd) && empty($this->ConnSel)) {
			$this->Connect();
		}
		$escapeConn = !empty($this->ConnAdd) ? $this->ConnAdd : $this->ConnSel;

		for($i = 0; $i<count($param);$i++) {

			$sqlParamName = "@param".$i;

			if($i == 0) {
				$bindQuery = "SET";
			}

			$temp = @mysqli_real_escape_string($escapeConn, $param[$i]);
			if($temp === false)	$this->writeLog();

			$bindQuery .= " " . $sqlParamName . " = '". $temp . "'";

			if($i < (count($param)-1))
				$bindQuery .= ",";
			else
				$bindQuery .= ";";

			$this->sqlParamNameArray[] 	= $sqlParamName;
		}

		$this->executeQuery($bindQuery);
	}

	public function executeStatement()
	{
		if(count($this->sqlParamNameArray)) {
			$usingParamString = implode(",",$this->sqlParamNameArray);
		}

		$stmt_query = "EXECUTE " . $this->stmt ." USING ".$usingParamString.";";
		$this->executeQuery($stmt_query);
	}

	public function closeStatement()
	{
		$deallocate_query = "DEALLOCATE PREPARE " . $this->stmt .";";
		$this->executeQuery($deallocate_query);
	}

	public function executeBindingQuery($query,$param,$auto_close = false)
	{
		$this->prepareStatement($query);
		$this->setParam($param);
		$this->executeStatement();
		if($auto_close == true) {
			$this->closeStatement();
		}
	}

	public function closeBindingQuery()
	{
		$this->closeStatement();
	}

	private function writeLog($conn='', $query_exec_time = '')
	{
		if (!empty($conn))
		{
			$errno = @mysqli_errno($conn);
			$errmsg = @mysqli_error($conn);

			if($errno)												// DB 에러가 발생한 경우
			{
				if(!empty($this->query))
					$db_err_log = "[SQL ERROR] : {$_SERVER['PHP_SELF']} [" . $this->query . "] -> <" . $errno . "> : " . $errmsg;
				else
					$db_err_log = "[DB ERROR] : <" . $errno . "> " . $errmsg;

				$this->guiguiland_logger->debug($db_err_log);
			}
			else													// 정상인 경우
			{
				if(DEBUG_MODE == "ON" && !empty($this->query))		// 서비스 전역 환경설정에서 디버그 모드가 ON으로 설정된 경우 모든 쿼리를 로깅한다.
				{
					$sql_log = "[SQL DEBUG] : [" . $query_exec_time ." sec][" . $this->query . "]";
					$this->guiguiland_logger->debug($sql_log);
					$this->query = "";								// 쿼리변수 초기화
				}
			}
		}
	}
}
?>
