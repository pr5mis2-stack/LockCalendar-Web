<?php
/**
 *  fn_image_exif.php
 *  @Desc   : 업로드된 JPEG 이미지의 EXIF Orientation 값을 읽어
 *            실제 픽셀을 회전/반전시킨 뒤 그대로 덮어써서 저장한다.
 *            (아이폰 등에서 촬영한 사진이 세로/가로로 눕는 문제 해결용)
 *  @Author : dejavu
 *  @Usage  : uploadFiles() 등으로 파일 저장 직후, ratioresize() 하기 "전"에 호출
 *            예) dejavu_fix_exif_orientation($save_dir);
 *                $Image = new Image($save_dir);
 *                $Image->ratioresize(1024, 1024);
 *                $Image->save();
 */

if (!function_exists('dejavu_gd_flip_horizontal'))
{
	// GD의 imageflip()은 PHP 5.5 이상에서만 존재하므로,
	// 구버전 PHP(5.2/5.3 등)에서도 동작하도록 imagecopyresampled 트릭으로 대체
	function dejavu_gd_flip_horizontal($img)
	{
		$w = imagesx($img);
		$h = imagesy($img);
		$tmp = imagecreatetruecolor($w, $h);
		imagecopyresampled($tmp, $img, 0, 0, 0, 0, $w, $h, -$w, $h);
		imagedestroy($img);
		return $tmp;
	}

	function dejavu_gd_flip_vertical($img)
	{
		$w = imagesx($img);
		$h = imagesy($img);
		$tmp = imagecreatetruecolor($w, $h);
		imagecopyresampled($tmp, $img, 0, 0, 0, 0, $w, $h, $w, -$h);
		imagedestroy($img);
		return $tmp;
	}
}

if (!function_exists('dejavu_fix_exif_orientation'))
{
	function dejavu_fix_exif_orientation($filePath)
	{
		if (empty($filePath) || !file_exists($filePath))
			return false;

		// 서버에 exif / gd 확장이 없으면 그냥 원본 그대로 진행 (에러 방지)
		if (!function_exists('exif_read_data') || !function_exists('imagecreatefromjpeg'))
			return false;

		// EXIF Orientation은 JPEG 파일에만 존재
		$imageInfo = @getimagesize($filePath);
		if (!$imageInfo || $imageInfo[2] != IMAGETYPE_JPEG)
			return false;

		$exif = @exif_read_data($filePath);
		if (!$exif || empty($exif['Orientation']))
			return false;

		$orientation = (int)$exif['Orientation'];
		if ($orientation == 1)
			return false; // 이미 정상 방향

		$srcImg = @imagecreatefromjpeg($filePath);
		if (!$srcImg)
			return false;

		switch ($orientation)
		{
			case 2: // 좌우 반전
				$srcImg = dejavu_gd_flip_horizontal($srcImg);
				break;
			case 3: // 180도 회전
				$srcImg = imagerotate($srcImg, 180, 0);
				break;
			case 4: // 상하 반전
				$srcImg = dejavu_gd_flip_vertical($srcImg);
				break;
			case 5: // 상하 반전 + 반시계 90도
				$srcImg = dejavu_gd_flip_vertical($srcImg);
				$srcImg = imagerotate($srcImg, 90, 0);
				break;
			case 6: // 시계방향 90도 (세로로 찍은 사진이 눕는 가장 흔한 케이스)
				$srcImg = imagerotate($srcImg, -90, 0);
				break;
			case 7: // 좌우 반전 + 반시계 90도
				$srcImg = dejavu_gd_flip_horizontal($srcImg);
				$srcImg = imagerotate($srcImg, 90, 0);
				break;
			case 8: // 반시계방향 90도
				$srcImg = imagerotate($srcImg, 90, 0);
				break;
			default:
				imagedestroy($srcImg);
				return false;
		}

		if (!$srcImg)
			return false;

		// 품질 95로 원본 경로에 덮어쓰기 (회전 후에는 Orientation 태그가
		// 더 이상 필요 없고, imagejpeg()는 EXIF를 다시 쓰지 않으므로
		// 이후 뷰어/브라우저에서 이중 회전될 걱정 없음)
		$result = imagejpeg($srcImg, $filePath, 95);
		imagedestroy($srcImg);

		return (bool)$result;
	}
}
?>
