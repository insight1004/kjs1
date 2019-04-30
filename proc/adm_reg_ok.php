<?
//include
include_once '../common/config.php';
include_once '../common/string.php';
include_once '../common/lib.php';
include_once '../common/dbconfig.php';
include_once '../common/password.php';


/*--------------------------------------------------------------------------------------
로그인, 권한체크 authChk(로그인체크사용:true(기본값), 접근레벨:'등급1,등급2,등급3....';  START
--------------------------------------------------------------------------------------*/
$authRtn = authChkProc($login=true, $level='super');
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



$a_id = trim_str($_REQUEST['a_id']);
$a_name = trim_str($_REQUEST['a_name']);
$a_pwd = $_REQUEST['a_pwd'];
$a_pwd_confirm = $_REQUEST['a_pwd_confirm'];
$a_level = trim_str($_REQUEST['a_level']);
$a_tel1 = trim_str($_REQUEST['a_tel1']);
$a_tel2 = trim_str($_REQUEST['a_tel2']);
$a_tel3 = trim_str($_REQUEST['a_tel3']);
$a_tel = $a_tel1."-".$a_tel2."-".$a_tel3; 
if($a_tel=="--")$a_tel="";
$a_ip = $_SERVER['REMOTE_ADDR'];


//세션 아이디
$a_reg_id = $_SESSION['ADM_ID'];


//파라미터 NULL 체크
if($a_id=='' || $a_name=='' || $a_pwd=='' || $a_pwd_confirm=='' || $a_level=='' || $a_tel1=='' || $a_tel2=='' || $a_tel3==''){
	echo '{"state":false, "rtnmsg":"'.$msgstr['param_null'].'"}';
	exit;
}

//패스워드 비교
if($a_pwd != $a_pwd_confirm){
	echo '{"state":false, "rtnmsg":"'.$msgstr['pwd_match'].'"}';
	exit;
}

//전화번호 체크 (- 제외 최대 12자)
if( mb_strlen($a_tel, "UTF-8") > 14 ){
	echo '{"state":false, "rtnmsg":"'.$msgstr['pwd_match'].'"}';
	exit;
}


//DB 객체 생성
$con_db = db_connect();


//아이디 중복 검사
$result = mysqli_query($con_db, "SELECT idx FROM ".$db['admin_table']." WHERE a_id='".$a_id."' LIMIT 1");
if(mysqli_num_rows($result) > 0) {
	$con_db=null;
	echo '{"state":false, "rtnmsg":"'.$msgstr['id_aready'].'"}';
	exit;
}


//패스워드 암호화
$pwdhash = password_hash($a_pwd, PASSWORD_DEFAULT);  


//데이터 등록
$sql = " INSERT INTO ".$db['admin_table']." (a_id, a_name, a_pwd, a_level, a_tel, a_reg_date, a_reg_id, a_ip) ";
$sql .= " VALUES('".$a_id."', '".$a_name."', '".$pwdhash."', '".$a_level."', '".$a_tel."', '".date("Y-m-d H:i:s")."', '".$a_reg_id."', '".$a_ip."') ";


if (mysqli_query($con_db, $sql)) {
	$con_db=null;
	echo '{"state":true, "rtnmsg":"'.$msgstr['adm_reg_success'].'"}';
	exit;
} else {
	$con_db=null;
	echo '{"state":false, "rtnmsg":"'.$msgstr['db_err'].'"}';
    Console_log("Error updating record:".mysqli_error($con_db));
}







?>
