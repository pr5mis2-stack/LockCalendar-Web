<?php
/**
 *  product_form.php
 *  @Desc      : 상품등록 관리
 *  @Author    : suya
 *  @Date      :
 *  @param 	 
 *  @Return
 */
import ( "class.controller.ProductCon" );
$ProductCon = new ProductCon ();

/**
 *
 * @var parameter setting
 */
$pid = $StringClass->getRequest ( 'pid' );
$search_target = $StringClass->getRequest ( 'search_target' );
$search_keyword = $StringClass->getRequest ( 'search_keyword' );

$mode = ($pid) ? "update" : "insert";

if ($pid) {
	$param = array ();
	$param ['product_id'] = $pid;
	$result = $ProductCon->getProductList ( $param );
	if ($result)
		$item = $result [0];
	
	$arrOptionList = $ProductCon->getProductOptionList ( $param );
	$arrImageList = $ProductCon->getProductImageList ( $param );
}
/**
 * ******************************************************************************************
 * @Desc 페이지 번호 목록 출력
 * *****************************************************************************************
 */
$getParam = "&menu=product";
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
<script language="Javascript">
    var is_proc_ing = false;

    function delOption(option_id)
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        var goUrl = "./product_proc.php";
        var param = "&mode=delete_option&option_id=" + option_id;
        //location.href = goUrl + "?" + param;

        var v = confirm('삭제하시겠습니까?');
        if (v == true) {
            is_proc_ing = true;

            $.ajax({
                type: 'post'
                  , async: true
                  , url: goUrl
                  , data: param
                  , beforeSend: function () { }
                  , success: function (data) {

                      is_proc_ing = false;

                      var result = data.trim();

                      if (result == "100") {
                          alert('삭제되었습니다');
                          window.location.reload();
                      }
                      else
                          alert('삭제중 오류가 발생하였습니다.');
                  }
                  , error: function (data, status, err) { }
                  , complete: function () { }
            });
        }
    }

    function delImage(img_id)
    {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        var goUrl = "./product_proc.php";
        var param = "&mode=delete_img&img_id=" + img_id;
        //location.href = goUrl + "?" + param;

        var v = confirm('삭제하시겠습니까?');
        if (v == true) {
            is_proc_ing = true;

            $.ajax({
                type: 'post'
                  , async: true
                  , url: goUrl
                  , data: param
                  , beforeSend: function () { }
                  , success: function (data) {

                      is_proc_ing = false;

                      var result = data.trim();

                      if (result == "100") {
                          alert('삭제되었습니다');
                          window.location.reload();
                      }
                      else
                          alert('삭제중 오류가 발생하였습니다.');
                  }
                  , error: function (data, status, err) { }
                  , complete: function () { }
            });
        }
    }

    function delProduct(pid) {

        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        var goUrl = "./product_proc.php";
        var param = "&mode=delete&pid=" + pid;
        //location.href = goUrl + "?" + param;

        var v = confirm('삭제하시겠습니까?');
        if (v == true) {
            is_proc_ing = true;

            $.ajax({
                type: 'post'
                  , async: true
                  , url: goUrl
                  , data: param
                  , beforeSend: function () { }
                  , success: function (data) {

                      is_proc_ing = false;

                      var result = data.trim();

                      if (result == "100") {
                          alert('삭제되었습니다');
                          location.href = '/manager/index.php?<?=$getParam;?>';
                      }
                      else
                          alert('삭제중 오류가 발생하였습니다.');
                  }
                  , error: function (data, status, err) { }
                  , complete: function () { }
            });
        }
    }

    function insertProduct() {
        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        var product_name = $("#product_name").val();
        var price = $("#price").val();
        var product_cnt = $("#product_cnt").val();
        if (product_name == "")
        {
            alert("상품명을 입력해 주세요");
            $("#product_name").focus();
            return;
        }
        if (price == "")
        {
            alert("판매가격을 입력해 주세요.");
            $("#price").focus();
            return;
        }
        if (product_cnt == "")
        {
            alert("재고수량을 입력해 주세요.");
            $("#product_cnt").focus();
            return;
        }
        if(!checkSpacContents()) {
	    	alert("내용을 입력해주세요");
		    editor.focus();
		    return;
	    }

        var v = confirm('등록하시겠습니까?');
        if (v == true) {
            is_proc_ing = true;
            document.productFrm.submit();
        }

    }

    function updateProduct() {

        if (is_proc_ing) {
            alert("진행중 입니다.");
            return;
        }

        var pid = $("#pid").val();
        var product_name = $("#product_name").val();
        var price = $("#price").val();
        var product_cnt = $("#product_cnt").val();

        if (product_name == "")
        {
            alert("상품명을 입력해 주세요");
            $("#product_name").focus();
            return;
        }
        if (price == "")
        {
            alert("판매가격을 입력해 주세요.");
            $("#price").focus();
            return;
        }
        if (product_cnt == "")
        {
            alert("재고수량을 입력해 주세요.");
            $("#product_cnt").focus();
            return;
        }
        if(!checkSpacContents()) {
	    	alert("내용을 입력해주세요");
		    editor.focus();
		    return;
	    }

        var v = confirm('수정하시겠습니까?');
        if (v == true) {
            is_proc_ing = true;
            document.productFrm.submit();
        }
    }

    function postManager() {
        var mode = $("#mode").val();
        if (mode == "update")
            updateProduct();
        else
            insertProduct();
    }

    function addOption()
    {
        var addDivHtml = "<input type='hidden' name='option_id[]' value='' />";
        addDivHtml += "<div class='info01'>";
        addDivHtml += "<ul>";
        addDivHtml += "<li class='text'>옵션명 : <input type='text' size='10' name='option_type[]' value='' /></li>";
        addDivHtml += "<li class='style'>옵션값 : <input type='text' size='10' name='option_value[]' value='' /> \"/\"로 구분해 입력해주세요.</li>";
        addDivHtml += "</ul>";
        addDivHtml += "</div>";

	    $("#optionDiv").append(addDivHtml);
    }

    function addImage()
    {
        var addDivHtml = "<input type='hidden' name='img_id[]' value='' />";
        addDivHtml += "<div class='info01'>";
        addDivHtml += "<ul>";
        addDivHtml += "<li class='text'><input type='file' size='10' name='user_file[]' /></li>";
        addDivHtml += "<li class='style'></li>";
        addDivHtml += "</ul>";
        addDivHtml += "</div>";
        
        $("#imageDiv").append(addDivHtml);
    }

