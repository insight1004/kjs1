<?
//include
include_once '../common/config.php';
include_once '../common/lib.php';
include_once '../common/dbconfig.php';
include_once '../common/string.php';
include_once '../common/password.php';


$a_id = trim_str($_REQUEST['a_id']);
$a_ip = $_SERVER['REMOTE_ADDR'];

//파라미터 NULL 체크
if($a_id==''){
	echo '{"state":false, "rtnmsg":"'.$msgstr['param_null'].'"}';
	exit;
}


//DB 객체 생성
$con_db = db_connect();


//회원 정보 조회
$result = mysqli_query($con_db, "SELECT idx, a_level, a_state, a_pwd FROM ".$db['admin_table']." WHERE a_id='".$a_id."' LIMIT 1");
if(mysqli_num_rows($result) > 0) {


	//활동중일 경우만 변경 가능
	$row = mysqli_fetch_assoc($result);
	$admState = $row['a_state'];
	$admLevel = $row['a_level'];

	if($admState == 1){
		//활동중 

		//슈퍼관리자 임시비밀번호 발급 금지
		if($admLevel == 'super' && !SUPER_PWD_RENEW){

			$con_db=null;
			echo '{"state":true, "rtnmsg":"'.$msgstr['pwd_renew_limit'].'"}';
			exit;

		}else{

			//랜덤 패스워드 생성 (전체 12 자리)
			$newpwd = GenerateString(12);

			//메일을 먼저 보내고 성공했을 경우 DB 수정
			$mailrtn = pwd_sendmail($a_id, FROM_EMAIL, FROM_NAME, $newpwd);

			if($mailrtn){
				//전송 성공

				//패스워드 암호화
				$pwdhash = password_hash($newpwd, PASSWORD_DEFAULT);  // 비밀번호 암호화 

				$sql = " UPDATE ".$db['admin_table']." SET a_pwd='".$pwdhash."', a_ip='".$a_ip."', a_edit_date='".date("Y-m-d H:i:s")."' WHERE a_id='".$a_id."' ";

				if (mysqli_query($con_db, $sql)) {
					$con_db=null;
					echo '{"state":true, "rtnmsg":"'.$msgstr['pwd_renew_success'].'"}';
					exit;
				} else {
					$con_db=null;
					echo '{"state":false, "rtnmsg":"'.$msgstr['db_err'].'"}';
					Console_log("Error updating record:".mysqli_error($con_db));
				}


			}else{
				//전송 실패
				$con_db=null;
				echo '{"state":false, "rtnmsg":"'.$msgstr['email_fail'].'"}';
				exit;
			}
		
		}

	}else{
		
		$con_db=null;
		echo '{"state":false, "rtnmsg":"'.$msgstr['acount_active_err'].'"}';
		exit;

	}


}else{

	$con_db=null;
	echo '{"state":false, "rtnmsg":"'.$msgstr['acount_deny'].'"}';
	exit;

}







?>
