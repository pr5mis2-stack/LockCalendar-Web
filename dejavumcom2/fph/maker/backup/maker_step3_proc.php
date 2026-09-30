<?php
set_time_limit(0);
/**
 *  maker_step2_proc.php
 *  @Desc      : 상품등록 처리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/include/common_header.php");

import("class.controller.MainCon");
import("class.controller.GalleryCon");
import("class.controller.GalleryPhotoCon");
import("class.controller.ImageCon");
import("php.util.ConvertImage");
import("php.util.ResizeImage");
import("php.util.JSON");

$MainCon 		= new MainCon();
$ImageCon		= new ImageCon();
$ConvertImage 	= new ConvertImage();
$GalleryCon		= new GalleryCon();
$GalleryPhotoCon = new GalleryPhotoCon();
$JSON 			= new Services_JSON();

/**
 *
 * @var pageing setting
 */
$thisPage = "/manager/product_proc.php";

/**
 *
 * @var parameter setting
 */
$_s				= $StringClass->getRequest('s');
$main_id		= $StringClass->getRequest('main_id');
$photo_id		= $StringClass->getRequest('photo_id');

$param = array();
$arrXml = array(
		"header"=>array("result_code"=>"100", "result_msg"=>"FAIL")
		, "body"=>array()
);

if ($_s == "del_file")	// 갤러리 사진 삭제
{
	if (!empty($photo_id))	{
	
		// get main info
		$param = array();
		$param['photo_id'] = $photo_id;
		$result = $GalleryPhotoCon->getGalleryPhotoList($param);
		if ($result)
		{
			$main_info = $result[0];
		
			if ($main_info['photo_url'])
				$ImageCon->unlinkFIle($main_info['photo_url']);
		}
		
		$result = $GalleryPhotoCon->delGalleryPhoto($photo_id);
		
		if ($result)
		{
			$arrXml["header"]["result_code"] = "000";
			$arrXml["header"]["result_msg"] = "SUCCESS";
		}	
	}
	echo trim($JSON->encode($arrXml));
}
else 
{
	//$_s				= $_POST['s'];
	//$main_id		= $_POST['main_id'];
	$is_gallery		= $_POST['is_gallery'];
	$gallery_type	= $_POST['gallery_type'];
	
	if (!empty($main_id))	{
		$param['main_id'] = $main_id;
		$param['is_gallery'] = $is_gallery;
		$result = $MainCon->setMain($param);
		
		$result = $GalleryCon->getGalleryCnt($param);
		$param['gallery_type'] = $gallery_type;
		//new dBug($result);
		//exit;
		if ($result > 0)
			$result2 = $GalleryCon->setGallery($param);
		else 
			$result2 = $GalleryCon->addGallery($param);
			
		$parm = array();
		$param['upload_dir'] = "THUMBNAIL";
		$param['middle_dir'] = $main_id."/";
		//new dBug($param);
		// user_file1 등록
		$param["order_no"] = "1";
		$filename1 = $ImageCon->uploadOneFileByFilename($param, 'user_file1');
		if (!empty($filename1))
		{
			$fparam = array();
			$fparam['main_id'] = $main_id;
			$fparam['photo_name'] = $val;
			$fparam['photo_memo'] = "";
			$fparam['order_no'] = "1";
			$fparam['photo_url'] = $conf_mimg_thumbnail_url.$param['middle_dir'].$filename1;

			$GalleryPhotoCon->deleteGalleryPhotoByOrderNo($main_id, "1");
			$result3 = $GalleryPhotoCon->addGalleryPhoto($fparam);
			
			// 이미지 비율에 맞게 큰부분을 1280 사이즈로 조정
			$save_dir = $conf_img_thumbnail_dir.$param['middle_dir'].$filename1;
			$save_url = $conf_mimg_thumbnail_url.$fparam['middle_dir'].$filename1;
			$Image = new Image($save_dir);
			$Image->ratioresize(1024, 1024);
			$Image->save();
			//new dBug($save_dir);
		}		

		// user_file2 등록
		$param["order_no"] = "2";
		$filename2 = $ImageCon->uploadOneFileByFilename($param, 'user_file2');
		if (!empty($filename2))
		{
			$fparam = array();
			$fparam['main_id'] = $main_id;
			$fparam['photo_name'] = $val;
			$fparam['photo_memo'] = "";
			$fparam['order_no'] = "2";
			$fparam['photo_url'] = $conf_mimg_thumbnail_url.$param['middle_dir'].$filename2;
		
			$GalleryPhotoCon->deleteGalleryPhotoByOrderNo($main_id, "2");
			$result3 = $GalleryPhotoCon->addGalleryPhoto($fparam);
				
			// 이미지 비율에 맞게 큰부분을 1280 사이즈로 조정
			$save_dir = $conf_img_thumbnail_dir.$param['middle_dir'].$filename2;
			$save_url = $conf_mimg_thumbnail_url.$fparam['middle_dir'].$filename2;
			$Image = new Image($save_dir);
			$Image->ratioresize(1024, 1024);
			$Image->save();
			//new dBug($save_dir);
		}
		
		// user_file3 등록
		$param["order_no"] = "3";
		$filename3 = $ImageCon->uploadOneFileByFilename($param, 'user_file3');
		if (!empty($filename3))
		{
			$fparam = array();
			$fparam['main_id'] = $main_id;
			$fparam['photo_name'] = $val;
			$fparam['photo_memo'] = "";
			$fparam['order_no'] = "3";
			$fparam['photo_url'] = $conf_mimg_thumbnail_url.$param['middle_dir'].$filename3;
		
			$GalleryPhotoCon->deleteGalleryPhotoByOrderNo($main_id, "3");
			$result3 = $GalleryPhotoCon->addGalleryPhoto($fparam);
				
			// 이미지 비율에 맞게 큰부분을 1280 사이즈로 조정
			$save_dir = $conf_img_thumbnail_dir.$param['middle_dir'].$filename3;
			$save_url = $conf_mimg_thumbnail_url.$fparam['middle_dir'].$filename3;
			$Image = new Image($save_dir);
			$Image->ratioresize(1024, 1024);
			$Image->save();
			//new dBug($save_dir);
		}
		
		// user_file4 등록
		$param["order_no"] = "4";
		$filename4 = $ImageCon->uploadOneFileByFilename($param, 'user_file4');
		if (!empty($filename4))
		{
			$fparam = array();
			$fparam['main_id'] = $main_id;
			$fparam['photo_name'] = $val;
			$fparam['photo_memo'] = "";
			$fparam['order_no'] = "4";
			$fparam['photo_url'] = $conf_mimg_thumbnail_url.$param['middle_dir'].$filename4;
		
			$GalleryPhotoCon->deleteGalleryPhotoByOrderNo($main_id, "4");
			$result3 = $GalleryPhotoCon->addGalleryPhoto($fparam);
				
			// 이미지 비율에 맞게 큰부분을 1280 사이즈로 조정
			$save_dir = $conf_img_thumbnail_dir.$param['middle_dir'].$filename4;
			$save_url = $conf_mimg_thumbnail_url.$fparam['middle_dir'].$filename4;
			$Image = new Image($save_dir);
			$Image->ratioresize(1024, 1024);
			$Image->save();
			//new dBug($save_dir);
		}
		
		// user_file5 등록
		$param["order_no"] = "5";
		$filename5 = $ImageCon->uploadOneFileByFilename($param, 'user_file5');
		if (!empty($filename5))
		{
			$fparam = array();
			$fparam['main_id'] = $main_id;
			$fparam['photo_name'] = $val;
			$fparam['photo_memo'] = "";
			$fparam['order_no'] = "5";
			$fparam['photo_url'] = $conf_mimg_thumbnail_url.$param['middle_dir'].$filename5;
		
			$GalleryPhotoCon->deleteGalleryPhotoByOrderNo($main_id, "5");
			$result3 = $GalleryPhotoCon->addGalleryPhoto($fparam);
				
			// 이미지 비율에 맞게 큰부분을 1280 사이즈로 조정
			$save_dir = $conf_img_thumbnail_dir.$param['middle_dir'].$filename5;
			$save_url = $conf_mimg_thumbnail_url.$fparam['middle_dir'].$filename5;
			$Image = new Image($save_dir);
			$Image->ratioresize(1024, 1024);
			$Image->save();
			//new dBug($save_dir);
		}
		
		//exit;
		//if(!empty($result2))
		//{
			echo "<script>document.domain = 'dejavu-m.com';</script>";
				
			if ($_s == "G")
				$StringClass->alertMsg('저장되었습니다.','parent', 'main.php?step=4', '');
			else if ($_s == "M")
				echo "<script>parent.fileReset();parent.modalPreViewerPop();</script>";
			else
				$StringClass->alertMsg('저장되었습니다.','parent', 'main.php?step=3', '');
		//}
		//else
		//	$StringClass->alertMsg('저장 중 오류가 발생하였습니다.','', '', 'NONE');
	}
	else
		$StringClass->alertMsg('초대장 정보가 없습니다.','', '', 'NONE');
}
?>