<?php
import("class.controller.WWWRoot");
import("class.controller.ImageCon");
import("class.model.BoardDao");
import("class.model.BoardCategoryDao");
import("class.model.BoardRecommendDao");
import("class.model.BoardReplyDao");
import("class.model.BoardTagDao");

/**
 * 
 *  BoardCon
 *
 *  @Desc     : 게시판
 *  @Author   : DEV02_01
 *  @Date     : 2012. 5. 3. 오후 10:39:53
 *  @Version  :
 */
class BoardCon extends WWWRoot {
		
	private $BoardDao;
	private $BoardCategoryDao;
	private $BoardRecommendDao;
	private $BoardReplyDao;
	private $BoardTagDao;
	private $board_param;

	/**
	 *  BoardCon
	 *
	 *  @Desc      : constructor
	 *  @Author    : DEV02_01
	 *  @Date      : 2012. 5. 3. 오후 10:09:11
	 *  @Return    :
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->BoardDao 		 = new BoardDao();
		$this->BoardCategoryDao  = new BoardCategoryDao();		
		$this->BoardRecommendDao = new BoardRecommendDao();
		$this->BoardReplyDao 	 = new BoardReplyDao();
		$this->BoardTagDao 		 = new BoardTagDao();
		
		$this->imagecon 		 = new Imagecon();
	}

	/**
	 * 
	 *  getBoardCnt
	 *
	 *  @Desc      : 게시판 글갯수 추출
	 *  @Author    : DEV02_01
	 *  @Date      : 2012. 5. 2. 오후 6:29:56
	 *  @param unknown_type $param
	 *  @Return    :
	 */
	public function getBoardCnt($param=array())
	{
		$result = $this->BoardDao->getBoardCnt($param);
		return $result;		
	}
	
	/**
	 * 
	 *  getBoardList
	 *
	 *  @Desc      : 게시판 글목록 추출
	 *  @Author    : DEV02_01
	 *  @Date      : 2012. 5. 2. 오후 6:29:59
	 *  @param unknown_type $param
	 *  @param unknown_type $start
	 *  @param unknown_type $list
	 *  @Return    :
	 */
	public function getBoardList($param=array(), $start_num='', $end_num='')
	{
		$result = $this->BoardDao->getBoardList($param, $start_num, $end_num);
		return $result;			
	}
	
	/**
	 * 
	 *  insertBoard
	 *
	 *  @Desc      : 게시판 글 입력
	 *  @Author    : DEV02_01
	 *  @Date      : 2012. 5. 2. 오후 6:30:59
	 *  @param unknown_type $param
	 *  @Return    :
	 */
	public function insertBoard($param=array())
	{
		$result = $this->BoardDao->insertBoard($param);
		return $result;			
	}
	
	/**
	 * 
	 *  updateBoard
	 *
	 *  @Desc      : 게시판 글 수정
	 *  @Author    : DEV02_01
	 *  @Date      : 2012. 5. 2. 오후 6:31:03
	 *  @param unknown_type $param
	 *  @Return    :
	 */
	public function updateBoard($param=array())
	{
		$result = 0;	
		if (isset($param['board_id']) && !empty($param['board_id']))
			$result = $this->BoardDao->updateBoard($param);
		return $result;			
	}
	
	/**
	 * 
	 *  increaseBoardVisit
	 *
	 *  @Desc      : 게시판 조회수 증가
	 *  @Author    : DEV02_01
	 *  @Date      : 2012. 5. 2. 오후 6:41:38
	 *  @param unknown_type $board_id
	 *  @Return    :
	 */
	public function increaseBoardVisit($board_id='')
	{	
		$result = 0;	
		if (!empty($board_id))
			$result = $this->BoardDao->increaseBoardVisit($board_id);
		return $result;		
	}
	
	/**
	 * 
	 *  deleteBoard
	 *
	 *  @Desc      : 게시판 글 삭제
	 *  @Author    : DEV02_01
	 *  @Date      : 2012. 5. 2. 오후 6:31:07
	 *  @param unknown_type $board_id
	 *  @Return    :
	 */
	public function deleteBoard($board_id='')
	{
		$result = 0;	
		if (!empty($board_id))
			$result = $this->BoardDao->deleteBoard($board_id);
		return $result;			
	}
	
	/**
	 * 
	 *  getPrevBoardList
	 *
	 *  @Desc      : 이전 게시판글 추출
	 *  @Author    : DEV02_01
	 *  @Date      : 2012. 5. 3. 오후 10:34:11
	 *  @param unknown_type $param
	 *  @Return    :
	 */
	public function getPrevBoardList($param=array())
	{
		if (isset($param['board_id']) && !empty($param['board_id']))
			$result = $this->BoardDao->getPrevBoardList($param);
		return $result;			
	}
	
	/**
	 * 
	 *  getNextBoardList
	 *
	 *  @Desc      : 다음 게시판글 추출
	 *  @Author    : DEV02_01
	 *  @Date      : 2012. 5. 3. 오후 10:34:29
	 *  @param unknown_type $param
	 *  @Return    :
	 */
	public function getNextBoardList($param=array())
	{
		if (isset($param['board_id']) && !empty($param['board_id']))
			$result = $this->BoardDao->getNextBoardList($param);
		return $result;			
	}
	
}
?>