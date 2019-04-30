<?
//include
include_once '../common/config.php';
include_once '../common/string.php';
include_once '../common/lib.php';
include_once '../common/dbconfig.php';




$board = trim_str($_REQUEST['board']); //게시판

$page = (isset($_REQUEST['page']) ? $_REQUEST['page'] : 1);
$vcnt = (isset($_REQUEST['vcnt']) ? $_REQUEST['vcnt'] : 20); //게시글 수


//파라미터 NULL 체크
if($board != "notice" && $board != "faq"){
	echo '{"state":false, "rtnmsg":"'.$msgstr['board_null'].'"}';
	exit;
}



//DB 객체 생성
$con_db = db_connect();


if ($board == "notice"){
	
	//SQL
	$columnStr = " idx, n_title, n_content, n_reg_date, n_state, a_id, n_ip ";
	$tableStr = " FROM ".$db['notice_table'];
	$whereStr = " WHERE n_state in (1) ";
	$orderbyStr = " ORDER BY idx DESC ";

		
	/*데이터 리스트 START*/
	$currentLimit = ($vcnt * $page) - $vcnt; //몇 번째의 글부터 가져오는지
	$sqlLimit = ' limit ' . $currentLimit . ', ' . $vcnt; //limit sql 구문

	$sql = " SELECT " . $columnStr;
	$sql .= $tableStr; 
	$sql .= $whereStr;
	$sql .= $orderbyStr;
	$sql .=  $sqlLimit; //원하는 개수만큼 가져온다. (0번째부터 20번째까지
	
	$result = mysqli_query($con_db, $sql);
	
	if(mysqli_num_rows($result) > 0) {
		
		$json = '{"state":true, "rtnmsg":"조회성공", "postdata":[';

		$i = 0;
		while($row = $result->fetch_assoc()){
			//NO (($allPost - $i)) - (($page-1)*$vcnt)	
			//'&quot;': '"', '&#039;': "'",
			//$content = str_replace('"', "&quot;", $row["n_content"]);
			//$content = str_replace("'", "&#039;", $content);

			$content = str_replace("'", "\'", $row["n_content"]);
			$content = str_replace('"', "\"", $content);

			if ($i>0) $json .= ',';
			$json .= '{"idx":'.$row["idx"].', "title":"'.$row["n_title"].'", "content":"'.utf8_encode($content).'", "date":"'.substr($row["n_reg_date"], 0, 16).'"}';

			$i++; 
		}

		$json .= ']}';

		$con_db=null;
		echo $json;
		exit;

	}else{
		
		$con_db=null;
		echo '{"state":false, "rtnmsg":"'.$msgstr['data_null'].'"}';
		exit;
	}


		


}else if($board == "faq"){

	//SQL
	$columnStr = " idx, f_cate, f_title, f_content, f_reg_date, f_edit_date, f_state, a_id, f_ip ";
	$tableStr = " FROM ".$db['faq_table'];
	$whereStr = " WHERE f_state in (1) ";
	$orderbyStr = " ORDER BY idx DESC ";

	$sql = " SELECT count(idx) AS cnt ";
	$sql .= $tableStr;
	$sql .= $whereStr;

	$result = $con_db->query($sql);
	$row = $result->fetch_assoc();

	$allPost = $row['cnt']; //전체 게시글의 수
	//$paging = "";

	if(!empty($allPost)) {

		
		/*데이터 리스트 START*/
		$currentLimit = ($vcnt * $page) - $vcnt; //몇 번째의 글부터 가져오는지
		$sqlLimit = ' limit ' . $currentLimit . ', ' . $vcnt; //limit sql 구문

		$sql = " SELECT " . $columnStr;
		$sql .= $tableStr; 
		$sql .= $whereStr;
		$sql .= $orderbyStr;
		$sql .=  $sqlLimit; //원하는 개수만큼 가져온다. (0번째부터 20번째까지
		
		$result = mysqli_query($con_db, $sql);
		
		
		$json = '{"state":true, "rtnmsg":"조회성공", "postdata":[';

		$i = 0;
		while($row = $result->fetch_assoc()){
			//NO (($allPost - $i)) - (($page-1)*$vcnt)	

			if ($i>0) $json .= ',';
			$json .= '{"idx":'.$row["idx"].', "title":"'.$row["f_title"].'", "content":"'.$row["f_content"].'", "date":"'.substr($row["f_reg_date"], 0, 16).'"}';

			$i++; 
		}

		$json .= ']}';

		$con_db=null;
		echo $json;
		exit;

	}else{
		
		$con_db=null;
		echo '{"state":false, "rtnmsg":"'.$msgstr['data_null'].'"}';
		exit;

	}

}


?>






