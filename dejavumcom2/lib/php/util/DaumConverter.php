<?php
/**
 *  DaumConverter.php
 *
 *  @Desc     : Daum API (위경도 -> 주소, 주소 -> 위경도)
 *  @Author   : 조오성
 *  @Date     : 2012. 2. 1.
 *  @Version  : 
 */

import("php.network.cURLClass");
import("php.util.JSON");
import("php.util.XmlClass");

class DaumConverter{
	
	private $apiKey;
	private $apiUrl;		// daum api URL
	private $c2aUrl;		// c2a url
	private $a2cUrl;		// a2c url
	private $retType;		// return type (JSON, XML)
	private $getOptStr;		// get data string
	private $coord2addr;
	private $addr2coord;
	
	private $CURL;
	private $CURL_OPTION;
	private $CURL_RETRY;
	private $CURL_POST;
	
	private $JSON;
	private $XML;
	
	public function __construct()
	{	
		$this->apiKey		= "apikey=15abf804b4c305b14130692c3b644bca5ead73a6";
		$this->retType		= "json";
		$this->apiUrl		= "http://apis.daum.net/local/geo/";
		$this->coord2addr	= "coord2addr?";
		$this->addr2coord	= "addr2coord?";
		
		$this->c2aUrl	= $this->apiUrl.$this->coord2addr.$this->apiKey."&output=".$this->retType."&inputCoordSystem=WGS84&format=simple";
		$this->a2cUrl	= $this->apiUrl.$this->addr2coord.$this->apiKey."&output=".$this->retType;
		
		$this->CURL			= new CURL();
		$this->CURL_OPT 	= array( CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true  );
		$this->CURL_RETRY	= 2;
		$this->CURL_POST	= false;
		
		$this->JSON			= new Services_JSON();	// to use JSON string parse
		$this->XML			= new XmlClass();		// to use XML string parse
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
	
	/*
	 * parameter
	 * lat: 위도
	 * lng: 경도
	 * list(boolean) : 중복 결과에 대하여 리스트 or 단일 결과
	 * jsReturn : js script에서 쓰이게 구분자(;)로 재구성 false일 경우 PHP Array 
	 */
	public function getAddressByLatLng($lat, $lng, $jsReturn){
		
		$target_url = $this->c2aUrl."&latitude=".$lat."&longitude=".$lng;		
		
		$ret = $this->getCurlResult($target_url);
		
		if(strtoupper($this->retType) == "JSON")
			$ret = $this->JSON->decode($ret);	
		
		else
			$ret = $this->XML->xmlToArray($ret);
		
		$add_array = array();
		
		$add_array['sido']		= strip_tags(htmlspecialchars_decode($ret->name1));
		$add_array['gugun']		= strip_tags(htmlspecialchars_decode($ret->name2));
		$add_array['dong']		= strip_tags(htmlspecialchars_decode($ret->name3));
		
		$add_array['latitude']	= $lat;
		$add_array['longitude']	= $lng;
		
		if(!empty($ret) && count($ret) > 0){
			if($jsReturn){
					
				return "sido=>".$add_array['sido'].":"."gugun=>".$add_array['gugun'].":"."dong=>".$add_array['dong'].":"."latitude=>".$add_array['latitude'].":"."longitude=>".$add_array['longitude'];
			}
			else
				return $add_array;
		}
		else 
			return false;
	}
	
	/*
	 * parameter
	 * address: 주소 문자열
	 * list(boolean) : 중복 결과에 대하여 리스트 or 단일 결과
	 * jsReturn : js script에서 쓰이게 구분자(;)로 재구성 
	 */
	public function getAddressByAddress($address, $jsReturn){
		
		$target_url = $this->a2cUrl."&q=".urlencode($address);		
		
		$ret = $this->getCurlResult($target_url);
		
		if(strtoupper($this->retType) == "JSON")
			$ret = $this->JSON->decode($ret);	
		
		else
			$ret = $this->XML->xmlToArray($ret);

		$addressArr = array();
		$tmp = array();
		
		foreach ($ret->channel->item as $res){
			
			$add_array = array();
			
			$add_array['title']		= strip_tags(htmlspecialchars_decode($res->title));
			$add_array['sido']		= strip_tags(htmlspecialchars_decode($res->localName_1));
			$add_array['gugun']		= strip_tags(htmlspecialchars_decode($res->localName_2));
			$add_array['dong']		= strip_tags(htmlspecialchars_decode($res->localName_3));
			
			$add_array['longitude']	= $res->point_x;
			$add_array['latitude']	= $res->point_y;
			
			array_push($tmp, $add_array);
		}
		
		$addressArr['list']		= $tmp;
		$addressArr['status']	= $ret->channel->result;
		
		if($ret->channel->totalCount > 0 && !empty($ret)){
			if($jsReturn){
				$returnStr = "";
		
				foreach ($addressArr['list'] as $add){
					if(!empty($returnStr)) $returnStr .= ";";
					
					$returnStr .= "title=>".$add['title'].":"."sido=>".$add['sido'].":"."gugun=>".$add['gugun'].":"."dong=>".$add['dong'].":"."latitude=>".$add['latitude'].":"."longitude=>".$add['longitude'];
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