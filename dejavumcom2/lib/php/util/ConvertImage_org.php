<?php

/**
 *  ConvertImage
 *
 *  @Desc     : 이미지 매직을 사용한 이미지 변환
 *  @Author   : uno
 *  @Date     : 2012. 1. 5. 오후 1:23:32
 *  @Version  : 
 */
import("class.controller.WWWRoot");

define("SMALL_SIZE", 0);
define("BIG_SIZE"  , 1);


/*
  		@exec("/usr/bin/convert -transparent white -trim -crop 0x0 -fill black -font font/HYGSRB.TTF -pointsize 12 label:'제 2012-{$rand_label} 호' PNG8:code_label_{$user_id}.png");
		@exec("/usr/bin/convert -size 384x33 -gravity center -transparent white -crop 0x0 -fill black -font font/HYGSRB.TTF label:'{$arrMessage[$rand_msg][0]}' PNG8:title_label_{$user_id}.png");
		@exec("/usr/bin/convert -size 384x25 -gravity center -transparent white -crop 0x0 -fill black -font font/HYGSRB.TTF label:'{$user_name}' PNG8:name_label_{$user_id}.png");
		@exec("/usr/bin/convert -size 384x110 -gravity center -transparent white -crop 0x0 -fill black -font font/HYGSRB.TTF label:'{$arrMessage[$rand_msg][1]}' PNG8:msg_label_{$user_id}.png");
		
		
		//이미지 머징하기
		@exec("/usr/bin/composite -geometry +0+0 certificate/{$rand_image}_frame.png certificate/{$rand_image}_bg.jpg result_{$user_id}.jpg");
		@exec("/usr/bin/composite -geometry +43+55 code_label_{$user_id}.png result_{$user_id}.jpg result_{$user_id}.jpg");
		@exec("/usr/bin/composite -geometry +0+80 title_label_{$user_id}.png result_{$user_id}.jpg result_{$user_id}.jpg");
		@exec("/usr/bin/composite -geometry +0+138 name_label_{$user_id}.png result_{$user_id}.jpg result_{$user_id}.jpg");
		@exec("/usr/bin/composite -geometry +0+160 msg_label_{$user_id}.png result_{$user_id}.jpg result_{$user_id}.jpg");
		@exec("/usr/bin/composite -geometry +50+280 certificate/{$rand_image}_label.png result_{$user_id}.jpg result_{$user_id}.jpg");		
 */
//예외처리.
class ConvertImageException extends Exception{
	public function writeErrorLog($fileName){
		return "Error Line : " . $this->getLine() . " Reson : " . $this->getMessage() . " fileName : " . $fileName;
	} 
}

//이미지 변환 클래스.
class ConvertImage extends WWWRoot{

	
	// 상품 리스트에 노출되는 이미지 사이즈 (97) , 상품 상세에 노출되는 이미지 (226)
	private static $PRODUCT_IMAGE_CONVERT_SIZE = array(
		SMALL_SIZE => "60X60!",
		BIG_SIZE   => "120X120!"
	);
	
	
	// 프로필 리스트에 노출되는 이미지 사이즈 (84) , 프로필 노출되는 이미지 (128)
	private static $PROFILE_IMAGE_CONVERT_SIZE = array(
		SMALL_SIZE => "43X43!",
		BIG_SIZE   => "60X60!"
	);	
		
	// 97사이즈 파일명의 접미사(_20) , 226사이즈 파일명의 접미사(_30)
	private static $IMAGE_FILE_NAME_SUFFIX = array(
		SMALL_SIZE => "_20",
		BIG_SIZE   => "_30"
	);
	
	//이미지 변환시 quality 를 100%로 셋팅.
	private static $IMAGE_QUALITY = 100;
	
	// 상용.개발 장비는 true , 로컬PC 는 false
	private $is_server_connect; 	
	
	
	
	/**
	 *  __construct
	 *
	 *  @Desc      : 초기화
	 *  @Author    : uno
	 *  @Date      : 2012. 1. 5. 오후 4:20:13
	 *  @Return    :
	 */
	public function __construct(){
		if( strpos(strtoupper($_SERVER["DOCUMENT_ROOT"]) , "C:/") === false ){	//상용 및 개발 장비에서 접속시...
			$this->is_server_connect = true;
		}else{
			$this->is_server_connect = false;
		}
		
		parent::__construct();
	}
	

