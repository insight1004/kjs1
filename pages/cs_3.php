<?if (!defined('_COOL_')) exit; // 개별 페이지 접근 불가?>
<!-- Main Slider banner -->
<div class="sub_top cs cs3"></div>
<!-- END Main Slider banner -->

<!-- popup -->
<div class="pop-window fade" id="modal-alert">
	<div class="alert">
		<div class="alert_con">
			<i class="mte i_check"></i>
			<p>1:1 문의가 완료되었습니다.<br>입력하신 이메일로 답변 드리겠습니다.</p>
		</div>
		<div class="modal_foot">
			<a href="javascript:;" data-dismiss="modal">확인</a>
		</div>
	</div>
</div>
<!-- END popup //-->

<!-- contents -->
<div class="sub_con">
	<div class="app_tit">
		<h1>1:1 문의</h1>
		<p>궁금하신 점이 있으신가요? 1:1 문의를 남겨주시면 메일로 답변 드리겠습니다.</p>
	</div>

	<form method="post" name="frm" id="frm" enctype='multipart/form-data'>
	
	<!-- input area -->
	<div class="input_wrap">
		<div>
			<label>문의자 명</label>
			<div class="input_field"><input type="text" name="q_usr" id="q_usr" placeholder="문의자 명을 입력하세요." maxlength="20" ></div>
		</div>
		<div>
			<label>답변 받으실 이메일</label>
			<div class="input_field"><input type="text" name="q_usr_email" id="q_usr_email" placeholder="이메일 주소를 입력하세요." onkeydown="fn_hanLimit(this)" maxlength="100"></div>
		</div>
		<div>
			<label>제목</label>
			<div class="input_field"><input type="text" name="q_title" id="q_title" placeholder="제목을 입력하세요." maxlength="30"></div>
		</div>
		<div>
			<label>문의 내용</label>
			<div class="input_field">
				<textarea type="text" name="q_content" id="q_content" placeholder="궁금하신 내용을 입력하세요." onblur="conCntCheck();"></textarea>
				<!-- <p class="intext">0/1000자</p> -->
				<p class="intext"><span id="wordcnt" style="color:#ff3300">0</span> / <span class="limit_wordcnt" style="color:#969696"></span></p>
			</div>
			
		</div>
		<div>
			<label>파일첨부</label>
			<div class="input_field attach">
				<input type="text" name="file1" id="file1" placeholder="이미지 등록하기" readonly>
				<label for="file_img1">
					<span class="b_file">첨부</span>
				</label>
				<input type="file" name="q_file[]" id="file_img1" onchange="file_change('file1');">
				<a href="javascript:fileCancel('file_img1');" class="btn_del">삭제</a>


				<input type="text" name="file2" id="file2" placeholder="이미지 등록하기" readonly>
				<label for="file_img2">
					<span class="b_file sec">첨부</span>
				</label>
				<input type="file" name="q_file[]" id="file_img2" onchange="file_change('file2');">
				<a href="javascript:fileCancel('file_img2');" class="btn_del2">삭제</a>


				<p>※ 이미지는 5MB 미만의 JPG, JPEG, PNG, GIF 형식 파일을 2개까지 업로드 가능합니다.</p>
				<p>※ 동영상은 300MB 미만의 AVI, MP4, MOV 형식 파일을 2개까지 업로드 가능합니다.</p>
				<p style="color:#ff3300">※ 현재 테스트 서버에서는 최대 20MB 까지 허용합니다.</p>

			</div>
		</div>
		<div>
			<label>개인정보취급방침 동의</label>
			<div class="input_field checkbox checkbox-css checkbox-danger">
				<input type="checkbox" name="agree" id="checkbox_css_1" value="" />
				<label for="checkbox_css_1">개인정보취급방침에 동의 합니다.</label>
				
				<iframe src="pages/privacy.html" frameborder="0"></iframe>
			</div>
		</div>
	</div>


	</form>
	
	<div class="input_btn">
		<a href="javascript:cancel();" class="b_cancel">취소</a>
		<a href="javascript:submit_ok();" class="b_answer" >1:1 문의하기</a>
	</div>
	<!-- END input area //-->
</div>
<!-- END contents //-->


<script type="text/javascript">

