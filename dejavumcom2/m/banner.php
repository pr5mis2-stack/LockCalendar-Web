<?php
// 광고목록
$adv_result = $AdvertisementCon->getRandBanner($main_info['shop_id']);
if ($adv_result)
{
	$adv_info = $adv_result[0];
	$adv_css = $adv_info['view_flag'] == "Y"? "cot_tl_fixed":"cot_tl_unfixed ";	// Y:유동형 , N:고정형
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
	  $banner_html = "<div id='cot_tl_resize'></div><div id='". $adv_css ."' class='". $adv_css ."' style='position:absolute; width:100%;'><a href='". $adv_url ."' target='_blank'><img id='addImg' src='". $conf_img_banner_url.$adv_info['file_url']."' style='width:100%;'/></a></div>";
	  echo"<script>$(window).load(function() { $('.last-img').append(\"". $banner_html ."\"); });</script>";
	} else if ($main_info['sample_id'] == "44") {
#	  if ($main_info['is_bank'] == "1")
#	    $banner_html = "<div id='cot_tl_resize'></div><div id='". $adv_css ."' class='". $adv_css ."' ><a href='". $adv_url ."' target='_blank'><img id='addImg' src='". $conf_img_banner_url.$adv_info['file_url']."' style='width:100%;'/></a></div>";
#    else
      $banner_html = "<div id='cot_tl_resize'></div><div id='". $adv_css ."' class='". $adv_css ."' ><a href='". $adv_url ."' target='_blank'><img id='addImg' src='". $conf_img_banner_url.$adv_info['file_url']."' style='width:100%;'/></a></div>";
	  echo"<script>$(window).load(function() { $('#footer').append(\"". $banner_html ."\"); });</script>";
	} else {
	  $banner_html = "<div id='cot_tl_resize'></div><div id='". $adv_css ."' class='". $adv_css ."'><a href='". $adv_url ."' target='_blank'><img id='addImg' src='". $conf_img_banner_url.$adv_info['file_url']."' style='width:100%;'/></a></div>";
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
	var sid = "<?=$main_info['sample_id'];?>";
	var banner_top;
    $(function(){
        //var banner_top;
        $(window).resize(function(){
          resizeBanner();
        });

        $(window).load(function(){
          resizeBanner();
        });
    });

resizeBanner = function() {
 // console.log($(".bank").height());
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

    switch (true) {
      //case (sid == "6") : banner_top = banner_top + 171; break;
      case (sid <= 12): banner_top = banner_top + 50; break;
      case (sid <= 14): banner_top = banner_top - 50; break;
	  //case (sid <= 56): banner_top = banner_top + 273; break;
      case (sid <= 15): banner_top = banner_top - 75; break;
	    case (sid <= 18): banner_top = banner_top - 50; break;
      case (sid >= 41 && sid < 42): banner_top = banner_top + 50; break;
      case (sid == 43): banner_top = banner_top  +50; break;
    }
  }
  else
    banner_top = 135;

  switch (true) {
    case (sid >= 1 && sid < 7) :
      $(".<?=$adv_css;?>").attr("style", "position:relative; width:100%;top:"+ banner_top +"%;");
      break;
    case (sid >= 7 && sid <= 12) :
      $(".<?=$adv_css;?>").attr("style", "position:relative; width:100%;top:"+ banner_top +"%;");
      break;
    case (sid >= 41 && sid <= 42) :
      $(".<?=$adv_css;?>").attr("style", "position:relative; width:100%;top:"+ banner_top +"%;");
      break;
   	// 202308022 수정 - 최은규 : 44 스타일 변경
	case(sid == 43) :
      $(".<?=$adv_css;?>").attr("style", "position:absolute; width:100%;top:"+ banner_top +"%;");
	    break;
  	case(sid == 44) :
      $(".<?=$adv_css;?>").attr("style", "position:absolute; width:100%;top:"+ banner_top +"%;");
	    break;
	  // 20230807 수정 - 이미선 : 56 스타일 변경
	  case(sid <= 56) :
	    $(".<?=$adv_css;?>").attr("style", "position:static; width:auto;top:auto");
	    break;
  	// 202308017 수정 - 최은규 : 57 스타일 변경
	  case(sid <= 57) :
	    $(".<?=$adv_css;?>").attr("style", "position:static; width:auto;top:auto");
	    break;
	  case(sid <= 60) :
	    $(".<?=$adv_css;?>").attr("style", "position:static; width:auto;top:auto");
	    break;
	  case(sid <= 61) :
	    $(".<?=$adv_css;?>").attr("style", "position:static; width:auto;top:auto");
	    break;
	  case(sid <= 63) :
	    $(".<?=$adv_css;?>").attr("style", "position:static; width:auto;top:auto");
	    break;
	  case(sid <= 65) :
	    $(".<?=$adv_css;?>").attr("style", "position:static; width:auto;top:auto");
	    break;
    case(sid <= 66) :
	    $(".<?=$adv_css;?>").attr("style", "position:static; width:auto;top:auto");
	    break;
    default:
      $(".<?=$adv_css;?>").attr("style", "position:absolute; width:100%;top:"+ banner_top +"%;");
      break;
  }
}
	</script>