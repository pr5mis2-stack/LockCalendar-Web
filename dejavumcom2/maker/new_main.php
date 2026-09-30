<?php
    /**
 *  main.php
 *  @Desc      : 메인
 *  @Author    : SUYA
 *  @Date      : 2012. 03. 07. 오전 11:03:57
 *  @param 	 
 *  @Return
 */
require_once($_SERVER["DOCUMENT_ROOT"]."/include/common_top.php");

import("class.controller.MainCon");
import("class.controller.SampleCon");
import("class.controller.ShopCon");
import("class.controller.ShopSampleCon");
import("class.controller.GalleryCon");
import("class.controller.GalleryPhotoCon");
import("class.controller.InvitationCon");
import("class.controller.AppreciationCon");
import("class.controller.CommonCodeCon");

$MainCon        	= new MainCon();
$SampleCon			= new SampleCon();
$ShopCon			= new ShopCon();
$ShopSampleCon		= new ShopSampleCon();
$GalleryCon			= new GalleryCon();
$GalleryPhotoCon 	= new GalleryPhotoCon();
$InvitationCon		= new InvitationCon();
$AppreciationCon	= new AppreciationCon();
$CommonCodeCon		= new CommonCodeCon();
//new dBug($_SESSION);
/**
 *
 * @var pageing setting
 */
$thisPage = "/maker/main.php";

/**
 *
 * @var parameter setting
 */
$_step = $StringClass->getRequest('step');

if (empty($_step))
	$_step = "1";
if (!file_exists("maker_step{$_step}.php"))
	$_step = "1";
$_js = "new_maker_step{$_step}.js?t=".time();

if ($_step == "3")
	$_m = "g";
else 
	$_m = "m";
?>

	<div id="container">
		<div class="section1">
			<!-- Modal Pop2 -->
			<div id="modalPreViewer" class="mw_pop2">
				<div id="pop_style2">
					<div class="preview">
						<div class="con">
							<iframe id="preViewer" name="preViewer" src="<?php if ($_SESSION['dejavu_id'] != "") { echo"http://m.dejavu-m.com/?m={$_SESSION['dejavu_id']}&p=M"; }?>" width="325" height="569" frameborder="0" marginheight="0" marginwidth="0" scrolling="yes"></iframe>
							<iframe id="preScrollViewer" name="preScrollViewer" src="" width="325" height="569" frameborder="0" marginheight="0" marginwidth="0" scrolling="yes" style="display:none;"></iframe>
						</div>
					</div>
					<button type="button" class="btn_close" onclick="closeModal('modalPreViewer')"><span class="blind">닫기</span></button>
				</div>
			</div>
			<!-- //Modal Pop2 -->
			<iframe id="sampleViewer" name="sampleViewer" src="" width="320" height="569" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" style="margin-top:69px"></iframe>
		</div>

		<div class="section2">
			<script type="text/javascript" src="/js/<?=$_js;?>"></script>
			<?php require_once("new_maker_step{$_step}.php"); ?>
			<div class="btn_box2">
				<?php if (in_array($_step, array("4"))) { ?>
				<span class="button style3"><button type="button" id="btnPass" onclick="gotoPass()">건너뛰기</button></span>
				<?php } ?>
				<span class="button style3"><button type="button" id="btnSave" onclick="gotoSave()">저장하기</button></span>
				<span class="button style3" style="margin-right:10px"><button type="button" id="btnPreview2" onclick="modalPreViewer2()">미리보기</button></span>
				<?php if (!in_array($_step, array("1"))) { ?>
				<span class="button style3 blue"><button type="button" id="btnPrev" onclick="gotoPrev()">이&nbsp;전</button></span>
				<?php } ?>
				<?php if (in_array($_step, array("5"))) { ?>
				<span class="button style3 blue"><button type="button" id="btnEnd" onclick="gotoEnd()">완&nbsp;료</button></span>
				<?php } else { ?>
				<span class="button style3 blue"><button type="button" id="btnNext" onclick="gotoNext()">다&nbsp;음</button></span>
				<?php } ?>
			</div>
		</div>
	</div>

<?php require_once($_SERVER["DOCUMENT_ROOT"]."/include/common_footer.php"); ?>
