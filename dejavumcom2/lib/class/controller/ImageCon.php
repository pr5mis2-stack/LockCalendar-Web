<?php
import("class.controller.WWWRoot");
import("php.util.HTTPFileUploadClass");
import("php.util.PhpUnzipClass");

/**
 *
 *  ImageController
 *
 *  @Desc     : 이미지 컨트롤러 클래스
 *  @Author   : 손명석
 *  @Date     : 2010. 11. 24. 오후 13:41:08
 *  @Version  :
 */
class ImageCon extends WWWRoot {

	private $HTTPFileUpload;
	private $thumbnail_type_cnt;						// 썸네일 이미지 해상도 유형 갯수
	private $conf_image_delimiter;						// 만화 이미지 및 썸네일 이미지 파일명 내의 구분자

	/**
	 *
	 *  ImageController
	 *
	 *  @Desc      : constructor
	 *  @Author    : 손명석
	 *  @Date      : 2010. 11. 24. 오후 13:41:31
	 *  @Return    : no
	 */
	public function __construct()
	{
		parent::__construct();

		$this->HTTPFileUpload		= new HTTPFileUpload();

		$this->thumbnail_type_cnt	= 4;						// 썸네일 이미지 해상도 유형 갯수
		$this->conf_image_delimiter	= "_";						// 만화 이미지 및 썸네일 이미지 파일명 내의 구분자
	}

	/**
  	*  uploadFiles
 	*
 	*  @Desc      : 다수의 파일들을 업로드한다. (공지사항 첨부파일, 이벤트 이미지 등)
 	*  @Author    : 손명석
 	*  @Date      : 2010.11.30
 	*  @param     : $param['upload_dir']
 	*  @Return    : BOOL (다수의 이미지 중 하나라도 업로드에 실패하면 FALSE를 리턴한다.)
 	*  @Note	  : 파일 업로드폼 샘플
 	*
		<!-- 다중 파일 업로드 폼 -->
		<form action="msson_sample.php" method="post" enctype="multipart/form-data">
			<input name="user_file[1]" type="file" /><br />				<!-- 공용 API 사용을 위해 반드시 인덱스를 1부터 시작하도록 설정해야 한다. -->
			<input name="user_file[2]" type="file" /><br />

			<input type="hidden" name="upload_dir" value="EVENT" />		<!-- 이벤트 : EVENT, 공지사항 : NOTICE -->
			<input type="submit" value="등록" />
		</form>
	*/
	public function uploadFiles($param)
	{
		global $conf_img_gallery_dir;
		global $conf_img_shop_dir;
		global $conf_img_thumbnail_dir;
		global $conf_img_banner_dir;
		global $conf_temp_file_dir;
		global $conf_img_sample_dir;
		global $conf_bgm_shop_dir;

		$param['upload_dir'] = strtoupper($param['upload_dir']);
		$upload_files = array();
		$file_name_arr = array();

		foreach($_FILES["user_file"]["name"] as $key => $file_name)
		{

			if (!empty($file_name))
			{
				/**
				 * 중복저장을 막기위한 조치
				 * 저장되는 파일명을 변경 생성년월일(YYYYMMDDHHIISS) 추가
				 */
				list($usec, $sec) = explode(" ", microtime());
				// 확장자
				$tmp_array = explode(".", $file_name);
				$file_ext = $tmp_array[count($tmp_array)-1];
				$key = "0";

				$preFilename = sprintf("%14s", date("YmdHis", $sec)) . "_".$key;
				if (!empty($file_name))
					array_push($file_name_arr, $preFilename . ".".$file_ext);
				else
					array_push($file_name_arr, "");

				$change_file_name = $preFilename . ".".$file_ext;
				/**
				 * 썸네일 이미지 파일명 배열과 동일한 업로드 API 사용을 위해 파일명 배열의 인덱스는 1부터 시작된다.
				 */
				switch($param['upload_dir'])
				{
					CASE "GALLERY":
						$upload_files[$key] = $conf_img_gallery_dir . $param['first_dir'] . $param['middle_dir'] . $change_file_name;
						break;
					CASE "SHOP":
						$upload_files[$key] = $conf_img_shop_dir . $param['first_dir'] . $param['middle_dir'] . $change_file_name;
						break;
					CASE "THUMBNAIL":
						$upload_files[$key] = $conf_img_thumbnail_dir . $param['first_dir'] . $param['middle_dir'] . $change_file_name;
						break;
					CASE "BANNER":
						$upload_files[$key] = $conf_img_banner_dir . $param['first_dir'] . $param['middle_dir'] . $change_file_name;
						break;
					CASE "SAMPLE":
						$upload_files[$key] = $conf_img_sample_dir . $param['first_dir'] . $param['middle_dir'] . $change_file_name;
						break;
					CASE "BGM":
						$upload_files[$key] = $conf_bgm_shop_dir . $param['first_dir'] . $param['middle_dir'] . $change_file_name;
						break;
					DEFAULT :
						$upload_files[$key] = $conf_temp_file_dir . $param['first_dir'] . $param['middle_dir'] . $change_file_name;
						break;
				}

				// 디렉토리 없으면 생성
				if (!is_dir(str_replace($param['middle_dir'] . $change_file_name, "", $upload_files[0])))
				{
					mkdir(str_replace($param['middle_dir'] . $change_file_name, "", $upload_files[0]));
					@chmod(str_replace($param['middle_dir'] . $change_file_name, "", $upload_files[0]), FILE_PUT_CONTENTS_ATOMIC_MODE);
				}

				if (!is_dir(str_replace($change_file_name, "", $upload_files[0])))
				{
					mkdir(str_replace($change_file_name, "", $upload_files[0]));
					@chmod(str_replace($change_file_name, "", $upload_files[0]), FILE_PUT_CONTENTS_ATOMIC_MODE);
				}
			}

		}
		//new dbug($file_name_arr);
		//new dbug($_FILES);
		//new dbug($upload_files);
		$result = $this->HTTPFileUpload->uploadMultiFiles($upload_files);
		return $file_name_arr;
	}

