<?if (!defined('_COOL_')) exit; // 개별 페이지 접근 불가?>
<?
//DB 접속 정보
define('MYSQL_HOST', 'localhost');
define('MYSQL_USER', 'coolwallet');
define('MYSQL_PASSWORD', 'aksfpq711!');
define('MYSQL_DB', 'coolwallet');
define('MYSQL_SET_MODE', false);


$db['admin_table'] = 'TB_Admin'; // 관리자 유저
$db['faq_table'] = 'TB_FAQ'; // FAQ 테이블
$db['main_bn_table'] = 'TB_MainBanner'; // 메인 배너 관리 테이블
$db['main_bn_file_table'] = 'TB_MainBanner_File'; // 메인 배너 파일 테이블
$db['notice_table'] = 'TB_Notice'; // 공지사항 테이블
$db['qna_table'] = 'TB_QNA'; // QNA 테이블
$db['qna_file_table'] = 'TB_QNA_File'; // QNA 파일 테이블
?>