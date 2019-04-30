<?if (!defined('_COOL_')) exit; // 개별 페이지 접근 불가?>

<?
$idx = (isset($_REQUEST['idx']) ? $_REQUEST['idx'] : '');

$page = (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1);

$f_start = (isset($_REQUEST['f_start']) ? $_REQUEST['f_start'] : '');
$f_end = (isset($_REQUEST['f_end']) ? $_REQUEST['f_end'] : '');
$f_kind = (isset($_REQUEST['f_kind']) ? $_REQUEST['f_kind'] : '');
$f_txt = (isset($_REQUEST['f_txt']) ? $_REQUEST['f_txt'] : '');


//DB 객체 생성
$con_db = db_connect();

//SQL
$sql = " SELECT idx, q_title, q_content, q_usr, q_usr_email, q_date, q_usrip, q_acontent, q_reg_date, q_state, q_email_state, q_email_date, q_del_memo, q_del_date, a_id, q_ip ";
$sql .= " FROM ".$db['qna_table'];
$sql .= " WHERE idx=".$idx;
//echo $sql;


$result = $con_db->query($sql);

if (mysqli_num_rows($result) > 0) {
	$row = $result->fetch_assoc();
}else{
	echo "<script>";
	echo "	alert('".$msgstr['data_null']."');";
	echo "	top.location.href = './?abkind=".$abkind."';";
	echo "</script>";
}

?>

<script src="../plugins/smarteditor2/js/service/HuskyEZCreator.js" type="text/javascript" charset="euc-kr"></script>


<!-- popup 1 confirm -->
<div class="pop-window fade" id="modal-alert">
	<div class="alert alert2">
		<div class="alert_con">
			<i class="mte i_error_outline red"></i>
			<p>
				등록된 답변은 수정이 불가하며, 문의자에게 이메일로 발송됩니다. 답변을 등록 하시겠습니까?
			</p>
		</div>
		<div class="modal_foot">
			<a href="javascript:answerReg();" class="b_red">확인</a>
			<a href="javascript:;" data-dismiss="modal" class="b_sgrey">취소</a>
		</div>
	</div>
</div>
<!-- END popup 1 confirm //-->

<!-- popup 2 del -->
<div class="pop-window fade" id="modal-del">
	<form method="post" action="" name="frmDel" id="frmDel">
	<input type="hidden" name="idx" value="<?=$idx?>">
	<div class="mban_input">
		<!-- head -->
		<div class="input_head">
			<h4>답변 제외 사유</h4>
			<a href="javascript:;" data-dismiss="modal"><i class="mte i_close mte-2x"></i></a>
		</div>
		<!-- con -->
		<div class="input_con type3">
			<textarea name="q_del_memo" id="q_del_memo" rows="2" placeholder="답변 제외 사유를 입력하세요" style="resize: none;"></textarea>
		</div>
		<!-- foot -->
		<div class="modal_foot">
			<a href="javascript:qnaDel();" class="b_red">답변 제외</a>
			<a href="javascript:;" data-dismiss="modal" class="b_sgrey">취소</a>
		</div>
	</div>
	</form>
</div>
<!-- END popup 2 del //-->



<!-- contents area -->
<div class="con_wrap">
	<!-- my info -->

	<form method="post" action="" name="frm" id="frm">
	<input type="hidden" name="idx" value="<?=$idx?>">

	<textarea name="q_acontent" style="display:none;" ></textarea>


	<div class="info_wrap">
		<h4 class="title">1:1문의 상세</h4>
		<div class="panel mody2">
			<ul>
				<li><h5>문의자 명</h5></li>
				<li><input type="text" placeholder="문의자 명" value="<?=$row["q_usr"];?>" disabled></li>
				<li><h5>문의자 이메일</h5></li>
				<li><input type="text" placeholder="문의자 이메일" value="<?=$row["q_usr_email"];?>" disabled></li>
				
				<li><h5>문의 일시</h5></li>
				<li><input type="text" placeholder="문의 일시" value="<?=$row["q_date"];?>" disabled></li>
				<li></li>
				<li></li>
				<li><h5>제목</h5></li>
				<li><input type="text" placeholder="제목" class="mody_tit" value="<?=$row["q_title"];?>" disabled></li>
				<li><h5>문의 내용</h5></li>
				<li><textarea name="" id="" disabled><?=$row["q_content"];?></textarea></li>
				
				<li><h5>첨부파일</h5></li>
				<li class="attach_file">

					<?
					$result = mysqli_query($con_db, "SELECT idx, filename FROM ".$db['qna_file_table']." WHERE q_idx=".$idx);
					if(mysqli_num_rows($result) > 0) {
						
						$z = 1;
						while($row2 = $result->fetch_assoc()){
						?>
							
							<a href="/files/qna/<?=$row2["filename"];?>" target="_blank">
								<i class="mte i_attach_file mte-1x vam"></i><?=$row2["filename"];?>
							</a>

						<?
						$z++;
						}?>

					<?}?>
				</li>
				
				<li><h5>상태</h5></li>
				<li class="select_input ha_wid">
					<div>
						<select name="q_state" id="q_state" class="" <?if($row["q_state"]=="0" || $row["q_state"]=="10") echo "disabled style='background:#EAEAE3;'" ;?>>
							<!-- <option value="">=상태선택=</option> -->
							<option value="1" <?if ($row["q_state"]=="1")echo "selected"; ?>>답변대기</option>
							<option value="10" <?if ($row["q_state"]=="10")echo "selected"; ?>>답변완료</option>
							<option value="0" <?if ($row["q_state"]=="0")echo "selected"; ?>>답변제외</option>
						</select>
					</div>
				</li>
				<li><h5>답변 일시</h5></li>
				<li class="ha_wid"><input type="text" placeholder="답변 일시" <?if ($row["q_reg_date"]!=""){?> value="<?=$row["q_reg_date"]?>" <?}else{?> value="-"<?}?> disabled></li>
				<li><h5>답변 발송</h5></li>
				<li class="input_wid"><input type="text" placeholder="답변 발송"  disabled
					
					<?
					switch ($row["q_email_state"]) {
						case '10':
							echo 'value="성공"';
							break;
						case '1':
							echo 'value="발송대기"';
							break;
						case '0':
							echo 'value="실패"';
							break;
					}
					?>
				
				></li>

				
				<?if($row["q_state"]=="0"){?>
				<li><h5>답변 제외 사유</h5></li>
				<li><input type="text" placeholder="답변 제외 사유" class="mody_tit" value="<?=$row["q_del_memo"]?>" disabled></li>
				<?}?>
				
				
				<li><h5>답변 내용</h5></li>
				<li style="<?if($row["q_state"]=="0" || $row["q_state"]=="10"){?>background:#EAEAE3; <?}else{?> background:#ffffff;<?}?> line-height:0px;" >
					<textarea name="ir1" id="ir1" style="width:100%; height:350px; display:none; line-height:0; margin:0; padding:0;" ><?=$row["q_acontent"];?></textarea>
				</li>


			</ul>
		</div>
	</div>
	
	</form>

	<!-- button area -->
	<div class="btn_wrap">
		
		<?if($row["q_state"]=="10" && $row["q_email_state"]=="0"){?>
		<a href="javascript:emailSend();"  class="b_blue">재발송</a>
		<?}?>

		<?if($row["q_state"]=="1"){?>
		<a href="javascript:answerSel();"  class="b_blue">답변 등록</a>
		<?}?>

		<?if($row["q_state"]!="0"){?>
		<a href="#modal-del" data-toggle="modal" class="b_red">답변 제외</a>
		<?}?>

		<a href="./?abkind=<?=$abkind?>&f_start=<?=$f_start;?>&f_end=<?=$f_end;?>&f_kind=<?=$f_kind;?>&f_txt=<?=$f_txt;?>&page=<?=$page;?>" class="b_sgrey">목록</a>
	</div>
	<!-- END button area //-->
