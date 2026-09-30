<?php 
/**
 *
 *  EtcClass
 *
 *  @Desc     : 프런트단에 필요한 ui 부분 작업
 *  @Author   : deborah
 *  @Date     : 2010. 12. 06. 오후 3:36:31
 *  @Version  :
 */

class EtcClass {
	
	var $strPoint;
	private $js_prefix;	
	private $js_suffix;	

	function __construct() { 
		 $this->js_prefix = "<script>";
		 $this->js_suffix = "</script>";
	}
			
	/**
	 *
	 *  setWorkPoint
	 *
	 *  @Desc      : 별점 주기
	 *  @Author    : deborah
	 *  @Date      : 2010. 12. 06. 오후 3:36:17
	 *  @param     : $point	 
	 *  @Return    : 
	 */
	public function setWorkPoint($point)
	{
		global $strImgPath;
		
		$full_cnt = floor($point / 2);
		$half_cnt = $point % 2;
		$this->strPoint  = "<dd class='clfix'>\n";
		for ($i = 1; $i <= $full_cnt ; $i++) {
			$this->strPoint  .= "<img src='{$strImgPath}/common/ico_star_full.gif' alt='' />";
		}
		if ($half_cnt)	
			$this->strPoint  .= "<img src='{$strImgPath}/common/ico_star_half.png' alt='' />";
				
		$this->strPoint .= "<span>({$point}/10)</span>\n";				
		$this->strPoint .= "</dd>\n";
		print_r($this->strPoint);
	}
	
	/**
	 *
	 *  setWorkPoint2
	 *
	 *  @Desc      : 별점 주기(no span tag)
	 *  @Author    : fearat
	 *  @Date      : 2010. 12. 14. 22:12:19
	 *  @param     : $point	 
	 *  @Return    : 
	 */
	public function setWorkPoint2($point='', $size='')
	{
		global $strImgPath;
		
		if(isset($point)){
			if($point == 0 || empty($point) || is_array($point))	$point = 10;	// 디폴트값	
			$full_cnt = floor($point / 2);
			$half_cnt = $point % 2;
			$this->strPoint  = "<span class='clfix'>\n";
			
			if($size==2){
				$img_size = ($size==2) ? "02" : "";
				$this->strPoint = "";
			}
			
			for ($i = 1; $i <= $full_cnt ; $i++) {
				$this->strPoint  .= "<img src='{$strImgPath}/common/star_full{$img_size}.gif' alt='' />";
			}
			if ($half_cnt)	
				$this->strPoint  .= "<img src='{$strImgPath}/common/star_half{$img_size}.png' alt='' />";

			if(empty($size)){
				$this->strPoint .= "</span>\n";	
			}
			
			return $this->strPoint;
			// print_r($this->strPoint);
		}else{
			return;
		}
	}
	
	/**
	 *  getOrigAmount
	 *
	 *  @Desc      : 원래 판매가격 구하기
	 *  @Author    : fearat
	 *  @Date      : 2010. 12. 08. 01:18:19
	 *  @param     : product_amount, dc_ratio	 
	 *  @Return    : $origin_amount
	 */
	public function getOrigAmount($product_amount, $dc_ratio)
	{
		if($dc_ratio>0 && $product_amount>0){
			$origAmount = ($product_amount * 100) / $dc_ratio;
			echo "[".$origAmount."]";
			return $origAmount;
		}else{
			return 0;
		}
	}
	
	
	/**
	 *  getConvertArray
	 *
	 *  @Desc      : php->js 1차원배열 변환
	 *  @Author    : fearat
	 *  @Date      : 2010. 12. 10. 22:07:19
	 *  @param     : $arr_name
	 *  @param     : $arr_list
	 *  @Return    : js text 
	 */
	public function getConvertArray($arr_name='', $ArrList=array())
	{
		$arr_text = "\"";
		for($i=0; $i<count($ArrList); $i++){
			$arr_text.= $ArrList[$i];
			if( $i<(count($ArrList)-1) ){
				$arr_text.= "\", \"";
			}else{
				$arr_text.= "\"";
			}
		}
		
		$js_txt = $this->js_prefix;
		$js_txt.= sprintf("var %s = [ %s ]",
						$arr_name, $arr_text);
		$js_txt.= $this->js_suffix;
		
		echo $js_txt;
		return;
	}
	
	/**
	 *  d_dir
	 *
	 *  @Desc      : 해당 폴더 안에 있는 특정 파일 갯수 찾기
	 *  @Author    : 김창민
	 *  @Date      : 2011. 05. 04. 10:47:19
	 *  @param     : $path, $pattern
	 *  @Return    : count 
	 */
	public function d_dir($path, $pattern){
		
		$d = @dir($path);
		unset($arr_dir);
		while (false !== ($dir = @$d->read())) { 
			if( preg_match('/'.$pattern.'/', $dir)) { 
				$arr_dir[] = $dir; 
			}
		} 
		$d->close();
		return $arr_dir;
	}
}

?>
								