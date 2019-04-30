<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->

<html lang="ko">
<!--<![endif]-->

<?
//include
include_once '../common/config.php';
include_once '../common/string.php';
include_once '../common/lib.php';
include_once '../common/dbconfig.php';

//로그인, 권한체크 authChk(로그인체크사용:true(기본값), 로그인얼럿사용:true(기본값), 접근레벨:'등급1,등급2,등급3....'(생략가능);
authChk(true, false);
?>

<head>

	<?
	//페이지 구분 값
	$abkind = (isset($_REQUEST['abkind'])) ? $_REQUEST['abkind'] : '';
	$amkind = (isset($_REQUEST['amkind'])) ? $_REQUEST['amkind'] : '';
	$askind = (isset($_REQUEST['askind'])) ? $_REQUEST['askind'] : '';

	?>

	<title><?=TITLE_ADMIN?></title>
	<?include_once '../common/meta.php';?>

    <link rel="shortcut icon" type="image/x-icon" href="<?=ICON_URL?>" />   
	
    <!-- BEGIN Touch icon -->
	<link rel="apple-touch-icon-precomposed" href="<?=ICON_URL_APPLE?>" />
	<!-- END Touch icon -->
    
    <!--  BASE CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="../css/material-icons.min.css" rel="stylesheet" />
	<link href="../css/elements.min.css" rel="stylesheet" />
	<link href="../css/admin_default.css" rel="stylesheet" />
	<!--  END BASE CSS  -->
	
	<!--  BASE JS  -->
	<script src="../js/jquery-1.9.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <script src="../js/apps.min.js"></script>
    <!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
	    <![endif]-->
    <!--  END BASE JS  -->
    
	<script src="../js/common.js"></script>

    <script>
        $(document).ready(function() {
            App.init();
        });

		//로그아웃
		function logout(){
			
			if (confirm("<?=$msgstr['logout_confirm']?>")){
				var ajax_url = "/proc/logout_ok.php";	
				var formData = "";
				var params = "";
				var msg = "";

				$.ajax({
				   type:"post",
				   url:ajax_url,
				   //data:params,
				   //data:formData,
				   dataType:"JSON", // JSON 리턴
				   beforeSend:function(){
				   },
				   success : function(data) {
						// success
						// TODO
						if (data.state){
							top.location.href='/adm/login.php';
						}
				   },
				   complete : function(data) {
						 // 통신이 실패했어도 완료가 되었을 때
						 // TODO
				   },
				   error : function(xhr, status, error) {
						 //alert("통신 에러");
				   },
				   timeout:100000 //응답제한시간 ms
				});
			}

			
		}
    </script>
    
    
</head>

<body>
<div class="wrap">
    <!-- head area -->
    <div class="head_wrap">
        <div class="head_bi">
            <div class="bi_img"><a href="./"><img src="../images/bi_coolwallet.png" alt="CoolWallet"></a></div>
            <h4>ADMINISTRATOR</h4>
        </div>
        <!-- login ingo -->
        <div class="head_info">
            <h5>ID : <?=$_SESSION['ADM_ID'];?></h5>
            <a href="./?abkind=myinfo" class="btn_info">내 정보</a>
            <a href="javascript:logout();" class="btn_out">로그아웃</a>
        </div>
        <!-- END login ingo //-->
    </div>
    <!-- END head area //-->

    <!-- side GNB -->
    <div id="sidebar" class="sidebar">
        <ul class="nav">
            
			<?if($_SESSION['ADM_LEVEL']=="super"){?>
			<li class="has-sub <?if($abkind=='adm') echo 'active'?>">
                <a href="./?abkind=adm">
                    <b class="ontab fl"></b>
                    <b class="caret fr"></b>
                    <i class="mte i_group vam ml20 mr10"></i>
                    <h5>관리자 관리</h5>
                </a>
            </li>
			<?}?>

            <li class="has-sub <?if($abkind=='mainbn') echo 'active'?>">
                <a href="./?abkind=mainbn">
                    <b class="ontab fl"></b>
                    <b class="caret fr"></b>
                    <i class="mte i_view_compact vam ml20 mr10"></i>
                    <h5>메인 관리</h5>
                </a>
            </li>
            <li class="has-sub <?if($abkind=='notice' || $abkind=='faq' || $abkind=='qna') echo 'active'?>">
                <a href="javascript:;">
                    <b class="ontab fl"></b>
                    <b class="caret fr"></b>
                    <i class="mte i_dvr vam ml20 mr10"></i>
                    <h5>고객센터</h5>
                </a>
                <ul class="sub-menu">
                    <li><a href="./?abkind=notice" <?if($abkind=='notice') echo 'class="on"'?> ><b class="mte vam">trip_origin</b>공지사항</a></li>
                    <li><a href="./?abkind=faq" <?if($abkind=='faq') echo 'class="on"'?> ><b class="mte vam">trip_origin</b>FAQ</a></li>
                    <li><a href="./?abkind=qna" <?if($abkind=='qna') echo 'class="on"'?> ><b class="mte vam">trip_origin</b>1:1 문의</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="side_bg"></div>
    <!-- END side GNB //-->

	<?
	/*===================================
	페이지 구분 (컨텐츠 영역) START
	=====================================*/
	switch ($abkind) {
		case 'adm':
			if($amkind=='list'){
				include 'pages/adm_list.php';
			}else if($amkind=='info'){
				include 'pages/adm_info.php';
			}else if($amkind=='reg'){
				include 'pages/adm_reg.php';
			}else{
				include 'pages/adm_list.php';
			}
			
			break;
		
		case 'mainbn':
			include 'pages/mainbn.php';
			break;

		case 'notice':
			if($amkind=='list'){
				include 'pages/notice_list.php';
			}else if($amkind=='edit'){
				include 'pages/notice_edit.php';
			}else if($amkind=='reg'){
				include 'pages/notice_reg.php';
			}else{
				include 'pages/notice_list.php';
			}

			break;
		case 'faq':
			if($amkind=='list'){
				include 'pages/faq_list.php';
			}else if($amkind=='edit'){
				include 'pages/faq_edit.php';
			}else if($amkind=='reg'){
				include 'pages/faq_reg.php';
			}else{
				include 'pages/faq_list.php';
			}
			break;

		case 'qna':
			if($amkind=='list'){
				include 'pages/qna_list.php';
			}else if($amkind=='detail'){
				include 'pages/qna_detail.php';
			}else{
				include 'pages/qna_list.php';
			}
			break;

		case 'myinfo':
			include 'pages/myinfo.php';
			break;

		default :
			include 'pages/main_content.php';
			break;
	}		

	/*===================================
	페이지 구분 (컨텐츠 영역) END
	=====================================*/
	?>

</div>


<?include_once 'footer.php';?>

</body>
</html>