	/**
	 *  convertExec
	 *
	 *  @Desc      : 상품 이미지 변환 함수.
	 *  @Author    : uno
	 *  @Date      : 2012. 1. 5. 오후 4:10:10
	 *  @param String $uploadFileName  (업로드 된 파일명)
	 *  @param String $productId (상품 아이디)
	 *  @Return    : Array (변환 파일명)
	 */
	public function convertExec($uploadFileName, $productId){
		global $conf_product_image_dir;
		global $back_ground_convert;
		
		if(!empty($uploadFileName) && !empty($productId)){
			$convert_file_upload_dir_path = $conf_product_image_dir . $productId . "/";	//변환된 이미지를 업로드할 디렉토리
			//$file_path_info = pathinfo($uploadFileName);
			
			$file_name_only = substr($uploadFileName,0,strrpos($uploadFileName,"."));//변환 파일이름
			$file_name_ext = substr($uploadFileName,strrpos($uploadFileName,"."));   //변환 확장자이름				
			

			//if(isset($file_path_info['filename']) && isset($file_path_info['extension'])){	//파일명(filename)과 확장자(extension)가 있을 경우...
			if(!empty($file_name_only) && !empty($file_name_ext)){
				//$file_name = $file_path_info['filename'];
				//$file_ext  = $file_path_info['extension'];
				
				$file_name = $file_name_only;
				$file_ext  = $file_name_ext;			
				
				foreach(self::$IMAGE_FILE_NAME_SUFFIX as $suffix){
					//$db_file_name[] = $file_name . $suffix . "." . $file_ext;
					$db_file_name[] = $file_name . $suffix  . $file_ext;
				}
				
				$db_file_name[] = $uploadFileName;
			}else{
				//Exception 업로드 파일명에서 파일명과 확장자를 걸러내지 못했다.
				try{
					throw new ConvertImageException("== [product image convert error] filename or extension get fail ==");
				}catch(ConvertImageException $e){
					$this->nmarket_logger->debug($e->writeErrorLog());
					return array();
				}
			}
			
			if($this->is_server_connect){	//상용 및 개발 장비에서 접속시...
				if(!empty($db_file_name) && isset($db_file_name)){
					$quality = self::$IMAGE_QUALITY;
					foreach(self::$PRODUCT_IMAGE_CONVERT_SIZE as $key => $size){
						//@exec("/usr/bin/convert -geometry {$size} {$convert_file_upload_dir_path}{$uploadFileName} {$convert_file_upload_dir_path}{$db_file_name[$key]}");	//이미지 매직으로 변환.						
						@exec("/usr/bin/convert  {$convert_file_upload_dir_path}{$uploadFileName} -resize {$size} {$convert_file_upload_dir_path}{$db_file_name[$key]} {$back_ground_convert}");	//이미지 매직으로 변환.(비동기 추가)
					}
				}
			}else{
				$convert_file_upload_dir_path1 .= $convert_file_upload_dir_path . "result/";
				$quality = self::$IMAGE_QUALITY;
				foreach(self::$PRODUCT_IMAGE_CONVERT_SIZE as $key => $size){
					//$runCommand = "C:\\Program Files\\ImageMagick-6.8.6-Q16\\convert.exe -geometry {$size} {$convert_file_upload_dir_path}{$uploadFileName} {$convert_file_upload_dir_path}{$db_file_name[$key]}";
					$runCommand = "C:\\Program Files\\ImageMagick-6.8.6-Q16\\convert.exe {$convert_file_upload_dir_path}{$uploadFileName} -resize {$size} -quality {$quality} {$convert_file_upload_dir_path1}{$db_file_name[$key]}";
                    $WshShell = new COM("WScript.Shell");
                    $output = $WshShell->Exec($runCommand)->StdOut->ReadAll;	                    			
				}
			}
						
		}else{
			//Exception 파일명 혹은 상품 아이디가 없음.
			try{
				throw new ConvertImageException("== [product image convert error] uploadfilename or productId is empty ==");
			}catch(ConvertImageException $e){
				$this->nmarket_logger->debug($e->writeErrorLog($uploadFileName));
				return array();
			}			
		}
		
		return $db_file_name;
	}
	
