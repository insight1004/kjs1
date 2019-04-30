<?if (!defined('_COOL_')) exit; // 개별 페이지 접근 불가?>

<!-- popup 1 delete -->
<div class="pop-window fade" id="modal-alert">
	<div class="alert">
		<div class="alert_con">
			<i class="mte i_error_outline red"></i>
			<p>관리자 신규 등록하시겠습니까?</p>
		</div>
		<div class="modal_foot">
			<a href="javascript:submit_ok();" class="b_red">확인</a>
			<a href="javascript:;" data-dismiss="modal" class="b_sgrey">취소</a>
		</div>
	</div>
</div>
<!-- END popup 1 delete //-->


<!-- contents area -->
<div class="con_wrap">
	<!-- my info -->
	
	<form method="post" action="" name="frm" id="frm">
		
	<div class="info_wrap">
		<h4 class="title">관리자 신규등록</h4>
		<div class="panel adds">
			<ul>
				<li><h5>아이디</h5></li>
				<li>
					<input type="text" name="a_id" id="a_id" placeholder="이메일 주소" class="input_add" onblur="emailChk(this, 'a_id_msg');" onkeydown="fn_hanLimit(this)" maxlength="50">
					<p class="t_blue" id="a_id_msg"></p>
				</li>
				<li><h5>관리자 명</h5></li>
				<li>
					<input type="text" name="a_name" id="a_name" placeholder="한글/영문 20자 이내" class="input_add" maxlength="20">
					<p class="t_red"></p>
				</li>
				<li><h5>비밀번호</h5></li>
				<li>
					<input type="password" name="a_pwd" id="a_pwd" placeholder="비밀번호" class="input_add" maxlength="20">
					<p class="t_red">영문/숫자/특수문자 2가지 이상 조합, 8자~20자</p>
				</li>
				<li><h5>비밀번호 확인</h5></li>
				<li><input type="password" name="a_pwd_confirm" id="a_pwd_confirm" placeholder="비밀번호 확인" class="input_add" maxlength="20"></li>
			
				<li><h5>분류</h5></li>
				<li class="select_input">
					<div>
						<select name="a_level" id="a_level" class="">
							<option value="normal">일반관리자</option>
							<option value="super">슈퍼관리자</option>
						</select>
					</div>
				</li>
				<li><h5>연락처</h5></li>
				<li class="phone_input">
					<div class="mr5">
						<select name="a_tel1" id="a_tel1" class="">
							 <?php echo option_str($tel_txt, $tel_value, ""); ?>
						</select>
					</div>
					<div>
						- <input type="text" name="a_tel2" id="a_tel2" maxlength="4" onkeydown="fn_onlyNumber(this)"> - <input type="text" name="a_tel3" id="a_tel3" maxlength="4" onkeydown="fn_onlyNumber(this)">
					</div>
				</li>
			</ul>
		</div>
	</div>
	
	<!-- button area -->
	<div class="btn_wrap">
		<a href="javascript:submit_ready();"  class="b_blue">등록</a>
		<a href="./?abkind=adm" class="b_sgrey">목록</a>
	</div>
	<!-- END button area //-->

	</form>

</div>
<!-- END contents area //-->



<script type="text/javascript">

//이메일 유효성 체크
function emailChk(obj, dp){
	var val = obj.value;

	if (val != ""){

		//공백 제거
		val = val.replace(/(\s*)/g, "");
		obj.value = val;

		if (!fn_emailChk(val)){
			$('#'+dp).html("<font color='#ff3300'><?=$msgstr['email_deny']?></font>");
		}else{
			//ID 중복 체크
			var ajax_url = "/proc/idchk.php";	
			//var formData = $("#frm").serialize();
			var params = "";
			var msg = "";

			params = "a_id="+val;

			$.ajax({
			   type:"post",
			   url:ajax_url,
			   data:params,
			   //data:formData,
			   dataType:"JSON", // JSON 리턴
			   beforeSend:function(){},
			   success : function(data) {
					 // success
					 // TODO
					if (data.state){
						$('#'+dp).html("<font color='#0066ff'>"+data.rtnmsg+"</font>");
					}else{
						$('#'+dp).html("<font color='#ff3300'>"+data.rtnmsg+"</font>");
					}

			   },
			   complete : function(data) {
					 // 통신이 실패했어도 완료가 되었을 때
					 // TODO
			   },
			   error : function(xhr, status, error) {
					 //alert("에러발생");
					 $('#'+dp).text('');
			   },
			   timeout:100000 /*응답제한시간 ms*/
			});
			

		}
	}else{
		$('#'+dp).text('');
	}

}

