viewModal = function(modal_id)
{
	$("#"+modal_id).addClass("open"); 
}

closeModal = function(modal_id)
{
	$("#"+modal_id).removeClass("open"); 
}

modalSampleViewer = function(sample_id)
{
	$("#preViewer").attr('src', "http://www.dejavu-m.com/maker/sample_viewer.php?sample_id="+sample_id);
	viewModal('modalPreViewer');
}

modalPreViewer = function(mid)
{
	var url = "http://m.dejavu-m.com/?m="+mid+"&t=p";
	$("#preViewer").attr('src', url);
	viewModal('modalPreViewer');
}

var $contents = $('#preViewer').contents();
var position = 0;

arrTop = function()
{
	$contents.scrollTop(position - 200);
	position = position - 200;
}

arrBottom = function()
{
	$contents.scrollTop(position + 200);
    position = position + 200;
}

arrLeft = function()
{
	
}

arrRight = function()
{

}

gotoSms = function (type) {
	var sms_hp_f 	= $("#sms_hp_f").val();
	var sms_hp_m 	= $("#sms_hp_m").val();
	var sms_url		= $("#sms_url").val();	
	var receiver 	= "";
	if (type == "m")
		receiver = sms_hp_m;
	else
		receiver = sms_hp_f;
		
	if (receiver == "")
	{
		alert("전송받을 휴대전화번호가 없습니다.")
		return false;
	}	
	
	if (sms_url == "")
	{
		alert("초대장 생성완료 후 전송해 주세요.")
		return false;
	}
	
	var inputdata = "sender="+receiver+"&receiver="+receiver+"&msg="+sms_url;

	$.ajax({
		type: "POST"
		, async: true
		, url: "/common/sms_proc.php"
		, data: inputdata
        , dataType: "json"
		, success: function(json) {
			var header = json.header;
			var body = json.body;
			
			if (header.result_code == "000")
			{
				alert("전송되었습니다.");
				//alert(header.result_msg);
				closeModal('modalSend');
				return true;
			}
			else
			{
				//alert(header.result_code);
				alert(header.result_msg);
				closeModal('modalSend');
                return false;
			}
		}
		, error: function(data, status, err) {
		}
		, complete: function() { 
		}
	});
}