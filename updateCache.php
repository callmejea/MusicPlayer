<?php
include_once 'config.php';

$files = glob($config['dir'] . '*');
$arr   = [];
if (!$files) {
    p($config['cacheFile'], '[]');
}
foreach ($files as $file) {
    $md5       = md5($file);
    $arr[$md5] = str_replace($config['dir'], '', $file);
}
p($config['cacheFile'], json_encode($arr, JSON_UNESCAPED_UNICODE));

function p($cacheFile, $content)
{
    file_put_contents($cacheFile, $content);
}