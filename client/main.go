package main

import (
	"encoding/json"
	"fmt"
	"github.com/faiface/beep"
	"github.com/faiface/beep/mp3"
	"github.com/faiface/beep/speaker"
	"io"
	"math/rand"
	"net/http"
	"os"
	"time"
)

type music struct {
	Id   string
	Name string
}
type musicList []music

var allMusic musicList        // 全部音乐 id=》name组合
var allMusicId map[int]string // 所有的id， int => id
var server string             // 服务端server 如：http://a.com 不要带/
var rType string              // 播放方式 默认列表循环 list 随机random
var cacheDir string           // 缓存文件地址
var nowId = 0                 // 正在播放的id

/**
 * get remote music list
 */
func playlist() {
	res, err := http.Get(server + "/clientApi.php?types=playlist")
	if err != nil {
		fmt.Println("Get list failed")
		panic(err)
	}
	defer res.Body.Close()

	err = json.NewDecoder(res.Body).Decode(&allMusic)
	if err != nil {
		fmt.Println("Decode json failed")
		panic(err)
	}
	for i, d := range allMusic {
		allMusicId[i] = d.Id
	}
}

/**
 * get remote mp3 and write to local file then return the path
 */
func getFile(file string) string {
	musicFile := cacheDir + "/" + file + ".mp3"
	_, err := os.Stat(musicFile) //os.Stat获取文件信息
	if err != nil {
		if os.IsExist(err) {
			return musicFile
		}
	}

	res, err := http.Get(server + "/file.php?id=" + file)
	if err != nil {
		fmt.Println("Download file failed")
		panic(err)
	}
	defer res.Body.Close()
	f, err := os.Create(musicFile)
	_, err = io.Copy(f, res.Body)

	defer f.Close()
	return musicFile
}

/**
 * load mp3 file and play
 */
func play(musicFile string) {
	m, err := os.Open(musicFile)
	if err != nil {
		fmt.Print("Open mp3 file failed %s", musicFile)
		panic(err)
	}
	defer m.Close()
	streamer, format, e := mp3.Decode(m)
	if e != nil {
		fmt.Print("Decode mp3 file failed %s", musicFile)
		panic(err)
	}
	defer streamer.Close()
	err = speaker.Init(format.SampleRate, format.SampleRate.N(time.Second/10))
	if err != nil {
		fmt.Print("Init streamer failed %s", musicFile)
		panic(err)
	}
	defer speaker.Close()
	defer speaker.Clear()
	fmt.Println("now Start : " + allMusic[nowId].Name + "\n")
	done := make(chan bool)
	speaker.Play(beep.Seq(streamer, beep.Callback(func() {
		done <- true
	})))
	<-done
}

func next() string {
	r := rand.New(rand.NewSource(time.Now().UnixNano()))

	l := len(allMusicId)
	if rType == "random" {
		next := r.Intn(l)
		nowId = next
	} else {
		if nowId == l {
			nowId = 0
		} else {
			nowId += 1
		}
	}
	return allMusicId[nowId]
}

func main() {
	/*if len(os.Args) != 4 {
		fmt.Print("usage : ")
		os.Exit(1)
	}*/
	rType = "random"                               //os.Args[1]
	server = "http://localhost:8888"               //os.Args[2]
	cacheDir = "/Users/jea/www/music/client/cache" //os.Args[2]
	allMusicId = make(map[int]string)
	playlist()
	//p := make(chan bool)
	play(getFile(next()))
}
