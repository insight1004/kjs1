<?if (!defined('_COOL_')) exit; // 개별 페이지 접근 불가?>
<?
$id = (isset($_REQUEST['id']) ? $_REQUEST['id'] : '');

$page = (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1);

$f_start = (isset($_REQUEST['f_start']) ? $_REQUEST['f_start'] : '');
$f_end = (isset($_REQUEST['f_end']) ? $_REQUEST['f_end'] : '');
$f_kind = (isset($_REQUEST['f_kind']) ? $_REQUEST['f_kind'] : '');
$f_txt = (isset($_REQUEST['f_txt']) ? $_REQUEST['f_txt'] : '');


//DB 객체 생성
$con_db = db_connect();

//SQL
$sql = " SELECT a_id, a_name, a_level, a_tel, a_reg_date, a_state, a_del_memo, a_del_date, a_reg_id, a_ip ";
$sql .= " FROM ".$db['admin_table'];
$sql .= " WHERE a_id='".$id."'";
//echo $sql;

$result = $con_db->query($sql);
$row = $result->fetch_assoc();


$a_tel1 = "";
$a_tel2 = "";
$a_tel3 = "";

//전화번호 분리
if($row["a_tel"] != "" && substr_count($row["a_tel"], "-") == 2){
	
	$telcut =explode('-' , $row["a_tel"]);

	$a_tel1 = $telcut[0];
	$a_tel2 = $telcut[1];
	$a_tel3 = $telcut[2];
}

?>


<!-- popup 1 modify -->
<div class="pop-window fade" id="modal-alert">
	<div class="alert">
		<div class="alert_con">
			<i class="mte i_error_outline red"></i>
			<p>수정하시겠습니까?</p>
		</div>
		<div class="modal_foot">
			<a href="javascript:infoEdit();" class="b_red">확인</a>
			<a href="javascript:;" data-dismiss="modal" class="b_sgrey">취소</a>
		</div>
	</div>
</div>
<!-- END popup 1 modify //-->


<!-- popup 2 pwd modify -->
<div class="pop-window fade" id="modal-pw">
	<form method="post" action="" name="frmPwd" id="frmPwd">
	<input type="hidden" name="a_id" value="<?=$row["a_id"];?>">
	<div class="mban_input">
		<!-- head -->
		<div class="input_head">
			<h4>변경할 비밀번호 입력</h4>
			<a href="javascript:;" data-dismiss="modal"><i class="mte i_close mte-2x"></i></a>
		</div>
		<!-- con -->
		<div class="input_con type2">
			<ul>
				<li><input type="password" name="a_pwd" id="a_pwd" maxlength="20" placeholder="비밀번호를 입력하세요(영어/숫자/특문2가지 조합, 8자 이상)"></li>
				<li><input type="password" name="a_pwd_confirm" id="a_pwd_confirm" maxlength="20" placeholder="비밀번호를 다시 한번 입력하세요"></li>
			</ul>
		</div>
		<!-- foot -->
		<div class="modal_foot">
			<a href="javascript:pwdEdit();" class="b_blue">비밀번호 변경</a>
			<a href="javascript:;" data-dismiss="modal" class="b_sgrey">취소</a>
		</div>
	</div>
	</form>
</div>
<!-- END popup 2 pwd modify //-->

<!-- popup 3 ID del -->
<div class="pop-window fade" id="modal-id-del">
	<form method="post" action="" name="frmDel" id="frmDel">
	<input type="hidden" name="a_id" value="<?=$row["a_id"];?>">
	<div class="mban_input">
		<!-- head -->
		<div class="input_head">
			<h4>아이디 삭제 사유</h4>
			<a href="javascript:;" data-dismiss="modal"><i class="mte i_close mte-2x"></i></a>
		</div>
		<!-- con -->
		<div class="input_con type3">
			<ul>
				<li><h5>아이디</h5></li>
				<li><?=$row["a_id"];?></li>
				<li><textarea name="a_del_memo" id="a_del_memo" rows="2" placeholder="삭제 사유를 입력하세요" style="resize: none;"></textarea></li>
			</ul>
		</div>
		<!-- foot -->
		<div class="modal_foot">
			<a href="javascript:idDel();" class="b_red">삭제</a>
			<a href="javascript:;" data-dismiss="modal" class="b_sgrey">취소</a>
		</div>
	</div>
	</form>
</div>
<!-- END popup 3 ID del //-->

