<?php
/**
 *  GoogleConverter.php
 *
 *  @Desc     : Google API (위경도 -> 주소, 주소 -> 위경도)
 *  @Author   : 조오성
 *  @Date     : 2011. 8. 2.
 *  @Version  : 
 */

import("php.network.cURLClass");
import("php.util.JSON");
import("php.util.XmlClass");

class GoogleConverter{
	
	private $apiUrl;		// google api URL
	private $actionUrl;		// merged api URL (JSON, XML)
	private $retType;		// return type (JSON, XML)
	private $getOptStr;		// get data string
	private $sensor;		// get data string
	
	private $CURL;
	private $CURL_OPTION;
	private $CURL_RETRY;
	private $CURL_POST;
	
	private $JSON;
	private $XML;
	
	public function __construct()
	{	
		$this->retType	= "json";
		$this->apiUrl	= "http://maps.google.co.kr/maps/api/geocode/";
		$this->actionUrl= $this->apiUrl.$this->retType;
		$this->sensor	= "&sensor=false";
		
		$this->CURL		= new CURL();
		$this->CURL_OPT = array( CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true  );
		$this->CURL_RETRY	= 2;
		$this->CURL_POST	= false;
		
		$this->JSON		= new Services_JSON();	// to use JSON string parse
		$this->XML		= new XmlClass();		// to use XML string parse
	}
	
	public function setStandardCurlOption()
	{ 
		$this->CURL->retry = $this->CURL_RETRY;
		$this->CURL->setOpt( CURLOPT_POST, $this->CURL_POST );
	}	
	
	public function getCurlResult($target_url)
	{
		$this->CURL->addSession( $target_url, $this->CURL_OPT );				// HTTP 접속 (cURL 세션 생성)
		$this->CURL->setOpt( CURLOPT_URL, $target_url);
		
		$result = $this->CURL->exec();
		$this->CURL->clear();
		
		return $result;
	}
	
	/* Set the return type
	 * 
	 * $type -> "json" or "xml"
	 */
	public function setReturnOption($type)
	{
		$this->retType	= $type;
		$this->actionUrl= $this->apiUrl.$this->retType;
	}
	
	/* get address use lat, lng
	 * 
	 * $lat -> 124.53525, $lng -> 64.23525235  (double data type)
	 * 
	 */
	public function getAddressByLatLng($lat, $lng) {
		
		$target_url = $this->actionUrl."?latlng=".$lat.",".$lng.$this->sensor;		
		
		$ret = $this->getCurlResult($target_url);
		
		if(strtoupper($this->retType) == "JSON")
			$result = $this->JSON->decode($ret);	
		
		else
			$result = $this->XML->xmlToArray($ret);
		
		return $result;
	}
	
	/* get latitude and longitude use address string
	 * 
	 * $address -> "서울시 마포구 서교동 blah blah"; 
	 */
	public function getLatLngByAddress($address) {
				
		$target_url = $this->actionUrl."?address=".$address.$this->sensor;		
		
		$ret = $this->getCurlResult($target_url);
		
		if(strtoupper($this->retType) == "JSON")
			$result = $this->JSON->decode($ret);	
		
		else
			$result = $this->XML->xmlToArray($ret);
		
		return $result;
	}
	
