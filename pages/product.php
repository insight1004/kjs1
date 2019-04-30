<?if (!defined('_COOL_')) exit; // 개별 페이지 접근 불가?>

<?
$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
$host = $_SERVER["HTTP_HOST"]; 
$uri = $_SERVER["REQUEST_URI"]; 


//공유 페이지 URL
$share_url = $protocol.$host.$uri;

//공유 페이지 제목
$share_title = TITLE;

?>

<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>

<script>

var kakaoKey = '<?=KAKAO_API_KEY;?>';
if(kakaoKey!='') Kakao.init(kakaoKey);

function sharePost(kind){
	var url, title, shareURL;
	
	if(kind=='naver'){
		url = encodeURI(encodeURIComponent('<?=$share_url;?>'));
		title = encodeURI('<?=$share_title;?>');

		shareURL = "https://share.naver.com/web/shareView.nhn?url="+url+ "&title="+title;
		window.open(shareURL);
	}else if (kind=='facebook'){
		url = encodeURI(encodeURIComponent('<?=$share_url;?>'));

		shareURL = "https://www.facebook.com/sharer/sharer.php?u=<?=$share_url?>";
		window.open(shareURL);
	}else if (kind=='twitter'){
		url = '<?=$share_url;?>';
		title = '<?=$share_title;?>';

		shareURL = "https://twitter.com/intent/tweet?text="+title+"&url="+url;
		window.open(shareURL);
	}else if (kind=='kakao'){
		url = '<?=$share_url;?>';
		title = '<?=$share_title;?>';

		if(kakaoKey!=''){
			kakaolink_send(title, url, '<?=COVER_IMG;?>');
		}else{
			alert('카카오 API KEY를 등록하세요.');
		}

	}
	
}


function kakaolink_send(text, url, img) {
	Kakao.Link.sendScrap({
		requestUrl: url
	});
}



function copy_url(){
	
	//input박스 value를 선택 
	$('#clip_target').select(); 
	
	// Use try & catch for unsupported browser 
	try { 
		// The important part (copy selected text) 
		var successful = document.execCommand('copy'); 

		if(successful){
			alert('주소가 복사되었습니다.');
		}else{
			alert('주소창을 터치하여 주소를 복사해주세요.'); 
		}
		
	} catch (err) { 
		alert('주소창을 터치하여 주소를 복사해주세요.'); 
	} 
}

</script>

<input id="clip_target" type="text" value="<?=$share_url?>" style="position:absolute;top:-9999em;"/>


<!-- Main banner -->
<div class="sub_top view_xs coolwallet"></div>
<!-- END Main banner -->

<!-- mobile product img -->
<div class="hidden_xs swiper-container">
	<div class="swiper-wrapper">
		<div class="swiper-slide" style="background:url(images/pay_img_1.jpg) center"></div>
		<div class="swiper-slide" style="background:url(images/pay_img_2.jpg) center"></div>
		<div class="swiper-slide" style="background:url(images/pay_img_3.jpg) center"></div>
		<div class="swiper-slide" style="background:url(images/pay_img_4.jpg) center"></div>
		<div class="swiper-slide" style="background:url(images/pay_img_5.jpg) center"></div>
	</div>
	<!-- Add Pagination -->
	<div class="swiper-pagination"></div>
</div>
<!-- END mobile product img //-->