</div>
<!-- END contents area //-->



<script type="text/javascript">
var oEditors = [];

// 추가 글꼴 목록
//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];

nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "ir1",
	sSkinURI: "../plugins/smarteditor2/SmartEditor2Skin.html",	
	htParams : {
		<?if($row["q_state"]=="0" || $row["q_state"]=="10"){?>
		bUseToolbar : false,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseModeChanger : false,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
		bUseVerticalResizer : false,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
		<?}else{?>
		bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
		bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
		<?}?>
		//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
		fOnBeforeUnload : function(){
			//alert("완료!");
		}
	}, //boolean
	fOnAppLoad : function(){
		//예제 코드
		//oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
	},
	fCreator: "createSEditor2"
});

function pasteHTML() {
	var sHTML = "<span style='color:#FF0000;'>이미지도 같은 방식으로 삽입합니다.<\/span>";
	oEditors.getById["ir1"].exec("PASTE_HTML", [sHTML]);
}

function showHTML() {
	var sHTML = oEditors.getById["ir1"].getIR();
	alert(sHTML);
}
	
function submitContents(elClickedObj) {
	oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
	
	// 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
	try {
		elClickedObj.form.submit();
	} catch(e) {}
}

function setDefaultFont() {
	var sDefaultFont = '돋음';
	var nFontSize = 24;
	oEditors.getById["ir1"].setDefaultFont(sDefaultFont, nFontSize);
}



function answerSel(){
	
	var f = document.frm;

	oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);
	f.q_acontent.value = document.getElementById("ir1").value;
	var ContentsStr = stripHTMLtag(f.q_acontent.value.replace(/&nbsp;/gi, ''));

	if (f.q_state.value != '10'){
		alert("<?=$msgstr['qna_state_deny']?>");
		f.q_state.focus();
		return false;

	}else if(ContentsStr == ''){
		alert("<?=$msgstr['qna_answer_null']?>");
		return false;

	}else if (ContentsStr.length > 5000){
		alert("<?=$msgstr['qna_answer_length']?>");
		return false;
	}else{
		$('#modal-alert').modal();
	}

}

function answerReg(){

	var ajax_url = "/proc/qna_answer_ok.php";	
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
				top.location.href='./?abkind=qna';
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


//답변 제외
function qnaDel(){

	var f = document.frmDel;

	if (f.q_del_memo.value == ''){
		alert("<?=$msgstr['qna_memo_null']?>");
		f.q_del_memo.focus();
		return false;

	}else if (f.q_del_memo.value.length > 100){
		alert("<?=$msgstr['qna_memo_length']?>");
		f.q_del_memo.focus();
		return false;

	}else{

		var ajax_url = "/proc/qna_del_ok.php";	
		var formData = $("#frmDel").serialize();
		var params = "";
		var msg = "";

		$.ajax({
		   type:"post",
		   url:ajax_url,
		   //data:params,
		   data:formData,
		   dataType:"JSON", // JSON 리턴
		   beforeSend:function(){
				 $('#modal-del').modal('hide');
		   },
		   success : function(data) {
				// success
				// TODO
				alert(data.rtnmsg);
				if (data.state){
					top.location.href='./?abkind=qna';
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


function stripHTMLtag(string) {
	 var objStrip = new RegExp();
	 objStrip = /[<][^>]*[>]/gi;
	 return string.replace(objStrip, "");
}

</script>