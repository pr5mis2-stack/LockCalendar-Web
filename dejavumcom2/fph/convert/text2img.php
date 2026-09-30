<?php
require_once ($_SERVER["DOCUMENT_ROOT"]."/include/common_header.php");

import("php.util.ConvertImage");
import("class.controller.Text2ImgCon");

$ConvertImage = new ConvertImage();
$Text2ImgCon = new Text2ImgCon();

$_mid = $StringClass->getRequest('mid');
$_label = $StringClass->getRequest('label');
$_font = $StringClass->getRequest('font');
$_size = $StringClass->getRequest('size');
$_color = $StringClass->getRequest('color');
$_stroke = $StringClass->getRequest('stroke');
$_stwidth = $StringClass->getRequest('stwidth');
$_tmpimg = "";

//http://www.dejavu-m.com/convert/text2img.php?mid=1&label=%EA%B8%B8%EB%8F%99%EC%9D%B4&font=batang.ttc&size=65&color=00a0b4&stroke=00a0b4&stwidth=2

/**
 * data 변환
 */
if (empty($_label))
	$_label = iconv("utf-8", "euc-kr", urldecode($_label));

if (!empty($_mid))
{
	$param = array();
	$param['label'] 		= urldecode($_label);//iconv("utf-8", "euc-kr", urldecode($_label));
	$param['fill'] 			= !empty($_color)? '#'.$_color:"#000000";	// 글자색
	$param['font'] 			= !empty($_font)? $_SERVER["DOCUMENT_ROOT"]."/convert/fonts/".$_font:$_SERVER["DOCUMENT_ROOT"]."/convert/fonts/batang.ttc";
	//NanumGothic.ttf
	//$param['font'] = 'Malgun-Gothic';
	$param['pointsize'] 	= $_size * 0.75;
	if (!empty($_stwidth))
		$param['strokewidth'] 	= $_stwidth;	// 글자테두리 간격
	if (!empty($_stroke))
		$param['stroke'] 		= '#'.$_stroke;	// 테두리색
	$param['compose'] 		= "Multiply";	// 이미지 합칠때 텍스트 이미지의 배경 (Multiply: 배경색없이 생성) default 값으로
	//$param['trim'] = "Y";
	//$param['background'] = "white";	// 배경색
	//$param['undercolor'] = "lightblue";	// 글자배경색
	//$param['crop'] = "720x50";
	//$param['size'] = "720x50";
	//$param['gravity'] = "center";	// 정렬(center:중앙정렬)
	//$param['interword-spacing'] = 10;	// 단어간 간격
	//$param['kerning'] = 10;	// 자간간격
	//$param['markup'] = "<span foreground=\"blue\" size=\"x-large\">Blue text</span> is <i>cool</i>!";	// pango format (참조 : http://developer.gnome.org/pango/stable/PangoMarkupFormat.html)

	//getLastImgId()
	
	/**
	 * 이미 만들어져 있는 data 체크
	 */
	$cparam = array();
	$cparam['main_id'] = $_mid;
	$cparam['label'] = urldecode($_label);
	$cparam['font'] = $param['font'];
	$cparam['size'] = $param['pointsize'];
	$cparam['color'] = $param['fill'];
	$cparam['stroke'] = $param['stroke'];
	$cparam['stroke_width'] = $param['strokewidth'];
	
	//$result = $Text2ImgCon->getText2ImgList($cparam);
	//if ($result)
	//	$param['file_name'] = $result[0]["img_id"];

	//new dBug($result);
	//exit;
	if (!empty($param['file_name']))
	{	
		$_tmpimg = $conf_img_thumbnail_dir . $_mid . "/".$param['file_name'].".png";
		/**
		 * 만들어져있는 이미지가 있으면 새로 만들지 않고 기존 이미지 노출
		 */
		if (is_file($_tmpimg))
		{
			$imgPng = imageCreateFromPng($_tmpimg);
			imageAlphaBlending($imgPng, true);
			imageSaveAlpha($imgPng, true);
			
			/* Output image to browser */
			header("Content-type: image/png");
			imagePng($imgPng);
		}
		else
		{
			$param['file_name'] = $Text2ImgCon->getLastImgId();
			convertImg($_mid, $param);
		}
	}
	else
	{
		$param['file_name'] = $Text2ImgCon->getLastImgId();
		convertImg($_mid, $param);
	}
	convertImg($_mid, $param);
	
}

