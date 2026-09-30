<?php
/**
 *  shop_form.php
 *  @Desc      : 회원정보 관리
 *  @Author    : suya
 *  @Date      :
 *  @param
 *  @Return
 */
/**
 *
 * @var parameter setting
 */
$_a = $StringClass->getRequest ( 'a' );
$shop_id = $StringClass->getRequest ( 'shop_id' );
$search_target = $StringClass->getRequest ( 'search_target' );
$search_keyword = $StringClass->getRequest ( 'search_keyword' );

/**
 *
 * @var get board data setting
 */
if ($_a == "view" || $_a == "update2") {
	$param = array ();
	$param ['shop_id'] = $shop_id;
	// new dBug($param);
	$arrList = $ShopCon->getShopList ( $param );
	if ($arrList)
		$userInfo = $arrList [0];
	else
		$StringClass->alertMsg ( '정보가 없습니다.', '_self', '', '' );

	/**
	 * get Video data setting
	 */
	$videoArrList = $ShopMultimediaCon->getShopVideoList ( $param );

	/**
	 * get advertisement data
	 */
	$adverArrList = $AdvertisementCon->getAdvertisementList ( $param );

	/**
	 * 멀티미디어 파일
	 */
	$imgArrList = $ShopMultimediaCon->getShopMultimediaList ( $param );

	/**
	 * 샘플자료 목록
	 */
	//$sParam = array ();
	//$sParam ['is_use'] = 1;
	//$sampleCnt = $SampleCon->getSampleCnt ( $sParam );
	//$sampleList = $SampleCon->getSampleList ( $sParam );
	//$sampleListNum = $sampleCnt - 1;
	$shopSampleList = $ShopSampleCon->getShopSampleList ( $param );
}
else {
	$userInfo['is_baby'] = "1";
	$userInfo['is_wedding'] = "1";
	$userInfo['is_silver'] = "1";
}
/**
 * ******************************************************************************************
 * @Desc 페이지 번호 목록 출력
 * *****************************************************************************************
 */
$getParam = "&m=shop&a=update&shop_id=" . $shop_id;
$getParam .= "&search_target={$search_target}";
$getParam .= "&search_keyword={$search_keyword}";

?>
<!--*****메인*****-->
<style>
#num ul {
	list-style: none;
}

#num ul li {
	display: inline;
	padding-right: 10px;
}