	/*
	 * parameter
	 * lat: 위도
	 * lng: 경도
	 * list(boolean) : 중복 결과에 대하여 리스트 or 단일 결과
	 * jsReturn : js script에서 쓰이게 구분자(;)로 재구성 
	 */
	public function getDivideAddress($lat, $lng, $list, $jsReturn){
		
		$target_url = $this->actionUrl."?latlng=".$lat.",".$lng.$this->sensor;		
		
		$ret = $this->getCurlResult($target_url);
		
		// 로그 설정
		import("log4php.Logger");										// 로그 클래스 임포트
			
		Logger::configure($conf_config_home_dir . '/NmarketLog.ini');	// 로그 객체 환경설정
		$nmarket_logger = Logger::getLogger("nmarket_logger");		// 로그 객체 생성
		
		$nmarket_logger->debug("google : ".$ret);
		
		if(strtoupper($this->retType) == "JSON")
			$ret = $this->JSON->decode($ret);	
		
		else
			$ret = $this->XML->xmlToArray($ret);
			
		$addressArr = array();
		$tmp = array();
		
		if($list){
			
			foreach ($ret->results as $res){
				
				$address_cp = $res->address_components;
				
				$address = "";
				
				for ($i=count($address_cp); $i >= 0; $i--){
					
					if($address_cp[$i]->types[0] != 'country' && $address_cp[$i]->types[0] != 'street_address')
					{
						if(!empty($address)) $address.= "&";
						
						$address .= $address_cp[$i]->short_name;
					}
				}
				
				$address = explode("&", $address);
				
				$add_array = array();
				
				$add_array['sido']		= $address[0];
				$add_array['gugun']		= $address[1];
				$add_array['dong']		= $address[2];
				
				$add_array['latitude']	= $lat;
				$add_array['longitude']	= $lng;
				
				array_push($tmp, $add_array);
			}
	
		}
		else{
			$address_cp = $ret->results[0]->address_components;
			
			$address = "";
			
			for ($i=count($address_cp); $i >= 0; $i--){
				
				if($address_cp[$i]->types[0] != 'country' && $address_cp[$i]->types[0] != 'street_address')
				{
					if(!empty($address)) $address.= "&";
					
					$address .= $address_cp[$i]->short_name;
				}
			}
			
			$address = explode("&", $address);
			
			$add_array = array();
			
			$add_array['sido']			= $address[0];
			$add_array['gugun']			= $address[1];
			$add_array['dong']			= $address[2];
			
			$add_array['latitude']	= $lat;
			$add_array['longitude']	= $lng;
			
			array_push($tmp, $add_array);
		}
		
		$addressArr['list']		= $tmp;
		$addressArr['status']	= $ret->status;
		
		if($ret->status == "ok" || $ret->status == "OK"){
			if($jsReturn){
				$returnStr = "";
		
				foreach ($addressArr['list'] as $add){
					if(!empty($returnStr)) $returnStr .= ";";
					
					$returnStr .= "sido=>".$add['sido'].":"."gugun=>".$add['gugun'].":"."dong=>".$add['dong'].":"."latitude=>".$add['latitude'].":"."longitude=>".$add['longitude'];
				}
				
				return $returnStr;
			}
			else
				return $addressArr;
		}
		else 
			return $ret->status;
	}
	
	/*
	 * parameter
	 * address: 주소 문자열
	 * list(boolean) : 중복 결과에 대하여 리스트 or 단일 결과
	 * jsReturn : js script에서 쓰이게 구분자(;)로 재구성 
	 */
	public function getDivideAddressByAddress($address, $list, $jsReturn){
		
		$target_url = $this->actionUrl."?address=".$address.$this->sensor;		
		
		$ret = $this->getCurlResult($target_url);
		
		if(strtoupper($this->retType) == "JSON")
			$ret = $this->JSON->decode($ret);	
		
		else
			$ret = $this->XML->xmlToArray($ret);

		$addressArr = array();
		$tmp = array();
		
		if($list){
			
			foreach ($ret->results as $res){
				
				$address_cp = $res->address_components;
				
				$address = "";
				
				for ($i=count($address_cp); $i >= 0; $i--){
					
					if($address_cp[$i]->types[0] != 'country' && $address_cp[$i]->types[0] != 'street_address')
					{
						if(!empty($address)) $address.= " ";
						
						$address .= $address_cp[$i]->short_name;
					}
				}
				
				$address = explode(" ", $address);
				
				$add_array = array();
				
				$add_array['sido']		= $address[0];
				$add_array['gugun']		= $address[1];
				$add_array['dong']		= $address[2];
				
				$add_array['latitude']	= $res->geometry->location->lat;
				$add_array['longitude']	= $res->geometry->location->lng;
				
				array_push($tmp, $add_array);
			}
	
		}else{
			
			$address_cp = $ret->results[0]->address_components;
				
			$address = "";
			
			for ($i=count($address_cp); $i >= 0; $i--){
				
				if($address_cp[$i]->types[0] != 'country' && $address_cp[$i]->types[0] != 'street_address')
				{
					if(!empty($address)) $address.= "&";
					
					$address .= $address_cp[$i]->short_name;
				}
			}
			
			$address = explode("&", $address);
			
			$add_array = array();
			
			$add_array['sido']		= $address[0];
			$add_array['gugun']	= $address[1];
			$add_array['dong']		= $address[2];
			
			$add_array['latitude']	= $ret->results[0]->geometry->location->lat;
			$add_array['longitude']= $ret->results[0]->geometry->location->lng;
			
			array_push($tmp, $add_array);
		}
		
		$addressArr['list']		= $tmp;
		$addressArr['status']	= $ret->status;
		
		if($ret->status == "ok" || $ret->status == "OK"){
			if($jsReturn){
				$returnStr = "";
		
				foreach ($addressArr['list'] as $add){
					if(!empty($returnStr)) $returnStr .= ";";
					
					$returnStr .= "sido=>".$add['sido'].":"."gugun=>".$add['gugun'].":"."dong=>".$add['dong'].":"."latitude=>".$add['latitude'].":"."longitude=>".$add['longitude'];
				}
				
				return $returnStr;
			}
			else
				return $addressArr;
		}
		else 
			return false;
	}
}

?>