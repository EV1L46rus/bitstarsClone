function endOfSong() {
    let idSong = event.target.dataset.id
    nextSong(event.target)
}

function changeSong(audio){
    document.querySelector(".activesong")?.classList.remove("activesong")
    audio.closest(".feed_one")?.classList.add("activesong")
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
    let newSong = eSong.closest(".feed_one").nextElementSibling?.querySelector("audio")
    if (newSong) {
        changeSong(newSong)
    } else {
        let firstSong = document.querySelector(".songs_list").firstElementChild.querySelector("audio")
        changeSong(firstSong)
    }
}

function prevSong(eSong) {
    let newSong = eSong.closest(".feed_one").previousElementSibling?.querySelector("audio")
    if (newSong) {
        changeSong(newSong)
    } else {
        let firstSong = document.querySelector(".songs_list").lastElementChild.querySelector("audio")
        changeSong(firstSong)
    }
}

document.addEventListener("click", e => {
    if (e.target.closest(".btn_play")) {
        if (e.target.closest(".feed_one")) {
            if (!document.querySelector(".btn")) {
                document.querySelector(".left")?.classList.add("btn")
                document.querySelector(".right")?.classList.add("btn")
            }   
            let audio = e.target.closest(".feed_one").querySelector("audio")
            let screenHeight = document.querySelector('.screen')
            if (!audio.classList.contains("active")) {
                changeSong(audio)
                screenHeight.style = 'height: calc(100vh - 200px);'
            } else {
                audio.paused ? audio.play() : audio.pause()
            }
        }
    }
})