//폼 항목 체크
function reg_form_chk(){
	
	var f = document.frm;
	
	if (f.a_id.value == ''){
		alert("<?=$msgstr['id_null']?>");
		f.a_id.focus();
		return false;

	}else if (!fn_emailChk(f.a_id.value)){
		alert("<?=$msgstr['email_deny']?>");
		f.a_id.focus();
		return false;

	}else if (f.a_name.value == ''){
		alert("<?=$msgstr['name_null']?>");
		f.a_name.focus();
		return false;

	}else if(fn_strCheck(f.a_name.value)){
		alert("<?=$msgstr['name_deny']?>");
		f.a_name.focus();
		return false;

	}else if (f.a_pwd.value == ''){
		alert("<?=$msgstr['pwd_null']?>");
		f.a_pwd.focus();
		return false;

	}else if (f.a_pwd.value.length < 8 && f.a_pwd.value.length > 20){
		alert("<?=$msgstr['pwd_deny']?>");
		f.a_pwd.focus();
		return false;
	
	}else if (!fn_pwdChk(f.a_pwd.value)){
		alert("<?=$msgstr['pwd_deny']?>");
		f.a_pwd.focus();
		return false;
	
	}else if (f.a_pwd_confirm.value == ''){
		alert("<?=$msgstr['pwd_null2']?>");
		f.a_pwd_confirm.focus();
		return false;

	}else if (f.a_pwd.value != f.a_pwd_confirm.value){
		alert("<?=$msgstr['pwd_match']?>");
		f.a_pwd_confirm.focus();
		return false;
	
	}else if (f.a_level.value == ''){
		alert("<?=$msgstr['level_null']?>");
		f.a_level.focus();
		return false;

	}else if (f.a_tel1.value == ''){
		alert("<?=$msgstr['tel_null']?>");
		f.a_tel1.focus();
		return false;

	}else if (f.a_tel2.value == ''){
		alert("<?=$msgstr['tel_null2']?>");
		f.a_tel2.focus();
		return false;

	}else if (f.a_tel3.value == ''){
		alert("<?=$msgstr['tel_null2']?>");
		f.a_tel3.focus();
		return false;

	}else{
		return true;
		
	}
	

}


function submit_ready(){
	if (reg_form_chk()){
		$('#modal-alert').modal();
	}
}


function submit_ok(){
	
	if (reg_form_chk()){
		//alert('전송');
		
		var ajax_url = "/proc/adm_reg_ok.php";	
		var formData = $("#frm").serialize();
		var params = "";
		var msg = "";

		$.ajax({
		   type:"post",
		   url:ajax_url,
		   //data:params,
		   data:formData,
		   dataType:"JSON", // JSON 리턴
		   beforeSend:function(){
				 $('#modal-alert').modal('hide');
		   },
		   success : function(data) {
				// success
				// TODO
				alert(data.rtnmsg);
				if (data.state){
					top.location.href='./?abkind=adm';
				}
		   },
		   complete : function(data) {
				 // 통신이 실패했어도 완료가 되었을 때
				 // TODO
		   },
		   error : function(xhr, status, error) {
				 //alert("통신 에러");
		   },
		   timeout:100000 //응답제한시간 ms
		});
		

	}

}
</script>