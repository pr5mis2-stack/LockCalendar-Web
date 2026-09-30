    var is_login_ing = false;
    var prev = "4";
    var next = "";
    var part = "A";

    /**
     * 
     */
    gotoSave = function () {
    	$("#s").val("S");
    	document.frm.submit();
    }
    
    /**
     * 
     */
    gotoPrev = function () {
    	location.href="main.php?step="+prev;
    }
    
    /**
     * 
     */
    gotoEnd = function () {
    	$("#s").val("E");
    	document.frm.submit();
    }
    
    gotoDone = function (main_id) {
    	if (confirm('등록하신 내용으로 생성하시겠습니까?\n생성 완료된 초대장은 \n언제든지 수정 가능합니다.'))
    		modalPreViewer(main_id);
    }
    
    /**
     * 
     */
    toggleSelbox = function(selId) {
    	var selboxId = "#i_list"+selId;
    	if ($(selboxId).attr("class") ==  "i_list")
    		$(selboxId).addClass("open no_scroll");
    	else
    		$(selboxId).removeClass("open no_scroll");	
    }
    
    /**
     * 
     */
    hiddenSelbox = function(selId) {
    	var selboxId = "#i_list"+selId;
    	$(selboxId).removeClass("open no_scroll");
    }
    
    /**
     * 
     */
    selSelbox = function(selId, hiddenId, selVal, vallabel) {
    	var selboxId = "#i_list"+selId;
    	var selvalId = "#i_list"+selId+"_val";
    	var hiddenId = "#"+hiddenId;
    	
    	$(selvalId).html(vallabel);
    	$(selboxId).removeClass("open no_scroll");
    	$(hiddenId).val(selVal);
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
    	$("#s").val("M");
    	document.frm.submit();
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

    /***************************
     * get data
     **************************/
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