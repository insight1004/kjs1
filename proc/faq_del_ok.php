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

$idx = trim_str($_REQUEST['idx']);
$n_ip = $_SERVER['REMOTE_ADDR'];


//세션 아이디
$reg_id = $_SESSION['ADM_ID'];


//파라미터 NULL 체크
if($idx == ""){
	echo '{"state":false, "rtnmsg":"'.$msgstr['param_null'].'"}';
	exit;
}


//DB 객체 생성
$con_db = db_connect();


//데이터 존재 확인
$result = mysqli_query($con_db, "SELECT idx FROM ".$db['faq_table']." WHERE idx=".$idx);
if(mysqli_num_rows($result) > 0) {
	
	//데이터 수정
	$sql = " UPDATE ".$db['faq_table'];
	$sql .= " SET f_state='0', f_edit_date='".date("Y-m-d H:i:s")."', a_id='".$reg_id."', f_ip='".$f_ip."' ";
	$sql .= " WHERE idx=".$idx;
	
	if (mysqli_query($con_db, $sql)) {
		$con_db=null;
		echo '{"state":true, "rtnmsg":"'.$msgstr['del_success'].'"}';
		exit;
	} else {
		$con_db=null;
		echo '{"state":false, "rtnmsg":"'.$msgstr['del_err'].'"}';
		Console_log("Error updating record:".mysqli_error($con_db));
	}

}else{
	$con_db=null;
	echo '{"state":false, "rtnmsg":"'.$msgstr['data_null'].'"}';
	exit;

}


?>
