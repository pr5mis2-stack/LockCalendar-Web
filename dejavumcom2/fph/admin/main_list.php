<?php 
/**
 *  main_list.php
 *  @Desc      : 초대장 목록 관리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */


/**
 *
 * @var parameter setting
 */
$sch_date		= $StringClass->getRequest('sch_date');
$sch_end		= $StringClass->getRequest('sch_end');
$sch_target		= $StringClass->getRequest('sch_target');
$sch_keyword 	= $StringClass->getRequest('sch_keyword');

$pageRowCnt = 15;
$nowPage = (isset($_GET['nowPage']) ? $_GET['nowPage'] : '');
$thisPage = $_SERVER['PHP_SELF'];
if (empty($nowPage)) $nowPage = 1;

$startPaging = ($nowPage - 1) * $pageRowCnt;
$endPaging = $nowPage * $pageRowCnt;

/**
 *
 * @var get board data setting
 */
$param = array();
// 등록기간별 검색옵션
if ($sch_date != "")
{
	switch ($sch_date)
	{
		case "a":	$param['st_date'] = ""; $param['ed_date'] = ""; break;	// 전체
		case "1":	$param['st_date'] = date("Y-m-d", strtotime(date("Y-m-d").' - 1month')); $param['ed_date'] = date("Y-m-d"); break;		// 최근 1개월
		case "6":	$param['st_date'] = date("Y-m-d", strtotime(date("Y-m-d").' - 6month')); $param['ed_date'] = date("Y-m-d"); break;	// 최근 6개월
	}
}
// 행사 종료여부
if ($sch_end != "")
{
	switch ($sch_end)
	{
		case "a":	$param['show_end'] = ""; break;		// 전체
		case "0":	$param['show_end'] = "0"; break;	// 행사종료전
		case "1":	$param['show_end'] = "1"; break;	// 행사종료
	}
	
}
// 검색어 검색
if (!empty($sch_target) && !empty($sch_keyword))
{
    switch($sch_target)
    {
    	case "reg_date":		$param['reg_date']  	= $sch_keyword; break;
    	case "email":     		$param['email']   		= $sch_keyword; break;
        case "father_name":		$param['father_name'] 	= $sch_keyword; break;
        case "mother_name":		$param['mother_name']  	= $sch_keyword; break;
        case "baby_name":    	$param['baby_name']  	= $sch_keyword; break;
        case "shop_name":    	$param['shop_name']  	= $sch_keyword; break;
    }
}
$param['shop_id']  = "56";

$cnt = $MainCon->getFphCnt($param);
$arrList = $MainCon->getFphList($param, $startPaging, $pageRowCnt);

/**
 * ******************************************************************************************
 * @Desc 페이지 번호 목록 출력
 * ******************************************************************************************/
$getParam = "&m=main";
$getParam .= "&sch_date={$sch_date}";
$getParam .= "&sch_end={$sch_end}";
$getParam .= "&sch_target={$sch_target}";
$getParam .= "&sch_keyword={$sch_keyword}";

$page = new Paging('BOARD');
$page->initPaging($cnt, $pageBlockSize, $pageRowCnt, $nowPage, $thisPage."?", $getParam);
$page_list = $page->getPaging();

$listNum = $cnt - $startPaging;	// List numbering


/**
 * ******************************************************************************************
 * @Desc 전체 등록 수량 체크
 * ******************************************************************************************/
$cntParam = array();
$cntParam['shop_id']  = "56";
$cntParam['show_end'] = "0";
$stayCnt = $MainCon->getFphCnt($cntParam);	// 행사종료전
$cntParam['show_end'] = "1";
$endCnt = $MainCon->getFphCnt($cntParam);	// 행사종료후
$cntParam['show_end'] = "";
$totalCnt = $MainCon->getFphCnt($cntParam);	// 전체
?>
<!--*****메인*****-->
<style>
    #num ul { list-style: none; }
    #num ul li { display: inline; padding-right: 10px; }
    #num ul li b { color: #f00; }
</style>
<script language="Javascript">
<!--
var is_proc_ing = false;

function goSearch()
{
	var sch_date	= $("input:radio[name=sch_date]:checked").val();
	var sch_end		= $("#sch_end").val();
    var sch_target	= $("#sch_target").val();
    var sch_keyword	= $("#sch_keyword").val();

	var strUrl = "<?=$thisPage;?>?m=main&sch_date="+ sch_date +"&sch_end="+ sch_end +"&sch_target="+ sch_target +"&sch_keyword="+ sch_keyword;

	location.href = strUrl;
}

