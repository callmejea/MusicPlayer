MusicPlayer - local player
========
### 禁止用于商业用途，仅限用于自己听音乐

> 由于不通平台之间的音乐不互通，但都提供下载的方式，在不侵权的情况下有此项目，从 [https://github.com/mengkunsoft/MKOnlineMusicPlayer](https://github.com/mengkunsoft/MKOnlineMusicPlayer) 这里fork的，进行了本地音乐播放的api添加，略微改动了js，仿照js接口增加了 php API，仅支持播放已下载的音乐文件。

### 使用
- 安装php，任意版本即可，开发使用的为7.2
- 下载项目
- 修改config.php中的dir为你本地的音乐存储目录，会自动遍历所有文件作为音乐文件
- 执行 php updateCache.php 会自动写入缓存文件目录，当音乐文件发生变更时需要重新执行该脚本
- 最简单的方式
```
cd $DIR;
php -S 127.0.0.1:8888
```
- 结束，直接访问就能听歌了，如果列表没音乐就点一下播放列表，再点任意一个播放列表即可加载全部音乐

# 相关链接
**Fork from ** [https://github.com/mengkunsoft/MKOnlineMusicPlayer](https://github.com/mengkunsoft/MKOnlineMusicPlayer)

# Thanks for 
[https://github.com/mengkunsoft/MKOnlineMusicPlayer](https://github.com/mengkunsoft/MKOnlineMusicPlayer)

[https://github.com/faiface/beep](https://github.com/faiface/beep)
# License
MIT