</script>
<div class="body">
	<div class="content" id="content" tabindex="0">
		<form name='productFrm' method="post" target="_actionfrm"
			action="product_proc.php" class="form" enctype="multipart/form-data">
			<input type="hidden" id="mode" name="mode" value="<?=$mode;?>" /> <input
				type="hidden" id="menu" name="menu" value="<?=$menu;?>" /> <input
				type="hidden" id="search_target" name="search_target"
				value="<?=$search_target;?>" /> <input type="hidden"
				id="search_keyword" name="search_keyword"
				value="<?=$search_keyword;?>" /> <input type="hidden" id="pid"
				name="pid" value="<?=$pid;?>" /> <input type="hidden"
				id="upload_dir" name="upload_dir" value="PRODUCT" />
			<h1 class="h1">상품등록</h1>
			<div class="table even">

				<fieldset class="section">
					<h2 class="h2">
						상품 관리
						<button type="button" class="sTog" title="Open/Close">
							<i class="icon-chevron-up"></i>
						</button>
					</h2>
					<ul>
						<li>
							<p class="q">상품명</p>
							<p class="a">
								<input type="text" size="20" id="product_name"
									name="product_name" value="<?=$item['product_name'];?>"
									value="" />
							</p>
						</li>
						<li>
							<p class="q">가격</p>
							<p class="a">
								<input type="text" size="5" id="price" name="price"
									value="<?=$item['price'];?>" style="width: 100px;" /> 원
							</p>
						</li>
						<li>
							<p class="q">할인판매가</p>
							<p class="a">
								<input type="text" size="10" id="sale_price" name="sale_price"
									value="<?=$item['sale_price'];?>" style="width: 100px;" /> 원
							</p>
						</li>
						<li>
							<p class="q">재고수량</p>
							<p class="a">
								<input type="text" size="10" id="product_cnt" name="product_cnt"
									value="<?=$item['product_cnt'];?>" style="width: 40px;" /> 개 <span
									style="color: red; font-weight: bold;">※ 재고수량을 0으로 변경하시면, 품절
									상태로 변경됩니다.</span>
							</p>

						</li>
						<li>
							<p class="q">
								옵션 <input type="button" onClick="addOption();" value="추가">
							</p>
							<p class="a" id="optionDiv">
		                <?php
																		if (! empty ( $arrOptionList )) {
																			foreach ( $arrOptionList as $oitem ) {
																				?>
			            <input type='hidden' name='option_id[]'
									value='<?=$oitem['option_id'];?>' />
							
							<div class='info01'>
								<ul>
									<li class='text'>옵션명 : <input type='text' size='10'
										name='option_type[]' value='<?=$oitem['option_type'];?>' /><input
										type="button"
										onClick="delOption('<?=$oitem['option_id'];?>');" value="삭제"></li>
									<li class='style'>옵션값 : <input type='text' size='10'
										name="option_value[]" value='<?=$oitem['option_value'];?>' />
										"/"로 구분해 입력해주세요.
									</li>
								</ul>
							</div>
		                <?php
																			}
																		}
																		?>
                        </p>
						</li>
						<li>
							<p class="q">판매여부</p>
							<p class="a">
								<select id="is_sale" name="is_sale">
									<option value="Y"
										<?php if ($item['is_sale'] == "Y") { echo"selected"; } ?>>판매중</option>
									<option value="N"
										<?php if ($item['is_sale'] == "N") { echo"selected"; } ?>>판매종료</option>
								</select>
							</p>
						</li>
						<li>
							<p class="q">
								상품이미지 <input type="button" onClick="addImage();" value="추가"> <span
									style="color: red;">※ 이미지 등록시 파일명은 영문이나 숫자명으로 등록해 주세요. 한글명일경우
									오류가 발생될 수 있습니다.</span>
							</p>
							<p class="a" id="imageDiv">
		                <?php
																		if (! empty ( $arrImageList )) {
																			foreach ( $arrImageList as $iitem ) {
																				?>
			            <input type='hidden' name='img_id[]'
									value='<?=$iitem['img_id'];?>' />
							
							<div class='info01'>
								<ul>
									<li class='text'><input type='file' size='10'
										name='user_file[]' /></li>
									<li class='style'>
                                <?php if ($iitem['file_url']) { ?>
                                <a
										href='<?=$conf_product_file_url.$iitem['file_url'];?>'
										target='_blank'><img
											src='<?=$conf_product_file_url.$iitem['file_url'];?>'
											style="with: 100px;" /></a> <input type="button"
										onClick="delImage('<?=$iitem['img_id'];?>');" value="삭제">
                                <?php } ?>
                                </li>
								</ul>
							</div>
		                <?php
																			}
																		}
																		?>
                        </p>
						</li>
						<li>
							<p class="q">상품정보</p>
							<p class="a">
								<script language="Javascript">createEditor('product_desc','210','<?=str_replace("\n", "", str_replace("\r\n", "", $item['product_desc']));?>','images');</script>
							</p>
						</li>
					</ul>
				</fieldset>

			</div>
			<div class="btnArea">
				<span class="side">
                <?php if (!empty($pid)) { ?>
                <input type="button" onClick="delProduct('<?=$pid;?>');"
					value="삭제">
                <?php } ?>
                <input type="button" onClick="postManager();" value="적용">
				</span>
			</div>
		</form>

	</div>
</div>
<!--*****메인 끝*****-->