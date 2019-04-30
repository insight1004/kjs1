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
$n_state = trim_str($_REQUEST['n_state']);
$n_title = htmlspecialchars($_REQUEST['n_title']);
$n_content = htmlspecialchars($_REQUEST['n_content']);
$n_ip = $_SERVER['REMOTE_ADDR'];


//세션 아이디
$reg_id = $_SESSION['ADM_ID'];


//파라미터 NULL 체크
if($idx == "" || $n_state == "" || $n_title == "" || $n_content == ""){
	echo '{"state":false, "rtnmsg":"'.$msgstr['param_null'].'"}';
	exit;
}


//DB 객체 생성
$con_db = db_connect();


//데이터 존재 확인
$result = mysqli_query($con_db, "SELECT idx FROM ".$db['notice_table']." WHERE idx=".$idx);
if(mysqli_num_rows($result) > 0) {
	
	//데이터 수정
	$sql = " UPDATE ".$db['notice_table'];
	$sql .= " SET n_title='".$n_title."', n_content='".$n_content."', n_state='".$n_state."', n_edit_date='".date("Y-m-d H:i:s")."', a_id='".$reg_id."', n_ip='".$n_ip."' ";
	$sql .= " WHERE idx=".$idx;
	
	if (mysqli_query($con_db, $sql)) {
		$con_db=null;
		echo '{"state":true, "rtnmsg":"'.$msgstr['edit_success'].'"}';
		exit;
	} else {
		$con_db=null;
		echo '{"state":false, "rtnmsg":"'.$msgstr['edit_err'].'"}';
		Console_log("Error updating record:".mysqli_error($con_db));
		exit;
	}

}else{
	$con_db=null;
	echo '{"state":false, "rtnmsg":"'.$msgstr['data_null'].'"}';
	exit;

}


?>
