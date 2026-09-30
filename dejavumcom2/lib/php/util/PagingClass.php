<?php
/*===========================================================================
 * 용도		: ActionClass 사용시 데이터출력의 페이지 나누기를 용이하게 해준다
 * 연락처	: spacer.ha@gmail.com
 * 사용제한 : 
 - 이 클래스 라이브러리 사용은 무료이나, 원작자의 정보나 주석을 삭제할 수 없습니다.(자동생성되는 뷰캐시내 주석 포함)
 - 원작자가 배포한 그대로 수정되지 않은 소스는 자유롭게 배포가 가능합니다.
 - 사용자환경에 맞게 소스를 수정하여 사용은 가능하나 수정된 소스나, 수정된 소스가 포함된 프로그램을 타인에게 제공할 수 없습니다.
 - 영리/비영리/개인/기업 관계없이 모두 사용할 수 있습니다.
 ============================================================================*/
class Paging {

	//var $pagingPath		= '../../../config/';

	var $pageSize, $blockSize;
	var $totalCount, $totalPage, $totalBlock;
	var $curPage, $curBlock;
	var $baseUrl;
	var $pageString;

	var $img_first;
	var $img_prev;
	var $img_next;
	var $img_last;

	var $view;
	var $getString;
	var $btn_class = " class='btn'";		// PHP8.4: initPaging에서만 쓰던 지역변수를 getPaging에서도 쓸 수 있도록 멤버변수로 변경

	function __construct($view='') { // cms(view=cms),front(view=) 구분		
		$this->view = $view; 
	}

	function initPaging($totRec, $blcSize, $pgSize, $page, $url, $param='') {
		 
		//$conf_paging				= parse_ini_file($this->pagingPath."/Paging.ini");
		$conf_paging				= parse_ini_file(__DIR__ . "/Paging.ini");
		$this->btn_class = " class='btn'";
		
		if ($this->view == "BOARD"){
		 	$conf_paging				= parse_ini_file(__DIR__ . "/PagingCMS.ini");
		 	$this->btn_class = "";
		 }
				
		$this->curPage = $page;
		$this->pageSize = $pgSize;
		$this->blockSize = $blcSize;
		$this->totalCount = $totRec;
		$this->curBlock = ceil($this->curPage/$blcSize);
		$this->totalPage = ceil($totRec/$pgSize);		
		$this->totalBlock = ceil($this->totalPage/$blcSize);
		$this->baseUrl = $url;
		$this->getString = $param;

		$this->img_first			= $conf_paging['img_first'];
		$this->img_prev				= $conf_paging['img_prev'];
		$this->img_next				= $conf_paging['img_next'];
		$this->img_last				= $conf_paging['img_last'];

		//페이지 이동 이미지
		if(!isset($this->img_first))	$this->img_first	= "◀";
		if(!isset($this->img_prev))	$this->img_prev			= "◁";
		if(!isset($this->img_next))	$this->img_next			= "▷";
		if(!isset($this->img_last))	$this->img_last			= "▶";

		$this->pageString				= '';

	}

	function encoding() {
		$this->getString = urlencode($this->getString);
	}

	function decoding() {
		$this->getString = urldecode($this->getString);
	}

	function getPaging($seperate='') {

		$stPage = ($this->curBlock - 1) * $this->blockSize + 1;
		$edPage = $this->curBlock * $this->blockSize;

		$prevBlockPage = $stPage - 1;
		$nextBlockPage = $edPage + 1;
	
		$this->pageString .= '<ul>';
		
		if ($this->totalBlock > 1)
		{
			// [이전블럭]
			if($this->curBlock == 1) {
				//$this->pageString = '<img src = ' . $this->img_first . ' />' . '&nbsp;&nbsp;';
				$this->pageString .= '<li><a href=' . $this->baseUrl;
				$this->pageString .= '&nowPage='. $this->curPage . $this->getString . $this->btn_class.'>' . $this->img_first . '</a></li>';
			} else {
				$this->pageString .= '<li><a href=' . $this->baseUrl;
				$this->pageString .= '&nowPage=' . $prevBlockPage . $this->getString . $this->btn_class.'>' . $this->img_first . '</a></li>';
			}
		}

		// [이전페이지]
		if($this->curPage == 1) {			
			//$this->pageString  .= '<img src = ' . $this->img_prev . ' />'. '&nbsp;&nbsp;';
			$this->pageString  .= '<li><a href=' . $this->baseUrl;
			$this->pageString  .= '&nowPage=1' . $this->getString;
			$this->pageString  .= $this->btn_class. '>' . $this->img_prev . '</a></li>';
		} else {			
			$this->pageString  .= '<li><a href=' . $this->baseUrl;
			$this->pageString  .= '&nowPage=' . ($this->curPage - 1) . $this->getString;
			$this->pageString  .= $this->btn_class. '>' . $this->img_prev . '</a></li>';
		}

		// [루프]
		for($i=$stPage; $i <= $edPage && $i <= $this->totalPage; $i++) {
			if($i == $this->curPage) {
				if(isset($seperate)){
					$this->pageString .= '<li><a href='.$this->baseUrl;
					$this->pageString .= '&nowPage='. $i . $this->getString;
					$this->pageString .= '><b>' . $i . '</b></a></li>';
				}else{
					$this->pageString .= '<li><b>' . $i . '</b></li>';
				}

			} else {
				$this->pageString .= '<li><a href=' . $this->baseUrl;
				$this->pageString .= '&nowPage=' . $i . $this->getString;
				$this->pageString .= $this->btn_class.'>' . $i . '</a></li>';
			}

			if($i<$edPage && $this->totalPage>$i) {
				if(!isset($seperate)){
					$this->pageString .= '|';
				}
			}

		}

		// [다음페이지]
		if($this->curPage == $this->totalPage) {
			$this->pageString .= '<li><a href=' . $this->baseUrl;
			$this->pageString .= '&nowPage=' . $this->totalPage . $this->getString;
			$this->pageString .= '>' . $this->img_next . '</a></li>';
		}
		else
		{	
			$this->pageString .= '<li><a href=' . $this->baseUrl;
			$this->pageString .= '&nowPage=' . ($this->curPage + 1) . $this->getString;
			$this->pageString .= '>' . $this->img_next . '</a></li>';
		}

		if ($this->totalBlock > 1)
		{
			// [다음블럭]
			if($this->curBlock == $this->totalBlock) {
				$this->pageString .= '<li><a href=' . $this->baseUrl;
				$this->pageString .= '&nowPage=' . $this->curPage . $this->getString;
				$this->pageString .= ' class=last>' . $this->img_last . '</a></li>';
				//$this->pageString  .= '&nbsp;&nbsp;' . '<img src = ' . $this->img_next . ' />';
			} else {
				$this->pageString .= '<li><a href=' . $this->baseUrl;
				if($nextBlockPage >= $this->totalPage){
					$this->pageString .= '&nowPage=' . $this->totalPage . $this->getString;
				}else{
					$this->pageString .= '&nowPage=' . $nextBlockPage . $this->getString;
				}
				$this->pageString .= ' class=last>' . $this->img_last . '</a></li>';
			}
		}

		//페이지가 2페이지 이상 없으면 출력자체를 안한다.
		
		if($this->totalPage<2) {
			$this->pageString = '<ul>';
		}
		$this->pageString .= '</ul>';
		
		return $this->pageString;
	}
}
?>