<?

include_once 'common/config.php';
include_once 'common/lib.php';


if(isMobile()){
	include_once 'intro_m.php';
}else{
	include_once 'intro.php';
}

?>
