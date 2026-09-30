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
	 * 
	 * convertTextExec
	 * 
	 * @ClassName  : ConvertImage
	 * @Comment    : 글자 생성 method
	 * @Author     : suya
	 * @Date       : 2013. 9. 4.
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function convertTextExec($main_id=0, $param=array())
	{
		global $conf_img_thumbnail_dir;
		global $back_ground_convert;
		$quality = self::$IMAGE_QUALITY;
		$convert_file_upload_dir_path = $conf_img_thumbnail_dir . $main_id . "/";	//변환된 이미지를 업로드할 디렉토리
			
		$option = "";
		
		// 라벨 과 저장될 파일명은 필수 조건
		if (!empty($param['file_name']) && (!empty($param['label']) || !empty($param['markup'])) )
		{
			foreach($param as $key=>$val)
			{
				switch ($key)
				{
					case "trim":				// 
						$option .= (!empty($val))? "-trim ":"";
						break; 
					case "crop":				// 
						$option .= (!empty($val))? "-crop {$val} ":"-crop 0x0 ";
						break;
					case "font":				// 
						$option .= (!empty($val))? "-font {$val} ":"";
						break;
					case "pointsize":			// pt 단위
						$option .= (!empty($val))? "-pointsize {$val} ":"";
						break;
					case "size":				// 이미지사이즈 100x100
						$option .= (!empty($val))? "-size {$val} ":"";
						break;			
					case "gravity":				// 정렬(center:중앙정렬)
						$option .= (!empty($val))? "-gravity {$val} ":"";
						break;
					case "interword-spacing":	// 단어간 간격
						$option .= (!empty($val))? "-interword-spacing {$val} ":"";
						break;
					case "kerning":				// 자간간격
						$option .= (!empty($val))? "-kerning {$val} ":"";
						break;
					case "background":			// 배경색
						$option .= (!empty($val))? "-background {$val} ":"";
						break;
					case "fill":				// 글자색
						$option .= (!empty($val))? "-fill {$val} ":"-fill black ";
						break;
					case "strokewidth":			// 글자테두리 간격
						$option .= (!empty($val))? "-strokewidth {$val} ":"";
						break;
					case "stroke":				// 테두리색
						$option .= (!empty($val))? "-stroke {$val} ":"";
						break;
					case "undercolor":			// 글자배경색
						$option .= (!empty($val))? "-undercolor {$val} ":"";
						break;
					case "compose":				// 이미지 합칠때 텍스트 이미지의 배경 (Multiply: 배경색없이 생성) default 값으로
						$option .= (!empty($val))? "-compose {$val} ":"-compose Multiply ";
						break;
				}
			}
			
			$option .= "-quality {$quality} ";
			if (!empty($param['markup']))
				$option .= "pango:'{$val}' ";
			else			
				//$option .= "-draw 'text 10,50 \"".addslashes($param['label'])."\"' ";
				$option .= "label:\"".addslashes($param['label'])."\" ";
				
			$option .= "PNG8:{$convert_file_upload_dir_path}{$param['file_name']}.png ";

			/*
			@exec("/usr/bin/convert -transparent white -trim -crop 0x0 -fill black -font font/HYGSRB.TTF -pointsize 12 label:'제 2012-{$rand_label} 호' PNG8:code_label_{$user_id}.png");
			@exec("/usr/bin/convert -size 384x33 -gravity center -transparent white -crop 0x0 -fill black -font font/HYGSRB.TTF label:'{$arrMessage[$rand_msg][0]}' PNG8:title_label_{$user_id}.png");
			@exec("/usr/bin/convert -size 384x25 -gravity center -transparent white -crop 0x0 -fill black -font font/HYGSRB.TTF label:'{$user_name}' PNG8:name_label_{$user_id}.png");
			@exec("/usr/bin/convert -size 384x110 -gravity center -transparent white -crop 0x0 -fill black -font font/HYGSRB.TTF label:'{$arrMessage[$rand_msg][1]}' PNG8:msg_label_{$user_id}.png");
			*/
			//new dBug($option);
			if($this->is_server_connect){	//상용 및 개발 장비에서 접속시...
				@exec("/usr/bin/convert  {$option} {$back_ground_convert}");	//이미지 매직으로 변환.(비동기 추가)
			}else{
				$runCommand = "C:\\Program Files\\ImageMagick-6.8.6-Q16\\convert.exe {$option}";
				$WshShell = new COM("WScript.Shell");
				$output = $WshShell->Exec($runCommand)->StdOut->ReadAll;
			}		
		}
	}
	
	/**
	 * 
	 * compositExec
	 * 
	 * @ClassName  : ConvertImage
	 * @Comment    : label과 image merge
	 * @Author     : suya
	 * @Date       : 2013. 9. 6.
	 * @param unknown_type $main_id
	 * @param unknown_type $param
	 * @return return_type
	 */
	public function compositExec($main_id=0, $param=array())
	{
		global $conf_img_thumbnail_dir;
		global $back_ground_convert;
		$quality = self::$IMAGE_QUALITY;
		$convert_file_upload_dir_path = $conf_img_thumbnail_dir . $main_id . "/";	//변환된 이미지를 업로드할 디렉토리
			
		$option = "";
			
		// 라벨 과 저장될 파일명은 필수 조건
		if (!empty($param['label_file_name']) && !empty($param['bg_file_name']) && !empty($param['result_file_name']))
		{
			$option .= (!empty($param['geometry']))? "-geometry {$param['geometry']} ":"-geometry +0+0 ";
			$option .= "{$convert_file_upload_dir_path}{$param['label_file_name']}.png {$convert_file_upload_dir_path}{$param['bg_file_name']}.png {$convert_file_upload_dir_path}{$param['result_file_name']}.png";

			/*
			//이미지 머징하기
			@exec("/usr/bin/composite -geometry +0+0 certificate/{$rand_image}_frame.png certificate/{$rand_image}_bg.jpg result_{$user_id}.jpg");
			@exec("/usr/bin/composite -geometry +43+55 code_label_{$user_id}.png result_{$user_id}.jpg result_{$user_id}.jpg");
			@exec("/usr/bin/composite -geometry +0+80 title_label_{$user_id}.png result_{$user_id}.jpg result_{$user_id}.jpg");
			@exec("/usr/bin/composite -geometry +0+138 name_label_{$user_id}.png result_{$user_id}.jpg result_{$user_id}.jpg");
			@exec("/usr/bin/composite -geometry +0+160 msg_label_{$user_id}.png result_{$user_id}.jpg result_{$user_id}.jpg");
			@exec("/usr/bin/composite -geometry +50+280 certificate/{$rand_image}_label.png result_{$user_id}.jpg result_{$user_id}.jpg");		
			*/
						
			if($this->is_server_connect){	//상용 및 개발 장비에서 접속시...
				@exec("/usr/bin/composite {$option} {$back_ground_convert}");	//이미지 매직으로 변환.(비동기 추가)
			}else{
				$runCommand = "C:\\Program Files\\ImageMagick-6.8.6-Q16\\composite.exe {$option}";
				$WshShell = new COM("WScript.Shell");
				$output = $WshShell->Exec($runCommand)->StdOut->ReadAll;
			}
		}
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
	 * 
	 * convertPhoto
	 * 
	 * @ClassName  : ConvertImage
	 * @Comment    : 사진이미지 리사이징
	 * @Author     : suya
	 * @Date       : 2013. 10. 6.
	 * @param unknown_type $uploadFileDir
	 * @param unknown_type $width
	 * @param unknown_type $height
	 * @return return_type
	 */
	public function resizePhoto($uploadFileDir, $resizeFileDir, $width, $height)
	{
		$quality = self::$IMAGE_QUALITY;
		$size = $width."x".$height;		//"720x1280";
		if($this->is_server_connect){	//상용 및 개발 장비에서 접속시...
			if(!empty($uploadFileDir)){
				//$runCommand = "/usr/bin/convert  {$uploadFileDir} -quality {$quality} -resize {$size}^ -gravity center -extent {$size} {$resizeFileDir}";
				$runCommand = "/usr/bin/convert  {$uploadFileDir} -quality {$quality} -resize {$size} {$resizeFileDir}";
				@exec($runCommand);	//이미지 매직으로 변환.(비동기 추가)
			}
		}else{
			if(!empty($uploadFileDir)){
				//$runCommand = "C:\\Program Files\\ImageMagick-6.8.6-Q16\\convert.exe {$uploadFileDir} -resize {$size}^ -gravity center -extent {$size} {$resizeFileDir}";
				$runCommand = "C:\\Program Files\\ImageMagick-6.8.6-Q16\\convert.exe {$uploadFileDir} -resize {$size} {$resizeFileDir}";
				$WshShell = new COM("WScript.Shell");
				$output = $WshShell->Exec($runCommand)->StdOut->ReadAll;

			}
		}
		//new dBug($runCommand);
	}
}
?>