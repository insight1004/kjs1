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
<div class="intro_wrap_m">
    <div class="">
        <a href="main.php" class="btn_m_intro"><img src="images/intro_bg_mobile.jpg" alt="coolwallet "></a>
    </div>
</div>
</body>
</html>