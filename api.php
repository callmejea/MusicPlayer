<?php
include_once "config.php";
$jsonp = [];

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

$callback = $_GET['callback'];
switch ($_POST['types']) {
    case "playlist":
        $tracks = [];
        $file   = file_get_contents($config['cacheFile']);
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

    case "search":
        $file       = file_get_contents('./tmp/cache.json');
        $arr        = json_decode($file, true);
        $searchName = strtolower($_POST['name']);
        $tracks     = [];
        foreach ($arr as $k => $v) {
            $t = strtolower($v);
            if (strpos($t, $searchName) !== false) {
                $tracks[] = [
                    'id'       => $k,
                    'name'     => $v,
                    'ar'       => [
                        [
                            'name' => 'test',
                        ]
                    ],
                    'artist'   => [''],
                    'album'    => '',
                    'lyric_id' => $k,
                    'al'       => ['name' => 'test', 'picUrl' => ''],
                    'source'   => 'local',
                    'url_id'   => 'file.php?s=' . $k,
                    'pic_id'   => null,
                ];
            }
        }
        $jsonp = $tracks;
        break;
    case "lyric":
        $jsonp = "asdfa";
        break;
    default:
        break;
}

echo $callback . '(' . json_encode($jsonp) . ')';