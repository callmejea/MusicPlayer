<?php
include_once "config.php";
$json = [];

switch ($_GET['types']) {
    case "playlist":
        $tracks = [];
        $file   = file_get_contents('./tmp/cache.json');
        $arr    = json_decode($file, true);
        foreach ($arr as $k => $v) {
            $json[] = [
                'id'   => $k,
                'name' => $v,
            ];
        }
        break;

    case "url":
        $json = [
            'url' => '/file.php?id=' . $_GET['id'],
        ];

        break;
    default:
        break;
}


echo json_encode($json, JSON_UNESCAPED_UNICODE);