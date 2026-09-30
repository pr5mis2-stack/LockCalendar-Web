    var is_login_ing = false;
    var prev = "3";
    var next = "5";
    var part = "I";

    gotoPass = function () {
    	$("#s").val("G");
		$("#is_invitation").val('0');
    	document.frm.submit();
    }
    
    /**
     * 
     */
    gotoSave = function () {
    	$("#s").val("S");
		$("#is_invitation").val('1');
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
		$("#is_invitation").val('1');
    	document.frm.submit();
    }
    
    /**
     * 
     */
    modalPreViewer2 = function ()
    {
    	$("#s").val("M");
    	$("#is_invitation").val('1');
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