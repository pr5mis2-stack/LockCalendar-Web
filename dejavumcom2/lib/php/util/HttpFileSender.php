<?php
/*
 * XMLHTTPREQUEST를 이용하여 프로필 이미지를 업로드를 처리하는 클래스
 * Author : UNO
 */
import("class.controller.WWWRoot");

class Http_FileSender_Exception extends Exception
{
	public function errorMessage()
	{
		return "[Http_FileSender ERROR] : " . $this->getMessage();		
	}
}


class Http_FileSender extends WWWRoot
{
	private $fileName;	//파일명
	private $filePath;  //파일 경로
	private $fileSize;	//파일 크기
	
	
	public function __construct()
	{
		parent::__construct();
		
		if(array_key_exists("CONTENT_LENGTH", $_SERVER)){
			$this->fileSize = $_SERVER['CONTENT_LENGTH'];
		}else
			$this->fileSize = 0;
	}
	
	/*
	 * 파일 사이즈를 리턴
	 */
	public function getFileSize()
	{
		return $this->fileSize;
	}
	
	/*
	 * 파일명을 리턴
	 */
	public function getFileName()
	{
		return $this->fileName;
	}
	
	/*
	 * 파일경로를 리턴
	 */
	public function getFilePath()
	{
		return $this->filePath;
	}	
	
	/* 파일 경로 및 파일명 지정 - 디렉토리 생성
	 * 
	 * $path_param = array()
	 * $path_param['file_path'] = ~~
	 * $path_param['user_id'] = ~~
	 */
	public function setUploadFilePath($path_param=array()){
	    
		if(array_key_exists('file_path', $path_param) && array_key_exists('user_id', $path_param)){
			$this->filePath = $path_param['file_path'] . $path_param['user_id'] . "/10/";
	    	$this->fileName = $path_param['user_id'] .  ".jpg";
	    	
	    	if(!is_dir($path_param['file_path'] . $path_param['user_id'])){
	    		$is_dir_make = mkdir($path_param['file_path'] . $path_param['user_id']);
	    		
	    		if($is_dir_make === false){ //디렉토리 생성 실패
	    			$this->throwException(__METHOD__ . " {$path_param['file_path']}/{$path_param['user_id']} can't make directory");
	    			return false;
	    		}
	    		
	    		chdir($path_param['file_path'] . $path_param['user_id']);
	    		
	    		if(!is_dir("10"))
	    			mkdir("10");
	    	}
	    	
	    	return true;
		}else{
			$this->throwException(__METHOD__ . " file_path OR user_id can't receive {$path_param['file_path']}/{$path_param['user_id']}");
			return false;
		}	    		
	}
	
	
	
	/**
	 *  startFileUpload
	 *
	 *  @Desc      : 파일 업로드 처리.
	 *  @Author    : uno
	 *  @Date      : 2012. 7. 5. 오후 3:49:25
	 *  @return string
	 *  @Return    :
	 */
	public function startFileUpload()
	{
		if(!$this->fileSize > 0 || empty($this->filePath) || empty($this->fileName)){
			$this->throwException(__METHOD__ . " fileSize or filePath or fileName not exists");
			return false;
		}
		
		//넘어온 데이터 확인..		
		$imageData = file_get_contents("php://input");		
		
		//넘어온 데이터가 존재 한다면....
		if ($imageData)
		{
			if($dh = opendir($this->filePath)){
				while( false !== ($file = readdir($dh))){
					if($file != "." && $file != ".."){
					@unlink($this->filePath . $file);			//현재 디렉토리의 프로필 이미지 삭제.
				}
			}
				closedir($dh);
			}			
		    
		    // Remove the headers (data:,) part.  
		    // A real application should use them according to needs such as to check image type
		    $filteredData=substr($imageData, strpos($imageData, ",")+1);
		 
		    // Need to decode before saving since the data we received is already base64 encoded
		    $unencodedData=base64_decode($filteredData);	

		    //파일 업로드
		    $upload_file_byte = file_put_contents($this->filePath . $this->fileName, $unencodedData);

		    if($upload_file_byte !== false)
		    	return true;
		    else
		    	return false;
		}else{
			$this->throwException(__METHOD__ . " imageData not exists");		
		}
		
		return false;
	}
	
	//Exception 을 던진다.
	public function throwException($msg){
		try{
			throw new Http_FileSender_Exception($msg);
		}catch(Http_FileSender_Exception $e){
			$this->nmarket_logger->debug($e->errorMessage());		
		}			
	}
}