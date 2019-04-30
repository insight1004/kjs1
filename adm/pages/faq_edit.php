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
$sql = " SELECT idx, f_cate, f_title, f_content, f_reg_date, f_edit_date, f_state, a_id, f_ip ";
$sql .= " FROM ".$db['faq_table'];
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


<!-- popup 1 modify -->
<div class="pop-window fade" id="modal-modify">
	<div class="alert">
		<div class="alert_con">
			<i class="mte i_error_outline red"></i>
			<p>수정하시겠습니까?</p>
		</div>
		<div class="modal_foot">
			<a href="javascript:faqEdit();" class="b_red">확인</a>
			<a href="javascript:;" data-dismiss="modal" class="b_sgrey">취소</a>
		</div>
	</div>
</div>
<!-- END popup 1 modify //-->

<!-- popup 2 delete -->
<div class="pop-window fade" id="modal-alert">
	<form method="post" action="" name="frmDel" id="frmDel">
	<input type="hidden" name="idx" value="<?=$idx?>">
	<div class="alert">
		<div class="alert_con">
			<i class="mte i_error_outline red"></i>
			<p>삭제하시겠습니까?</p>
		</div>
		<div class="modal_foot">
			<a href="javascript:faqDel();" class="b_red">확인</a>
			<a href="javascript:;" data-dismiss="modal" class="b_sgrey">취소</a>
		</div>
	</div>
	</form>
</div>
<!-- END popup 2 delete //-->

<!-- contents area -->
<div class="con_wrap">
	<!-- my info -->

	<form method="post" action="" name="frm" id="frm">
	<input type="hidden" name="idx" value="<?=$idx?>">

	<textarea name="f_content" style="display:none;" ></textarea>

	<div class="info_wrap">
		<h4 class="title">FAQ 상세</h4>
		<div class="panel mody2">
			<ul>
				<li><h5>작성자 ID</h5></li>
				<li>
					<input type="text" placeholder="작성자 ID" value="<?=$row["a_id"];?>" disabled>
				</li>
				<li><h5>등록일</h5></li>
				<li>
					<input type="text" placeholder="등록일" value="<?=$row["f_reg_date"];?>" disabled>
				</li>
				<li><h5>카테고리</h5></li>
				<li class="select_input">
					<div>
						<select name="f_cate" id="f_cate" class="" <?if($row["f_state"]=="0") echo "disabled style='background:#EAEAE3;'" ;?>>
							<!-- <option value="">=카테고리=</option> -->
							<option value="일반문의" <?if ($row["f_cate"]=="일반문의")echo "selected"; ?>>일반문의</option>
							<option value="사용문의" <?if ($row["f_cate"]=="사용문의")echo "selected"; ?>>사용문의</option>
							<option value="고장문의" <?if ($row["f_cate"]=="고장문의")echo "selected"; ?>>고장문의</option>
						</select>
					</div>
				</li>
				<li><h5>상태</h5></li>
				<li class="select_input">
					<div>
						<select name="f_state" id="f_state" class="" <?if($row["f_state"]=="0") echo "disabled style='background:#EAEAE3;'" ;?>>
							<!-- <option value="">=상태선택=</option> -->
							<option value="1" <?if ($row["f_state"]=="1")echo "selected"; ?>>노출중</option>
							<option value="2" <?if ($row["f_state"]=="2")echo "selected"; ?>>노출안함</option>
							<option value="0" <?if ($row["f_state"]=="0")echo "selected"; ?>>삭제</option>
						</select>
					</div>
				</li>
				
				<li><h5>제목</h5></li>
				<li>
					<input type="text" placeholder="제목" class="mody_tit" name="f_title" id="f_title" maxlength="255"  value="<?=$row["f_title"];?>" <?if($row["f_state"]=="0") echo "disabled"; ?>>
				</li>
				<!-- <li><h5>질문</h5></li>
				<li><textarea name="" id=""></textarea></li> -->
				<li><h5>답변</h5></li>
				<li style="<?if($row["f_state"]=="0"){?>background:#EAEAE3; <?}else{?> background:#ffffff;<?}?> line-height:0px;" disabled>
					<textarea name="ir1" id="ir1" style="width:100%; height:350px; display:none; line-height:0; margin:0; padding:0;" ><?=$row["f_content"];?></textarea>
				</li>
			</ul>
		</div>
	</div>
	</form>

	<!-- button area -->
	<div class="btn_wrap">

		<?if($row["f_state"]!="0"){?>
		<a href="javascript:faqEditSel();" class="b_blue">수정</a>
		<!-- <a href="#modal-alert" data-toggle="modal" class="b_red">삭제</a> -->
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
		<?if($row["f_state"]=="0"){?>
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



function faqEditSel(){
	
	var f = document.frm;

	oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);
	f.f_content.value = document.getElementById("ir1").value;
	var ContentsStr = stripHTMLtag(f.f_content.value.replace(/&nbsp;/gi, ''));
	

	if (f.f_cate.value == ''){
		alert("<?=$msgstr['faq_cate_null']?>");
		f.f_cate.focus();
		return false;
	}else if (f.f_state.value == ''){
		alert("<?=$msgstr['faq_state_null']?>");
		f.f_state.focus();
		return false;
	}else if (f.f_title.value == ''){
		alert("<?=$msgstr['faq_title_null']?>");
		f.f_title.focus();
		return false;
	}else if(ContentsStr == ''){
		alert("<?=$msgstr['faq_con_null']?>");
		return false;
	}else if (ContentsStr.length > 5000){
		alert("<?=$msgstr['faq_con_length']?>");
		return false;
	}else{
		$('#modal-modify').modal();
	}

}

function faqEdit(){

	var ajax_url = "/proc/faq_edit_ok.php";	
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
		    $('#modal-modify').modal('hide');
	   },
	   success : function(data) {
			// success
			// TODO
			alert(data.rtnmsg);
			if (data.state){
				top.location.href='./?abkind=faq';
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



function faqDel(){

	var ajax_url = "/proc/faq_del_ok.php";	
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
		    $('#modal-alert').modal('hide');
	   },
	   success : function(data) {
			// success
			// TODO
			alert(data.rtnmsg);
			if (data.state){
				top.location.href='./?abkind=faq';
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




function stripHTMLtag(string) {
	 var objStrip = new RegExp();
	 objStrip = /[<][^>]*[>]/gi;
	 return string.replace(objStrip, "");
}

</script>