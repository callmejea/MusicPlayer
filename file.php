<?php
include_once 'config.php';

$file = file_get_contents('./tmp/cache.json');
$arr  = json_decode($file, true);

echo file_get_contents($config['dir'] . $arr[$_GET['id']]);