document.addEventListener("click", e => {
   if (e.target.closest(".edite_btn")) {
      let idClick = e.target.closest(".edite_btn").id
      document.getElementById("editor_"+idClick).click();
   }
})

function endOfSong() {
    let idSong = event.target.dataset.id
    nextSong(event.target)
}

function changeSong(audio){
    document.querySelector(".activesong")?.classList.remove("activesong")
    audio.closest(".song")?.classList.add("activesong")
    document.querySelector(".active")?.pause()
    document.querySelector(".active")?.removeEventListener("ended", endOfSong)
    document.querySelector(".active")?.classList.remove("active")
    audio.classList.add("active")
    audio.play()
}

function clicked(dir) {

    const audio = document.querySelector(".active")

    
    if(dir == 'left'){
        prevSong(audio)
    } else {
        nextSong(audio)
    }
}

function nextSong(eSong) {
    let newSong = eSong.closest(".song").nextElementSibling?.querySelector("audio")
    if (newSong) {
        changeSong(newSong)
    } else {
        let firstSong = document.querySelector(".songs_list").firstElementChild.querySelector("audio")
        changeSong(firstSong)
    }
}

function prevSong(eSong) {
    let newSong = eSong.closest(".song").previousElementSibling?.querySelector("audio")
    if (newSong) {
        changeSong(newSong)
    } else {
        let firstSong = document.querySelector(".songs_list").lastElementChild.querySelector("audio")
        changeSong(firstSong)
    }
}

const leftMenu = document.querySelector('.left_menu')
const screen = document.querySelector('.screen')
const makeMenu = document.querySelector('.playlist_push')
let playLast = ''


document.addEventListener("click", e => {
   if (e.target.closest(".play_bg")) {
        let song = e.target.closest('.song')
        let playStop = song.querySelector('.play')   
        let audio = e.target.closest(".song").querySelector("audio")
        if (!audio.classList.contains("active")) {
            changeSong(audio)
            playStop.src = '/img/pausedark.png'
            playLast.src = '/img/playdark.png'
            playLast = playStop
        } else {
            if (audio.paused) {
                audio.play()
                
                playStop.src = '/img/pausedark.png'
            } else {
                audio.pause()
                playStop.src = '/img/playdark.png'
            }
            
        }
        if (!document.querySelector(".btn")) {
            document.querySelector(".left")?.classList.add("btn")
            document.querySelector(".right")?.classList.add("btn")
            document.querySelector('.playlsit_show').style = 'height: calc(100vh - 155px);'
            leftMenu.style = "height: calc(100vh - 155px);"
            screen.style = "height: calc(100vh - 155px);"
            makeMenu.style = "height: calc(100vh - 155px);"
        }
   }
})

function playListAdd(img) {
   let idPlaylist = img.id
   let addClassPlaylist = document.getElementById('playlist'+idPlaylist)
   addClassPlaylist.classList.add("playlsit_show")
}

function playListRemove(div) {
   let addClassPlaylist = document.querySelector('.playlsit_show')
   addClassPlaylist.classList.remove("playlsit_show") 
}


document.querySelector('.search_music_input').addEventListener('input', searchUpdate)

function searchUpdate() {
   const allSongs = document.querySelectorAll('.song')
   const search = document.querySelector('.search_music_input').value.toLowerCase()
   Object.entries(allSongs).forEach(([num, song]) => {
      let text = song['innerText'].toLowerCase()
      song.style = ""
      if (!text.includes(search)) {
         song.style = "display: none;"
      }
   }) 
}