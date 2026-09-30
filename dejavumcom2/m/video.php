<?php 
if (!empty($shop_video))
{
?>
	<div id="layerWrap">
		<div id="dimmed"></div>
    	<div id="layerPopCnt" >
    	<iframe id="videoFrm" src="<?=$shop_video['file_url'];?>?rel=0&ps=blogger" frameborder="0" width="100%" height="300" scrolling="no" allowfullscreen></iframe>
		<button type="button" class="btn_close" onclick="hideVideo();"><span class="blind">닫기</span></button>
    	</div>
		</div>
	</div>
<script>
var vdoFlag = getCookie('dejavu_video');

if (vdoFlag == "Y")
	$("#layerWrap").hide();
else
	$("#layerWrap").show();

function hideVideo()
{
	//setCookie('dejavu_video', 'Y', 1);
	$('#videoFrm').attr('src', '');
	$('#layerWrap').hide();
}
setCookie('dejavu_video', 'N', 1);
</script>
<?php
}
?>