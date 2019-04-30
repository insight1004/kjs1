<?
//include
include_once '../common/config.php';
include_once '../common/lib.php';
include_once '../common/dbconfig.php';
include_once '../common/string.php';
include_once '../common/password.php';


$a_id = trim_str($_REQUEST['a_id']);
$a_pwd = $_REQUEST['a_pwd'];



//파라미터 NULL 체크
if($a_id=='' || $a_pwd==''){
	echo '{"state":false, "rtnmsg":"'.$msgstr['param_null'].'"}';
	exit;
}


//DB 객체 생성
$con_db = db_connect();


//회원 정보 조회
$result = mysqli_query($con_db, "SELECT idx, a_level, a_state, a_pwd FROM ".$db['admin_table']." WHERE a_id='".$a_id."' LIMIT 1");
if(mysqli_num_rows($result) < 1) {
	$con_db=null;
	echo '{"state":false, "rtnmsg":"'.$msgstr['acount_deny'].'"}';
	exit;
}else{
	$row = mysqli_fetch_assoc($result);
	$admState = $row['a_state'];
	$pwdhash = $row['a_pwd'];
	$a_level = $row['a_level'];


	if($admState == 0){
		//삭제된 계정
		$con_db=null;
		echo '{"state":false, "rtnmsg":"'.$msgstr['acount_del'].'"}';
		exit;

	}else{
		
		//패스워드 비교
		if ($pwdhash && password_verify($a_pwd, $pwdhash)) { 
			//로그인 처리

			session_start();
			$_SESSION['ADM_ID'] = $a_id;
			$_SESSION['ADM_LEVEL'] = $a_level;
			
			$con_db=null;
			echo '{"state":true, "rtnmsg":"'.$msgstr['login_success'].'"}';
			exit;
		} else { 
			$con_db=null;
			echo '{"state":false, "rtnmsg":"'.$msgstr['acount_deny'].'"}';
			exit;
		}


	}
}







?>
