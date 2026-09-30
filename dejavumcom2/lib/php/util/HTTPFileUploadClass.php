<?php
/**
 * 
 *  HTTPFileUpload
 *
 *  @Desc     : HTTPFileUpload
 *  @Author   : 손명석
 *  @Date     : 2010. 11. 23.
 *  @Version  :
 */

import("php.util.ConvertImage");

class HTTPFileUpload {
	
	private $max_file_size;
	private $allow_file_type;
	private $dejavu_logger;
	private $ConvertImage;
	private $UnZip;
	
	public function __construct()
	{
		global $conf_config_dir;										// 로그 홈디렉토리 전역변수 선언
		global $conf_dejavu_logger;										// 로거 전역변수 선언
		
		$this->ConvertImage 	= new ConvertImage();
		$this->UnZip			= new ZipArchive();
		
		if(empty($conf_dejavu_logger))
		{
			Logger::configure($conf_config_dir . '/DejavuLog.ini');	// 로그 객체 환경설정
			$this->dejavu_logger	= Logger::getLogger("dejavu_logger");	// 로그 객체 생성
			
			$conf_dejavu_logger = $this->dejavu_logger;					// 최초 생성된 로거 객체 전역적으로 공유
			//new dbug($this->dejavu_logger);
		}
		else
			$this->dejavu_logger = $conf_dejavu_logger;
		
		/**
		 * @var 최대 허용 업로드 파일 크기 (byte 단위): 1MB
		 */
		$this->max_file_size = 1024 * 20480; 
		
		/**
		 * @var	$file_type : 업로드가 허용되는 이미지 파일 유형 정의 (mime type)
		 */
		$this->allow_file_type = array("image/jpg", "image/jpeg", "image/pjpeg", "image/png", "image/gif",
									   "application/vnd.ms-excel", "application/vnd.ms-powerpoint", "application/msword", "application/haansofthwp", "application/x-zip-compressed", "application/zip");
	} 

	/**
	 *
	 * uploadMultiFiles
	 *
	 * @ClassName  : HTTPFileUpload
	 * @Comment    : 다수의 파일 업로드
	 * @Author     : suya
	 * @Date       : 2013. 8. 15.
	 * @param unknown_type $upload_files
	 * @param unknown_type $param
	 * @return unknown
	 * @return unknown
	 */
	public function uploadMultiFiles($upload_files=array(), $param=array())
	{
		/**
		 new dbug($_FILES);
		 new dbug($upload_files);
			*/
		$arr_file_name = array(); // 업로드된 파일이 하나도 없는 경우를 대비한 기본값
	
		global $conf_img_gallery_dir;
		global $conf_img_shop_dir;
		global $conf_img_thumbnail_dir;
		global $conf_img_banner_dir;
		global $conf_img_sample_dir;
		global $conf_temp_file_dir;
	
		global $conf_img_gallery_url;
		global $conf_img_shop_url;
		global $conf_img_thumbnail_url;
		global $conf_img_banner_url;
		global $conf_img_sample_url;
			
		if(empty($upload_files))
		{
			$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> upload file names array is empty";
			$this->dejavu_logger->debug($upload_err_log);
		}
			
		// 업로드 파일별로 에러 발생 여부를 체크한다.
	
		if(is_array($_FILES["user_file"]["name"])){
			foreach ($_FILES["user_file"]["error"] as $key => $error)
			{
				// 파일 타입 체크
				if(!empty($_FILES["user_file"]["type"][$key]) && !in_array($_FILES["user_file"]["type"][$key], $this->allow_file_type))
				{
					$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> " . $_FILES["user_file"]["type"][$key] . " file type is not allowed.";
					$this->dejavu_logger->debug($upload_err_log);
					//return FALSE;
				}
	
				// 파일 크기 체크
				if($_FILES["user_file"]["size"][$key] > $this->max_file_size)
				{
					$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> " . $_FILES["user_file"]["size"][$key] . " exceed max file size";
					$this->dejavu_logger->debug($upload_err_log);
					//return FALSE;
				}
	
				// 업로드 에러 체크
				if ($error == UPLOAD_ERR_OK)
				{
					$tmp_name = $_FILES["user_file"]["tmp_name"][$key];
					 
					if(is_uploaded_file($tmp_name)) {								// upload attack 방어
						move_uploaded_file($tmp_name, $upload_files[$key]);
						@chmod($upload_files[$key], FILE_PUT_CONTENTS_ATOMIC_MODE);
					}
					else
					{
						$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> Check Upload Attack";
						$this->dejavu_logger->debug($upload_err_log);
						//return FALSE;
					}
				}
				else
				{
					$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> error : " . $error;
					$this->dejavu_logger->debug($upload_err_log);
					//return FALSE;
				}
			}
		}
		else
		{
			// 파일 타입 체크
			if(!empty($_FILES["user_file"]["type"]) && !in_array($_FILES["user_file"]["type"], $this->allow_file_type))
			{
				$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> " . $_FILES["user_file"]["type"] . " file type is not allowed.";
				$this->dejavu_logger->debug($upload_err_log);
				//return FALSE;
			}
				
			// 파일 크기 체크
			if($_FILES["user_file"]["size"][1] > $this->max_file_size)
			{
				$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> " . $_FILES["user_file"]["size"] . " exceed max file size";
				$this->dejavu_logger->debug($upload_err_log);
				//return FALSE;
			}
	
			// 업로드 에러 체크
			if ($error == UPLOAD_ERR_OK)
			{
				$tmp_name = $_FILES["user_file"]["tmp_name"];
				if(is_uploaded_file($tmp_name)) {								// upload attack 방어
					move_uploaded_file($tmp_name, $upload_files[1]);
					@chmod($upload_files[1], FILE_PUT_CONTENTS_ATOMIC_MODE);
				}
				else
				{
					$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> Check Upload Attack";
					$this->dejavu_logger->debug($upload_err_log);
					//return FALSE;
				}
			}
			else
			{
				$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> error : " . $error;
				$this->dejavu_logger->debug($upload_err_log);
				//return FALSE;
			}
		}
		//return TRUE;
		return $arr_file_name;
	}	
	
