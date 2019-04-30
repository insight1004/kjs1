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

$q_state = trim_str($_REQUEST['q_state']);
$q_acontent = htmlspecialchars($_REQUEST['q_acontent']);

$n_ip = $_SERVER['REMOTE_ADDR'];


//세션 아이디
$reg_id = $_SESSION['ADM_ID'];


//파라미터 NULL 체크
if($idx == "" || $q_state == "" || $q_acontent == "" ){
	echo '{"state":false, "rtnmsg":"'.$msgstr['param_null'].'"}';
	exit;
}


//DB 객체 생성
$con_db = db_connect();


//데이터 존재 확인
$result = mysqli_query($con_db, "SELECT idx FROM ".$db['qna_table']." WHERE idx=".$idx);
if(mysqli_num_rows($result) > 0) {

	//데이터 수정
	$sql = " UPDATE ".$db['qna_table'];
	$sql .= " SET q_acontent='".$q_acontent."',  q_reg_date='".date("Y-m-d H:i:s")."', q_state='".$q_state."', a_id='".$reg_id."', q_ip='".$q_ip."' ";
	$sql .= " WHERE idx=".$idx;
	
	if (mysqli_query($con_db, $sql)) {

		//정보 조회
		$getData = mysqli_fetch_assoc(mysqli_query($con_db, "SELECT q_content, q_usr, q_usr_email, q_acontent FROM  ".$db['qna_table']."  WHERE idx=".$idx));
		
		//이메일 주소가 있는 경우
		if($getData['q_usr_email']!=''){
			
			//이메일 전송 
			$mailrtn = qna_sendmail($getData['q_usr_email'], $getData['q_usr'], FROM_EMAIL, FROM_NAME, htmlspecialchars_decode($getData['q_content']), htmlspecialchars_decode($getData['q_acontent']));
			
			if($mailrtn){
				//전송 성공
				$sql = " UPDATE ".$db['qna_table'];
				$sql .= " SET q_email_state=10, q_email_date='".date("Y-m-d H:i:s")."' ";
				$sql .= " WHERE idx=".$idx;
				mysqli_query($con_db, $sql);
			}else{
				//전송 실패
				$sql = " UPDATE ".$db['qna_table'];
				$sql .= " SET q_email_state=0, q_email_date='".date("Y-m-d H:i:s")."' ";
				$sql .= " WHERE idx=".$idx;
				mysqli_query($con_db, $sql);
			}

		}else{
			
			//전송 실패
			$sql = " UPDATE ".$db['qna_table'];
			$sql .= " SET q_email_state=0, q_email_date='".date("Y-m-d H:i:s")."' ";
			$sql .= " WHERE idx=".$idx;
			mysqli_query($con_db, $sql);

		}
		
		$con_db=null;
		echo '{"state":true, "rtnmsg":"'.$msgstr['qna_answer_success'].'"}';
		exit;
	} else {
		$con_db=null;
		echo '{"state":false, "rtnmsg":"'.$msgstr['qna_answer_err'].'"}';
		Console_log("Error updating record:".mysqli_error($con_db));
		exit;
	}

}else{
	$con_db=null;
	echo '{"state":false, "rtnmsg":"'.$msgstr['data_null'].'"}';
	exit;

}


?>
