<?
//include
include_once '../common/config.php';
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

$f_start = (isset($_REQUEST['f_start']) ? $_REQUEST['f_start'] : '');
$f_end = (isset($_REQUEST['f_end']) ? $_REQUEST['f_end'] : '');
$f_kind = (isset($_REQUEST['f_kind']) ? $_REQUEST['f_kind'] : '');
$f_txt = (isset($_REQUEST['f_txt']) ? $_REQUEST['f_txt'] : '');


if($f_txt=='')$f_kind='';
if($f_kind=='')$f_txt='';

//날짜 기본 셋팅
if($f_start == "") $f_start =  date('Y/m/d', strtotime(date('Y/m/d')."-30 days"));
if($f_end == "") $f_end = date('Y/m/d');


//DB 객체 생성
$con_db = db_connect();

//SQL
$columnStr = " idx, q_title, q_content, q_usr, q_usr_email, q_date, q_usrip, q_acontent, q_reg_date, q_state, q_email_state, q_email_date, q_del_memo, q_del_date, a_id, q_ip ";
$tableStr = " FROM ".$db['qna_table'];
$whereStr = " WHERE q_state in (0, 1, 10) ";
$orderbyStr = " ORDER BY idx DESC ";


//날짜 조건 (시작일)
if($f_start!=''){
	$start_date = strtotime($f_start);
	$whereStr .= " AND q_date >= '".date('Y-m-d', $start_date)." 00:00:00' "; 
}


//날짜 조건 (종료일)
if($f_end!=''){
	$end_date = strtotime($f_end." +1 days");
	$whereStr .= " AND q_date < '".date('Y-m-d', $end_date)." 00:00:00' "; 
}


//검색 단어
if($f_kind!='' && $f_txt!='') $whereStr .= " AND ".$f_kind." like '%".$f_txt."%' "; 


$sql = " SELECT count(idx) AS cnt ";
$sql .= $tableStr;
$sql .= $whereStr;


$result = $con_db->query($sql);
$row = $result->fetch_assoc();

$allPost = $row['cnt']; //전체 게시글의 수


// CSV 파일 최상단에 표기 할 내용입니다. 
$csv_dump = iconv("UTF-8", "EUC-KR", "idx,문의제목,문의내용,고객명,고객이메일,문의일자,고객IP,답변내용,답변일자,답변상태,이메일상태,이메일전송일자,삭제사유,삭제일자,관리자ID,관리자IP,"); 
$csv_dump .= "\r\n"; 


if(!empty($allPost)) {
	

	/*데이터 리스트 START*/
	$sql = " SELECT " . $columnStr;
	$sql .= $tableStr; 
	$sql .= $whereStr;
	$sql .= $orderbyStr;

	$result = mysqli_query($con_db, $sql);


	while($row = $result->fetch_assoc()){

		// CSV저장 시 CR+LF 및 , 표시가 있으면 안되므로 치환시킵니다. 

		$idx = iconv("UTF-8", "EUC-KR", $row['idx']); 

		$q_title = str_replace("\r\n","",$row['q_title']); 
		$q_title = str_replace(","," ",$q_title); 
		$q_title = str_replace("&nbsp;"," ",$q_title); 
		$q_title = iconv("UTF-8", "EUC-KR",$q_title);

		$q_content = str_replace("\r\n","",strip_tags(htmlspecialchars_decode($row['q_content']))); 
		$q_content = str_replace(","," ",$q_content); 
		$q_content = str_replace("&nbsp;"," ",$q_content); 
		$q_content = iconv("UTF-8", "EUC-KR",$q_content);

		$q_usr = iconv("UTF-8", "EUC-KR", $row['q_usr']); 

		$q_usr_email = iconv("UTF-8", "EUC-KR", $row['q_usr_email']); 

		$q_date = iconv("UTF-8", "EUC-KR", $row['q_date']); 

		$q_usrip = iconv("UTF-8", "EUC-KR", $row['q_usrip']); 

		$q_acontent = str_replace("\r\n","",strip_tags(htmlspecialchars_decode($row['q_acontent']))); 
		$q_acontent = str_replace(","," ",$q_acontent); 
		$q_acontent = str_replace("&nbsp;"," ",$q_acontent); 
		$q_acontent = iconv("UTF-8", "EUC-KR",$q_acontent);


		$q_reg_date = iconv("UTF-8", "EUC-KR", $row['q_reg_date']); 

		$q_email_date = iconv("UTF-8", "EUC-KR", $row['q_email_date']); 

		$q_del_memo = str_replace("\r\n","",$row['q_del_memo']); 
		$q_del_memo = str_replace(","," ",$q_del_memo); 
		$q_del_memo = str_replace("&nbsp;"," ",$q_del_memo); 
		$q_del_memo = iconv("UTF-8", "EUC-KR",$q_del_memo);

		$q_del_date = iconv("UTF-8", "EUC-KR", $row['q_del_date']); 

		$q_del_date = iconv("UTF-8", "EUC-KR", $row['q_del_date']); 

		$q_ip = iconv("UTF-8", "EUC-KR", $row['q_ip']); 

		

		switch ($row["q_state"]) {
			case '10':
				$q_state = iconv("UTF-8", "EUC-KR", '답변완료');
				break;
			case '1':
				$q_state = iconv("UTF-8", "EUC-KR", '답변대기');
				break;
			case '0':
				$q_state = iconv("UTF-8", "EUC-KR", '삭제');
				break;
		}


		switch ($row["q_email_state"]) {
			case '10':
				$q_email_state = iconv("UTF-8", "EUC-KR", '성공');
				break;
			case '1':
				$q_email_state = iconv("UTF-8", "EUC-KR", '발송대기');
				break;
			case '0':
				$q_email_state = iconv("UTF-8", "EUC-KR", '실패');
				break;
		}

		$csv_dump .= $idx.","; 
		$csv_dump .= $q_title.","; 
		$csv_dump .= $q_content.","; 
		$csv_dump .= $q_usr.","; 
		$csv_dump .= $q_usr_email.","; 
		$csv_dump .= $q_date.","; 
		$csv_dump .= $q_usrip.","; 
		$csv_dump .= $q_acontent.","; 
		$csv_dump .= $q_reg_date.","; 
		$csv_dump .= $q_state.",";
		$csv_dump .= $q_email_state.",";
		$csv_dump .= $q_email_date.",";
		$csv_dump .= $q_del_memo.",";
		$csv_dump .= $q_del_date.",";
		$csv_dump .= $q_del_date.",";
		$csv_dump .= $q_ip.","; 
		$csv_dump .= "\r\n"; 

	}
	
	$date = date("YmdHi"); 
	$filename = "qna_".$date.".csv"; 

	header('Content-Encoding: UTF-8');
	header('Content-type: text/csv; charset=UTF-8');
	header("Content-disposition: attachment; filename=".$filename);
	//echo "\xEF\xBB\xBF"; // UTF-8 BOM

	echo trim($csv_dump);

}else{

	$date = date("YmdHi"); 
	$filename = "qna_".$date.".csv"; 

	header('Content-Encoding: UTF-8');
	header('Content-type: text/csv; charset=UTF-8');
	header("Content-disposition: attachment; filename=".$filename);

	$csv_dump .= iconv("UTF-8", "EUC-KR", "해당 조건의 데이터가 없습니다.").","; 
	$csv_dump .= "\r\n"; 
	
	echo trim($csv_dump);
}




?>
