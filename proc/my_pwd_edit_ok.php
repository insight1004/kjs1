<?
//include
include_once '../common/config.php';
include_once '../common/lib.php';
include_once '../common/dbconfig.php';
include_once '../common/string.php';
include_once '../common/password.php';


/*--------------------------------------------------------------------------------------
로그인, 권한체크 authChk(로그인체크사용:true(기본값), 접근레벨:'등급1,등급2,등급3....';  START
--------------------------------------------------------------------------------------*/
$authRtn = authChkProc($login=true, $level='super,normal');
if($authRtn=='logout'){
	echo '{"state":false, "rtnmsg":"'.$msgstr['deny1'].'"}';
	exit;
}else if($authRtn=='deny'){
	echo '{"state":false, "rtnmsg":"'.$msgstr['deny2'].'"}';
	exit;
}
/*--------------------------------------------------------------------------------------
로그인, 권한체크 authChk(로그인체크사용:true(기본값), 접근레벨:'등급1,등급2,등급3....';  END
--------------------------------------------------------------------------------------*/


$a_id = $_SESSION['ADM_ID'];

$a_pwd = $_REQUEST['a_pwd'];
$a_pwd_confirm = $_REQUEST['a_pwd_confirm'];
$a_ip = $_SERVER['REMOTE_ADDR'];



//세션 아이디
$a_reg_id = $_SESSION['ADM_ID'];


//파라미터 NULL 체크
if($a_pwd=='' || $a_pwd_confirm=='' ){
	echo '{"state":false, "rtnmsg":"'.$msgstr['param_null'].'"}';
	exit;
}

//패스워드 비교
if($a_pwd != $a_pwd_confirm){
	echo '{"state":false, "rtnmsg":"'.$msgstr['pwd_match'].'"}';
	exit;
}


//DB 객체 생성
$con_db = db_connect();


//회원 정보 조회
$result = mysqli_query($con_db, "SELECT idx, a_level, a_state FROM ".$db['admin_table']." WHERE a_id='".$a_id."' LIMIT 1");
if(mysqli_num_rows($result) < 1) {
	$con_db=null;
	echo '{"state":false, "rtnmsg":"'.$msgstr['adm_null'].'"}';
	exit;
}else{
	$row = mysqli_fetch_assoc($result);
	$admState = $row['a_state'];

	if($admState == 0){
		//삭제 상태면 수정 불가
		$con_db=null;
		echo '{"state":false, "rtnmsg":"'.$msgstr['adm_del_state'].'"}';
		exit;

	}else{
		
		//패스워드 암호화
		$pwdhash = password_hash($a_pwd, PASSWORD_DEFAULT);  // 비밀번호 암호화 

		$sql = " UPDATE ".$db['admin_table']." SET a_pwd='".$pwdhash."', a_ip='".$a_ip."', a_edit_date='".date("Y-m-d H:i:s")."', a_reg_id='".$a_reg_id."' WHERE a_id='".$a_id."' ";

		if (mysqli_query($con_db, $sql)) {
			$con_db=null;
			echo '{"state":true, "rtnmsg":"'.$msgstr['adm_edit_success'].'"}';
			exit;
		} else {
			$con_db=null;
			echo '{"state":false, "rtnmsg":"'.$msgstr['db_err'].'"}';
			Console_log("Error updating record:".mysqli_error($con_db));
			exit;
		}


	}
}







?>
