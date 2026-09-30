    var is_login_ing = false;
    var prev = "";
    var next = "3";
    var part = "M";

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

    	var father_name = $("#father_name");
    	var mother_name = $("#mother_name");
    	var father_hp = $("#father_hp");
    	var mother_hp = $("mother_hp");
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
    	if (!checkVariableField("baby_name", "아기이름을 입력해 주세요."))
    		return false;
    	if (!checkVariableField("holl_name", "홀이름을 입력해 주세요."))
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
    }
    /**
     * save
     */
    gotoSave = function () {
    	if (checkFrm())
    	{
	    	$("#s").val("S");
	    	document.frm.submit();
    	}
    }
    
    /**
     * go next
     */
    gotoNext = function () {
    	if (checkFrm())
    	{
	    	$("#s").val("G");
	    	document.frm.submit();
    	}
    }

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
    }    
    
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
    }
    
    /**
     * 
     */
    selSelbox = function(selId, hiddenId, selVal, vallabel) {
    	var selboxId = "#i_list"+selId;
    	var selvalId = "#i_list"+selId+"_val";
    	var hiddenId = "#"+hiddenId;
    	
    	$(selvalId).html(vallabel);
    	$(selboxId).removeClass("open");
    	$(hiddenId).val(selVal);
    }

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
			if (eval(sm) < 10)
				sm = "0"+sm;

			$("#show_time").val(st+":"+sm);
		}
    }
    
    /***************************
     * get data
     **************************/
    /**
     * 지점정보 추출
     */
    getSubShopList = function(shop_id)
	{
		$.ajax({
			type: "POST"
			, async: true
			, url: "/maker/search_proc.php"
			, data: "s=shop&shop_id=" + shop_id
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
				}
				
			}
			, error: function(data, status, err) {
			}
			, complete: function() { 
				if (_shop_id != "" && $("#shop_id").val() == "")
					selSelbox('2', 'shop_id', _shop_id, _shop_name);
			}
		});
	}	
	
	/**
	 * 지점정보 리셋
	 */
    resetSubShopList = function()
	{
		$("#i_list2").html("");
		selSelbox('2', 'shop_id', '', '지점선택')
	}
	
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
			, data: "s=sample&shop_id=" + shop_id
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
			}
		});
	}
    
	/**
	 * 샘플목록 리셋
	 */
    resetSampleList = function()
	{
		$("#i_list3").html("");
		selSelbox('3', 'sample_id', '', '샘플선택')
	}
    
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
	}
	
	/**
	 * 뷰타입 리셋
	 */
    resetViewtypeList = function()
	{
		$("#i_list4").html("");
		selSelbox('4', 'view_type', '0', '세로타입');
        $("#tr_3").hide();
	}

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
	}
	
	/**
	 * 샘플타임 리셋
	 */
    resetSampleTime = function()
	{
		$("#sample_time").html("");
        $("#sample_time").hide();
	}
    
    fileReset = function()
    {
    	$("#userfile").val("");
    }
    
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

    }
    
    modalPreViewerPop = function()
    {
    	var mid = $("#main_id").val();
    	var p = $("#p").val();
    	var url = "http://m.dejavu-m.com/?m="+mid+"&p="+p+"&t=p";
    	if (mid == "")
    	{
    		alert("초대장 정보가 없습니다.");
    		return false;
    	}
    	$("#preViewer").attr('src', url);
    	viewModal('modalPreViewer');
    }
    
	/**
	 * 샘플보기
	 * @param sample_id
	 * @param part
	 */
    viewSampleViewer = function(sample_id)
	{
		if (sample_id != "")
		{
			$("#sampleViewer").attr('src', "http://www.dejavu-m.com/maker/sample_viewer.php?sample_id="+sample_id+"&part="+part);
		}
	}