	/**
	 * 
	 * uploadMultiFiles
	 * 
	 * @ClassName  : HTTPFileUpload
	 * @Comment    : 다수의 파일 업로드
	 * @Author     : suya
	 * @Date       : 2013. 8. 15.
	 * @param unknown_type $upload_files
	 * @param unknown_type $param
	 * @return unknown
	 * @return unknown
	 */
	public function uploadOneFile($upload_file='', $field_name='')
	{
		/**
			new dbug($_FILES);
			new dbug($upload_files);
		*/
		
		global $conf_img_gallery_dir;
		global $conf_img_shop_dir;
		global $conf_img_thumbnail_dir;
		global $conf_img_banner_dir;
		global $conf_img_sample_dir;
		global $conf_temp_file_dir;
		
		global $conf_img_gallery_url;
		global $conf_img_shop_url;
		global $conf_img_thumbnail_url;
		global $conf_img_banner_url;
		global $conf_img_sample_url;
					
		if(empty($upload_file) || empty($field_name))
		{
			$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> upload file names array is empty";
			$this->dejavu_logger->debug($upload_err_log);
		}
			
		// 업로드 파일별로 에러 발생 여부를 체크한다.

		if(!empty($_FILES[$field_name]["name"]))
		{
			// 파일 타입 체크
			if(!empty($_FILES[$field_name]["type"]) && !in_array($_FILES[$field_name]["type"], $this->allow_file_type))
			{
				$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> " . $_FILES[$field_name]["type"] . " file type is not allowed.";
				$this->dejavu_logger->debug($upload_err_log);
				//return FALSE;
			}
			
			// 파일 크기 체크
			if($_FILES[$field_name]["size"] > $this->max_file_size)
			{
				$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> " . $_FILES[$field_name]["size"] . " exceed max file size";
				$this->dejavu_logger->debug($upload_err_log);
				//return FALSE;
			}

			// 업로드 에러 체크
		    if ($error == UPLOAD_ERR_OK)													
		    {
	    	    $tmp_name = $_FILES[$field_name]["tmp_name"];
		        if(is_uploaded_file($tmp_name)) {								// upload attack 방어
	    	    	move_uploaded_file($tmp_name, $upload_file);
	    	    	@chmod($upload_file, FILE_PUT_CONTENTS_ATOMIC_MODE);
		        }
	        	else
	        	{
					$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> Check Upload Attack";
					$this->dejavu_logger->debug($upload_err_log);
	        		//return FALSE;
	        	}
	    	}
	    	else
	    	{
	    		$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> error : " . $error;
				$this->dejavu_logger->debug($upload_err_log);
	    		//return FALSE;
	    	}
		}
		//return TRUE;
	}

