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
    
    <!-- Main Slider banner -->
    <div class="swiper-container main_slider">
        <div class="swiper-wrapper">
            
			<?
			$sql = " SELECT idx, mb_link, mb_target, mb_reg_date, mb_edit_date, mb_state ";
			$sql .= " FROM ".$db['main_bn_table'];
			$sql .= " WHERE mb_state=1 ";
			$sql .= " ORDER BY idx DESC ";
			
			//DB 객체 생성
			$con_db = db_connect();

			$result = mysqli_query($con_db, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				while($row = $result->fetch_assoc()){

					//이미지 조회
					$getFile = mysqli_fetch_assoc(mysqli_query($con_db, "SELECT filename FROM ".$db['main_bn_file_table']." WHERE mb_idx=".$row['idx']));
					$filename = $getFile['filename'];

				?>
					<div class="swiper-slide mbanner" style="background:url(files/mainbn/<?=$filename;?>) center; background-size:cover">
						<?if( ($row['mb_target']=='_self' || $row['mb_target']=='_blank') && $row['mb_link'] ){?>
						<a href="<?=$row['mb_link'];?>" target="<?=$row['mb_target'];?>"></a>
						<?}?>
					</div>
				<?
				}
			}
			?>
			

        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next swiper-button-white"></div>
        <div class="swiper-button-prev swiper-button-white"></div>
    </div>
    <!-- END Main Slider banner -->
    
    <!-- contents -->
    <div class="con mt70">
        <div class="con_tit">
            <h1>가장 안전한 하드웨어 월렛, Cool<span class="txt_y">Wallet S</span></h1>
            <p>CoolWallet S는 카드 안에서 Private Key(개인키)를 생성하여 어떠한 제품보다 안전합니다.</p>
        </div>
        <div class="bg_cover_l"></div>
        <a href="/sub.php?bkind=product" class="btn_more">더보기</a>
        <div class="product tar prod_1">
            <img src="images/product_img_1.png" alt="가장 안전한 하드웨어 월렛" class="mpc">
            <img src="images/product_img_1s.png" alt="가장 안전한 하드웨어 월렛" class="mobi">
        </div>
    </div>
    
    <div class="con">
        <div class="con_tit">
            <h1>스마트폰과 직접 연결하는<span class="txt_y">단 하나의 월렛</span></h1>
            <p>스마트폰과 CoolWallet S를 연결 하여 쉽고 빠르게 거래하세요. CoolWallet S가 있으면 거래소가 필요 없습니다.</p>
        </div>
        <div class="bg_cover_r"></div>
        <a href="/sub.php?bkind=product" class="btn_more">더보기</a>
        <div class="product tal prod_2">
            <img src="images/product_img_2.png" alt="스마트폰과 직접 연결하는 단 하나의 월렛" class="mpc">
            <img src="images/product_img_2s.png" alt="스마트폰과 직접 연결하는 단 하나의 월렛" class="mobi">
        </div>
    </div>
    
    <div class="con">
        <div class="con_tit">
            <h1>편리한 이용, <span class="txt_y">강력한 보안</span></h1>
            <p>CoolWallet S는 지갑에 넣을 수 있는 신용카드 사이즈이기 때문에 이용이 편리합니다.</p>
            <p>또한 암호화된 블루투스 연결을 통해 입금과 출금 모두 강력한 보안 하에 가능합니다.</p>
        </div>
        <div class="bg_cover_l"></div>
        <a href="/sub.php?bkind=product" class="btn_more">더보기</a>
        <div class="product product_2 tar prod_3">
            <img src="images/product_img_3.png" alt="편리한 이용, 강력한 보안" class="mpc">
            <img src="images/product_img_3s.png" alt="편리한 이용, 강력한 보안" class="mobi">
        </div>
    </div>
    
    <!-- product mov -->
    <div class="con_mov">
        <div class="mov_txt">
            <p>영상으로 보는 CoolWallet S</p>
            <div class="hyphen"></div>
            <h3>하드웨어 월렛의<br class="view_xs">보안성, 편의성, 안정성과<br class="view_xs">이동성까지 갖춘<br class="view_xs">세계최초 카드 타입 하드웨어 월렛</h3>
            <p><img src="images/bi_invert.png" alt="CoolWallet S"></p>
        </div>
        <div class="mov_li">
            <video class="" controls poster="images/con_mov.jpg">
                <source src="file/coolwallet_intro.mp4" type="video/mp4" />
            </video>
        </div>
    </div>
    <!-- END product mov //-->
    
    <!-- support -->
    <div class="cs_wrap">
        <div>
            <p class="cs_txt1">CoolWallet S 사용 관련 궁금하신 점이 있으면</p>
            <h2 class="cs_txt2">한솔시큐어 고객센터</h2>
            <p class="cs_txt3">02-2082-0756</p>
            <p class="cs_txt4">(고객센터 운영 시간 평일 10:00~12:00, 13:00~17:00)</p>
        </div>
    </div>
    <!-- END support //-->
    <!-- END contents //-->
    
    <?include_once 'footer.php';?>
</div>

<!-- swiper js -->
<script src="js/swiper.min.js"></script>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper('.swiper-container', {
        spaceBetween: 0,
        loop: true,
        centeredSlides: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>

</body>
</html>