<?
//include
include_once '../common/config.php';
include_once '../common/string.php';
include_once '../common/lib.php';
include_once '../common/dbconfig.php';

/*
파일 업로드 셋팅 관련 참조
https://www.phpschool.com/gnuboard4/bbs/board.php?bo_table=tipntech&wr_id=33202

php.ini파일에서 용량과 관련하여 설정해 주어야 하는 부분은 6부분입니다.

1. file_uploads = On
파일 업로드를 허용할지 설정하는 부분으로 당연히 ON

2. upload_max_filesize = 20M
최대 업로드 파일 사이즈입니다

3. post_max_size = 20M
Post방식으로 넘겨질 최대 데이터 사이즈

4. max_execution_time = 300
최대 실행시간

5. memory_limit = 128M
php의 메모리 사용량. 파일 업로드시 업로드된 파일은 먼저 메모리에 적재되므로 메모리 사용량이 넉넉해야함.

추가
/etc/httpd/conf.d/php.conf

LimitRequestBody = 20000000 (바이트)


===========
post_max_size 값 > upload_max_filesize 값 >= memory_limit 값


-아파치 재 시작


*오류 발생시 참조 : https://stackoverflow.com/questions/31876920/file-not-uploaded-more-then-300mb-in-php


*/



//메인배너 저장경로
$path = QNA_FILE_PATH;
 

$q_usr = trim_str($_REQUEST['q_usr']);
$q_usr_email = trim_str($_REQUEST['q_usr_email']);
$q_title = htmlspecialchars($_REQUEST['q_title']);
$q_content = htmlspecialchars($_REQUEST['q_content']);
$q_file = $_FILES['q_file'];

$q_usrip = $_SERVER['REMOTE_ADDR'];



//파라미터 NULL 체크
if($q_usr=='' || $q_usr_email=='' || $q_title=='' || $q_content==''){
	echo '{"state":false, "rtnmsg":"'.$msgstr['param_null'].'"}';
	exit;
}



//파일 필드 수
$filecnt = count($q_file["name"]);



//이미지 파일 체크
for ($i = 0; $i < $filecnt; $i++) {

	$fname = $q_file['name'][$i]; //파일 명
	$fsize = $q_file['size'][$i]; //파일 크기


	//파일 필드중 파일을 선택한 필드만 처리
	if($fname != "" && $fname != null){

		//파일 업로드시 에러
		if ($q_file["error"][$i] > 0){
			echo '{"state":false, "rtnmsg":"'.$msgstr['file_up_err'].'"}';
			exit;
		}


		//파일 형식 체크
		$ext = strtolower(end(explode('.', $fname))); 
		if(in_array($ext, $qna_image_formats)){
			//이미지 파일	

			//파일 용량 체크
			if($fsize > ( QNA_FILE_IMAGE_SIZE*1024*1024 )){
				//제한된 크기의 파일
				echo '{"state":false, "rtnmsg":"이미지 파일은 '.QNA_FILE_IMAGE_SIZE.$msgstr['file_size_limit'].'"}'; 
				exit;
			}

		}else if(in_array($ext, $qna_movie_formats)){
			//동영상 파일

			//파일 용량 체크
			if($fsize > ( QNA_FILE_MOVIE_SIZE*1024*1024 )){
				//제한된 크기의 파일
				echo '{"state":false, "rtnmsg":"동영상 파일은 '.QNA_FILE_MOVIE_SIZE.$msgstr['file_size_limit'].'"}'; 
				exit;
			}

		}else{
			//허용되지 않는 확장자

			$formatStr = "";
			for($z=0; $z < count($qna_image_formats); $z++){
				if($z > 0)$formatStr .= "/";
				$formatStr .= $qna_image_formats[$z];
			}
			
			$formatStr .= "/";

			for($z=0; $z < count($qna_movie_formats); $z++){
				if($z > 0)$formatStr .= "/";
				$formatStr .= $qna_movie_formats[$z];
			}


			echo '{"state":false, "rtnmsg":"'.strtoupper($formatStr).$msgstr['file_format_limit2'].'"}'; 
			exit;
		}

	}

}




//모두 통과 했으니 저장
if($filecnt>0) fileSave($q_file);