#num ul li b {
	color: #f00;
}
</style>
<script type="text/javascript" src="/js/map.js"></script>
<script language="Javascript">
<!--
    var is_proc_ing = false;
    var map_key = "<?=$naver_map_key;?>";

    $(document).ready(function () {

    	$("#address").change(function () {
    		changeAddressInfo($("#address").val());
    	});

		$("#btnViewMap").click(function () {
			popMap();
		});

		$("#btnSearchNMap").click(function () {
		  popSearchNMap();
		});

		$("#btnViewNMap").click(function () {
		  popNaverMap();
			//popNMap();
		});

		$("#btnSearchCompany").click(function () {
			popShopList();
		});
    });

	/**
	 *
	 */
    function postShop()
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        var shop_id			    = $("#shop_id").val();
        var parent_shop_id	= $("#parent_shop_id").val();
        var shop_name		    = $("#shop_name").val();
        var city			      = $("#city").val();
        var zone			      = $("#zone").val();
        var tel				      = $("#tel").val();
        var fax				      = $("#fax").val();
        var address			    = $("#address").val();
        var address_etc		  = $("#address_etc").val();
        var xlocation		    = $("#xlocation").val();
        var ylocation		    = $("#ylocation").val();
        var ceo_name		    = $("#ceo_name").val();
        var staff_name		  = $("#staff_name").val();
        var staff_tel		    = $("#staff_tel").val();
        var staff_hp		    = $("#staff_hp").val();
        var staff_email		  = $("#staff_email").val();
        var gallery_type	  = $("#gallery_type").val();
        var contract_end	  = $("#contract_end").val();
        var time_week		    = $("#time_week").val();
        var time_sat		    = $("#time_sat").val();
        var time_sun		    = $("#time_sun").val();
        var memo			      = $("#memo").val();
        var is_baby			    = ($("#is_baby").is(':checked')) ? "1" : "0";
        var is_wedding		  = ($("#is_wedding").is(':checked')) ? "1" : "0";
        var is_silver		    = ($("#is_silver").is(':checked')) ? "1" : "0";
        var map_url         = $("#map_url").val();

        var goUrl = "./shop/shop_proc.php";
        var param = "&a=<?=$_a;?>&shop_id="+ shop_id
    			+"&parent_shop_id="+ parent_shop_id
    			+"&shop_name="+ shop_name
    			+"&city="+ city
    			+"&zone="+ zone
    			+"&tel="+ tel
    			+"&fax="+ fax
    			+"&address="+ address
    			+"&address_etc="+ address_etc
    			+"&xlocation="+ xlocation
    			+"&ylocation="+ ylocation
    			+"&ceo_name="+ ceo_name
    			+"&staff_name="+ staff_name
    			+"&staff_tel="+ staff_tel
    			+"&staff_hp="+ staff_hp
    			+"&gallery_type="+ gallery_type
    			+"&staff_email="+ staff_email
					+"&contract_end="+ contract_end
					+"&time_week="+ time_week
					+"&time_sat="+ time_sat
					+"&time_sun="+ time_sun
					+"&memo="+ memo
					+"&is_baby="+ is_baby
					+"&is_wedding="+ is_wedding
					+"&is_silver="+ is_silver
					+"&map_url="+ map_url;

        <?php if ($_a == "view" || $_a == "update") { ?>
        if (!checkVariableField('shop_id', '아이디를 입력해 주세요.')) return false;
        <?php } ?>
        if (!checkVariableField('shop_name', '업체명을 입력해 주세요.')) return false;
        if (!checkVariableField('tel', '연락처를 입력해 주세요.')) return false;
        if (!checkVariableField('address', '주소를 입력해 주세요.')) return false;


        //location.href = goUrl + "?" + param;
		    //return false;

        $.ajax({
      	  type: 'post'
          , async: true
          , url: goUrl
          , data: param
          , beforeSend: function () {
      		  is_proc_ing = true;
          }
          , success: function (data) {

          	is_proc_ing = false;

            var result = data.trim();

            if (result == "100")
            {
            	alert('처리되었습니다');
            	<?php if ($_a == "view" || $_a == "update") { ?>
    					location.reload();
    					<?php } else { ?>
    					location.href="/manager/?m=shop";
    					<?php } ?>
            }
            else
            	alert('처리중 오류가 발생하였습니다.');
		      }
    			, error: function (data, status, err) { }
          , complete: function () { }
    		});
    }

	/**
	 *
	 */
    function postDelete()
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        var shop_id		= $("#shop_id").val();

        var goUrl = "./shop/shop_proc.php";
        var param = "&a=delete&shop_id="+ shop_id;
        //location.href = goUrl + "?" + param;
    		//return false;
    		is_proc_ing = true;

        $.ajax({
        	type: 'post'
          , async: true
          , url: goUrl
          , data: param
          , beforeSend: function () {
      		  is_proc_ing = true;
          }
          , success: function (data) {

          	is_proc_ing = false;

            var result = data.trim();

            if (result == "100")
            {
            	alert('처리되었습니다');
			        location.href="/manager/?m=shop";
            }
            else
            	alert('처리중 오류가 발생하였습니다.');
    			}
    			, error: function (data, status, err) { }
          , complete: function () { }
    		});
    }

	/**
	 *
	 */
    function changeAddressInfo(address)
    {
        var goUrl = "/common/map_proc.php";
        var param = "&a=a2c&address="+ address;

        checkVariableField('address', '주소를 입력해 주세요.');

        //location.href = goUrl + "?" + param;
		    //return false;

        $.ajax({
        	type: 'post'
            , async: true
            , url: goUrl
            , data: param
            , beforeSend: function () {
        		is_proc_ing = true;
            }
            , success: function (data) {
            	is_proc_ing = false;

                var result = data.trim().split(";");

                if (result[0] == "100")
                {
                	$("#address").val(result[3]);
                	$("#xlocation").val(result[1]);
                	$("#ylocation").val(result[2]);
                }
                else
                	alert('주소 변환 처리중 오류가 발생하였습니다.');
			}
			, error: function (data, status, err) { }
            , complete: function () { }
		});
    }

    function popMap() {

        if (!checkVariableField('xlocation', '지도 정보가 없습니다.\n주소를 먼저 입력해 주세요.')) return false;
        if (!checkVariableField('ylocation', '지도 정보가 없습니다.\n주소를 먼저 입력해 주세요.')) return false;

        var shop_id = $("#shop_id").val();
		//var lat = $("#xlocation").val();
		//var lng = $("#ylocation").val();
        //window.open('/map/map.php?latitude='+lat+'&longitude='+lng, 'popMap', 'width=500px,height=500px');
        window.open('/map/newmap.php?shop_id='+ shop_id, 'popMap', 'width=505px,height=405px');

    };

    function popNMap() {
        if (!checkVariableField('xlocation', '지도 정보가 없습니다.\n주소를 먼저 입력해 주세요.')) return false;
        if (!checkVariableField('ylocation', '지도 정보가 없습니다.\n주소를 먼저 입력해 주세요.')) return false;

  		var lat = $("#xlocation").val();
  		var lng = $("#ylocation").val();
  		var address = $("#address").val();
  		var url = "http://m.map.naver.com/map.nhn?lng="+lng+"&lat="+lat+"&dlevel=11&title="+address;
        window.open(url, 'popMap', 'width=500px,height=500px');
    }

    //네이버 모바일지도 검색
    function popSearchNMap() {
      if (!checkVariableField('shop_name', '업체명을 넣어주세요.')) return false;
		  var shop_name = $("#shop_name").val();
		  var url = "https://m.map.naver.com/search2/search.naver?query="+ shop_name;

      window.open(url, 'popMap', 'width=500px,height=500px');
    }

    //네이버 모바일지도 보기
    function popNaverMap() {
      if (!checkVariableField('map_url', '네이버 지도주소를 등록해 주세요.')) return false;
		  var map_url = $("#map_url").val();
      window.open(map_url, 'popMap', 'width=500px,height=500px');
    }

    function popShopList() {
        window.open('/manager/shop/popShopList.php', 'popShop', 'width=500px,height=500px');
    }