	/**
	 * 
	 * uploadMultiFilesNConvert
	 * 
	 * @ClassName  : HTTPFileUpload
	 * @Comment    : 다수의 이미지 업로드와 컨버팅 동시 진행
	 * @Author     : suya
	 * @Date       : 2013. 8. 15.
	 * @param unknown_type $upload_files
	 * @param unknown_type $param
	 * @return return_type
	 */
	
	/**
	public function uploadMultiFilesNConvert($upload_files=array(), $param=array())
	{	
		global $conf_img_gallery_dir;
		global $conf_img_shop_dir;
		global $conf_img_thumbnail_dir;
		global $conf_img_banner_dir;
		global $conf_img_sample_dir;
		global $conf_temp_file_dir;
	
		global $conf_img_gallery_url;
		global $conf_img_shop_url;
		global $conf_img_thumbnail_url;
		global $conf_img_banner_url;
		global $conf_img_sample_url;
			
		if(empty($upload_files))
		{
			$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> upload file names array is empty";
			$this->dejavu_logger->debug($upload_err_log);
		}
			
		// 업로드 파일별로 에러 발생 여부를 체크한다.
	
		if(is_array($_FILES["user_file"]["name"])){
			foreach ($_FILES["user_file"]["error"] as $key => $error)
			{
				// 파일 타입 체크
				if(!empty($_FILES["user_file"]["type"][$key]) && !in_array($_FILES["user_file"]["type"][$key], $this->allow_file_type))
				{
					$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> " . $_FILES["user_file"]["type"][$key] . " file type is not allowed.";
					$this->dejavu_logger->debug($upload_err_log);
					//return FALSE;
				}
	
				// 파일 크기 체크
				if($_FILES["user_file"]["size"][$key] > $this->max_file_size)
				{
					$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> " . $_FILES["user_file"]["size"][$key] . " exceed max file size";
					$this->dejavu_logger->debug($upload_err_log);
					//return FALSE;
				}
	
				// 업로드 에러 체크
				if ($error == UPLOAD_ERR_OK)
				{
					$tmp_name = $_FILES["user_file"]["tmp_name"][$key];
					 
					if(is_uploaded_file($tmp_name))								// upload attack 방어
					{
						move_uploaded_file($tmp_name, $upload_files[$key]);
	
						if (!empty($param) && !empty($param['main_id']))
						{
							//이미지 매직을 이용한 이미지 변환.  ( 변환 사이즈는 변경 해야함. / bar,qrcode는 일단 N)
							$fileName = substr(strrchr($upload_files[$key], "/"), 1);
	
							$arr_file_name = $this->ConvertImage->convertExec($fileName, $param["main_id"]);
						}
					}
					else
					{
						$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> Check Upload Attack";
						$this->dejavu_logger->debug($upload_err_log);
						//return FALSE;
					}
				}
				else
				{
					$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> error : " . $error;
					$this->dejavu_logger->debug($upload_err_log);
					//return FALSE;
				}
			}
		}
		else
		{
			// 파일 타입 체크
			if(!empty($_FILES["user_file"]["type"]) && !in_array($_FILES["user_file"]["type"], $this->allow_file_type))
			{
				$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> " . $_FILES["user_file"]["type"] . " file type is not allowed.";
				$this->dejavu_logger->debug($upload_err_log);
				//return FALSE;
			}
				
			// 파일 크기 체크
			if($_FILES["user_file"]["size"] > $this->max_file_size)
			{
				$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> " . $_FILES["user_file"]["size"] . " exceed max file size";
				$this->dejavu_logger->debug($upload_err_log);
				//return FALSE;
			}
	
			// 업로드 에러 체크
			if ($error == UPLOAD_ERR_OK)
			{
				$tmp_name = $_FILES["user_file"]["tmp_name"];
	
				if(is_uploaded_file($tmp_name))								// upload attack 방어
				{
					move_uploaded_file($tmp_name, $upload_files[1]);

					if (!empty($param) && !empty($param['main_id']))
					{
						//이미지 매직을 이용한 이미지 변환.  ( 변환 사이즈는 변경 해야함. / bar,qrcode는 일단 N)
						$fileName = substr(strrchr($upload_files[1], "/"), 1);
					
						$arr_file_name = $this->ConvertImage->convertExec($fileName, $param["main_id"]);
					}
				}
				else
				{
					$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> Check Upload Attack";
					$this->dejavu_logger->debug($upload_err_log);
					//return FALSE;
				}
			}
			else
			{
				$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> error : " . $error;
				$this->dejavu_logger->debug($upload_err_log);
				//return FALSE;
			}
		}
		//return TRUE;
		return $arr_file_name;
	}
	*/
	