<!-- contents -->
<div class="sub_con">
		
	<!-- pay -->
	<div class="pay_wrap">
		<ul>
			<li class="pay_img">
				<!-- product thumb -->
				<ul class="pay_thumb">
					<li class="active">
						<a href="#nav-pills-tab-1" data-toggle="tab">
							<span class=""><img src="images/pay_img_1.jpg" alt=""></span>
						</a>
					</li>
					<li>
						<a href="#nav-pills-tab-2" data-toggle="tab">
							<span class=""><img src="images/pay_img_2.jpg" alt=""></span>
						</a>
					</li>
					<li>
						<a href="#nav-pills-tab-3" data-toggle="tab">
							<span class=""><img src="images/pay_img_3.jpg" alt=""></span>
						</a>
					</li>
					<li>
						<a href="#nav-pills-tab-4" data-toggle="tab">
							<span class=""><img src="images/pay_img_4.jpg" alt=""></span>
						</a>
					</li>
					<li>
						<a href="#nav-pills-tab-5" data-toggle="tab">
							<span class=""><img src="images/pay_img_5.jpg" alt=""></span>
						</a>
					</li>
				</ul>
				<!-- END product thumb //-->
				<!-- product img -->
				<div class="pay_view">
					<div class="fade active in" id="nav-pills-tab-1">
						<img src="images/pay_img_1.jpg" alt="coolwallet s">
					</div>
					<div class="fade" id="nav-pills-tab-2">
						<img src="images/pay_img_2.jpg" alt="coolwallet s">
					</div>
					<div class="fade" id="nav-pills-tab-3">
						<img src="images/pay_img_3.jpg" alt="coolwallet s">
					</div>
					<div class="fade" id="nav-pills-tab-4">
						<img src="images/pay_img_4.jpg" alt="coolwallet s">
					</div>
					<div class="fade" id="nav-pills-tab-5">
						<img src="images/pay_img_5.jpg" alt="coolwallet s">
					</div>
				</div>
				<!-- END product img //-->
			</li>
			<li>
				<!-- pay -->
				<div class="pay_sys">
					<h1 class="pay_tit">Cool<span class="txt_y">Wallet S</span></h1>
					<p>하드웨어 월렛의 보안성, 편의성, 안정성과 이동성까지 갖춘 세계최초 카드 타입 하드웨어 지갑</p>
					<div class="hline"></div>
					<ul class="price">
						<li><h1 class="pay_money">129,000<span>원</span></h1></li>
						<li class="low_price">149,000 원</li>
					</ul>
					<div class="pay_xs">
						<a href="https://smartstore.naver.com/coolwallets/products/2963664958" target="_blank" class="btn_pay">구매하기</a>
						<div class="hline"></div>
						<!-- sns button -->
						<div class="sns_wrap">
							<a href="javascript:sharePost('facebook');"><img src="images/sns_facebook.png" alt="facebook"></a>
							<a href="javascript:sharePost('twitter');"><img src="images/sns_twitter.png" alt="twitter"></a>
							<a href="javascript:sharePost('kakao');"><img src="images/sns_kakao.png" alt="kakao"></a>
							<a href="javascript:sharePost('naver');"><img src="images/sns_naver.png" alt="naver"></a>
							<a href="javascript:copy_url();"><img src="images/sns_link.png" alt="link"></a>
						</div>
						
					</div>
				</div>
				<!-- END pay //-->
			</li>
		</ul>
	</div>
	<!-- END pay //-->

	<!-- detail -->
	<div class="product_detail">
		<ul>
			<li>
                <div class="view_xs"><img src="images/coolwallet_detail_1.jpg" alt="coolwallet s detail"></div>
                <div class="hidden_xs"><img src="images/coolwallet_detail_mobile_1.jpg" alt="coolwallet s detail"></div>
            </li>
			<li class="btn_wrap">
				<a href="file/coolwallet_s_user_manual.pdf" class="btn_view">매뉴얼 보기</a>
				<a href="file/coolwallet_s_user_manual.zip" class="btn_down">매뉴얼 다운로드</a>
			</li>
			<li>
                <div class="view_xs"><img src="images/coolwallet_detail_2.jpg" alt="coolwallet s detail"></div>
                <div class="hidden_xs"><img src="images/coolwallet_detail_mobile_2.jpg" alt="coolwallet s detail"></div>
            </li>
		</ul>
		<!-- END detail //-->
	</div>


</div>    
<!-- END contents //-->