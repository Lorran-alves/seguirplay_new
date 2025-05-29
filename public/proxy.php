<?php
$url = $_GET['url'];
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
$data = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

header("Content-Type: " . $info["content_type"]);
echo $data;
