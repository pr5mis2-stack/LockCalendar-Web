    var is_login_ing = false;
    var prev = "1";
    var next = "4";
    var part = "G";
    
    /**
     * 
     */
    gotoPass = function () {
    	$("#s").val("G");
    	$("#is_gallery").val('0');
    	document.frm.submit();
    }
    
    gotoSave = function () {
    	$("#s").val("S");
    	$("#is_gallery").val('1');
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
    gotoNext = function () {
    	$("#s").val("G");
    	$("#is_gallery").val('1');
    	document.frm.submit();
    }

    gotoPhotoDel = function (photo_id) {
    	var main_id 		= $("#main_id").val();
    	var inputdata = "s=del_file&photo_id="+photo_id;

		$.ajax({
			type: "POST"
			, async: true
			, url: "/maker/maker_step3_proc.php"
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
    	$("#userfile1").val("");
    	$("#userfile2").val("");
    	$("#userfile3").val("");
    	$("#userfile4").val("");
    	$("#userfile5").val("");
    }
    
    /**
     * 
     */
    modalPreViewer2 = function ()
    {
    	$("#s").val("M");
    	$("#is_gallery").val('1');
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