//-->
</script>
<div class="body">
	<div class="content" id="content" tabindex="0">
		<!-- shop info start -->
		<h1 class="h1">업체 관리</h1>
		<form name="boardFrm" method="post" target="_actionfrm" action="./shop/shop_proc.php" class="form">
			<input type="hidden" id="shop_id" name="shop_id" value="<?=$userInfo['shop_id'];?>" />
			<input type="hidden" id="parent_shop_id" name="parent_shop_id" value="<?=$userInfo['parent_shop_id'];?>" />
			<input type="hidden" id="xlocation" name="xlocation" value="<?=$userInfo['xlocation'];?>" />
			<input type="hidden" id="gallery_type" name="gallery_type" value="<?=$userInfo['gallery_type'];?>" />
			<input type="hidden" id="ylocation" name="ylocation" value="<?=$userInfo['ylocation'];?>" />
			<div class="table even">
				<fieldset class="section">
					<h2 class="h2">
						업체 정보
						<button type="button" class="sTog" title="Open/Close"></button>
					</h2>
					<table class="list01">
						<colgroup>
							<col width="15%">
							<col width="35%">
							<col width="15%">
							<col width="35%">
						</colgroup>
						<tbody>
							<tr>
								<th>업체명</th>
								<td style="text-align: left; padding-left: 15px;"><input type="text" id="shop_name" name="shop_name" value="<?=$userInfo['shop_name'];?>" style="width: 340px;" /></td>
								<th>본사명</th>
								<td style="text-align: left; padding-left: 15px;"><input type="text" id="parent_shop_name" name="parent_shop_name" value="<?=$userInfo['parent_shop_name'];?>" style="width: 250px;" />
								<input type="button" id="btnSearchCompany" value="본사찾기" /></td>
							</tr>
							<tr>
								<th>시(도)</th>
								<td style="text-align: left; padding-left: 15px;"><input type="text" id="city" name="city" value="<?=$userInfo['city'];?>" style="width: 150px;" /></td>
								<th>구(군)</th>
								<td style="text-align: left; padding-left: 15px;"><input type="text" id="zone" name="zone" value="<?=$userInfo['zone'];?>" style="width: 150px;" /></td>
							</tr>
							<tr>
								<th>전화</th>
								<td style="text-align: left; padding-left: 15px;"><input type="text" id="tel" name="tel" value="<?=$userInfo['tel'];?>" style="width: 150px;" /></td>
								<th>FAX</th>
								<td style="text-align: left; padding-left: 15px;"><input type="text" id="fax" name="fax" value="<?=$userInfo['fax'];?>" style="width: 150px;" /></td>
							</tr>
							<tr>
								<th>주소</th>
								<td colspan="3" style="text-align: left; padding-left: 15px;"><input type="text" id="address" name="address" value="<?=$userInfo['address'];?>" style="width: 400px;" /><br/><br/>
								<input type="text" id="address_etc" name="address_etc" value="<?=$userInfo['address_etc'];?>" style="width: 300px;" /> <!--input type="button" id="btnViewMap" value="지도보기" /-->
								</td>
							</tr>
							<tr>
							<th>네이버 지도주소</th>
							  <td colspan="3" style="text-align: left; padding-left: 15px;"><input type="text" id="map_url" name="map_url" value="<?=$userInfo['map_url'];?>" style="width: 600px;" />
							  <input type="button" id="btnSearchNMap" value="모바일지도 검색" />
								<input type="button" id="btnViewNMap" value="등록지도 보기" /><br/><br/>
								지도주소 등록방법<br/>
								1. <b>업체명</b> 입력 후 <b>모바일지도 검색</b> 버튼 클릭하여 검색<br/>
								2. 조회된 결과에서 업체의 <b>지도</b>클릭<br/>
								3. 조회된 지도페이지의 <b>URL</b> 복사 하여 <b>네이버 지도주소</b> 입력란에 붙여넣기
							  </td>
							</tr>
							<tr>
								<th>대표자명</th>
								<td style="text-align: left; padding-left: 15px;"><input
									type="text" id="ceo_name" name="ceo_name"
									value="<?=$userInfo['ceo_name'];?>" style="width: 150px;" /></td>
								<th>담당자명</th>
								<td style="text-align: left; padding-left: 15px;"><input
									type="text" id="staff_name" name="staff_name"
									value="<?=$userInfo['staff_name'];?>" style="width: 150px;" /></td>
							</tr>
							<tr>
								<th>담당자 전화</th>
								<td style="text-align: left; padding-left: 15px;"><input
									type="text" id="staff_tel" name="staff_tel"
									value="<?=$userInfo['staff_tel'];?>" style="width: 150px;" /></td>
								<th>담당자 휴대전화</th>
								<td style="text-align: left; padding-left: 15px;"><input
									type="text" id="staff_hp" name="staff_hp"
									value="<?=$userInfo['staff_hp'];?>" style="width: 150px;" /></td>
							</tr>
							<tr>
								<th>담당자 E-Mail</th>
								<td style="text-align: left; padding-left: 15px;"><input
									type="text" id="staff_email" name="staff_email"
									value="<?=$userInfo['staff_email'];?>" style="width: 340px;" /></td>
								<th>초대장 사용</th>
								<td style="text-align: left; padding-left: 15px;">
								돌잔치 사용 <input type="checkbox" id="is_baby" name="is_baby" <?php if ($userInfo['is_baby'] == "1") echo "checked";?> />&nbsp;&nbsp;&nbsp;
								결혼식 사용 <input type="checkbox" id="is_wedding" name="is_wedding" <?php if ($userInfo['is_wedding'] == "1") echo "checked";?> />&nbsp;&nbsp;&nbsp;
								고희연 사용 <input type="checkbox" id="is_silver" name="is_silver" <?php if ($userInfo['is_silver'] == "1") echo "checked";?> />
								</td>
								<!--
								<th>갤러리타입</th>
								<td style="text-align: left; padding-left: 15px;"><select
									id="gallery_type" name="gallery_type">
										<option value="0"
											<?php if ($userInfo['gallery_type'] == "0") echo "selected";?>>스크롤형</option>
										<option value="1"
											<?php if ($userInfo['gallery_type'] == "1") echo "selected";?>>슬라이드형</option>
								</select></td>
								-->
							</tr>
							<tr>
								<th>계약여부</th>
								<td style="text-align: left; padding-left: 15px;" colspan="3"><select
									id="contract_end" name="contract_end">
										<option value="0"
											<?php if ($userInfo['contract_end'] == "0") echo "selected";?>>계약중</option>
										<option value="1"
											<?php if ($userInfo['contract_end'] == "1") echo "selected";?>>계약종료</option>
								</select></td>
							</tr>
							<tr>
								<th>업체메모</th>
								<td style="text-align: left; padding-left: 15px;" colspan="3"><textarea
										id="memo" name="memo" style="height: 50px; width: 100%;"><?=$userInfo["memo"]?></textarea>
								</td>
							</tr>

							<tr>
								<th>가입일</th>
								<td style="text-align: left; padding-left: 15px;"><?=$userInfo['reg_date'];?></td>
								<th>수정일</th>
								<td style="text-align: left; padding-left: 15px;"><?=$userInfo['edt_date'];?></td>
							</tr>
						</tbody>
					</table>
					<h2 class="h2">
						행사시간 정보
						<button type="button" class="sTog" title="Open/Close"></button>
					</h2>
					<table class="list01">
						<colgroup>
							<col width="10%">
							<col width="23%">
							<col width="10%">
							<col width="23%">
							<col width="10%">
							<col width="23%">
						</colgroup>
						<tbody>
							<tr>
								<th>행사시간(평일)</th>
								<td style="text-align: left; padding-left: 15px;"><textarea
										id="time_week" name="time_week"
										style="height: 150px; width: 95%;" maxlength="200"><?=$userInfo["time_week"]?></textarea>
								</td>
								<th>행사시간(토요일)</th>
								<td style="text-align: left; padding-left: 15px;"><textarea
										id="time_sat" name="time_sat"
										style="height: 150px; width: 95%;" maxlength="200"><?=$userInfo["time_sat"]?></textarea>
								</td>
								<th>행사시간(일요일)</th>
								<td style="text-align: left; padding-left: 15px;"><textarea
										id="time_sun" name="time_sun"
										style="height: 150px; width: 95%;" maxlength="200"><?=$userInfo["time_sun"]?></textarea>
								</td>
							</tr>
						</tbody>
					</table>

				</fieldset>

			</div>
			<div class="btnArea">
				<span class="side"> <input type="button" id="btnPost"
					onClick="postShop();" value="등록"> <input type="button"
					id="btnDelete" onClick="postDelete();" value="삭제"> <input
					type="button" onClick="history.back();" value="목록으로">
				</span>
			</div>
		</form>
		<!-- shop info end -->
		<?php
		if ($shop_id) {
			include_once ("shop_vod_form.php");
			include_once ("shop_advertisement_form.php");
			include_once ("shop_image_form.php");
			include_once ("shop_sample_form.php");
		}
		?>
    </div>
</div>
<script type="text/javascript">
<!--
var action = "<?=$_a;?>";

if (action == "insert") {
	$("#btnDelete").hide();
	$("#btnPost").val("등록");
} else if (action == "update") {
	$("#btnDelete").show();
	$("#btnPost").val("수정");
}
//-->
</script>
<!--*****메인 끝*****-->