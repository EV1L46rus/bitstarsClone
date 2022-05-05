function endOfSong() {
    let idSong = event.target.dataset.id
    var xhr = new XMLHttpRequest()
    let url = new URL('http://t96800rh.beget.tech/Tracks/song.php')
    url.searchParams.set('id', idSong)
    xhr.open('GET', url, true)
    xhr.send()
    nextSong(event.target)
}

function changeSong(audio){
    document.querySelector(".activesong")?.classList.remove("activesong")
    audio.closest(".song")?.classList.add("activesong")
    document.querySelector(".active")?.pause()
    document.querySelector(".active")?.removeEventListener("ended", endOfSong)
    document.querySelector(".active")?.classList.remove("active")
    audio.addEventListener("ended", endOfSong)
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
    if (e.target.closest(".song")) {
        let song = e.target.closest('.song')
        let playStop = song.querySelector('.play') 
        if (!document.querySelector(".btn")) {
            document.querySelector(".left")?.classList.add("btn")
            document.querySelector(".right")?.classList.add("btn")
            document.querySelector(".audio_filtres_list").style = 'height: calc(100vh - 155px);'
            document.querySelector(".tracks_filters").style = 'height: calc(100vh - 155px);'
            document.querySelector(".audio_list").style = 'height: calc(100vh - 155px);'
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
})

function pushBtn(button) {
    if (button.querySelector('.rotate90')){
        button.querySelector('img').classList.remove('rotate90')
        document.querySelector('.menu_lvl_2').classList.remove('slide_down')
        document.querySelector('.menu_lvl_2_hide').classList.remove('slide_down')
        document.querySelector('.pushMenuType').style = 'top: 150px;'
        hideMore()
    } else {
        button.querySelector('img').classList.add('rotate90')
        document.querySelector('.menu_lvl_2').classList.add('slide_down')
        document.querySelector('.menu_lvl_2_hide').classList.add('slide_down')
        document.querySelector('.pushMenuType').style = 'top: 375px;'
        
    }

}


function showMore () {
    document.querySelector('.menu_lvl_2').style = 'display: none;'
    document.querySelector('.menu_lvl_2_hide').style = 'display: block;'
    document.querySelector('.pushMenuType').style = 'top: 5025px;'
    
}

function hideMore () {
    document.querySelector('.menu_lvl_2').style = 'display: block;'
    document.querySelector('.menu_lvl_2_hide').style = 'display: none;'
    if (document.querySelector('.slide_down')) {
        document.querySelector('.pushMenuType').style = 'top: 375px;'
    } else {
        document.querySelector('.pushMenuType').style = 'top: 150px;'
    }
}

function pushBtnType(div) {
    if (div.querySelector('.rotate90')){
        div.querySelector('img').classList.remove('rotate90')  
        document.querySelector('.menu_lvl_2_type').classList.remove('slide_down_type')
    } else {
        div.querySelector('img').classList.add('rotate90')
        document.querySelector('.menu_lvl_2_type').classList.add('slide_down_type')
    }
    
}
