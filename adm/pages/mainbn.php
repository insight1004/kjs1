<?if (!defined('_COOL_')) exit; // 개별 페이지 접근 불가?>

<!-- popup 1 delete -->
<div class="pop-window fade" id="modal-alert">
	<form method="post" action="" name="frmDel" id="frmDel">
	<input type="hidden" name="mb_idx" value="">
	<div class="alert">
		<div class="alert_con">
			<i class="mte i_error_outline red"></i>
			<p>선택하신 메인이미지를 삭제하시겠습니까?</p>
		</div>
		<div class="modal_foot">
			<a href="javascript:bnDel();" class="b_red">확인</a>
			<a href="javascript:;" data-dismiss="modal" class="b_sgrey">취소</a>
		</div>
	</div>
	</form>
</div>
<!-- END popup 1 delete //-->


<!-- popup 2 modify -->
<div class="pop-window fade" id="modal-modify">
	<form method="post" action="" name="frmEdit" id="frmEdit">
	<input type="hidden" name="mb_idx" value="">
	<div class="mban_input">
		<!-- head -->
		<div class="input_head">
			<h4>메인 배너 수정</h4>
			<a href="javascript:;" data-dismiss="modal"><i class="mte i_close mte-2x"></i></a>
		</div>
		<!-- con -->
		<div class="input_con">
			<ul>
				<li><h5>현재 이미지</h5></li>
				<li><input type="text" placeholder="현재 이미지" name="now_img" id="now_img" disabled></li>
				<li><h5>변경할 이미지</h5></li>
				<li>
					<div class="attach">
						<input type="text" name="file_name" id="file1" placeholder="이미지 등록하기" readonly>
						<label for="file_img1">
							<span class="b_file">첨부</span>
						</label>
						<input type="file" name="new_mb_file[]" id="file_img1" onchange="document.getElementById('file1').value=this.value;">
						<a href="javascript:fileCancel('frmEdit');" class="b_red">삭제</a>
					</div>
				</li>
				<li><h5>링크 사용</h5></li>
				<li class="input_chk">
					<div class="radio radio-css radio-danger">
						<input type="radio" name="mb_target" id="radio_css_1" checked value="no" onclick="linkUse('frmEdit', 'no');">
						<label for="radio_css_1">링크없음</label>
					</div>
					<div class="radio radio-css radio-danger">
						<input type="radio" name="mb_target" id="radio_css_2" value="_self" onclick="linkUse('frmEdit', '_self');">
						<label for="radio_css_2">현재 창</label>
					</div>
					<div class="radio radio-css radio-danger">
						<input type="radio" name="mb_target" id="radio_css_3" value="_blank" onclick="linkUse('frmEdit', '_blank');">
						<label for="radio_css_3">새 창</label>
					</div>
				</li>

				</li>
				<li><h5>링크 URL</h5></li>
				<li><input type="text" placeholder="http://" name="mb_link" disabled value=""></li>
			</ul>
		</div>
		<!-- foot -->
		<div class="modal_foot">
			<a href="javascript:bnEdit();" class="b_blue">수정</a>
			<a href="javascript:;" data-dismiss="modal" class="b_sgrey">취소</a>
		</div>
	</div>
	</form>
</div>
<!-- END popup 2 modify //-->


