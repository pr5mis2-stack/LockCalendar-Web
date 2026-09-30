    var is_login_ing = false;
    var prev = "";
    var next = "3";
	var part = "M";
	var is_added_promo = false;

    $(function() {    	

		$(".datepicker").datepicker({
			// 달력 아이콘
			showOn: "button",
			buttonImage: "/img/calendar.gif",
			buttonImageOnly: true,
			// 달력 하단의 종료와 오늘 버튼 Show
			showButtonPanel: true,
			// date 포멧
			dateFormat : "yy-mm-dd",
			// 달력 에니메이션 ( show(default),slideDown,fadeIn,blind,bounce,clip,drop,fold,slide,"")
			showAnim : "",
			// 다른 달의 일 보이기, 클릭 가능
			showOtherMonths: true,
	 		selectOtherMonths: true,
	 		// 년도, 달 변경
	 		changeMonth: true,
     		changeYear: true,
     		// 여러달 보이기
     		numberOfMonths: 1,
      		showButtonPanel: true,
      		// 달력 선택 제한 주기(min: 현재부터 -20일,max:현재부터 +1달+10일)
      		//minDate: -20,
      		//maxDate: "+1M +10D",
      		// 주차 보여주기
      		showWeek: false,
      		firstDay: 0
		});
		
		/**
		 * data change setting
		 */
    	$("#show_t").change(function () {
    		setShowTime();
		});
    	$("#show_m").change(function () {
    		setShowTime();
		});
    	$("#show_tflag").change(function () {
    		setShowTime();
		});
    });

    checkFrm = function() {
    	setShowTime();

    	if ($("#type").val() == "B")
    	{
    		$("#father_name").val($("#father_name_bb").val());
    		$("#father_hp").val($("#father_hp_bb").val());
    		$("#mother_name").val($("#mother_name_bb").val());
    		$("#mother_hp").val($("#mother_hp_bb").val());
    		$("#baby_name").val($("#baby_name_bb").val());
    	} else if ($("#type").val() == "W")
    	{
    		$("#father_name").val($("#father_name_wd").val());
    		$("#father_hp").val($("#father_hp_wd").val());
    		$("#mother_name").val($("#mother_name_wd").val());
    		$("#mother_hp").val($("#mother_hp_wd").val());		
    	} else if ($("#type").val() == "S")
    	{
    		$("#father_name").val($("#father_name_sv").val());
    		$("#father_hp").val($("#father_hp_sv").val());
    		$("#baby_name").val($("#baby_name_sv").val());    		
    	}
    	
    	var father_name = $("#father_name");
    	var mother_name = $("#mother_name");
    	var father_hp = $("#father_hp");
    	var mother_hp = $("#mother_hp");
    	var agree1 = $("#agree1")
    	var agree2 = $("#agree2")
    	
    	if (!checkVariableField("shop_id", "업체를 선택해 주세요."))
    		return false;
    	if (!checkVariableField("sample_id", "샘플을 선택해 주세요."))
    		return false;
    	if (!checkVariableField("show_date", "행사일자를 입력해 주세요."))
    		return false;
    	if (!checkVariableField("show_time", "행사시간을 입력해 주세요."))
    		return false;
    	if (!checkVariableField("email", "이메일을 입력해 주세요."))
    		return false;
    	if (!checkVariableField("pwd", "비밀번호를 입력해 주세요."))
    		return false;
    	if (!checkVariableField("holl_name", "홀이름을 입력해 주세요."))
    		return false;

    	if ($("#type").val() == "B")
    	{
	    	if (!checkVariableField("baby_name", "아기이름을 입력해 주세요."))
	    		return false;
	    	
	    	if (father_name.val() == "" && mother_name.val() == "")
	    	{
	    		alert("아빠이름이나 엄마이름 둘중 하나는 입력해 주세요.");
	    		return false;
	    	}
	
	    	if (father_hp.val() == "" && mother_hp.val() == "")
	    	{
	    		alert("아빠전화번호나 엄마전화번호 둘중 하나는 입력해 주세요.");
	    		return false;
	    	}
    	} else if ($("#type").val() == "W")
    	{
	    	if (father_name.val() == "" && mother_name.val() == "")
	    	{
	    		alert("신랑,신부의 이름을 입력해 주세요.");
	    		return false;
	    	}
	
	    	if (father_hp.val() == "" && mother_hp.val() == "")
	    	{
	    		alert("신랑, 신부의 전화번호를 입력해 주세요.");
	    		return false;
	    	}
    	} else if ($("#type").val() == "S")
    	{
	    	if (!checkVariableField("baby_name", "부모님의 성함을 입력해 주세요."))
	    		return false;
	    	
	    	if (father_name.val() == "")
	    	{
	    		alert("자제분의 이름을 입력해 주세요.");
	    		return false;
	    	}
	
	    	if (father_hp.val() == "")
	    	{
	    		alert("자제분의 전화번호를 입력해 주세요.");
	    		return false;
	    	}
    	}
    	
    	if ($("#ck_bank").is(':checked'))
    	  $("#is_bank").val('1');
    	else 
     	  $("#is_bank").val('0');
    	
    	if (!agree1.is(':checked'))
    	{
    		alert("이용약관에 동의해 주셔야 초대장 생성이 가능합니다.");
    		return false;
    	}    	
    	if (!agree2.is(':checked'))
    	{
    		alert("개인정보취급방침에 동의해 주셔야 초대장 생성이 가능합니다.");
    		return false;
    	}    	
    	return true;
    };
    
    /**
     * save
     */
    gotoSave = function () {
    	if (checkFrm())
    	{
	    	$("#s").val("S");
	    	document.frm.submit();
    	}
    };
    
    /**
     * go next
     */
    gotoNext = function () {
    	if (checkFrm())
    	{
	    	$("#s").val("G");
	    	document.frm.submit();
    	}
    };

    gotoPhotoDel = function () {
    	var main_id 		= $("#main_id").val();
    	var inputdata = "s=del_file&main_id="+main_id;

		$.ajax({
			type: "POST"
			, async: true
			, url: "/maker/maker_step1_proc.php"
			, data: inputdata
            , dataType: "json"
			, success: function(json) {
				var header = json.header;
				var body = json.body;
				
				if (header.result_code == "000")
				{
					alert("삭제 되었습니다.");
					location.reload();
					return true;
				}
				else
				{
	                alert("삭제중 오류가 발생했습니다.");
	                return false;
				}
			}
			, error: function(data, status, err) {
			}
			, complete: function() { 
			}
		});
    }; 
    
    /**
     * 
     */
    toggleSelbox = function(selId) {
    	var selboxId = "#i_list"+selId;
    	if ($(selboxId).attr("class") ==  "i_list")
    		$(selboxId).addClass("open");
    	else
    		$(selboxId).removeClass("open");	
    }
    
    /**
     * 
     */
    hiddenSelbox = function(selId) {
    	var selboxId = "#i_list"+selId;
    	$(selboxId).removeClass("open");
    };
    
    /**
     * 
     */
    selSelbox = function(selId, hiddenId, selVal, vallabel) {
    	//console.log('selId='+selId+' hiddenId='+ hiddenId +' selVal='+ selVal +' vallabel='+vallabel);
    	var selboxId = "#i_list"+selId;
    	var selvalId = "#i_list"+selId+"_val";
    	var hiddenId = "#"+hiddenId;
		
    	$(selvalId).html(vallabel);
    	$(selboxId).removeClass("open");
    	$(hiddenId).val(selVal);
    };

    /**
     * 행사 시간 설정
     */
    setShowTime = function()
    {
		var st = $("#show_t").val();
		var sm = $("#show_m").val();
		var tf = $("#show_tflag").val();
		if (tf == "") 
			tf = "AM";
		
		if (st != "" && sm != "")
		{
			if (tf == "AM" && st > 12)
				st = eval(st) - 12;
			if (tf == "PM" && st < 12)
				st = eval(st) + 12;
			if (sm > 60)
				sm = eval(sm) - 60;
			if (String(sm).length < 2)
				sm = "0"+sm;

			$("#show_time").val(st+":"+sm);
		}
    };
    
    /**
     * 추가정보 화면 처리
     * @param type
     */
    showSubInfo = function(type) {
    	if (type == "B")
    	{
    		$("#div_baby").show();
    		$("#div_wedding").hide();
    		$("#div_silver").hide();
    		$("#div_photo").show();
    		
    	} else if (type == "W")
    	{
    		$("#div_baby").hide();
    		$("#div_wedding").show();
    		$("#div_silver").hide();
    		$("#div_photo").show();
    		
    	} else if (type == "S")
    	{
    		$("#div_baby").hide();
    		$("#div_wedding").hide();
    		$("#div_silver").show();
    		$("#div_photo").hide();
    	}
    };
    
    /***************************
     * get data
     **************************/
    /**
     * 초대장 종류에 따른 업체목록 추출
     */
    getShopList = function(type, shop_id)
    {
    	var _shop_name = "";
    	//console.log(type);
		$.ajax({
			type: "POST"
			, async: true
			, url: "/maker/search_proc.php"
			, data: "s=type&type=" + type
            , dataType: "json"
			, success: function(json) {
				var header = json.header;
				var body = json.body;
				
				if (header.result_code == "000")
				{
					var shop_list = body.shop_list;
					var i = 0;
					resetShopList();
					resetSubShopList();
					resetSampleList();
					resetViewtypeList()
					
	                $.each(shop_list, function(key){ 
	              	  
	                	var shop_info = shop_list[key].shop_info;
	                    var sel_shop_id = shop_info.shop_id;
	                    var sel_shop_name = shop_info.shop_name;
	                    var html = "<li onClick=\"selSelbox('1', 'shop_id', '"+sel_shop_id+"', '"+sel_shop_name+"');selSelbox('1', 'parent_shop_id', '"+sel_shop_id+"', '"+sel_shop_name+"');getSubShopList('"+sel_shop_id+"');getSampleTime('"+sel_shop_id+"');\"><label for='a"+i+"'>"+sel_shop_name+"</label></li>";
	                    $("#i_list1").append(html);
	                    if (shop_id == sel_shop_id)
	                    	shop_name = sel_shop_name;
	                    i++;
	                });
					if (shop_id != "")
						selSelbox('1', 'shop_id', shop_id, shop_name);
				}				
				else
				{
					resetShopList();
					resetSubShopList();
					resetSampleList();
					resetViewtypeList()
				}
			}
			, error: function(data, status, err) {
			}
			, complete: function() { 
			}
		});
    };
    
	/**
	 * 업체정보 리셋
	 */
    resetShopList = function()
	{
		$("#i_list1").html("");
		selSelbox('1', 'shop_id', '', '업체선택')
	};
    
    /**
     * 지점정보 추출
     * @param shop_id
     */
    getSubShopList = function(shop_id)
	{
		$.ajax({
			type: "POST"
			, async: true
			, url: "/maker/search_proc.php"
			, data: "s=shop&shop_id=" + shop_id + "&type="+ $("#type").val()
            , dataType: "json"
			, success: function(json) {
				var header = json.header;
				var body = json.body;
				
				if (header.result_code == "000")
				{
					var shop_list = body.shop_list;
					var i = 0;
					resetSubShopList();
					resetSampleList();
					resetViewtypeList()
					
	                $.each(shop_list, function(key){ 
	              	  
	                	var shop_info = shop_list[key].shop_info;
	                    var sub_shop_id = shop_info.shop_id;
	                    var sub_shop_name = shop_info.shop_name;
	                    var html = "<li onClick=\"selSelbox('2', 'shop_id', '"+sub_shop_id+"', '"+sub_shop_name+"');getSampleList('"+sub_shop_id+"');getViewtypeList('"+sub_shop_id+"');getSampleTime('"+sub_shop_id+"');\"><label for='a"+i+"'>"+sub_shop_name+"</label></li>";
	                    
	                    $("#i_list2").append(html);
	                    i++;
	                });
					
	                $("#tr_1").show();
				}
				else
				{
	                $("#tr_1").hide();
	                getSampleList(shop_id);
	                getViewtypeList(shop_id);
	                getSampleTime(shop_id);
				}
				
			}
			, error: function(data, status, err) {
			}
			, complete: function() { 
				if (_shop_id != "" && $("#shop_id").val() == "")
					selSelbox('2', 'shop_id', _shop_id, _shop_name);
			}
		});
	};
	
	/**
	 * 지점정보 리셋
	 */
    resetSubShopList = function()
	{
		$("#i_list2").html("");
		selSelbox('2', 'shop_id', '', '지점선택')
	};
	
	/**
	 * 샘플목록 추출
	 * @param shop_id
	 */
    getSampleList = function(shop_id)
	{
		$.ajax({
			type: "POST"
			, async: true
			, url: "/maker/search_proc.php"
			, data: "s=sample&shop_id=" + shop_id + "&type="+ $("#type").val()
            , dataType: "json"
			, success: function(json) {
				var header = json.header;
				var body = json.body;
				resetSampleList();
				
				if (header.result_code == "000")
				{
					var sample_list = body.sample_list;
					var i = 0;

	                $.each(sample_list, function(key){ 
	              	  
	                	var sample_info = sample_list[key].sample_info;
	                    var sample_id = sample_info.sample_id;
	                    var sample_name = sample_info.sample_name;
	                    var html = "<li onClick=\"selSelbox('3', 'sample_id', '"+sample_id+"', '"+sample_name+"');viewSampleViewer('"+sample_id+"');\"><label for='a"+i+"'>"+sample_name+"</label></li>";
	                    
	                    $("#i_list3").append(html);
	                    i++;
	                });
				}
			}
			, error: function(data, status, err) {
			}
			, complete: function() { 
				if (_sample_id != "")
				{
					selSelbox('3', 'sample_id', _sample_id, _sample_name);
					viewSampleViewer(_sample_id);
				}

				// 프로모션 정보 조회
				getPromo(shop_id);
			}
		});
	};
    
	/**
	 * 샘플목록 리셋
	 */
    resetSampleList = function()
	{
		$("#i_list3").html("");
		selSelbox('3', 'sample_id', '', '샘플선택')
	};
    
	/**
	 * 뷰타입 추출
	 * @param shop_id
	 */
    getViewtypeList = function(shop_id)
	{
    	$("#tr_3").hide();
    	/*
		$.ajax({
			type: "POST"
			, async: true
			, url: "/maker/search_proc.php"
			, data: "s=viewtype&shop_id=" + shop_id
            , dataType: "json"
			, success: function(json) {
				var header = json.header;
				var body = json.body;
				resetViewtypeList();
				
				if (header.result_code == "000")
				{
					var gallery_type = body.gallery_type;

                    var html = "<li onClick=\"selSelbox('4', 'view_type', '0', '세로타입')\"><label for='a0'>세로타입</label></li>";
                    $("#i_list4").append(html);

					if (gallery_type == "1")
					{
	                    var html = "<li onClick=\"selSelbox('4', 'view_type', '1', '가로타입')\"><label for='a1'>가로타입</label></li>";
	                    $("#i_list4").append(html);
		                $("#tr_3").show();
					}
				}
				else
				{
					selSelbox('4', 'view_type', '0', '세로타입');
	                $("#tr_3").hide();
				}
			}
			, error: function(data, status, err) {
			}
			, complete: function() { 
			}
		});
		*/
	};
	
	/**
	 * 뷰타입 리셋
	 */
    resetViewtypeList = function()
	{
		$("#i_list4").html("");
		selSelbox('4', 'view_type', '0', '세로타입');
        $("#tr_3").hide();
	};
    
	/**
	 * 샘플타임 추출
	 * @param shop_id
	 */
    getSampleTime = function(shop_id)
	{
    	resetSampleTime();
    	
		$.ajax({
			type: "POST"
			, async: true
			, url: "/maker/search_proc.php"
			, data: "s=sampletime&shop_id=" + shop_id
            , dataType: "json"
			, success: function(json) {
				var header = json.header;
				var body = json.body;
				
				if (header.result_code == "000")
				{
					var time_week = body.time_week;
					var time_sat = body.time_sat;
					var time_sun = body.time_sun;

					var html = "<div style='text-align: center;font-weight:bold;padding: 10px 0px 10px 0px;'>행사시간 미리보기</div>";
					if (time_week != "" && time_week != "undefined")
						html = html + time_week +"<br />";
					if (time_sat != "" && time_sat != "undefined")
						html = html + time_sat +"<br />";
					if (time_sun != "" && time_sun != "undefined")
						html = html + time_sun +"<br />";
					
					$("#sample_time").html("");
	                $("#sample_time").append(html);
		            $("#sample_time").show();
				}
				else
					resetSampleTime();
			}
			, error: function(data, status, err) {
			}
			, complete: function() { 
			}
		});
	};
	
	/**
	 * 샘플타임 리셋
	 */
    resetSampleTime = function()
	{
		$("#sample_time").html("");
        $("#sample_time").hide();
	};

    fileReset = function()
    {
    	$("#userfile").val("");
    };
    
    /**
     * 
     */
    modalPreViewer2 = function ()
    {
    	if (checkFrm())
    	{
	    	$("#s").val("M");
	    	document.frm.submit();
    	}

    };
    
    modalPreViewerPop = function()
    {
    	var mid = $("#main_id").val();
    	var p = $("#p").val();
    	// PHP8.4 마이그레이션: 운영 도메인(dejavu-m.com)일 때만 모바일 서브도메인 사용,
    	// 그 외(임시 신규서버 테스트 중)에는 현재 접속 중인 도메인의 /m/ 경로로 우회
    	var host = location.hostname;
    	var url;
    	if (host.indexOf("dejavu-m.com") !== -1) {
    		url = "https://m.dejavu-m.com/?m="+mid+"&p="+p+"&t=p";
    	} else {
    		url = "//"+location.host+"/m/index.php?m="+mid+"&p="+p+"&t=p";
    	}
    	if (mid != "")
    	{
        	$("#preViewer").attr('src', url);
        	viewModal('modalPreViewer');
    	}
    	else
    	{
    		alert("초대장 정보가 없습니다..");
    		return false;
    	}
    };
    
	/**
	 * 샘플보기
	 * @param sample_id
	 * @param part
	 */
    viewSampleViewer = function(sample_id)
	{
		if (sample_id != "")
		{
			$("#sampleViewer").attr('src', "https://www.dejavu-m.com/maker/sample_viewer.php?sample_id="+sample_id+"&part="+part);
		}
	};
	
	/**
	 * 프로모션 정보 조회
	 */
	getPromo = function(shop_id) {
		$("#img_promo").attr("src", "");
		$("#notice_promo").hide();
		$("#promo_service").html();
		$("#promo_service").hide();

		$.ajax({
			type: "POST"
			, async: true
			, url: "/maker/promotion_proc.php"
			, data: "s=ps&shop_id=" + shop_id
            , dataType: "json"
			, success: function(json) {
				var header = json.header;
				var body = json.body;

				if (header.result_code == "000")
				{
					var promotion_list = body.promotion_list;
					var i = 0;

					if (promotion_list.length > 0)
					{
						var is_popup = promotion_list[0].promotion_info.is_popup;
						var shop_name = promotion_list[0].promotion_info.shop_name;
						var img_width = promotion_list[0].promotion_info.img_width;
						var img_height = promotion_list[0].promotion_info.img_height;
						var file_url = promotion_list[0].promotion_info.file_url;

						if (is_popup)
						{
							$("#img_promo").attr("src", file_url);
							$("#img_promo").css("width", img_width);
							$("#img_promo").css("height", img_height);
							$("#notice_promo").show();
							//window.open(file_url, "notice_promo_"+ shop_id, "width="+ img_width +",height="+ img_height);
						}

						var sample_service = $("#sample_service").html();
						sample_service = sample_service.replace("@SHOP_NAME@", shop_name);
						$("#promo_service").html(sample_service);
						$("#promo_service").show();
					}
				}
			}
			, error: function(data, status, err) {
			}
			, complete: function() { 
			}
		});
	};

	hideNoticePromo = function() {
		$("#img_promo").attr("src", "");
		$("#notice_promo").hide();
	};