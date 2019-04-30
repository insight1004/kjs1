<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="ko">
<!--<![endif]-->

<?
//include
include_once '../common/config.php';
include_once '../common/string.php';
include_once '../common/lib.php';

/*============================================
기본 슈퍼관리자 생성 START
============================================*/
if(SUPER_BASE_USE && SUPER_BASE_ID != '' && SUPER_BASE_PWD != ''){
	
	include_once '../common/dbconfig.php';
	include_once '../common/password.php';

	//DB 객체 생성
	$con_db = db_connect();

	//등록+활동중인 슈퍼 관리자 수 
	$getData = mysqli_fetch_assoc(mysqli_query($con_db, " SELECT COUNT(idx) AS cnt FROM ".$db['admin_table']." WHERE a_level='super' and a_state=1 "));
	if($getData['cnt'] < 1){	

		//아이디 중복 검사 후 없는 경우에만 등록
		$result = mysqli_query($con_db, "SELECT idx FROM ".$db['admin_table']." WHERE a_id='".SUPER_BASE_ID."' LIMIT 1");
		if(mysqli_num_rows($result) < 1) {

			//패스워드 암호화
			$pwdhash = password_hash(SUPER_BASE_PWD, PASSWORD_DEFAULT);  

			//데이터 등록
			$sql = " INSERT INTO ".$db['admin_table']." (a_id, a_name, a_pwd, a_level, a_tel, a_reg_date, a_reg_id, a_ip) ";
			$sql .= " VALUES('".SUPER_BASE_ID."', '슈퍼관리자', '".$pwdhash."', 'super', '010-0000-0000', '".date("Y-m-d H:i:s")."', 'SYSTEM', '".$_SERVER['REMOTE_ADDR']."') ";
			mysqli_query($con_db, $sql);
			$con_db=null;
		}

	}	
}
/*============================================
기본 슈퍼관리자 생성 END
============================================*/
?>

<head>
	<title><?=TITLE_ADMIN?></title>
	<?include_once '../common/meta.php';?>

    <link rel="shortcut icon" type="image/x-icon" href="<?=ICON_URL?>" />   
	
    <!-- BEGIN Touch icon -->
	<link rel="apple-touch-icon-precomposed" href="<?=ICON_URL_APPLE?>" />
	<!-- END Touch icon -->
    
    <!--  BASE CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="../css/material-icons.min.css" rel="stylesheet" />
	<link href="../css/elements.min.css" rel="stylesheet" />
	<link href="../css/admin_default.css" rel="stylesheet" />
	<!--  END BASE CSS  -->
	
	<!--  BASE JS  -->
	<script src="../js/jquery-1.9.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <script src="../js/apps.min.js"></script>
    <!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
	    <![endif]-->
    <!--  END BASE JS  -->

	<script src="../js/common.js"></script>
    
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
</head>

<body>

<div class="login_wrap">
    <!-- Login area -->
    <form method="post" action="" name="frm" id="frm" onsubmit="login_ok(); return false;">
	<div class="login_box">
        <div class="login_bi"><img src="../images/bi_admin.png" alt="CoolWallet"></div>
        <div class="login_input">
            <div class="mb10">
                <i class="mte i_person vam"></i>
                <input type="text" name="a_id" id="a_id" placeholder="아이디 (이메일)" onkeydown="fn_hanLimit(this)" maxlength="50">
            </div>
            <div>
                <i class="mte i_lock vam"></i>
                <input type="password" name="a_pwd" id="a_pwd" placeholder="비밀번호" maxlength="20">
            </div>
            <div class="mt40">
                <button type="submit" class="btn_admin">관리자 로그인</button>
                <button type="button" class="btn_pw" onclick="pwdFind();">비밀번호 찾기</button>
            </div>
        </div>
    </div>
    </form>
    <!-- END Login area -->
</div>


<script type="text/javascript">
function login_ok(){
	
	var f = document.frm;

	if (f.a_id.value == ''){
		alert("<?=$msgstr['login_id_null']?>");
		f.a_id.focus();
		return false;

	}else if (!fn_emailChk(f.a_id.value)){
		alert("<?=$msgstr['email_deny']?>");
		f.a_id.focus();
		return false;

	}else if (f.a_pwd.value == ''){
		alert("<?=$msgstr['login_pwd_null']?>");
		f.a_pwd.focus();
		return false;

	}else if (f.a_pwd.length < 8 && f.a_pwd.length > 20){
		alert("<?=$msgstr['pwd_deny']?>");
		f.a_pwd.focus();
		return false;

	}else{

		var ajax_url = "/proc/login_ok.php";	
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
		   },
		   success : function(data) {
				// success
				// TODO
				if (data.state){
					location.href="./";
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
		   timeout:100000 //응답제한시간 ms
		});

	}
}


//비밀번호 찾기
function pwdFind(){
	
	var f = document.frm;

	if (f.a_id.value == ''){
		alert("<?=$msgstr['login_id_null']?>");
		f.a_id.focus();
		return false;

	}else if (!fn_emailChk(f.a_id.value)){
		alert("<?=$msgstr['email_deny']?>");
		f.a_id.focus();
		return false;

	}else{

		var ajax_url = "/proc/pwd_renew.php";	
		var formData = $("#frm").serialize();
		var params = "";
		var msg = "";

		$.ajax({
		   type:"post",
		   url:ajax_url,
		   //data:params,
		   data:formData,
		   dataType:"JSON", // JSON 리턴
		   beforeSend:function(){},
		   success : function(data) {
				// success
				// TODO
				alert(data.rtnmsg);
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



</body>
</html>