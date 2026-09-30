<?php
import("class.controller.CommonCodeCon");


/**
 * 
 *  StringClass
 *
 *  @Desc     : 문자열 처리 관련 클래스
 *  @Author   : 이정수
 *  @Date     : 2010. 12. 08
 *  @Version  :
 *  
 */
class StringClass
{
	private $CommonCodeCon;
		
	public function __construct() 
	{
		$this->CommonCodeCon = new CommonCodeCon();
	}
	
    /**
     *
     */
    public function getRequest($request)
    {
        if (isset($_POST[$request])) {
            $rtn_val = trim($_POST[$request]);
        } elseif (isset($_GET[$request])) {
            $rtn_val = trim($_GET[$request]);
        } else {
            $rtn_val = "";
        }
        return $rtn_val;
    }

	/**
	 *
	 *  checkArrayKeyVal
	 *
	 *  @Desc      : 배열의 초기값 체크
	 *               해당 배열에 $key 가 없을경우 $key를 추가해준다.
	 *  @Author    : 이정수
	 *  @Date      : 2010. 12. 08 
	 *  @param     : &$param array 체크 배열
	 *               $key - 체크할 키
	 *               $def - 설정할 초기값
	 *  @Return    : 
	 */
	public function checkArrayKeyVal(&$param, $key, $def='')
	{
		if (!ISSET($param[$key]))
			$param[$key] = $def;

		if (!TRIM($param[$key]))
			$param[$key] = $def;
	}

	/**
	 *
	 *  alertMsg
	 *
	 *  @Desc      : 메세지 화면 출력 method
	 *  @Author    : 이정수
	 *  @Date      : 2010. 12. 08 
	 *  @param     : $msg - 출력 메세지
	 *               $target - 화면이동할 타겟
	 *               $url - 이동할 페이지
	 *               $target 값과 $url값이 없으면  이전페이지(history.back())처리한다.
	 *  @Return    : 
	 */
	public function alertMsg($msg='', $target='_self', $url='', $action = '')
	{
		$printMsg = "";
		if (!empty($msg))
			$printMsg .= "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
				
		$printMsg .= "<script language='javascript'>\n<!--\n";
		
		if ($msg)
			$printMsg .= "alert('".$msg."');\n";
		if ($url)
		{
			if ($target)
				$printMsg .= $target.".location.href='".$url."';\n";
			else
				$printMsg .= "location.href='".$url."';\n";
		}
		else
		{
			if (strtoupper($action) != "NONE")
			{
				if(strtoupper($action) == "CLOSE")
					$printMsg .= "window.close();\n";
				else
					$printMsg .= "history.back();\n";
			}
		}
						
		$printMsg .="//-->\n</script>";

		echo($printMsg);
		exit;
	}
	
	/**
	 *
	 *  getSelectOptionStr
	 *
	 *  @Desc      : 코드테이블의 값을 읽어 셀렉트의 옵션 스트링을 생성해 리턴한다.
	 *  @Author    : 손명석
	 *  @Date      : 2010. 12. 09 
	 *  @param     : $param - 코드 정의
	 *               $default_value - 디폴트값
	 *  @Return    : $SelectOptionStr
	 */
	public function getSelectOptionStr($param, $selected_value = '')
	{
		$selected = "";
		$select_option_str = "";
		$selected_value = trim($selected_value);

		$code_list = $this->CommonCodeCon->getCommonCodeList($param);
		
		foreach($code_list as $row)
		{
			if($row['code_val'] == $selected_value)
				$selected = "selected";
				
			$select_option_str .= "<option value=\"{$row['code_val']}\" {$selected}>{$row['code_lbl']}</option>";
			$selected = "";
		}
		
		return $select_option_str;
	}

	/**
	 *
	 *  getDate
	 *
	 *  @Desc      : 날짜필드의 값을 출력할 포맷으로 맟추어 리턴한다.
	 *  @Author    : 손명석
	 *  @Date      : 2010. 12. 09 
	 *  @param     : $date_str
	 *  @Return    : $date_str
	 */
	public function getDate($date_str)
	{
		$year	= substr($date_str, 0, 4);
		$month	= substr($date_str, 4, 2);
		$day	= substr($date_str, 6, 2);
		
		$date_str = "{$year}.{$month}.{$day}";
		return $date_str;
	}

	/**
	 *
	 *  getCodeLableList
	 *
	 *  @Desc      : 코드테이블의 값을 읽어 코드값을 키로, 코드레이블을 값으로 가지는 배열을 생성해 리턴한다.
	 *  @Author    : 손명석
	 *  @Date      : 2010. 12. 09 
	 *  @param     : $param - 코드 정의
	 *               $default_value - 디폴트값
	 *  @Return    : $SelectOptionStr
	 */
	public function getCodeLableList($param)
	{
		
		$code_list = $this->CommonCodeDao->getCommonCodeList($param);
		$code_label_list = array();
		
		foreach($code_list as $row)
		{
			$key = $row['code_val'];
			$value = $row['code_lbl'];
			
			$code_label_list[$key] = $value;
		}
		
		return $code_label_list;
	}
	
