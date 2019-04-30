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


//메인배너 저장경로
$path = MAIN_FILE_PATH;
 

//파라미터
$mb_file = $_FILES['mb_file'];
$mb_target = trim_str($_REQUEST['mb_target']);
$mb_link = trim_str($_REQUEST['mb_link']);
$mb_ip = $_SERVER['REMOTE_ADDR'];


//세션 아이디
$a_id = $_SESSION['ADM_ID'];



//파라미터 NULL 체크
if($mb_target==''){
	echo '{"state":false, "rtnmsg":"'.$msgstr['param_null'].'"}';
	exit;
}


//타겟 선택시 링크 URL 체크
if(($mb_target=="_self" || $mb_target=="_blank") && $mb_link == ""){
	echo '{"state":false, "rtnmsg":"'.$msgstr['mb_url_null'].'"}';
	exit;	
}



//DB 객체 생성
$con_db = db_connect();


//등록 제한 수 
$getData = mysqli_fetch_assoc(mysqli_query($con_db, "SELECT count(idx) AS cnt FROM ".$db['main_bn_table']." WHERE mb_state=1"));
if($getData['cnt'] > 3){
	$con_db=null;
	echo '{"state":false, "rtnmsg":"'.$msgstr['mb_cnt_limit'].'"}';
	exit;
}	



//파일 필드 수
$filecnt = count($mb_file["name"]);

//실제 첨부한 이미지 파일 수
$imgcnt = 0;

//이미지 파일 체크
for ($i = 0; $i < $filecnt; $i++) {

	$fname = $mb_file['name'][$i]; //파일 명
	$fsize = $mb_file['size'][$i]; //파일 크기


	//빈 파일 체크 if문 start
	if($fname != "" && $fname != null){

		//파일 업로드시 에러
		if ($mb_file["error"][$i] > 0){
			echo '{"state":false, "rtnmsg":"'.$msgstr['file_up_err'].'"}';
			exit;
		}

		//파일 용량 체크
		if($fsize < ( MAIN_FILE_SIZE*1024*1024 )){

			//파일 형식 체크
			$ext = end(explode('.', $fname)); 
			if(in_array($ext, $main_file_formats)){
				$imgcnt++;
			}else{
				//허용되지 않는 확장자

				$formatStr = "";
				for($z=0; $z < count($main_file_formats); $z++){
					if($z > 0)$formatStr .= "/";
					$formatStr .= $main_file_formats[$z];
				}

				echo '{"state":false, "rtnmsg":"'.strtoupper($formatStr).$msgstr['file_onlyimg'].'"}'; 
				exit;
			}
			
		}else{
			//제한된 크기의 파일
			echo '{"state":false, "rtnmsg":"'.MAIN_FILE_SIZE.$msgstr['file_size_limit'].'"}'; 
			exit;
		}

	}

}




//이미지 첨부 필수
if($imgcnt > 0){
	//모두 통과 했으니 저장
	fileSave($mb_file);
}else{
	echo '{"state":false, "rtnmsg":"'.$msgstr['mb_file_null'].'"}';
	exit;
}



//파일 저장
function fileSave($files){
	global $path;
	global $saveFileName;
	$saveFileName = array();

	$cntstr = '';
	$filecnt = count($files["name"]);
	$fdate = nowDateTimeTight();
	
	$z=0;
	for ($i=0; $i < $filecnt; $i++) {

		$fname = $files['name'][$i]; //파일 명

		//파일 필드중 파일을 선택한 필드만 처리
		if($fname != "" && $fname != null){

			$ext = end(explode('.', $fname));
			if($i>0)$cntstr = '('.$i.')';
			$saveName = $fdate.$cntstr.".".$ext; //파일명 셋팅

			//$tmp = $_FILES['mb_file']['tmp_name'][$i]; //임시 디렉토리에 저장된 파일
			$tmp = $files['tmp_name'][$i]; //임시 디렉토리에 저장된 파일
			
			if(move_uploaded_file($tmp, $path.$saveName)){
				//저장 완료
				$saveFileName[$z] = $saveName;
				$z++;
			}else{
				//저장 실패
				//기존 저장된 파일이 있다면 삭제
				if(count($saveFileName) > 0){
					foreach ($saveFileName as $item) {
					   unlink($path.$item);
					}
				}

				//결과 리턴
				echo '{"state":false, "rtnmsg":"'.$msgstr['mb_file_err'].'"}';
				exit;
			}

		}

	}
	
}





//실제 저장된 이미지 갯수
$saveCnt = count($saveFileName);

if($saveCnt > 0){
	
	//데이터 등록
	$sql = " INSERT INTO ".$db['main_bn_table']." (mb_link, mb_target, mb_reg_date, a_id, mb_ip) ";
	$sql .= " VALUES('".$mb_link."', '".$mb_target."', '".date("Y-m-d H:i:s")."', '".$a_id."', '".$mb_ip."') ";


	if (mysqli_query($con_db, $sql)) {
		$idx = mysqli_insert_id($con_db); //idx 리턴
		
		$sql = "";
		for ($i=0; $i < $saveCnt; $i++){
			
			$sql .= " INSERT INTO ".$db['main_bn_file_table']." (mb_idx, filename) ";
			$sql .= " VALUES(".$idx.", '".$saveFileName[$i]."') ";

		}

		if (mysqli_query($con_db, $sql)) {
			$con_db=null;
			echo '{"state":true, "rtnmsg":"'.$msgstr['save_success'].'"}';
			exit;
		}else{
			$con_db=null;
			echo '{"state":false, "rtnmsg":"'.$msgstr['save_err'].'"}';
			Console_log("Error updating record:".mysqli_error($con_db));
			exit;
		}

		
	} else {
		$con_db=null;
		echo '{"state":false, "rtnmsg":"'.$msgstr['save_err'].'"}';
		Console_log("Error updating record:".mysqli_error($con_db));
		exit;
	}


}else{
	$con_db=null;
	echo '{"state":false, "rtnmsg":"'.$msgstr['mb_file_null'].'"}';
	exit;
	
}




?>
