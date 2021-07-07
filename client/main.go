package main

import (
	"encoding/json"
	"fmt"
	"github.com/faiface/beep"
	"github.com/faiface/beep/mp3"
	"github.com/faiface/beep/speaker"
	"io"
	"net/http"
	"os"
	"time"
)

type music struct {
	Id   string
	Name string
}
type musicList []music

var allMusic musicList
var allMusicId map[int]string

/**
 * get remote music list
 */
func playlist() {
	res, err := http.Get("http://localhost:8888/clientApi.php?types=playlist")
	if err != nil {
		panic(err)
	}
	defer res.Body.Close()

	err = json.NewDecoder(res.Body).Decode(&allMusic)
	if err != nil {
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
	res, err := http.Get("http://localhost:8888/file.php?id=" + file)
	if err != nil {
		panic(err)
	}
	fmt.Print("start play")
	musicFile := "/Users/jea/www/music/client/cache/" + file + ".mp3"
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
	streamer, format, err := mp3.Decode(m)
	if err != nil {
		panic(err)
	}
	defer streamer.Close()
	err = speaker.Init(format.SampleRate, format.SampleRate.N(time.Second/10))
	if err != nil {
		panic(err)
	}

	done := make(chan bool)
	speaker.Play(beep.Seq(streamer, beep.Callback(func() {
		done <- true
	})))
	<-done
	defer speaker.Close()
	defer speaker.Clear()
}

func main() {
	allMusicId = make(map[int]string)
	playlist()
	musicFile := getFile("22c23130c88acf4f6c7c3497c473b071")
	play(musicFile)
	select {}
}
