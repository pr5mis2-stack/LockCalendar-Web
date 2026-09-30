<?php

class ReplaceGetData{
	
	// 생성자
	public function __construct()
	{	
		
	}
	
	// target에 맞는 key를 찾아 해당 value를 바꾼다. 없으면 붙임
	public function replaceValueByKey($base_url, $target, $value)
	{	
		$baseURL = explode("?", $base_url);
		$getURL = explode("&", $baseURL[1]);
		
		$getData = array();
		foreach($getURL as $get){
			$data = explode("=", $get);
			
			$getData[$data[0]] = $data[1];
		}

		$replaceGetUrl = "";
		$idx = 0;
		$isIn = false;
		foreach($getData as $key => $val){
			
			if($idx++ != 0)	$replaceGetUrl .= "&";
			
			$replaceGetUrl .= $key . "=";
			if($key == $target){
				$isIn = true;
				$replaceGetUrl .= $value;
			}
			else
				$replaceGetUrl .= $val;
		}
		
		if(!$isIn){
			if($idx == 0)	$replaceGetUrl .= $target."=".$value;
			else			$replaceGetUrl .= "&".$target."=".$value;
		}
		
		if (substr($replaceGetUrl, 0, 1) == "=")
			$replaceGetUrl = substr($replaceGetUrl, 1, strlen($replaceGetUrl));
		
		return $baseURL[0] . "?" . $replaceGetUrl;
	}
	
	public function getValueByKey($base_url, $target)
	{	
		$baseURL = explode("?", $base_url);
		$getURL = explode("&", $baseURL[1]);
		
		$getData = array();
		foreach($getURL as $get){
			$data = explode("=", $get);
			
			if($data[0] == $target)
				return $data[1];
		}
		
		return false;
	}

	// target과 맞는 key의 존재 여부를 리턴
	public function findKey($base_url, $target)
	{	
		$baseURL = explode("?", $base_url);
		$getURL = explode("&", $baseURL[1]);
		
		$getData = array();
		foreach($getURL as $get){
			$data = explode("=", $get);
			
			if($data[0] == $target) return true;
		}
		
		return false;
	}
	
	// get string에 포함 된 get 변수의 수를 리턴
	public function getCountOfGetDate($base_url)
	{	
		// URL 분류
		$baseURL = explode("?", $base_url);
		$getURL = explode("&", $baseURL[1]);
		
		return count($getURL);
	}
	
	// taget을 get string에서 제거 한다
	public function removeKey($base_url, $target)
	{	
		$baseURL = explode("?", $base_url);
		$getURL = explode("&", $baseURL[1]);
		
		$getData = array();
		foreach($getURL as $get){
			$data = explode("=", $get);
			
			$getData[$data[0]] = $data[1];
		}

		$replaceGetUrl = "";
		$idx = 0;
		foreach($getData as $key => $val){
			
			if($idx++ != 0)	$replaceGetUrl .= "&";
			
			$replaceGetUrl .= $key . "=";
			
			if($key != $target)
				$replaceGetUrl .= $val;
				
		}
		
		return $baseURL[0] . "?" . $replaceGetUrl;
	}
	
	// taget을 get string에서 제거 한다
	public function removeParam($base_url, $target)
	{
		$baseURL = explode("?", $base_url);
		$getURL = explode("&", $baseURL[1]);
	
		$getData = array();
		foreach($getURL as $get){
			$data = explode("=", $get);
				
			$getData[$data[0]] = $data[1];
		}
	
		$replaceGetUrl = "";
		$idx = 0;
		foreach($getData as $key => $val){
			
			if($key != $target)
			{
				if($idx++ != 0)	$replaceGetUrl .= "&";
				$replaceGetUrl .= $key . "=";
				$replaceGetUrl .= $val;
			}
	
		}
	
		return $baseURL[0] . "?" . $replaceGetUrl;
	}
}

?>