<?php
/**
 *  CookieManager.php
 *  @Desc      : 쿠키 관련 클래스
 *  @Author    : uno
 *  @Date      : 2012. 01. 26. 오전 11:03:57
 *  @param 	 
 *  @Return
 */
class CookieManager{	
	
	//N마켓에서 사용하는 모든 쿠키
	private static $COOKIE_ALL = array(
		"user_id" , "service_id" , "acc_token" , "init_set_cookie" , "list_url" , "svc_type"  , "market_code", 
		"latitude", "longitude"  , "device_id" , "location_accept" , "apk_ver"  , "autologin", "nmarket_phone_number"
	);
	
	
	//로그아웃시 삭제되는 쿠키 목록.
	private static $COOKIE_LOGOUT = array(
		"user_id"  , "service_id" , "acc_token" , "init_set_cookie" , "list_url",
		"latitude" , "longitude"  , "autologin" , "nmarket_phone_number"
	);
	

	//회원 로그인과 관련된 쿠키
	private static $COOKIE_LOGIN = array(
		"user_id", "service_id", "acc_token"
	);
	
	//N마켓 도메인
	private $COOKIE_DOMAIN = array();
	
	

	/**
	 *  __construct
	 *
	 *  @Desc      : 초기화
	 *  @Author    : uno
	 *  @Date      : 2012. 1. 14. 오후 5:41:25
	 *  @Return    :
	 */
	public function __construct(){

		switch($_SERVER['SERVER_ADDR']){
			
			case "1.234.6.147" : 		// cms.nmarket.co.kr
			case "1.234.6.148" :		// m.nmarket.co.kr www.nmarket.co.kr 
			case "1.234.6.149" :		// tns.nmarket.co.kr	
			case "114.108.171.226" :  //신규 서버
			case "114.108.171.229" : //신규 서버	
			case "114.108.171.210" : //신규 서버				
			case "127.0.0.1"   :		// 로컬	
				$this->COOKIE_DOMAIN['APP'] = "app.nmarket.co.kr";
				$this->COOKIE_DOMAIN['WAP'] = "m.nmarket.co.kr";
			break;
			
			case '114.108.171.205':
				$this->COOKIE_DOMAIN['APP'] = "nm.mcontents.co.kr";
			break;
		}
	}
	

	
	/**
	 *  createCookie
	 *
	 *  @Desc      : 쿠키를 생성한다.
	 *  @Author    : uno
	 *  @Date      : 2012. 1. 14. 오후 5:42:26
	 *  @param unknown_type $cookieName   - 쿠키명
	 *  @param unknown_type $cookieValue  - 쿠키값
	 *  @param unknown_type $cookieExpire - 만료시간 (디폴트값 2년)
	 *  @param unknown_type $cookiePath   - 서버경로 (디폴트값 루트)
	 *  @param unknown_type $cookieSecure
	 *  @Return    :
	 *  
	 *  
	 *  쿠키생성 예)
	 *  createCookie("uno","1234");  -> 만료시간 2년으로 생성
	 *  createCookie("uno","1234",0) -> 만료시간 0으로 생성
	 *  
	 */
	public function createCookie($cookieName, $cookieValue, $cookieExpire=true, $cookiePath='/' , $cookieSecure=0){
		
		$cookieExpire = ($cookieExpire === true) ? time()+(3600*24*31*24) : $cookieExpire;
		
		foreach($this->COOKIE_DOMAIN as $cookieDomain)
			setcookie($cookieName, $cookieValue, $cookieExpire, $cookiePath, $cookieDomain, $cookieSecure);
	}
	
	
	

	
	/**
	 *  createMultiCookie
	 *
	 *  @Desc      : 배열로 넘어온 데이터로 쿠키 생성.
	 *  @Author    : uno
	 *  @Date      : 2012. 1. 26. 오후 4:53:13
	 *  @param unknown_type $arrayCookie
	 *  @param unknown_type $cookieExpire
	 *  @Return    :
	 *  
	 *  
	 *  쿠키 생성 예)
	 *  
	 *  $param = array();
	 *  $param['user_id']    = 'uno';
	 *  $param['acc_token']  = "tokdjlwkejf";
	 *  $param['service_id'] = '200';
	 *  
	 *  createMultiCookie($param);		-> 만료시간 2년으로 생성
	 *  createMultiCookie($param, 0);	-> 만료시간 0으로 생성
	 *  
	 */
	public function createMultiCookie($arrayCookie, $cookieExpire=true){
		
		if(!empty($arrayCookie) && is_array($arrayCookie)){
			
			foreach($arrayCookie as $name => $value){
				$this->createCookie($name, $value, $cookieExpire);
			}
					
		}	
	}	
	

	
	