function goReset()
{
	var strUrl = "<?=$thisPage;?>?m=main";
	location.href = strUrl;
}

function postManager()
{
	document.boardFrm.submit();
}

function gotoEdit(did)
{
	var url = "goto_maker.php?did="+did;
	window.open(url);	
}

function gotoDel(did)
{
    if (is_proc_ing) {
        alert("진행중 입니다.");
        return;
    }
    
    var goUrl = "./main_proc.php";
    var param = "&a=delete&main_id="+ did;
    //location.href = goUrl + "?" + param;
	//return false;
	
	if (did == "")
	{
		alert("선택된 초대장이 없습니다.");
		return false;
	}
	
    is_proc_ing = true;

    $.ajax({
    	type: 'post'
        , async: true
        , url: goUrl
        , data: param
        , beforeSend: function () { }
        , success: function (data) {

        	is_proc_ing = false;

            var result = data.trim();

            if (result == "100")
            {
            	alert('처리되었습니다');
				location.reload();
            }
            else
            	alert('처리중 오류가 발생하였습니다.');
		}
		, error: function (data, status, err) { }
        , complete: function () { }
	});
}
//-->
</script>
<div class="body">
    <div class="content" id="content" tabindex="0">
        <h1 class="h1">초대장등록 목록</h1>
        <form action="" method="post">
        <div id="search_box" class="table">
	    	<table class="list01">
				<colgroup>
	            	<col width="10%">
					<col width="20%">
	                <col width="10%">
	                <col width="10%">
	                <col width="10%">
	                <col width="20%">
	                <col width="20%">
	            </colgroup>
	            <tbody>
					<tr>
						<th style="vertical-align:middle;">등록기간</th>
						<td style="text-align: left; vertical-align:middle; padding-left: 15px;">
						<input type="radio" id="sch_date0" name="sch_date" value="a" <?php if($sch_date == "a" || $sch_date == "") echo" checked";?> />전체
						<input type="radio" id="sch_date1" name="sch_date" value="1" <?php if($sch_date == "1") echo" checked";?> />최근1개월
						<input type="radio" id="sch_date6" name="sch_date" value="6" <?php if($sch_date == "6") echo" checked";?> />최근6개월
						</td>
						<th style="vertical-align:middle;">행사종료</th>
						<td style="text-align: left; vertical-align:middle; padding-left: 15px;">
						<select id="sch_end" name="sch_end">
							<option value="a" <?php if($sch_end == "a" || $sch_end == "") echo" selected";?>>전체</option>
							<option value="0" <?php if($sch_end == "0") echo" selected";?>>종료전</option>
							<option value="1" <?php if($sch_end == "1") echo" selected";?>>종료후</option>
						</select>
						</td>
						<th style="vertical-align:middle;">검색어</th>
						<td style="text-align: left; vertical-align:middle; padding-left: 15px;">
			            <select name="sch_target" id="sch_target">
			                <option value="baby_name" <?php if($sch_target == "baby_name") echo" selected";?>>아기이름</option>
			                <option value="email" <?php if($sch_target == "email") echo" selected";?>>이메일</option>
			                <option value="father_name" <?php if($sch_target == "father_name") echo" selected";?>>아빠이름</option>
			                <option value="mother_name" <?php if($sch_target == "mother_name") echo" selected";?>>엄마이름</option>
			                <option value="reg_date" <?php if($sch_target == "reg_date") echo" selected";?>>등록일</option>
						</select>
			            <input type="text" name="sch_keyword" id="sch_keyword" style="width:150px;" value="<?=$sch_keyword;?>">
						</td>
						<td style="text-align: center; vertical-align:middle; padding-left: 15px;">
						<input type="button" onclick="goSearch()" value="검색">
						<input type="button" onclick="goReset()" value="검색초기화">
						</td>
					</tr>
				</tbody>
			</table>
        </div>
        </form>
        <div id="search_box" class="table">
	    	<table class="list01">
				<colgroup>
	            	<col width="13%">
					<col width="20%">
	                <col width="13%">
	                <col width="20%">
	                <col width="13%">
	                <col width="20%">
	            </colgroup>
	            <tbody>
					<tr>
						<th style="vertical-align:middle;">전체 등록수량</th>
						<td style="text-align: left; vertical-align:middle; padding-left: 15px;"><?=number_format($totalCnt);?> 건</td>
						<th style="vertical-align:middle;">행사대기 등록수량</th>
						<td style="text-align: left; vertical-align:middle; padding-left: 15px;"><?=number_format($stayCnt);?> 건</td>
						<th style="vertical-align:middle;">행사종료 등록수량</th>
						<td style="text-align: left; vertical-align:middle; padding-left: 15px;"><?=number_format($endCnt);?> 건</td>
					</tr>
        		</tbody>
        	</table>
        </div>
        <form name='boardFrm' method="post" target="_actionfrm" action="main_proc.php" class="form">
        <div class="table even">
            <table width="100%" border="1" cellspacing="0" class="_memberList">
                <caption>
                    모든 초대장(<?=$cnt;?>)
                    <span class="side">
                    </span>
                </caption>
                <thead>
                    <tr>
                        <th scope="col" class="nowr">No</th>
                        <th scope="col" class="nowr">업체명</th>
                        <th scope="col" class="nowr">샘플명</th>
                        <th scope="col" class="nowr">이메일</th>
                        <th scope="col" class="nowr">아빠이름</th>
                        <th scope="col" class="nowr">엄마이름</th>
                        <th scope="col" class="nowr">아기이름</th>
                        <th scope="col" class="nowr">행사일시</th>
                        <th scope="col" class="nowr">D-Day</th>
                        <th scope="col" class="nowr">조회수</th>
                        <!--th scope="col" class="nowr">작성완료</th-->
                        <th scope="col" class="nowr">등록일</th>
                        <th scope="col" class="nowr">관리</th>
					</tr>
                </thead>
                <tfoot>
                    <tr>
                        <th scope="col" class="nowr">No</th>
                        <th scope="col" class="nowr">업체명</th>
                        <th scope="col" class="nowr">샘플명</th>
                        <th scope="col" class="nowr">이메일</th>
                        <th scope="col" class="nowr">아빠이름</th>
                        <th scope="col" class="nowr">엄마이름</th>
                        <th scope="col" class="nowr">아기이름</th>
                        <th scope="col" class="nowr">행사일시</th>
                        <th scope="col" class="nowr">D-Day</th>
                        <th scope="col" class="nowr">조회수</th>
                        <!--th scope="col" class="nowr">작성완료</th-->
                        <th scope="col" class="nowr">등록일</th>
                        <th scope="col" class="nowr">관리</th>
                    </tr>
                </tfoot>
                <tbody>
				    <?php
				    foreach($arrList as $item) {
				    ?>
				    <tr>
					    <td class="nowr"><?=$listNum;?></td>
						<td class="nowr"><?=$item['shop_name'];?></td>					    
						<td class="nowr"><?=$item['sample_name'];?></td>					    
						<td class="nowr"><?=$item['email'];?></td>					    
						<td class="nowr"><?=$item['father_name'];?></td>					    
						<td class="nowr"><?=$item['mother_name'];?></td>					    
						<td class="nowr"><?=$item['baby_name'];?></td>					    
						<td class="nowr"><?=$item['show_date'];?> <?=$item['show_time'];?></td>					    
						<td class="nowr"><?=$item['dday'];?>일</td>
						<!--td class="nowr"><?=$item['end_flag_desc'];?></td-->					    
						<td class="nowr"><?=$item['readcnt'];?></td>					    
						<td class="nowr"><?=$item['reg_date'];?></td>
				    	<td class="nowr"><a href="http://m.dejavu-m.com/?m=<?=$item["main_id"];?>" target="_blank">보기</a>
				    	<a href="javascript:gotoEdit('<?=$item["main_id"];?>');">수정</a>
				    	<a href="javascript:gotoDel('<?=$item["main_id"];?>');">삭제</a>
				    	</td>
				    </tr>
				    <?php
					    $listNum--;
				    }
				    ?>
                </tbody>
            </table>
        </div>
        <div class="btnArea">
            <span class="side">
            </span>
        </div>
        </form>

        <div class="search">
            <form action="" class="pagination xe-pagination" style="float: none;text-align:center;" method="post">
            <div id="num">
			<?=$page_list;?>
			</div>
            </form>
        </div>
    </div>
</div>
<!--*****메인 끝*****-->