	/**
	 *
	 *  substr_kr
	 *
	 *  @Desc      : 한글자르기
	 *  @Author    : 이정수
	 *  @Date      : 2010. 12. 15 
	 *  @param     : $str    - "문자열"
	 *               $strart - "0"
	 *               $len    - "10"
	 *               $last   - "..."
	 *  @Return    : string
	 */	
	public function substr_kr($str,$start,$len,$last) 
	{ 
  		if (strlen($str) < $len) 
  			return $str; 
  		$str_kr    = trim(substr($str,$start,$len)); 
  		if (! ( strlen(str_replace(" ","",$str_kr)) % 2 ) ) 
  			return $str_kr.$last; 
  		else 
  			return substr($str_kr,0,$len -1).$last; 
	}


	/**
	 *
	 *  strcut_utf8
	 *
	 *  @Desc      : utf 한글자르기
	 *  @Author    : Itoa
	 *  			 [출처] [PHP] UTF-8 한글 자르기|작성자 Itoa
	 *  @Date      : 2010. 12. 15 
	 *  @param     : String $str : 원본 문자열
	 *				 Integer $len : 문자열을 자를 길이
	 *				 Boolean $checkmb : 이 값을 true로 하면 한글을 영문2자와 같이 취급한다. 기본값은 false
	 * 				 String $tail : 생략후 붙일 줄임 기호
	 *  @Return    : string
	 */	
	function strcut_utf8($str, $len, $checkmb=false, $tail='...') 
	{
		$str = strip_tags($str);
		preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);
		$m = $match[0];
		$slen = strlen($str); // length of source string
		$tlen = strlen($tail); // length of tail string
		$mlen = count($m); // length of matched characters
		
		if ($slen <= $len) return $str;
		if (!$checkmb && $mlen <= $len) return $str;
		
		$ret = array();
		$count = 0;

		for ($i=0; $i < $len; $i++) {
			$count += ($checkmb && strlen($m[$i]) > 1)?2:1;
		
			if ($count + $tlen > $len) break;
			$ret[] = $m[$i];
		}
		return join('', $ret).$tail;
	}

	/**
	 *  setStatsLink
	 *
	 *  @Desc      : 통계를 위해 URL상에 파라미터 추가한 URL생성 method
	 *  @Author    : suya
	 *  @Date      : 2011. 01. 10 
	 *  @param     : String $url : 원본 URL
	 *  @Return    : string $url : 파라미터 추가된 URL
	 */	
	function setStatsLink($url)
	{
		$fr = (isset($_GET["fr"]) && !empty($_GET["fr"]))? trim($_GET["fr"]):trim($_POST["fr"]);
		
		// fr값이 있을경우 URL 마지막에 fr파라미터를 추가
		if (!empty($fr))
			$url .= (stripos($url, "?") !== false)? "&fr=".$fr:"?fr=".$fr;
			 		
		return $url;
	}

	/**
	 *  filterCrossBrower
	 *
	 *  @Desc      : crossbrower위해 일부 특수기호 삭제
	 *  @Author    : suya
	 *  @Date      : 2011. 01. 10 
	 *  @param     : String $str
	 *  @Return    : string $str
	 */	
	function filterCrossBrower($str)
	{
		$str = str_replace("%3C", "", $str);	
		$str = str_replace("%3E", "", $str);
		$str = str_replace("<", "", $str);
		$str = str_replace(">", "", $str);
		return $str;
	}
	
	
	/**
	 *  escapeString
	 *
	 *  @Desc      : 문자열 escape
	 *  @Author    : suya
	 *  @Date      : 2011. 01. 10 
	 *  @param     : String $str
	 *  @Return    : string $str
	 */			
	public function escapeString($str)
	{
		$str = trim($str);
		$str = strip_tags($str);
		$str = htmlentities($str, ENT_QUOTES, 'UTF-8');		// 모든 html 테그를 html 엔티티로 변환		
		$str = str_ireplace("cookie", "cook1e", $str);
		$str = str_ireplace("document", "d0cument", $str);
		$str = str_ireplace("script", "scr1pt", $str);
		$str = str_ireplace("/", "1", $str);
//		$str = str_ireplace("<", "&lt;", $str);		
//		$str = str_ireplace(">", "&gt;", $data);		
		$str = str_ireplace("<", "", $str);		
		$str = str_ireplace(">", "", $str);	
		$str = str_ireplace("%3C", "", $str);		
		$str = str_ireplace("%3E", "", $str);
		$str = str_ireplace("(", "&#40;", $str);		
		$str = str_ireplace(")", "&#41;", $str);		
		$str = str_ireplace("#", "&#35;", $str);		
		$str = str_ireplace("&", "&#38;", $str);

		return $str;
	} 
}
?>