function convertImg($_mid, $param)
{
	global $conf_img_thumbnail_dir;
	global $ConvertImage;
	global $Text2ImgCon;
	global $cparam;
	
	### Get exact dimensions of text string
	$box = @imageTTFBbox($param['pointsize'],0,$param['font'],$param['label']);
	
	### Get width of text from dimensions
	$textwidth = abs($box[4] - $box[0]);
	
	### Get height of text from dimensions
	$textheight = abs($box[5] - $box[1]);
	
	### Get x-coordinate of centered text horizontally using length of the image and length of the text
	$xcord = ($imagewidth/2)-($textwidth/2)-2;
	
	### Get y-coordinate of centered text vertically using height of the image and height of the text
	$ycord = ($imageheight/2)+($textheight/2);
	
	//$image = @imagecreatetruecolor(strlen($param['label']) * $param['pointsize'] / 1.5, $param['pointsize']*1.75);
	$image = @imagecreatetruecolor($textwidth*1.1, $textheight*1.1);
	
	imagesavealpha($image, true);
	imagealphablending($image, false);
	$white = imagecolorallocatealpha($image, 255, 255, 255, 127);
	imagefill($image, 0, 0, $white);
	
	### Convert HTML text color to RGB
	if( preg_match( '/([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})/i', $param['fill'], $textrgb ) )
	{
		$textred = hexdec( $textrgb[1] );   
		$textgreen = hexdec( $textrgb[2] );   
		$textblue = hexdec( $textrgb[3] );
	}
	$fontcolor = imagecolorallocate($image, $textred, $textgreen, $textblue);
	
	if (!empty($param['stroke']))
	{
		if( preg_match( '/([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})/i', $param['stroke'], $textrgb ) )
		{
			$textred = hexdec( $textrgb[1] );
			$textgreen = hexdec( $textrgb[2] );
			$textblue = hexdec( $textrgb[3] );
		}
		$strokecolor = imagecolorallocate($image, $textred, $textgreen, $textblue);

		imagettfstroketext(&$image, $param['pointsize'], 0, 0, $textheight-2, &$fontcolor, &$strokecolor, $param['font'], $param['label'], $param['strokewidth']);
	}
	else
		imagettftext($image, $param['pointsize'], 0, 0, $textheight-2, $fontcolor, $param['font'], $param['label']);
	header("Content-type: image/png");
	imagepng($image);
	imagedestroy($image);
	
	

	
	/*
	$ConvertImage->convertTextExec($_mid, $param);	
	$_tmpimg = $conf_img_thumbnail_dir . $_mid . "/".$param['file_name'].".png";
		
	if (is_file($_tmpimg))
		$Text2ImgCon->addText2Img($cparam);
	
	$imgPng = imageCreateFromPng($_tmpimg);
	imageAlphaBlending($imgPng, true);
	imageSaveAlpha($imgPng, true);
	*/
	/* Output image to browser */
	//header("Content-type: image/png");
	//imagePng($imgPng); 
}

/**
 * Writes the given text with a border into the image using TrueType fonts.
 * @author John Ciacia
 * @param image An image resource
 * @param size The font size
 * @param angle The angle in degrees to rotate the text
 * @param x Upper left corner of the text
 * @param y Lower left corner of the text
 * @param textcolor This is the color of the main text
 * @param strokecolor This is the color of the text border
 * @param fontfile The path to the TrueType font you wish to use
 * @param text The text string in UTF-8 encoding
 * @param px Number of pixels the text border will be
 * @see http://us.php.net/manual/en/function.imagettftext.php
 */
function imagettfstroketext(&$image, $size, $angle, $x, $y, &$fontcolor, &$strokecolor, $fontfile, $text, $px) {

	for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
	{
		for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
		{
			$bg = imagettftext($image, $size+$px, $angle, $c1, $c2, $strokecolor, $fontfile, $text);
		}
	}
	return imagettftext($image, $size, $angle, $x, $y, $fontcolor, $fontfile, $text);
}
?>