<!-- popup 3 add -->
<div class="pop-window fade" id="modal-add">
	<form method="post" action="" name="frm" id="frm" enctype="multipart/form-data">
	<div class="mban_input">
		<!-- head -->
		<div class="input_head">
			<h4>메인 배너 등록</h4>
			<a href="javascript:;" data-dismiss="modal"><i class="mte i_close mte-2x"></i></a>
		</div>
		<!-- con -->
		<div class="input_con">
			<ul>
				<li><h5>등록할 이미지</h5></li>
				<li>
					<div class="attach">
						<input type="text" name="file_name" id="file2" placeholder="이미지 등록하기" readonly>
						<label for="file_img2">
							<span class="b_file">첨부</span>
						</label>
						<input type="file" name="mb_file[]" id="file_img2" onchange="document.getElementById('file2').value=this.value;">
						<a href="javascript:fileCancel('frm');" class="b_red">삭제</a>
					</div>
				</li>
				<li><h5>링크 사용</h5></li>
				<li class="input_chk">
					<div class="radio radio-css radio-danger">
						<input type="radio" name="mb_target" id="radio_css_4" checked value="no" onclick="linkUse('frm', 'no');">
						<label for="radio_css_4">링크없음</label>
					</div>
					<div class="radio radio-css radio-danger">
						<input type="radio" name="mb_target" id="radio_css_5" value="_self" onclick="linkUse('frm', '_self');">
						<label for="radio_css_5">현재 창</label>
					</div>
					<div class="radio radio-css radio-danger">
						<input type="radio" name="mb_target" id="radio_css_6" value="_blank" onclick="linkUse('frm', '_blank');">
						<label for="radio_css_6">새 창</label>
					</div>
				</li>
				<li><h5>링크 URL</h5></li>
				<li><input type="text" placeholder="http://" name="mb_link" disabled ></li>
			</ul>
		</div>
		<!-- foot -->
		<div class="modal_foot">
			<a href="javascript:bnReg();" class="b_blue">등록</a>
			<a href="javascript:;" data-dismiss="modal" class="b_sgrey">취소</a>
		</div>
	</div>
	</form>
</div>
<!-- END popup 3 add //-->



<!-- contents area -->
<div class="con_wrap">
	<!-- main banner -->
	<div class="mban_wrap">
		<h4 class="title">메인이미지 관리</h4>

		<!-- main banner edit --> 
		<div class="mban_edit">
			
			<?
			$sql = " SELECT idx, mb_link, mb_target, mb_reg_date, mb_edit_date, mb_state ";
			$sql .= " FROM ".$db['main_bn_table'];
			$sql .= " WHERE mb_state=1 ";
			$sql .= " ORDER BY idx DESC ";
			
			//DB 객체 생성
			$con_db = db_connect();

			$result = mysqli_query($con_db, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				$i = 0;
				while($row = $result->fetch_assoc()){

					//이미지 조회
					$getFile = mysqli_fetch_assoc(mysqli_query($con_db, "SELECT filename FROM ".$db['main_bn_file_table']." WHERE mb_idx=".$row['idx']));
					$filename = $getFile['filename'];

				?>
					<div class="edit_ban">
						<a href="#modal-alert" class="btn_del" onclick="bnDelSel(<?=$row['idx'];?>)">삭제</a>
						<a href="#modal-modify" class="btn_mody" onclick="bnEditSel(<?=$row['idx'];?>, '<?=$filename;?>', '<?=$row['mb_target'];?>', '<?=$row['mb_link'];?>');">수정</a>
						<img src="../../files/mainbn/<?=$filename;?>" alt="main banner 1">
					</div>
				<?
				$i++;
				}
			}
			?>
						
			<?if($i<3){?>
			<div class="mban_insert">
				<a href="#modal-add" data-toggle="modal">
					<i class="mte i_image mte-5x"></i><p>이미지 등록</p>
				</a>
			</div>
			<?}?>
			

		</div>
		<!-- END main banner edit -->
	</div>
	<!-- END main banner //-->
</div>

<!-- END contents area //-->
<div class="pt50"></div>


<script type="text/javascript">


