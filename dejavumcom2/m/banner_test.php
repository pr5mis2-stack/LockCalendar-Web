<?php 
// 
$adv_result = $AdvertisementCon->getRandBanner($main_info['shop_id']);
if ($adv_result)
{
	$adv_info = $adv_result[0];
	$adv_css = $adv_info['view_flag'] == "Y"? "cot_tl_fixed":"cot_tl_unfixed ";	// Y: , N:
	$adv_url = $adv_info['site_url'];
	if (!empty($adv_url) && !strstr($adv_url, "http://"))
		$adv_url = "http://".$adv_url;
		
	if ($adv_info['view_flag'] == "Y")
	{
?>
<script>
    $(function(){        
        $(window).resize(function(){
        	$("#cot_tl_resize").attr("style", "margin-bottom:"+ $("#addImg").height()+"px;");
        });                    

        $(window).load(function(){
        	$("#cot_tl_resize").attr("style", "margin-bottom:"+ $("#addImg").height()+"px;");
        });                    
    });
	</script>
<?php
	}

	if ($main_info['sample_id'] == "43") {
	  $banner_html = "<div id='cot_tl_resize'></div><div id='". $adv_css ."' style='position:absolute; width:100%;'><a href='". $adv_url ."' target='_blank'><img id='addImg' src='". $conf_img_banner_url.$adv_info['file_url']."' style='width:100%;'/></a></div>";
	  echo"<script>$(window).load(function() { $('.last-img').append(\"". $banner_html ."\"); });</script>";
	} else if ($main_info['sample_id'] == "44") {
#	  if ($main_info['is_bank'] == "1")
#	    $banner_html = "<div id='cot_tl_resize'></div><div id='". $adv_css ."' class='". $adv_css ."' ><a href='". $adv_url ."' target='_blank'><img id='addImg' src='". $conf_img_banner_url.$adv_info['file_url']."' style='width:100%;'/></a></div>";
#    else
      $banner_html = "<div id='cot_tl_resize'></div><div id='". $adv_css ."' class='". $adv_css ."' ><a href='". $adv_url ."' target='_blank'><img id='addImg' src='". $conf_img_banner_url.$adv_info['file_url']."' style='width:100%;'/></a></div>";
	  echo"<script>$(window).load(function() { $('#footer').append(\"". $banner_html ."\"); });</script>";	  
	} else {
	  $banner_html = "<div id='cot_tl_resize'></div><div id='". $adv_css ."'><a href='". $adv_url ."' target='_blank'><img id='addImg' src='". $conf_img_banner_url.$adv_info['file_url']."' style='width:100%;'/></a></div>";
    echo $banner_html;
	}

?>
<!--
<div id="cot_tl_resize"></div>
<div id="<?=$adv_css;?>">
<a href="<?=$adv_url;?>" target="_blank"><img id="addImg" src="<?=$conf_img_banner_url.$adv_info['file_url'];?>" style="width:100%;"/></a>
</div>
-->
<?php 
}
?>
<script>
    $(function(){        
        var banner_top;
        $(window).resize(function(){
          console.log($(".bank").height());
          if ($(".bank")) {
            switch (true) {
              case ($(".bank").height() > 190): banner_top = 175; break;
              case ($(".bank").height() > 170): banner_top = 170; break;
              case ($(".bank").height() > 150): banner_top = 166; break;
              case ($(".bank").height() > 130): banner_top = 162; break;
              case ($(".bank").height() > 100): banner_top = 158; break;
              case ($(".bank").height() > 80): banner_top = 154; break;
              default:banner_top = 150; break;
            }
          }
          else
            banner_top = 135;

          $(".<?=$adv_css;?>").attr("style", "position:absolute; width:100%;top:"+ banner_top +"%;");
        });                    

        $(window).load(function(){
          console.log($(".bank").height());
          if ($(".bank")) {
            switch (true) {
              case ($(".bank").height() > 190): banner_top = 175; break;
              case ($(".bank").height() > 170): banner_top = 170; break;
              case ($(".bank").height() > 150): banner_top = 166; break;
              case ($(".bank").height() > 130): banner_top = 162; break;
              case ($(".bank").height() > 100): banner_top = 158; break;
              case ($(".bank").height() > 80): banner_top = 154; break;
              default:banner_top = 150; break;
            }
          }
          else
            banner_top = 135;

          $(".<?=$adv_css;?>").attr("style", "position:absolute; width:100%;top:"+ banner_top +"%;");
        });                    
    });
	</script>