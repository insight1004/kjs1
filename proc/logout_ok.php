<?
//include
include_once '../common/config.php';
include_once '../common/string.php';

session_start();
session_destroy();

echo '{"state":true, "rtnmsg":"'.$msgstr['logout_success'].'"}';
exit;
?>