//배너등록
function bnReg(){
	var f = document.frm;


	var fileinput = $('#frm input[name="mb_file[]"]');
    var filecnt = 0;

    for (var i = 0; i < fileinput.length; i++) {
        if (fileinput[i].value) {
           filecnt++;
        }
    } 

	
	if(filecnt < 1){
		alert("<?=$msgstr['mb_file_null']?>");
		return false;

	}else if((f.mb_target.value=="_self" || f.mb_target.value=="_blank") && f.mb_link.value==""){
		alert("<?=$msgstr['mb_url_null']?>");
		f.mb_link.focus();
		return false;

	}else{

		if(confirm("<?=$msgstr['mb_reg_confirm']?>")){
			
			var ajax_url = "/proc/mainbn_reg_ok.php";	
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
			   beforeSend:function(){
					$("#frm input[name='file_name']").val('');
					$("#file_img2").val("");
					$('#modal-add').modal('hide');
			   },
			   success : function(data) {
					// success
					// TODO
					alert(data.rtnmsg);
					if (data.state){
						top.location.reload();
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


//배너선택 (수정)
function bnEditSel(idx, filename, target, linkurl){
	//값 셋팅
	$("#frmEdit input[name=mb_idx]").val(idx);
	$("#frmEdit input[name=now_img]").val(filename);
	$("#frmEdit input[name=mb_link]").val(linkurl);

	if (target=="no"){
		$("#radio_css_1").prop("checked", true)
		$("#frmEdit input[name=mb_link]").attr("disabled", true);
	}else if (target=="_self"){
		$("#radio_css_2").prop("checked", true)
		$("#frmEdit input[name=mb_link]").attr("disabled", false);
	}else if (target=="_blank"){
		$("#radio_css_3").prop("checked", true)
		$("#frmEdit input[name=mb_link]").attr("disabled", false);
	}

	$('#modal-modify').modal();
	
}


//배너수정
function bnEdit(){
	var f = document.frmEdit;


	if((f.mb_target.value=="_self" || f.mb_target.value=="_blank") && f.mb_link.value==""){
		alert("<?=$msgstr['mb_url_null']?>");
		f.mb_link.focus();
		return false;

	}else{

		if(confirm("<?=$msgstr['mb_edit_confirm']?>")){
			
			var ajax_url = "/proc/mainbn_edit_ok.php";	
			var formData = new FormData($("#frmEdit")[0]);
			var params = "";
			var msg = "";

			$.ajax({
			   type:"post",
			   mimeType: 'multipart/form-data',
			   url:ajax_url,
			   //data:params,
			   data:formData,
			   dataType:"JSON", // JSON 리턴
			   beforeSend:function(){
					$("#frmEdit input[name='file_name']").val('');
					$("#file_img1").val("");
					$('#modal-add').modal('hide');
			   },
			   success : function(data) {
					// success
					// TODO
					alert(data.rtnmsg);
					if (data.state){
						top.location.reload();
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


//배너선택 (삭제)
function bnDelSel(idx){
	
	//값 셋팅
	$("#frmDel input[name='mb_idx']").val(idx);
	$('#modal-alert').modal();
}

//배너삭제
function bnDel(){

	if(confirm("<?=$msgstr['mb_del_confirm']?>")){
			
		var ajax_url = "/proc/mainbn_del_ok.php";	
		var formData = new FormData($("#frmDel")[0]);
		var params = "";
		var msg = "";

		$.ajax({
		   type:"post",
		   url:ajax_url,
		   //data:params,
		   data:formData,
		   dataType:"JSON", // JSON 리턴
		   beforeSend:function(){
				$("#frmDel input[name='mb_idx']").val('');
				$('#modal-alert').modal('hide');
		   },
		   success : function(data) {
				// success
				// TODO
				alert(data.rtnmsg);
				if (data.state){
					top.location.reload();
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


//링크사용
function linkUse(frm, kind){
	if(kind=="no"){
		$("#"+frm+" input[name=mb_link]").attr("disabled", true); //설정
	}else if(kind=="_self" || kind=="_blank"){
		$("#"+frm+" input[name=mb_link]").attr("disabled", false); //해제
	}
}


//파일 선택 취소
function fileCancel(frm){

	if(frm=='frm'){

		if($("#file_img2").val()==''){
			alert("<?=$msgstr['img_del_null']?>");
		}else{
			$("#"+frm+" input[name=file_name]").val('');
			$("#file_img2").val("");
		}

	}else if(frm=='frmEdit'){

		if($("#file_img1").val()==''){
			alert("<?=$msgstr['img_del_null']?>");
		}else{
			$("#"+frm+" input[name=file_name]").val('');
			$("#file_img1").val("");
		}

	}
	
}

</script>