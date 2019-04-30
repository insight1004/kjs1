<?
//include
include_once '../common/config.php';
include_once '../common/lib.php';
include_once '../common/dbconfig.php';
include_once '../common/string.php';



$a_id = trim_str($_REQUEST['a_id']);

//echo $a_id;

if($a_id==''){
	echo '{"state":false, "rtnmsg":"'.$msgstr['id_null'].'"}';
	exit;
}


//DB 객체 생성
$con_db = db_connect();

//아이디 중복 검사
$result = mysqli_query($con_db, "SELECT idx FROM ".$db['admin_table']." WHERE a_id='".$a_id."' LIMIT 1");


if(mysqli_num_rows($result) > 0) {
	$con_db=null;
	echo '{"state":false, "rtnmsg":"'.$msgstr['id_aready'].'"}';
	exit;
}else{
	$con_db=null;
    echo '{"state":true, "rtnmsg":"'.$msgstr['id_ok'].'"}';
	exit;
}

?>
