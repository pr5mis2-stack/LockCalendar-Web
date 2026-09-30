<?php 
// 계좌정보
// 특별 케이스 css
$base_css = "margin:1em 1.6em 1em 1.6em; border:2px solid #000000;";
if ($main_info['type_value'] == "B") {	// 돌잔치
	switch ($main_info['sample_id'])
	{
		case "1": $base_css = "margin:0.6em 0.6em 0.6em 0.6em; border:1px solid #000000;"; break;
		case "2": case "3": case "4": case "5": case "6": case "7": case "8": case "9": case "10": case "27": $base_css = "margin:0.6em 0.6em 0.6em 0.6em; border:2px solid #000000;"; break;
		case "12": $base_css = "margin:0.2em 0.8em 0.6em 0.8em; border:2px solid #000000;"; break;
		case "41": case "42": $base_css = "margin:5em 0.8em 1em 0.8em; border:2px solid #000000;"; break;
		case "43": case "53": $base_css = "margin:67em 1.6em 1em 1.6em; border:2px solid #000000; width: 90%;"; break; 
		case "44": $base_css = "margin:16.5em 0.8em 0.6em 0.8em; border:2px solid #000000;"; break;		
	}
} else if ($main_info['type_value'] == "W") {	// 웨딩
	switch ($main_info['sample_id'])
	{
		case "13": case "14": $base_css = "margin:0.6em 0.6em 0.6em 0.6em; border:2px solid #000000;"; break;
		case "15": $base_css = "margin:0em 1.6em 1em 1.6em; border:2px solid #000000;"; break;
  }
} else if ($main_info['type_value'] == "S") {	// 고희연
  $base_css = "margin:0.6em 0.6em 0.6em 0.6em; border:2px solid #000000;";
}
?>
<style>
/* BANK MEMO */

.bank{position:relative; background-color:#ffffff; border-radius:5px;<?=$base_css;?>}
.bank .bankbox{margin:1em;display:block;overflow:hidden;left:0;z-index:2}/* 202301005 이미선 삭제 : width:100%; */
.bank .bankbox table{}/* 202301005 이미선 삭제 : width:100%;margin:0 auto; */
.bank .bankbox table td{width:100%;min-height:6.65em;font-size:1.05em;line-height:1.438em;color:#000;padding:0;margin:0;letter-spacing:-0.063em}


</style>
	<div class="bank">
		<span class="bankbox <?=$main_info['sample_id'];?>">
		<table class="<?=$main_info['type_value'];?><?=$main_info['sample_id'];?>"><tr><td><?=nl2br($main_info['bank_memo']);?></td></tr></table>
		</span>
	</div>	