//파일 저장
function fileSave($files){
	global $path, $filecnt;
	global $saveFileName;
	$saveFileName = array();

	$cntstr = '';
	$fdate = nowDateTimeTight();
	
	$z=0;
	for ($i=0; $i < $filecnt; $i++) {

		$fname = $files['name'][$i]; //파일 명
		
		//파일 필드중 파일을 선택한 필드만 처리
		if($fname != "" && $fname != null){

			$ext = end(explode('.', $fname));
			if($i>0)$cntstr = '('.$i.')';
			$saveName = $fdate.$cntstr.".".$ext; //파일명 셋팅
			
			//$tmp = $_FILES['q_file']['tmp_name'][$i]; //임시 디렉토리에 저장된 파일
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
				echo '{"state":false, "rtnmsg":"'.$msgstr['file_up_err'].'"}';
				exit;
			}

		}

	}
	
}




//DB 객체 생성
$con_db = db_connect();


//실제 저장된 이미지 갯수
$saveCnt = count($saveFileName);


if($saveCnt > 0){
	
	//데이터 등록
	$sql = " INSERT INTO ".$db['qna_table']." (q_title, q_content, q_usr, q_usr_email, q_date, q_usrip) ";
	$sql .= " VALUES('".$q_title."', '".$q_content."', '".$q_usr."', '".$q_usr_email."', '".date("Y-m-d H:i:s")."', '".$q_usrip."') ";


	if (mysqli_query($con_db, $sql)) {
		$idx = mysqli_insert_id($con_db); //idx 리턴
		
		$sql = "";
		for ($i=0; $i < $saveCnt; $i++){
			
			$sql .= " INSERT INTO ".$db['qna_file_table']." (q_idx, filename) ";
			$sql .= " VALUES(".$idx.", '".$saveFileName[$i]."'); ";

		}
		
		
		if (mysqli_multi_query($con_db, $sql)) {
			do {
			   if (!mysqli_more_results($con_db)) {
				
				//관리자들에게 메일보내기
				qna_regmail(htmlspecialchars_decode($q_content));
				$con_db=null;
				echo '{"state":true, "rtnmsg":"'.$msgstr['qna_success'].'"}';
				exit();
			   }
			} while (mysqli_next_result($con_db));
		}

		/*
		$sql = " INSERT INTO ".$db['main_bn_file_table']." (mb_idx, filename) ";
		$sql .= " VALUES ";
		for ($i=0; $i < $saveCnt; $i++){
			if($i > 0)$sql .= ","; 
			$sql .= "(".$idx.", '".$saveFileName[$i]."')";
		}
		$sql .= ";";


		if (mysqli_query($con_db, $sql)) {
			$con_db=null;
			echo '{"state":true, "rtnmsg":"2'.$msgstr['qna_success'].'"}';
			exit;
		}else{
			$con_db=null;
			echo '{"state":false, "rtnmsg":"2'.$msgstr['save_err'].'"}';
			Console_log("Error updating record:".mysqli_error($con_db));
			exit;
		}
		*/

		
	} else {
		$con_db=null;
		echo '{"state":false, "rtnmsg":"'.$msgstr['save_err'].'"}';
		Console_log("Error updating record:".mysqli_error($con_db));
		exit;
	}


}else{

	//데이터 등록
	$sql = " INSERT INTO ".$db['qna_table']." (q_title, q_content, q_usr, q_usr_email, q_date, q_usrip) ";
	$sql .= " VALUES('".$q_title."', '".$q_content."', '".$q_usr."', '".$q_usr_email."', '".date("Y-m-d H:i:s")."', '".$q_usrip."') ";
	
	if (mysqli_query($con_db, $sql)) {
		
		//관리자들에게 메일보내기
		qna_regmail(htmlspecialchars_decode($q_content));

		$con_db=null;
		echo '{"state":true, "rtnmsg":"'.$msgstr['qna_success'].'"}';
		exit;

	} else {
		$con_db=null;
		echo '{"state":false, "rtnmsg":"'.$msgstr['save_err'].'"}';
		Console_log("Error updating record:".mysqli_error($con_db));
		exit;
	}

	
}









?>
