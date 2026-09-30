<?php 
import("class.controller.MainCon");
$MainCon        	= new MainCon();
if (!empty($_SESSION['dejavu_id']))
{
	// get main info
	$param = array();
	$param['main_id'] = $_SESSION['dejavu_id'];
	$result = $MainCon->getMainList($param);
	if ($result)
	{
		$main_info = $result[0];
		$sms_hp_f = $main_info['father_hp'];
		$sms_hp_m = $main_info['mother_hp'];
//		$sms_url = str_replace("&","@@",$main_info['baby_name'])."의 초대장이 완성되었습니다.\nhttp://m.dejavu-m.com/?m=".$_SESSION["dejavu_id"];
		$sms_url = str_replace("&","@@",$main_info['baby_name'])."의 초대장입니다.\nhttp://m.dejavu-m.com/?m=".$_SESSION["dejavu_id"];



	}
}
?>
<script src="/js/scroll-startstop.events.jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/modal.js"></script>
	<!-- Modal Pop1 -->
	<div id="modalSearchPw" class="mw_pop"><!-- 활성화 class = open -->
		<div class="bg"></div>
		<div id="pop_style">
			<h4>비밀번호 찾기</h4>
			<span class="txt">등록된 E-mail 주소로<br />로그인 정보를 보내드립니다</span>
			<fieldset>
				<legend>비밀번호 찾기</legend>
				<input type="text"><span class="button style3"><button type="button">보내기</button></span>
				<div class="guide">이메일 주소를 입력하세요</div>
			</fieldset>
			<button type="button" class="btn_close" onclick="closeModal('modalSearchPw')"><span class="blind">닫기</span></button>
		</div>
	</div>
	<!-- //Modal Pop1 -->
	<!-- Modal Pop2 -->
	<div id="modalSend" class="mw_pop">
		<input type="hidden" id="sms_hp_f" value="<?=$sms_hp_f;?>" />
		<input type="hidden" id="sms_hp_m" value="<?=$sms_hp_m;?>" />
		<input type="hidden" id="sms_url" value="<?=$sms_url;?>" />
		<div class="bg"></div>
		<div id="pop_style">
			<h4>폰으로 보내기</h4>
			<span class="txt">등록된 아빠와 엄마의 휴대폰으로<br />초대장 주소를 전송합니다.</span>
			<fieldset>
				<legend>폰으로 보내기</legend>
				<span class="button style3 blue" style="margin-right:5px"><button type="button" onclick="gotoSms('f')">아빠에게 보내기</button></span>
				<span class="button style3"><button type="button" onclick="gotoSms('m')">엄마에게 보내기</button></span>
			</fieldset>
			<button type="button" class="btn_close" onclick="closeModal('modalSend')"><span class="blind">닫기</span></button>
		</div>
	</div>
	<!-- //Modal Pop2 -->
	<!-- Modal Pop / 메인 하단 샘플 미리보기 / 131106 추가 -->
	<!--
	<div class="mw_pop" id="sample_review" style="display:none">
		<div class="bg"></div>
		<div id="pop_style4">
			<div class="preview">
				<span class="con"><img src="/img/sp1.jpg" width="320" alt="샘플1"/></span>
				<button type="button" class="btn_close" onclick="javascript:showhidden('sample_review')"><span class="blind">닫기</span></button>
			</div>
		</div>
	</div>
	<div class="mw_pop" id="sample_review2" style="display:none">
		<div class="bg"></div>
		<div id="pop_style4">
			<div class="preview">
				<span class="con"><img src="/img/sp2.jpg" width="320" alt="샘플2"/></span>
				<button type="button" class="btn_close" onclick="javascript:showhidden('sample_review2')"><span class="blind">닫기</span></button>
			</div>
		</div>
	</div>
	<div class="mw_pop" id="sample_review3" style="display:none">
		<div class="bg"></div>
		<div id="pop_style4">
			<div class="preview">
				<span class="con"><img src="/img/sp3.jpg" width="320" alt="샘플3"/></span>
				<button type="button" class="btn_close" onclick="javascript:showhidden('sample_review3')"><span class="blind">닫기</span></button>
			</div>
		</div>
	</div>
	<div class="mw_pop" id="sample_review4" style="display:none">
		<div class="bg"></div>
		<div id="pop_style4">
			<div class="preview">
				<span class="con"><img src="/img/sp4.jpg" width="320" alt="샘플4"/></span>
				<button type="button" class="btn_close" onclick="javascript:showhidden('sample_review4')"><span class="blind">닫기</span></button>
			</div>
		</div>
	</div>
	<div class="mw_pop" id="sample_review5" style="display:none">
		<div class="bg"></div>
		<div id="pop_style4">
			<div class="preview">
				<span class="con"><img src="/img/sp5.jpg" width="320" alt="샘플5"/></span>
				<button type="button" class="btn_close" onclick="javascript:showhidden('sample_review5')"><span class="blind">닫기</span></button>
			</div>
		</div>
	</div>
	<div class="mw_pop" id="sample_review6" style="display:none">
		<div class="bg"></div>
		<div id="pop_style4">
			<div class="preview">
				<span class="con"><img src="/img/sp6.jpg" width="320" alt="샘플6"/></span>
				<button type="button" class="btn_close" onclick="javascript:showhidden('sample_review6')"><span class="blind">닫기</span></button>
			</div>
		</div>
	</div>

	<div class="mw_pop" id="sample_review7" style="display:none">
		<div class="bg"></div>
		<div id="pop_style4">
			<div class="preview">
				<span class="con"><img src="/img/sp8.jpg" width="320" alt="샘플7"/></span>
				<button type="button" class="btn_close" onclick="javascript:showhidden('sample_review7')"><span class="blind">닫기</span></button>
			</div>
		</div>
	</div>
	<div class="mw_pop" id="sample_review8" style="display:none">
		<div class="bg"></div>
		<div id="pop_style4">
			<div class="preview">
				<span class="con"><img src="/img/sp9.jpg" width="320" alt="샘플8"/></span>
				<button type="button" class="btn_close" onclick="javascript:showhidden('sample_review8')"><span class="blind">닫기</span></button>
			</div>
		</div>
	</div>
	<div class="mw_pop" id="sample_review9" style="display:none">
		<div class="bg"></div>
		<div id="pop_style4">
			<div class="preview">
				<span class="con"><img src="/img/sp10.jpg" width="320" alt="샘플9"/></span>
				<button type="button" class="btn_close" onclick="javascript:showhidden('sample_review9')"><span class="blind">닫기</span></button>
			</div>
		</div>
	</div>
	<div class="mw_pop" id="sample_review10" style="display:none">
		<div class="bg"></div>
		<div id="pop_style4">
			<div class="preview">
				<span class="con"><img src="/img/sp11.jpg" width="320" alt="샘플10"/></span>
				<button type="button" class="btn_close" onclick="javascript:showhidden('sample_review10')"><span class="blind">닫기</span></button>
			</div>
		</div>
	</div>-->
	<!-- //Modal Pop/메인 하단 샘플 미리보기 -->