//폼 항목 체크
function reg_form_chk(){
	
	var f = document.frm;
	
	//이메일 필드 공백제거
	f.q_usr_email.value = fn_trim(f.q_usr_email.value);


	if (f.q_usr.value == ''){
		alert("<?=$msgstr['qna_name_null']?>");
		f.q_usr.focus();
		return false;
	
	}else if (f.q_usr_email.value == ''){
		alert("<?=$msgstr['qna_email_null']?>");
		f.q_usr_email.focus();
		return false;

	}else if (!fn_emailChk(f.q_usr_email.value)){
		alert("<?=$msgstr['qna_email_deny']?>");
		f.q_usr_email.focus();
		return false;

	}else if (f.q_title.value == ''){
		alert("<?=$msgstr['qna_title_null']?>");
		f.q_title.focus();
		return false;

	}else if (f.q_content.value == ''){
		alert("<?=$msgstr['qna_content_null']?>");
		f.q_content.focus();
		return false;
	
	}else if (f.q_content.value.length > 1000){
		alert("<?=$msgstr['qna_content_length']?>");
		f.q_content.focus();
		return false;
	
	}else if (!f.agree.checked){
		alert("<?=$msgstr['qna_agree_null']?>");
		f.agree.focus();
		return false;
	

	}else{
		return true;
		
	}
}


function submit_ok(){
	
	if (reg_form_chk()){
		//alert('전송');

		if(confirm("<?=$msgstr['qna_reg_confirm']?>")){
			
			var ajax_url = "/proc/qna_reg_ok.php";	
			var formData = new FormData($("#frm")[0]);
			var params = "";
			var msg = "";

			$.ajax({
			   type:"post",
			   mimeType: 'multipart/form-data',
			   url:ajax_url,
			   //data:params,
			   data:formData,
			   dataType:"JSON", // JSON 리턴
			   beforeSend:function(){},
			   success : function(data) {
					// success
					// TODO
					if (data.state){
						$('#modal-alert').modal();
						cancel();
					}else{
						alert(data.rtnmsg);
					}
			   },
			   complete : function(data) {
					 // 통신이 실패했어도 완료가 되었을 때
					 // TODO
			   },
			   error : function(xhr, status, error) {
					 //alert("통신 에러");
			   },
			   cache: false,
			   contentType: false,
			   processData: false,
			   timeout:100000 //응답제한시간 ms
			});

		}
		

	}

}


//테스트
function submit_test(){
	
	var f = document.frm;
	f.action = "/proc/qna_reg_ok.php";
	f.submit();

}

function cancel(){
	
	$("#frm input[name=q_usr]").val('');
	$("#frm input[name=q_usr_email]").val('');
	$("#frm input[name=q_title]").val('');
	$("#frm textarea[name=q_content]").val('');
	$("#frm input[name=file1]").val('');
	$("#frm input[name=file2]").val('');
	$("#frm #file_img1").val('');
	$("#frm #file_img2").val('');
	$("#frm input[name=agree]").prop('checked', false);
	$('#wordcnt').text("0");
	<?if(isMobile()){?>
		$("body").scrollTop(0);
	<?}?>


}


function file_change(kind){
	var fileName;
	var f = document.frm;

	if(kind=='file1'){
		fileName = document.getElementById('file_img1').value;
		$('#file1').val(fileName.substring(fileName.lastIndexOf("\\")+1, fileName.length));
	}else if(kind=='file2'){
		fileName = document.getElementById('file_img2').value;
		$('#file2').val(fileName.substring(fileName.lastIndexOf("\\")+1, fileName.length));
	}
		
}


//파일 선택 취소
function fileCancel(kind){

	if(kind=='file_img1'){

		if($("#file_img1").val()==''){
			alert("<?=$msgstr['file_del_null']?>");
		}else{
			$("#frm input[name=file1]").val('');
			$("#file_img1").val("");
		}


	}else if(kind=='file_img2'){

		if($("#file_img2").val()==''){
			alert("<?=$msgstr['file_del_null']?>");
		}else{
			$("#frm input[name=file2]").val('');
			$("#file_img2").val("");
		}

	}

}


//메시지 제한 글자수 DP
$(document).ready(function () {
	
	$('.limit_wordcnt').text('1,000 자');  //메시지창에 적용

	$('#q_content').keyup(function(){
		
		if ($('#q_content').val().length > 1000){
			alert("<?=$msgstr['qna_content_length']?>");
			$('#q_content').val($('#q_content').val().substring(0, 1000));
		}

		//글자수 표시
		$('#wordcnt').text($('#q_content').val().length);
		
	});

});


function conCntCheck(){
	
	if ($('#q_content').val().length > 1000){
		alert("<?=$msgstr['qna_content_length']?>");
		$('#q_content').val($('#q_content').val().substring(0, 1000));
	}

	//글자수 표시
	$('#wordcnt').text($('#q_content').val().length);

}
</script>