	public function uploadOneFileByFilename($param=array(), $field_name='')
	{
		global $conf_img_gallery_dir;
		global $conf_img_shop_dir;
		global $conf_img_thumbnail_dir;
		global $conf_img_banner_dir;
		global $conf_temp_file_dir;
		global $conf_img_sample_dir;
		global $conf_bgm_shop_dir;

		$param['upload_dir'] = strtoupper($param['upload_dir']);
		$upload_file = "";
		$change_file_name = "";
		//new dBug($field_name);
		if (!empty($field_name))
		{
			$file_name = $_FILES[$field_name]["name"];
			if (!empty($file_name))
			{
				/**
				 * 중복저장을 막기위한 조치
				 * 저장되는 파일명을 변경 생성년월일(YYYYMMDDHHIISS) 추가
				 */
				list($usec, $sec) = explode(" ", microtime());
				// 확장자
				$tmp_array = explode(".", $file_name);
				$file_ext = $tmp_array[count($tmp_array)-1];
				$key = ($param["order_no"] == "")? "0":$param["order_no"];

				$preFilename = sprintf("%14s", date("YmdHis", $sec)) . "_".$key;
				if (!empty($file_name))
				{
					$change_file_name = $preFilename . ".".$file_ext;

					/**
					 * 썸네일 이미지 파일명 배열과 동일한 업로드 API 사용을 위해 파일명 배열의 인덱스는 1부터 시작된다.
					 */
					switch($param['upload_dir'])
					{
						CASE "GALLERY":
							$upload_file = $conf_img_gallery_dir . $param['first_dir'] . $param['middle_dir'] . $change_file_name;
							break;
						CASE "SHOP":
							$upload_file = $conf_img_shop_dir . $param['first_dir'] . $param['middle_dir'] . $change_file_name;
							break;
						CASE "THUMBNAIL":
							$upload_file = $conf_img_thumbnail_dir . $param['first_dir'] . $param['middle_dir'] . $change_file_name;
							break;
						CASE "BANNER":
							$upload_file = $conf_img_banner_dir . $param['first_dir'] . $param['middle_dir'] . $change_file_name;
							break;
						CASE "SAMPLE":
							$upload_file = $conf_img_sample_dir . $param['first_dir'] . $param['middle_dir'] . $change_file_name;
							break;
						CASE "BGM":
							$upload_file = $conf_bgm_shop_dir . $param['first_dir'] . $param['middle_dir'] . $change_file_name;
							break;
						DEFAULT :
							$upload_file = $conf_temp_file_dir . $param['first_dir'] . $param['middle_dir'] . $change_file_name;
							break;
					}

					// 디렉토리 없으면 생성
					if (!is_dir(str_replace($param['middle_dir'] . $change_file_name, "", $upload_files[0])))
					{
						mkdir(str_replace($param['middle_dir'] . $change_file_name, "", $upload_files[0]));
						@chmod(str_replace($param['middle_dir'] . $change_file_name, "", $upload_files[0]), FILE_PUT_CONTENTS_ATOMIC_MODE);
					}
					if (!is_dir(str_replace($change_file_name, "", $upload_file)))
					{
						mkdir(str_replace($change_file_name, "", $upload_file));
						@chmod(str_replace($change_file_name, "", $upload_file), FILE_PUT_CONTENTS_ATOMIC_MODE);
					}
					//new dbug($file_name_arr);
					//new dbug($_FILES);
					//new dbug($upload_files);
					$result = $this->HTTPFileUpload->uploadOneFile($upload_file, $field_name);
				}
			}
		}

		return $change_file_name;
	}