	/**
	*  convertGarageExec
	*
	*  @Desc      : 상품 이미지 변환 함수.
	*  @Author    : uno
	*  @Date      : 2012. 1. 5. 오후 4:10:10
	*  @param String $uploadFileName  (업로드 된 파일명)
	*  @param String $productId (상품 아이디)
	*  @Return    : Array (변환 파일명)
	*/
	public function convertGarageExec($uploadFileName, $productId){
		global $conf_product_image_dir;
	
		if(!empty($uploadFileName) && !empty($productId)){
			$convert_file_upload_dir_path = $conf_product_image_dir . $productId . "/";	//변환된 이미지를 업로드할 디렉토리
			//$file_path_info = pathinfo($uploadFileName);
				
			$file_name_only = substr($uploadFileName,0,strrpos($uploadFileName,"."));//변환 파일이름
			$file_name_ext = substr($uploadFileName,strrpos($uploadFileName,"."));   //변환 확장자이름
				
	
			//if(isset($file_path_info['filename']) && isset($file_path_info['extension'])){	//파일명(filename)과 확장자(extension)가 있을 경우...
			if(!empty($file_name_only) && !empty($file_name_ext)){
				//$file_name = $file_path_info['filename'];
				//$file_ext  = $file_path_info['extension'];
	
				$file_name = $file_name_only;
				$file_ext  = $file_name_ext;
	
				foreach(self::$IMAGE_FILE_NAME_SUFFIX as $suffix){
					//$db_file_name[] = $file_name . $suffix . "." . $file_ext;
					$db_file_name[] = $file_name . $suffix  . $file_ext;
				}
	
				$db_file_name[] = $uploadFileName;
			}else{
				//Exception 업로드 파일명에서 파일명과 확장자를 걸러내지 못했다.
				try{
					throw new ConvertImageException("== [product image convert error] filename or extension get fail ==");
				}catch(ConvertImageException $e){
					$this->nmarket_logger->debug($e->writeErrorLog());
					return array();
				}
			}
				
			if($this->is_server_connect){
				//상용 및 개발 장비에서 접속시...
				if(!empty($db_file_name) && isset($db_file_name)){
					$quality = self::$IMAGE_QUALITY;
					foreach(self::$PRODUCT_IMAGE_CONVERT_SIZE as $key => $size){
						//@exec("/usr/bin/convert -geometry {$size} {$convert_file_upload_dir_path}{$uploadFileName} {$convert_file_upload_dir_path}{$db_file_name[$key]}");	//이미지 매직으로 변환.
						@exec("/usr/bin/convert  {$conf_product_image_dir}{$uploadFileName} -resize {$size} -quality {$quality} {$convert_file_upload_dir_path}{$db_file_name[$key]}");	//이미지 매직으로 변환.
						//$this->nmarket_logger->debug("/usr/bin/convert  {$conf_product_image_dir}{$uploadFileName} -resize {$size} -quality {$quality} {$convert_file_upload_dir_path}{$db_file_name[$key]}");
					}
				}
			}else{
				$convert_file_upload_dir_path1 .= $convert_file_upload_dir_path . "result/";
				$quality = self::$IMAGE_QUALITY;
				foreach(self::$PRODUCT_IMAGE_CONVERT_SIZE as $key => $size){
					//$runCommand = "C:\\Program Files\\ImageMagick-6.8.6-Q16\\convert.exe -geometry {$size} {$convert_file_upload_dir_path}{$uploadFileName} {$convert_file_upload_dir_path}{$db_file_name[$key]}";
					$runCommand = "C:\\Program Files\\ImageMagick-6.8.6-Q16\\convert.exe {$convert_file_upload_dir_path}{$uploadFileName} -resize {$size} -quality {$quality} {$convert_file_upload_dir_path1}{$db_file_name[$key]}";
					$WshShell = new COM("WScript.Shell");
					$output = $WshShell->Exec($runCommand)->StdOut->ReadAll;
				}
			}
	
			// 원본 이동
			@exec("mv {$conf_product_image_dir}{$uploadFileName} {$convert_file_upload_dir_path}{$uploadFileName}");	//이미지 매직으로 변환.
			
		}else{
		//Exception 파일명 혹은 상품 아이디가 없음.
			try{
				throw new ConvertImageException("== [product image convert error] uploadfilename or productId is empty ==");
			}catch(ConvertImageException $e){
				$this->nmarket_logger->debug($e->writeErrorLog($uploadFileName));
				return array();
			}
		}
	
		return $db_file_name;
	}

}
?>