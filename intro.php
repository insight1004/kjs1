<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="ko">
<!--<![endif]-->

<?
//include
include_once 'common/config.php';
?>

<head>
	<title><?=TITLE?></title>
	<?include_once 'common/meta.php';?>

    <link rel="shortcut icon" type="image/x-icon" href="<?=ICON_URL?>" />   
	
    <!-- BEGIN Touch icon -->
	<link rel="apple-touch-icon-precomposed" href="<?=ICON_URL_APPLE?>" />
	<!-- END Touch icon -->
    
    <!--  BASE CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="css/material-icons.min.css" rel="stylesheet" />
    <link href="css/animate.min.css" rel="stylesheet" />
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
    
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    
</head>
<body>
<div class="intro_wrap">
<div class="intro_bg">
    <!-- Title effect -->
    <div class="intro_tit">
        <h2 class="animated ani_tit_1">스마트한 소비의 시작</h2>
        <div class="animated ani_tit_2"><img src="images/intro_bi.png" alt="CoolWallet"></div>
    </div>
    <!-- END Title effect //-->
    
    <!-- wallet card animation -->
    <div class="card_wrap">
        <div>
            <ol class="grid ani_button">
                <li class="grid__item">
                    <button class="icobutton" href="#hello" data-toggle="tab" >
                        <span>
                            <div class="btn_img animated">
                                <img src="images/intro_button2.png" alt="button" >
                            </div>
                        </span>
                    </button>
                </li>
            </ol>
            <!-- card img -->
            <div class="wallet_package">
                <div id="hello" class="img_hello animated hello"><img src="images/intro_hello.png" alt="hello" id="aaa"></div>
                <div class="animated ani_card_1">
                    <div><img src="images/intro_front_card.png" alt="coolwallet card"></div>
                </div>
                <div class="animated ani_card_2"><img src="images/intro_back_box.png" alt="coolwallet package"></div>
                <div class="animated ani_card_3"><img src="images/intro_back_card.png" alt="coolwallet card"></div>
            </div>
        </div>
    </div>
    <!-- END wallet card animation //-->
</div>
</div>
<!-- intro effect -->
<!-- <script src="js/ani-mo.min.js"></script> -->
<script src="js/ani-mo.js"></script>
<script src="js/ani-demo.js"></script>
<!-- END intro effect //-->


</body>
</html>