<!-- contents area -->
<div class="con_wrap">
	<!-- my info -->

	<form method="post" action="" name="frm" id="frm">
	<input type="hidden" name="a_id" value="<?=$row["a_id"];?>">
	<div class="info_wrap">
		<h4 class="title">관리자 상세정보</h4>
		<div class="panel">
			<ul>
				<li><h5>아이디</h5></li>
				<li><input type="text" placeholder="" value="<?=$row["a_id"];?>" disabled></li>
				<li><h5>관리자 명</h5></li>
				<li><input type="text" name="a_name" id="a_name" placeholder="" value="<?=$row["a_name"];?>" <?if($row["a_state"]==0)echo "disabled";?> maxlength="20"></li>
				<li><h5>분류</h5></li>
				<li class="select_input">
					<div>
						<select name="a_level" id="a_level" class="" <?if($row["a_state"]==0){?> disabled style="background:#EAEAE3;" <?}?> >
							<option value="normal" <?if($row["a_level"]=="normal")echo "selected"?>>일반관리자</option>
							<option value="super" <?if($row["a_level"]=="super")echo "selected"?>>슈퍼관리자</option>
						</select>
					</div>
				</li>
				<li><h5>연락처</h5></li>
				<li class="phone_input">
					<div class="mr5">
						<select name="a_tel1" id="a_tel1" class="" <?if($row["a_state"]==0){?> disabled style="background:#EAEAE3;" <?}?>>
							 <?php echo option_str($tel_txt, $tel_value, $a_tel1); ?>
						</select>
					</div>
					<div>
						- <input type="text" name="a_tel2" id="a_tel2" value="<?=$a_tel2;?>"  <?if($row["a_state"]==0)echo "disabled";?> maxlength="4" onkeydown="fn_onlyNumber(this)"> - <input type="text" name="a_tel3" id="a_tel3" value="<?=$a_tel3;?>"  <?if($row["a_state"]==0)echo "disabled";?> maxlength="4" onkeydown="fn_onlyNumber(this)">
					</div>
				</li>
				<li><h5>현재 상태</h5></li>
				<li><input type="text" placeholder="" disabled
					<?
					switch ($row["a_state"]) {
						case '0':
							echo 'value="삭제"';
							break;
						case '1':
							echo 'value="활동중"';
							break;
					}
					?>
					>
				</li>
				<li><h5>삭제 사유</h5></li>
				<!-- <li><input type="text" placeholder="" value="<?=$row["a_del_memo"];?>" disabled></li> -->
				<li><textarea name="" id="" cols="30" rows="1" style="width:285px; resize: none;" disabled><?=$row["a_del_memo"];?></textarea></li>
			</ul>
		</div>
	</div>
	
	</form>

	<!-- button area -->
	<div class="btn_wrap">
		<?if ($row["a_state"]==1){?>
		<a href="#modal-pw" data-toggle="modal" class="b_yellow">비밀번호 변경</a>
		<a href="#modal-alert" data-toggle="modal" class="b_blue">수정 완료</a>
		<a href="#modal-id-del" data-toggle="modal" class="b_red">삭제</a>
		<?}?>

		<a href="./?abkind=<?=$abkind?>&f_start=<?=$f_start;?>&f_end=<?=$f_end;?>&f_kind=<?=$f_kind;?>&f_txt=<?=$f_txt;?>&page=<?=$page;?>" class="b_sgrey">목록</a>
	</div>
	<!-- END button area //-->
</div>
<!-- END contents area //-->

<?$con_db=null;?>

<script type="text/javascript">

//비밀번호 변경
function pwdEdit(){
	
	var f = document.frmPwd;

	if (f.a_pwd.value == ''){
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
	}else{
		
		var ajax_url = "/proc/adm_pwd_edit_ok.php";	
		var formData = $("#frmPwd").serialize();
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
					//location.reload();
					top.location.href="./?abkind=<?=$abkind;?>";
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

//정보 수정
function infoEdit(){
	
	$('#modal-alert').modal('hide');

	var f = document.frm;

	if (f.a_name.value == ''){
		alert("<?=$msgstr['name_null']?>");
		f.a_name.focus();
		return false;

	}else if(fn_strCheck(f.a_name.value)){
		alert("<?=$msgstr['name_deny']?>");
		f.a_name.focus();
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

		var ajax_url = "/proc/adm_edit_ok.php";	
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
				 //$('#modal-alert').modal('hide');
		   },
		   success : function(data) {
				// success
				// TODO
				alert(data.rtnmsg);
				if (data.state){
					top.location.href="./?abkind=<?=$abkind;?>";
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



//관리자자 삭제
function idDel(){
	
	var f = document.frmDel;

	if (f.a_del_memo.value == ''){
		alert("<?=$msgstr['memo_null']?>");
		f.a_del_memo.focus();
		return false;

	}else if (f.a_del_memo.value.length > 100){
		alert("<?=$msgstr['memo_length']?>");
		f.a_del_memo.focus();
		return false;

	}else{

		var ajax_url = "/proc/adm_del_ok.php";	
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
					//location.reload();
					top.location.href="./?abkind=<?=$abkind;?>";
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