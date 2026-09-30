<!--iframe src="data/silence.mp3" allow="autoplay" id="audio" style="display:none"></iframe-->
<script src="js/sound.js"></script>
<script>
<?php
/**
 * Map URL
 */
if ($shop_info['map_url'] != "") {
  echo("$('.map_link2').attr('href', '{$shop_info['map_url']}');\n");
  echo("$('.map_link_new').attr('href', '{$shop_info['map_url']}');\n");
}

/**
* BGM 파일
*/
$shopBgm = "";
$bgmParam = array();
$bgmParam['shop_id'] = $main_info['shop_id'];
$bgmParam['media_type'] = "";

if ($main_info['type_value'] == "B") 	// 돌잔치
  $bgmParam['media_type'] = 4;
else if ($main_info['type_value'] == "W") 	// 웨딩
  $bgmParam['media_type'] = 5;
else if ($main_info['type_value'] == "S") 	// 고희연
  $bgmParam['media_type'] = 6;

if ($bgmParam['media_type'] != "")
{
  $shopBgmFile = $ShopMultimediaCon->getShopMultimediaList($bgmParam);
  if ($shopBgmFile) {
    $shopBgm = $conf_bgm_shop_url.$shopBgmFile[0]['file_url'];
  }
}

if ($shopBgm != "")
{
?>
  var bgmDiv = "<div id='bgmDiv' style='display:none; position: relative;width:120px;'>  <img id='bgmPlay' src='img/bgm_on.png' onClick='stopBgm()' style='cursor: pointer;width:100%;'/><img id='bgmStop' src='img/bgm_off.png' onClick='playBgm()' style='cursor: pointer;width:100%;'/></div>";
  var bgmPath = "<?=$shopBgm;?>";
  var bgmNowPlaying = false;
  var bgm = new Sound('myAudio', bgmPath, 100, true);

  window.onload = function() {
      bgm.init();
      $("#wrapper").before(bgmDiv);
      $("#bgmDiv").show();
      playBgm();
  };

  function stopBgm() {
      if (bgmNowPlaying) {
          bgmNowPlaying = !bgmNowPlaying;
          bgm.pauseMusic();

          $("#bgmPlay").hide();
          $("#bgmStop").show();
      }
  }
  function playBgm() {
      if (!bgmNowPlaying) {
          bgmNowPlaying = !bgmNowPlaying;
          bgm.startMusic();

          $("#bgmStop").hide();
          $("#bgmPlay").show();
      }
  }
<?php
}
?>
</script>