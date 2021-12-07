MusicPlayer - local player
========
### 禁止用于商业用途，仅限用于自己听音乐

> 由于不通平台之间的音乐不互通，但都提供下载的方式，在不侵权的情况下有此项目，从 [https://github.com/mengkunsoft/MKOnlineMusicPlayer](https://github.com/mengkunsoft/MKOnlineMusicPlayer) 这里fork的，进行了本地音乐播放的api添加，略微改动了js，仿照js接口增加了 php API，仅支持播放已下载的音乐文件。

### docker
```
docker pull justdoitlikemea/musicplayer
# 挂载本地的音乐目录到 /music/musicFiles；端口监听为8888，映射出来的端口随意～像下面一样
docker run -v /Users/jea/Music/download:/music/musicFiles -p 8888:8888 -d justdoitlikemea/musicplayer
#一份完整的docker-compose参见项目内的 docker-compose.yml
```

### 使用
- 安装php，任意版本即可，开发使用的为7.2
- 下载项目
- 修改config.php中的dir为你本地的音乐存储目录，会自动遍历所有文件作为音乐文件
- 音乐文件发生变更时将自动更新缓存列表，策略为每次访问更新
- 最小使用如下
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