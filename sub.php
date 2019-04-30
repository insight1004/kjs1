<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="ko">
<!--<![endif]-->

<?
//include
include_once 'common/config.php';
include_once 'common/string.php';
include_once 'common/lib.php';
include_once 'common/dbconfig.php';
?>

<head>

	<?
	//페이지 구분 값
	$bkind = (isset($_REQUEST['bkind'])) ? $_REQUEST['bkind'] : '';
	$mkind = (isset($_REQUEST['mkind'])) ? $_REQUEST['mkind'] : '';
	$skind = (isset($_REQUEST['skind'])) ? $_REQUEST['skind'] : '';
	
	if(!$bkind) header( 'Location: main.php' );

	?>

	<title><?=TITLE?></title>
	<?include_once 'common/meta.php';?>

    <link rel="shortcut icon" type="image/x-icon" href="<?=ICON_URL?>" />   
	
    <!-- BEGIN Touch icon -->
	<link rel="apple-touch-icon-precomposed" href="<?=ICON_URL_APPLE?>" />
	<!-- END Touch icon -->
    
    <!--  BASE CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="css/material-icons.min.css" rel="stylesheet" />
	<link href="css/elements.min.css" rel="stylesheet" />
	<link href="css/swiper.min.css" rel="stylesheet" />
	<link href="css/default.css" rel="stylesheet" />
	<link href="css/responsive.min.css" rel="stylesheet" />
	<!--  END BASE CSS  -->
	
	<!--  BASE JS  -->
	<script src="js/jquery-1.9.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/apps.min.js"></script>
    <!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
	    <![endif]-->
    <!--  END BASE JS  -->

	<script src="js/common.js"></script>
    
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
</head>

<body>
<div class="wrap">

    <!-- GNB area -->
    <div class="gnb header-nav">
        <!-- head gnb -->
        <div class="bi_wrap">
            <div class="mbtn collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <span></span><span></span><span></span>
            </div>
            <div class="head_bi"><a href="main.php"><img src="images/bi_coolwallet.png" alt="CoolWallet S"></a></div>
            <div class="head_bi_w"><a href="main.php"><img src="images/bi_coolwallet_w.png" alt="CoolWallet S"></a></div>
        </div>
        <div class="head_menu" id="navbar-collapse">
            <ul class="nav">
                <li><a href="sub.php?bkind=product"><i class="mte i_bi"></i>Product</a></li>
                <li><a href="sub.php?bkind=app"><i class="mte i_perm_device_information"></i>App</a></li>
                <li class="dropdown dropdown-hover">
                    <a href="" data-toggle="dropdown" onclick="location.href='sub.php?bkind=cs1'" class="view_xs"><i class="mte i_live_help"></i>Support</a>
                    <a href="" data-toggle="dropdown" class="hidden_xs"><i class="mte i_live_help"></i>Support</a>
                    <ul class="dropdown-menu">
                        <li><a href="sub.php?bkind=cs1"><i class="mte i_trip_origin mte-12">trip_origin</i>공지사항</a></li>
                        <li><a href="sub.php?bkind=cs2"><i class="mte i_trip_origin mte-12">trip_origin</i>FAQ</a></li>
                        <li><a href="sub.php?bkind=cs3"><i class="mte i_trip_origin mte-12">trip_origin</i>1:1문의</a></li>
                    </ul>
                </li>
                <li><a href="sub.php?bkind=download"><i class="mte i_cloud_download"></i>Download</a></li>
            </ul>
        </div>
        <!-- head gnb -->

    </div>
    <!-- END GNB area //-->
    <div class="null"></div>
    
	<?
	/*===================================
	페이지 구분 (컨텐츠 영역) START
	=====================================*/

	switch ($bkind) {
		case 'product':
			include 'pages/product.php';
			break;
		case 'app':
			include 'pages/app.php';
			break;
		case 'cs1':
			include 'pages/cs_1.php';
			break;
		case 'cs2':
			include 'pages/cs_2.php';
			break;
		case 'cs3':
			include 'pages/cs_3.php';
			break;
		case 'download':
			include 'pages/download.php';
			break;
	}		

	/*===================================
	페이지 구분 (컨텐츠 영역) END
	=====================================*/
	?>

    <?include_once 'footer.php';?>
</div>

<!-- Swiper JS -->
<script src="js/swiper.min.js"></script>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper('.swiper-container', {
        pagination: {
            el: '.swiper-pagination',
        },
    });
</script>
  
</body>
</html>