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
$mb_idx = trim_str($_REQUEST['mb_idx']);


//파라미터 NULL 체크
if($mb_idx==''){
	echo '{"state":false, "rtnmsg":"'.$msgstr['param_null'].'"}';
	exit;
}


//타겟 선택시 링크 URL 체크
if(($mb_target=="_self" || $mb_target=="_blank") && $mb_link == ""){
	echo '{"state":false, "rtnmsg":"'.$msgstr['mb_url_null'].'"}';
	exit;	
}


//파일 수
$filecnt = count($new_mb_file["name"]);


//DB 객체 생성
$con_db = db_connect();




//데이터 존재 체크
$getData = mysqli_fetch_assoc(mysqli_query($con_db, "SELECT idx FROM ".$db['main_bn_table']." WHERE idx=".$mb_idx));
if(!$getData['idx']){
	$con_db=null;
	echo '{"state":false, "rtnmsg":"'.$msgstr['data_null'].'"}';
	exit;
}	


//등록된 이미지가 1개 일 경우 삭제 금지
$getData = mysqli_fetch_assoc(mysqli_query($con_db, "SELECT COUNT(idx) AS cnt FROM ".$db['main_bn_table']." WHERE mb_state=1"));
if($getData['cnt'] < 2){
	$con_db=null;
	echo '{"state":false, "rtnmsg":"'.$msgstr['mb_cnt_limit2'].'"}';
	exit;
}	




//기존 파일 삭제
$sql = " SELECT filename FROM ".$db['main_bn_file_table']." WHERE mb_idx=".$mb_idx;

$result = mysqli_query($con_db, $sql);

if (mysqli_num_rows($result) > 0) {
	while($row = $result->fetch_assoc()){
		unlink($path.$row["filename"]);
	}
}


//기존 파일 정보 삭제
$sql = " DELETE FROM ".$db['main_bn_file_table']." WHERE mb_idx=".$mb_idx;
mysqli_query($con_db, $sql);


//데이터 삭제
$sql = " DELETE FROM ".$db['main_bn_table']." WHERE idx=".$mb_idx;
if (mysqli_query($con_db, $sql)) {
	$con_db=null;
	echo '{"state":true, "rtnmsg":"'.$msgstr['del_success'].'"}';
	exit;
}else{
	$con_db=null;
	echo '{"state":false, "rtnmsg":"'.$msgstr['del_err'].'"}';
	Console_log("Error updating record:".mysqli_error($con_db));
	exit;

}




?>
