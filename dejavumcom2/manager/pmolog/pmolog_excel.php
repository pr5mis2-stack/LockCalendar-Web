<?php
/**
 *  pmolog_excel.php
 *  @Desc      : 프로모션 참여 엑셀
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
require_once ($_SERVER["DOCUMENT_ROOT"]."/include/common_header.php");

import("php.util.StringClass");
import("class.controller.ServiceLogCon");    // 서비스 로그 저장
import("class.controller.MainCon");
import("class.controller.PromotionCon");

$StringClass        = new StringClass();
$ServiceLogCon 		= new ServiceLogCon();
$MainCon = new MainCon();
$PromotionCon = new PromotionCon();
/**
 *
 * @var parameter setting
 */
$sch_date = $StringClass->getRequest('sch_date');
$sch_end = $StringClass->getRequest('sch_end');
$sch_target = $StringClass->getRequest('sch_target');
$sch_keyword = $StringClass->getRequest('sch_keyword');

/**
 *
 * @var get board data setting
 */
$param = array();
                             
// 등록기간별 검색옵션
if ($sch_date != "") {
	switch ($sch_date) {
		case "a" :
			$param['st_date'] = "";
			$param['ed_date'] = "";
			break; // 전체
		case "1" :
			$param['st_date'] = date("Y-m-d", strtotime(date("Y-m-d") . ' - 1month'));
			$param['ed_date'] = date("Y-m-d");
			break; // 최근 1개월
		case "6" :
			$param['st_date'] = date("Y-m-d", strtotime(date("Y-m-d") . ' - 6month'));
			$param['ed_date'] = date("Y-m-d");
			break; // 최근 6개월
	}
}

// 검색어 검색
if (!empty($sch_target) && !empty($sch_keyword)) {
	switch ($sch_target) {
		case "shop_id" :
			$param['shop_id'] = $sch_keyword;
			break;
		case "shop_name" :
			$param['shop_name'] = $sch_keyword;
			break;
		case "email" :
			$param['email'] = $sch_keyword;
			break;
		case "father_name" :
			$param['father_name'] = $sch_keyword;
			break;
		case "mother_name" :
			$param['mother_name'] = $sch_keyword;
			break;
		case "baby_name" :
			$param['baby_name'] = $sch_keyword;
			break;
		case "reg_date" :
			$param['reg_date'] = $sch_keyword;
			break;
	}
}

$arrList = $PromotionCon->getPromotionLogExcel($param);

header("Content-type: application/vnd.ms-excel");
header("Content-type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename = pmolog.xls");
header("Content-Description: PHP Generated Data");
?>
<meta http-equiv="Content-Type" content="application/vnd.ms-excel; charset=utf-8">
<table border="1">
	<thead>
		<tr>
			<th>No</th>
			<th>업체명</th>
			<th>이메일</th>
			<th>아버지 이름</th>
			<th>아버지 연락처</th>
			<th>어머니 이름</th>
			<th>어머니 연락처</th>
			<th>아기 이름</th>
			<th>행사일시</th>
			<th>등록일</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$listNum = 1;
	foreach ( $arrList as $item ) {
	?>
		<tr>
			<td><?=$listNum;?></td>
			<td style="mso-number-format:'\@'"><?=$item['shop_name'];?></td>
			<td style="mso-number-format:'\@'"><?=$item['email'];?></td>
			<td style="mso-number-format:'\@'"><?=$item['father_name'];?></td>
			<td style="mso-number-format:'\@'"><?=$item['father_hp'];?></td>
			<td style="mso-number-format:'\@'"><?=$item['mother_name'];?></td>
			<td style="mso-number-format:'\@'"><?=$item['mother_hp'];?></td>
			<td style="mso-number-format:'\@'"><?=$item['baby_name'];?></td>	
			<td style="mso-number-format:'\@'"><?=$item['show_date'];?> <?=$item['show_time'];?></td>																																		
			<td style="mso-number-format:'\@'"><?=$item['reg_date'];?></td>
		</tr>
	<?php
		$listNum++;
	}
	?>
	</tbody>
</table>