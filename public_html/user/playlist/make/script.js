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

let playLast = ''

document.addEventListener("click", e => {
   let leftMenu = document.querySelector('.left_menu')
   let screen = document.querySelector('.screen')
   let makeMenu = document.querySelector('.make_menu')
   if (e.target.closest(".play_bg")) {
    if (e.target.closest(".song")) {
        let song = e.target.closest('.song')
        let playStop = song.querySelector('.play')
        if (!document.querySelector(".btn")) {
            document.querySelector(".left")?.classList.add("btn")
            document.querySelector(".right")?.classList.add("btn")
            leftMenu.style = "height: calc(100vh - 155px);"
            screen.style = "height: calc(100vh - 155px);"
            makeMenu.style = "height: calc(100vh - 269px);"
        }   
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
    }
   }
})

document.addEventListener("click", e => {
   if (e.target.closest(".play_img")) {
      document.getElementById("infile").click();
   }
})

function replaceImg(input) {
   if (input.files && input.files[0]) {
      let reader = new FileReader()
      reader.onload = function (e) {
         let res = e.target.result
         const img = document.getElementById("photo_playlist")
         img.src = res
      };
    reader.readAsDataURL(input.files[0]);
   }
}

function addAudio(button) {
   const song = button.closest('.song')
   const songId = song.dataset.id
   const rand = button.closest('.song')
   const randId = rand.dataset.hash

   if (button.querySelector('.rotate45')){
      button.querySelector('img').classList.remove('rotate45')
      var xhr = new XMLHttpRequest()
       let url = new URL('http://t96800rh.beget.tech/user/playlist/make/remove.php')
       url.searchParams.set('hash', randId)
       xhr.open('GET', url, true)
       xhr.send()
       url.searchParams.set('id', songId)
       xhr.open('GET', url, true)
       xhr.send()
   } else {
      button.querySelector('img').classList.add('rotate45')
      var xhr = new XMLHttpRequest()
       let url = new URL('http://t96800rh.beget.tech/user/playlist/make/add.php')
       url.searchParams.set('hash', randId)
       xhr.open('GET', url, true)
       xhr.send()
       url.searchParams.set('id', songId)
       xhr.open('GET', url, true)
       xhr.send()
      }
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