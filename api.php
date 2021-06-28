<?php
include_once "config.php";
$jsonp = [];

$callback = $_GET['callback'];
switch ($_POST['types']) {
    case "playlist":
        $tracks = [];
        $file   = file_get_contents('./tmp/cache.json');
        $arr    = json_decode($file, true);
        foreach ($arr as $k => $v) {
            $tracks[] = [
                'id'     => $k,
                'name'   => $v,
                'ar'     => [
                    [
                        'name' => 'test',
                    ]
                ],
                'al'     => ['name' => 'test', 'picUrl' => ''],
                'source' => 'local',
                'url'    => 'file.php?s=' . $k,
            ];
        }
        $jsonp = [
            'playlist' => [
                'name'        => 'Jea',
                'coverImgUrl' => 'https://image.xidibuy.com/linz/linz.1fc38e441024b2db9287b909bd814446a61ca92355d96faebf5aa4c4361a27fb.png/1030x340',
                'creator'     => [
                    'name'      => 'Jea',
                    'avatarUrl' => 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eqdm5fvvGZ14rKg2roVbKiboHcaTxOqtJicqHdjOYtAPFibOrsPEUhK4qraM5A4QfzEpz3icYLlEZdsOQ/132',
                ],
                'tracks'      => $tracks,
            ],
        ];
        break;

    case "url":
        $jsonp = [
            'url' => '/file.php?id=' . $_POST['id'],
        ];

        break;
    default:
        break;
}

echo $callback . '(' . json_encode($jsonp) . ')';