<?

/*
http://www.coolwallet.co.kr/
카페24 계정
ID : coolwallet
PW : aksfpq711

Mysql
uws64-150.cafe24.com/WebMysql
ID : coolwallet
pw : aksfpq711!


개발 환경
CentOS Linux release 7.2
php 5.5 / Apache 1.3 / mysql 5.1.45

패스워드 암호화 : BCRYPT 

*/

header("Content-Type: text/html; charset=UTF-8");

//개별 페이지 접속 불가 상수
define('_COOL_', true);

//Site Url
define('DOMAIN', 'http://coolwallet.cafe24.com');

//Title
define('TITLE', '[Coolwallet] 세계최초 카드 타입 월렛');

//Description
define('DESCRIPTION', '보안성, 편의성, 안정성, 이동성까지 제공하는 세계최초 카드 타입 월렛');

//Title - Admin
define('TITLE_ADMIN', '[Coolwallet] 관리자');

//대표 이미지
define('COVER_IMG', 'http://coolwallet.cafe24.com/images/opengraph.jpg');

//shortcut icon
define('ICON_URL', '/images/favicon.ico');

//apple-touch-icon-precomposed
define('ICON_URL_APPLE', '/images/touch_wallet.png');

//카카오 API KEY
define('KAKAO_API_KEY', ''); 

// MySQLi 사용여부를 설정합니다.
define('MYSQLI_USE', true);

// escape string 처리 함수 지정
define('ESCAPE_FUNCTION', 'sql_escape_string');

//세션사용 (기본 180분)
session_cache_expire(120); // 세션 캐쉬 보관시간 (분)
ini_set("session.gc_probability", 1);
ini_set("session.gc_divisor", 1);
ini_set("session.gc_maxlifetime", 7200); //초
ini_set("session.cache_expire", 120); // 세션 캐쉬 보관시간 (분)
session_start();

//공통 배열 변수
$cool = array();

//슈퍼관리자 비밀번호 찾기 허용 (로그인 페이지)
define('SUPER_PWD_RENEW', true);

//메인배너 파일 저장경로, 허용 파일 사이즈(MB), 확장자
define('MAIN_FILE_PATH', '../files/mainbn/');
define('MAIN_FILE_SIZE', 5);
$main_file_formats = array("jpg", "png", "gif", "bmp", "jpeg");

//1:1문의 파일 저장경로, 허용 파일 사이즈(MB), 확장자
define('QNA_FILE_PATH', '../files/qna/');
define('QNA_FILE_IMAGE_SIZE', 5); 
define('QNA_FILE_MOVIE_SIZE', 20);  //300
$qna_image_formats = array("jpg", "png", "gif", "bmp", "jpeg");
$qna_movie_formats = array("avi", "mp4", "mov");

//1:1문의 등록시 알림 메일 (이메일 주소)
$qna_email = array("js505123@nate.com", "panda505@naver.com");

//메일 발송에 사용할 대표 이메일 주소, 이름
define('FROM_EMAIL', 'test@test.com');
define('FROM_NAME', 'Coolwallet');

//처음 설정시 슈퍼 관리자(활동중인)가 없는 경우, 관리자 로그인 페이지에서 해당 계정을 슈퍼관리자로 자동으로 생성
//(모든 값이 설정되어있어도 활동중인 슈퍼관리자가 한 개도 없는 경우만 생성. 동일한 ID(Email)가 이미 있다면 생성되지 않음)
define('SUPER_BASE_USE', true);
define('SUPER_BASE_ID', 'admin@aaa.com');
define('SUPER_BASE_PWD', '123456789a');
?>