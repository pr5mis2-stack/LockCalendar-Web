<script language="Javascript">
<!--
$(document).ready(function () {

	$("#sch_type").change(function () {
		getSampleList($("#sch_type").val());
	});
});

function postShopSample()
{
    if (is_proc_ing) {
        alert("진행중 입니다.");
        return;
    }

    document.sampleFrm.submit();
}

getSampleList = function(type)
{
	console.log(type);
	$.ajax({
		type: "GET"
		, async: true
		, url: "./shop/search_proc.php"
		, data: "s=type&sch_type=" + type
        , dataType: "json"
		, success: function(json) {
			var header = json.header;
			var body = json.body;
			
			if (header.result_code == "000")
			{
				var sample_list = body.sample_list;
				var i = 0;
				resetSampleList();
				
                $.each(sample_list, function(key){ 
              	  
                	var sample_info = sample_list[key].sample_info;
                    var sample_id = sample_info.sample_id;
                    var sample_name = sample_info.sample_name;
                    var html = "<option value='"+ sample_id +"'>"+ sample_name +"</option>";
                    $("#sample_id").append(html);
                    i++;
                });
			}				
			else
			{
				resetSampleList();
			}
		}
		, error: function(data, status, err) {
		}
		, complete: function() { 
		}
	});
}

resetSampleList = function()
{
	$("#sample_id").html("");
    var html = "<option value=''>샘플선택</option>";
    $("#sample_id").append(html);
}

postSampleDelete = function(shop_id, sample_id)
{
    if (is_proc_ing) {
        alert("진행중 입니다.");
        return;
    }
    
    var goUrl = "./shop/shop_proc.php";
    var param = "&a=sample_delete&shop_id="+ shop_id + "&sample_id="+ sample_id;
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
            	location.reload();
            }
            else
            	alert('처리중 오류가 발생하였습니다.');
		}
		, error: function (data, status, err) { }
        , complete: function () { }
	});
}
-->
</script>
<h1 class="h1">업체 샘플 관리</h1>
<div class="table even">

	<fieldset class="section">
		<h2 class="h2">샘플 관리<button type="button" class="sTog" title="Open/Close"></button></h2>
		<form name='sampleFrm' method="post" target="_actionfrm" action="./shop/shop_proc.php" class="form">
			<input type="hidden" name="a" value="sample_insert" /> <input type="hidden" name="shop_id" value="<?=$shop_id;?>" />
			<table class="list01">
				<colgroup>
					<col width="20%">
					<col width="20%">
					<col width="20%">
					<col width="20%">
					<col width="20%">
				</colgroup>
				<tbody>
					<tr>
						<th>타입</th>
						<td style="text-align: left; padding-left: 15px;">
							<select id="sch_type" name="sch_type">
								<option value="" selected>타입선택</option>
								<option value="B">돌잔치</option>
								<option value="W">결혼식</option>
								<option value="S">고희연</option>
							</select>
						</td>
						<th>샘플</th>
						<td style="text-align: left; padding-left: 15px;">
						<select id="sample_id" name="sample_id">
							<option value=''>샘플선택</option>
                        </select>
                        </td>
						<td><span class="side"> <input type="button" id="btnPost" onClick="postShopSample();" value="등록">
						</span></td>
					</tr>
				</tbody>
			</table>
		</form>

		<form name='sampleListFrm' method="post" target="_actionfrm"
			action="./shop/shop_proc.php" class="form">
			<div class="table even">
				<table width="100%" border="1" cellspacing="0" class="_memberList">
					<thead>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">타입</th>
							<th scope="col" class="nowr">샘플명</th>
							<th scope="col" class="nowr">등록일</th>
							<th scope="col" class="nowr">삭제</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col" class="nowr">No</th>
							<th scope="col" class="nowr">타입</th>
							<th scope="col" class="nowr">샘플명</th>
							<th scope="col" class="nowr">등록일</th>
							<th scope="col" class="nowr">삭제</th>
						</tr>
					</tfoot>
					<tbody>
				    <?php
					foreach ( $shopSampleList as $item ) {
					// new dBug($item);
					?>
				    <tr>
						<td class="nowr"><?=$sampleListNum;?></td>
						<td class="nowr"><?=$item['sample_type_name'];?></td>
						<td class="nowr"><?=$item['sample_name'];?></td>
						<td class="nowr"><?=$item['reg_date'];?></td>
						<td class="nowr"><input type="button" onClick="postSampleDelete(<?=$item['shop_id'];?>, <?=$item['sample_id'];?>)" value="삭제" /></td>
					</tr>
				    <?php
						$sampleListNum --;
					}
					?>
	                </tbody>
				</table>
			</div>
		</form>
	</fieldset>
</div>