	public function uploadZipFile($param)
	{
		global $conf_img_gallery_dir;
		global $conf_img_shop_dir;
		global $conf_img_thumbnail_dir;
		global $conf_img_banner_dir;
		global $conf_temp_file_dir;
		global $conf_img_sample_dir;

		$param['upload_dir'] = strtoupper($param['upload_dir']);
		$upload_files = array();

		$file_index = 1; // return 배열 인덱스

		$upload_zip = array();
		$file_name	= $_FILES['user_file']['name'];
		$file_name_arr = array();

		/**
		 * 중복저장을 막기위한 조치
		 * 저장되는 파일명을 변경 생성년월일(YYYYMMDDHHIISS) 추가
		 */
		list($usec, $sec) = explode(" ", microtime());
		$preFilename = sprintf("%14s", date("YmdHis", $sec)) . "_".$key;
		if (!empty($file_name))
			array_push($file_name_arr, $preFilename . $file_name);
		else
			array_push($file_name_arr, "");

		// zip 파일은 한개 첫 번째 것만

		switch($param['upload_dir'])
		{
			CASE "SAMPLE": //샘플 이미지
				//$upload_files[$key] = $conf_product_image_dir . $param["product_id"] . $preFilename . $file_name;
				// . "/". $_POST["product_image_resoultion"]
				$directory = $conf_img_sample_dir . "/". $param["sample_id"];

				// 생성   =>  /data/sample_img/샘플아이디/
				// 디렉토리가 있는지 체크 없으면 생성
				if (!is_dir($directory))
					mkdir($directory);
				chdir($directory);

				// $upload_files[1] 1개 뿐이기 때문에 1로 맞춤
				$upload_files[1] = $directory . "/" . $preFilename . $file_name;

				break;
		} // zip 파일이 올라갈 경로

		$result = $this->HTTPFileUpload->uploadZipFiles($upload_files, $param);
		// 일단 올리고

		return $file_name_arr;
	}

	/**
	 *
	 * unlinkFIle
	 *
	 * @ClassName  : ImageCon
	 * @Comment    :
	 * @Author     : suya
	 * @Date       : 2014. 1. 7.
	 * @param unknown_type $file
	 * @return return_type
	 */
	public function unlinkFIle($file)
	{
		global $conf_data_dir;
		// http://m.dejavu-m.com/data/thumbnail_img/36/20140107231949_0.jpg
		$file_dir = str_replace("http://m.dejavu-m.com/data", $conf_data_dir, $file);
		//new dBug($file_dir);
		//exit;
		if (is_file($file_dir))
			unlink($file_dir);
	}
}
?>