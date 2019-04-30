<?
//include
include_once '../common/config.php';
include_once '../common/string.php';
include_once '../common/lib.php';
include_once '../common/dbconfig.php';


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

$f_cate = trim_str($_REQUEST['f_cate']);
$f_state = trim_str($_REQUEST['f_state']);
$f_title = htmlspecialchars($_REQUEST['f_title']);
$f_content = htmlspecialchars($_REQUEST['f_content']);
$f_ip = $_SERVER['REMOTE_ADDR'];


//세션 아이디
$reg_id = $_SESSION['ADM_ID'];


//파라미터 NULL 체크
if($f_cate=='' || $f_state=='' || $f_title=='' || $f_content==''){
	echo '{"state":false, "rtnmsg":"'.$msgstr['param_null'].'"}';
	exit;
}


//DB 객체 생성
$con_db = db_connect();


//데이터 등록
$sql = " INSERT INTO ".$db['faq_table']." (f_cate, f_title, f_content, f_reg_date, f_state, a_id, f_ip) ";
$sql .= " VALUES('".$f_cate."', '".$f_title."', '".$f_content."', '".date("Y-m-d H:i:s")."', '".$f_state."', '".$reg_id."', '".$f_ip."') ";


if (mysqli_query($con_db, $sql)) {
	$con_db=null;
	echo '{"state":true, "rtnmsg":"'.$msgstr['save_success'].'"}';
	exit;
} else {
	$con_db=null;
	echo '{"state":false, "rtnmsg":"'.$msgstr['save_err'].'"}';
    Console_log("Error updating record:".mysqli_error($con_db));
}







?>