	/**
	 * 
	 * uploadZipFiles
	 * 
	 * @ClassName  : HTTPFileUpload
	 * @Comment    : zip 파일 업로드후 지정된 폴더에 저장
	 * @Author     : suya
	 * @Date       : 2013. 8. 15.
	 * @param unknown_type $upload_files
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function uploadZipFiles($upload_files, $param)
	{
		
		//new dbug($_FILES);
		//new dbug($upload_files);
		//new dBug($param);
				
		global $conf_img_gallery_dir;
		global $conf_img_shop_dir;
		global $conf_img_thumbnail_dir;
		global $conf_img_banner_dir;
		global $conf_img_sample_dir;
		global $conf_temp_file_dir;
		
		global $conf_img_gallery_url;
		global $conf_img_shop_url;
		global $conf_img_thumbnail_url;
		global $conf_img_banner_url;
		global $conf_img_sample_url;
					
		if(empty($upload_files))
		{
			$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> upload file names array is empty";
			$this->dejavu_logger->debug($upload_err_log);
		}
				
		// 업로드 파일별로 에러 발생 여부를 체크한다.
		//new dBug($_FILES);
		//exit;
		// 파일 타입 체크
		if(!empty($_FILES["user_file"]["type"]) && !in_array($_FILES["user_file"]["type"], $this->allow_file_type))
		{
			$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> " . $_FILES["user_file"]["type"] . " file type is not allowed.";
			$this->dejavu_logger->debug($upload_err_log);
			//return FALSE;
		}
		
		// 파일 크기 체크
		if($_FILES["user_file"]["size"] > $this->max_file_size)
		{
			$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> " . $_FILES["user_file"]["size"] . " exceed max file size";
			$this->dejavu_logger->debug($upload_err_log);
			//return FALSE;
		}

		// 업로드 에러 체크
	    if ($error == UPLOAD_ERR_OK)													
	    {
    	    $tmp_name = $_FILES["user_file"]["tmp_name"];
	    	
	        if(is_uploaded_file($tmp_name))								// upload attack 방어
    	    {
    	    	move_uploaded_file($tmp_name, $upload_files[1]);
    	    
    	    	$unzipFile = $upload_files[1];
    	    	
    	    	$phpftp_tmpdir = substr($upload_files[1], 0, strrpos($upload_files[1], "/"));

	    	    if (!$this->UnZip->open($unzipFile)) die('Failed to open zip file.');
	    	    {				
	    	    	if(!$this->UnZip->extractTo($phpftp_tmpdir)) die('fail to unzip.');
	    	    	
					for($i = 0; $i < $this->UnZip->numFiles; $i++)
					{ 
						$fileName = $this->UnZip->getNameIndex($i);
					}
					
					$this->UnZip->close();
					//@unlink($unzipFile);	// zip file 삭제
				}
        	}
        	else
        	{
				$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> Check Upload Attack | tmp_name = " . $tmp_name . " | svc_type = " . $_COOKIE['svc_type'] .  " | os_type = " .  $_COOKIE['os_type'].  " | what_upload = " . $param['what_upload'];
				$this->dejavu_logger->debug($upload_err_log);
        		//return FALSE;
        	}
    	}
    	else
    	{
    		$upload_err_log = "[UPLOAD ERROR] : [" . __METHOD__ . "] -> error : " . $error;
			$this->dejavu_logger->debug($upload_err_log);
    		//return FALSE;
    	}
		
		//return TRUE;
		return $arr_file_name;
	}
}

/**
 * @Desc : 파일 업로드 프로그레스 샘플 
 * 
	print_r(apc_fetch("upload_$_POST[APC_UPLOAD_PROGRESS]"));
	
	Array
	(
	    [total] => 1142543
	    [current] => 1142543
	    [rate] => 1828068.8
	    [filename] => test
	    [name] => file
	    [temp_filename] => /tmp/php8F
	    [cancel_upload] => 0
	    [done] => 1
	)
 */
?>