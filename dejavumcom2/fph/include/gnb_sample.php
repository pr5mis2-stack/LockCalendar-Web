<?php 
if (strstr($_SERVER["REQUEST_URI"], '/policy/')) {
?>
		<div class="gnb">
			<ul id="side-nav">
				<li id="menu0" class="n1 on"><a id="section-1" href="/main/main.php">초대장 소개</a></li>
				<li id="menu1" class="n2"><a id="section-2" href="/main/main.php">메인</a></li>
				<li id="menu2" class="n3"><a id="section-3" href="/main/main.php">갤러리</a></li>
				<li id="menu3" class="n4"><a id="section-4" href="/main/main.php">초대글</a></li>
				<li id="menu4" class="n5"><a id="section-5" href="/main/main.php">덕담게시판</a></li>
				<li id="menu5" class="n6"><a id="section-6" href="/main/main.php">Quick메뉴</a></li>
				<li id="menu6" class="n8"><a id="section-7" href="/main/main.php">감사장</a></li>
				<li id="menu7" class="n8"><a href="javascript:viewHelp()">제작가이드</a></li>
			</ul>
		</div>
<?php } else { ?>
		<div class="gnb">
			<ul id="side-nav">
				<li id="menu0" class="n1 on"><a id="section-1">초대장 소개</a></li>
				<li id="menu1" class="n2"><a id="section-2" >메인</a></li>
				<li id="menu2" class="n3"><a id="section-3" >갤러리</a></li>
				<li id="menu3" class="n4"><a id="section-4" >초대글</a></li>
				<li id="menu4" class="n5"><a id="section-5" >덕담게시판</a></li>
				<li id="menu5" class="n6"><a id="section-6" >Quick메뉴</a></li>
				<li id="menu6" class="n8"><a id="section-7" >감사장</a></li>
				<li id="menu7" class="n8"><a href="javascript:viewHelp()">제작가이드</a></li>
				
			</ul>
		</div>
<?php } ?>