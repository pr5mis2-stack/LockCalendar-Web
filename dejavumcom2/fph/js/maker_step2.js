    var is_login_ing = false;
    var prev = "1";
    var next = "3";
    var part = "M";

    /**
     * 
     */
    gotoPass = function () {
    	location.href="main.php?step="+next;
    }
    
    /**
     * 
     */
    gotoSave = function () {
    	if ($("#userfile").val() != "")
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
    	if ($("#userfile").val() != "")
    		gotoSave();
    	location.href="main.php?step="+next;

    }
    
    
    /**
     * 
     */
    modalPreViewer2 = function ()
    {
    	var mid = $("#main_id").val();
    	var p = $("#p").val();
    	var url = "http://m.dejavu-m.com/?m="+mid+"&p="+p+"&t=p";
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