	/**
	 *  deleteCookie
	 *
	 *  @Desc      : 쿠키 삭제
	 *  @Author    : uno
	 *  @Date      : 2012. 1. 26. 오후 3:59:28
	 *  @param unknown_type $cookieName - 삭제할 쿠키명
	 *  @Return    :
	 */
	public function deleteCookie($cookieName){
		foreach($this->COOKIE_DOMAIN as $domain)
			setcookie($cookieName , "", time()-3600, "/", $domain, 0);
	}
	

	
	
	/**
	 *  deleteAllCookie
	 *
	 *  @Desc      : 모든 쿠키를 삭제 한다.
	 *  @Author    : uno
	 *  @Date      : 2012. 1. 26. 오후 3:59:50
	 *  @Return    :
	 */
	public function deleteAllCookie(){
		foreach(self::$COOKIE_ALL as $name){
			$this->deleteCookie($name);
		}
	}
	
	
	/**
	 *  userLogout
	 *
	 *  @Desc      : 로그아웃시 필요한 쿠키를 제외한 나머지 쿠키 삭제..
	 *  @Author    : uno
	 *  @Date      : 2012. 1. 26. 오후 3:52:46
	 *  @Return    :
	 */
	public function userLogout(){
		foreach(self::$COOKIE_LOGOUT as $name){
			$this->deleteCookie($name);
		}
	}
	

	
	
	/**
	 *  isUserLogin
	 *
	 *  @Desc      : 로그인 여부 체크
	 *  @Author    : uno
	 *  @Date      : 2012. 1. 26. 오후 4:01:10
	 *  @Return    : boolean
	 */
	public function isUserLogin(){
		
		$cookie_count = 0;
		
		foreach(self::$COOKIE_LOGIN as  $name){
			if(isset($_COOKIE[$name]) && !empty($_COOKIE[$name])){
				$cookie_count++;
			}
		}

		if($cookie_count == count(self::$COOKIE_LOGIN)) {	//로그인...
			return true;
		}else{	//비로그인....
			return false;
		}
	}
	
	
	
	/**
	 *  getUserIdFromCookie
	 *
	 *  @Desc      : 복호화된 쿠키값(user_id)를 가져온다.
	 *  @Author    : uno
	 *  @Date      : 2012. 3. 5. 오후 5:32:31
	 *  @return user_id
	 *  @Return    :
	 *  
	 *  사용 예)
	 *  $manager = new CookieManager();
	 *  if($manager->isUserLogin()){	//로그인된 상태인지 확인하고.
	 *  	$user_id = $manager->getUserIdFromCookie();
	 *  }
	 */
	public function getUserIdFromCookie(){
		require(__DIR__ . "/_if_security_init.php");
		$rsa->loadKey( trim($conf_rsa_public_key), $conf_rsa_public_key_format );				
		$user_id = $rsa->decrypt(base64_decode(trim($_COOKIE["user_id"])));	
		return $user_id;
	}
	
	
	
	/**
	 *  getCookieValues
	 *
	 *  @Desc      : 쿠키값을 가져온다... (하나의 값만 가져올려면 그냥 소스상에서 $_COOKIE['쿠키이름'] 으로 쓰시는게...)
	 *  @Author    : uno
	 *  @Date      : 2012. 3. 12. 오후 3:10:22
	 *  @param array $param
	 *  @return array
	 *  @Return    :
	 *  
	 *  사용 예)
	 *  $manager = new CookieManager();
	 *  
	 *  $cookie_param = array("user_id", "acc_token");  //가져오고자 하는 쿠키값의 이름...
	 *  $manager->getCookieValues($cookie_param);
	 *  
	 */
	public function getCookieValues($param){
		
		$result = array();
		
		if(!empty($param) && count($param) > 0){			
			foreach($param as $key){
				if(isset($_COOKIE[$key]) && !empty($_COOKIE[$key]))
					$result[$key] = $_COOKIE[$key];
			}
		}
		
		return $result;
	}
}
?>