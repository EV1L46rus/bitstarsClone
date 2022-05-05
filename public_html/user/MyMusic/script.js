function endOfSong() {
    let idSong = event.target.dataset.id
    nextSong(event.target)
}

function changeSong(audio){
    document.querySelector(".activesong")?.classList.remove("activesong")
    audio.closest(".one_song")?.classList.add("activesong")
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
    let newSong = eSong.closest(".one_song").nextElementSibling?.querySelector("audio")
    if (newSong) {
        changeSong(newSong)
    } else {
        let firstSong = document.querySelector(".songs_list").firstElementChild.querySelector("audio")
        changeSong(firstSong)
    }
}

function prevSong(eSong) {
    let newSong = eSong.closest(".one_song").previousElementSibling?.querySelector("audio")
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
	if (e.target.closest(".btn_play")) {
    if (e.target.closest(".one_song")) {
    	let song = e.target.closest('.one_song')
        let playStop = song.querySelector('.play')
        if (!document.querySelector(".btn")) {
            document.querySelector(".left")?.classList.add("btn")
            document.querySelector(".right")?.classList.add("btn")
            leftMenu.style = "height: calc(100vh - 155px);"
            screen.style = "height: calc(100vh - 155px);"
        }   
        let audio = e.target.closest(".one_song").querySelector("audio")
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

function deleteSong(songId) {
	var xhr = new XMLHttpRequest()
    let url = new URL('http://t96800rh.beget.tech/user/MyMusic/delete.php')
    url.searchParams.set('id', songId)
    xhr.open('GET', url, true)
    xhr.send()
}

function acceptPopUp(button) {
	const song = button.closest('.one_song')
	const songId = song.dataset.id
	let acceptDiv = document.createElement('div')
	acceptDiv.className = 'acceptpopup'
	let div = document.createElement('div')
	let h2 = document.createElement('h2')
	h2.innerHTML = "Вы уверены, что хотите удалить аудиозапись?"
	let buttonYes = document.createElement('button')
	buttonYes.innerHTML = 'Yes'
	buttonYes.dataset.id = songId
	buttonYes.setAttribute("onclick","confirmed(this)")
	let buttonNo = document.createElement('button')
	buttonNo.innerHTML = 'No'
	buttonNo.setAttribute("onclick","cancel()")
	div.appendChild(h2)
	div.appendChild(buttonYes)
	div.appendChild(buttonNo)
	acceptDiv.appendChild(div)
	document.body.appendChild(acceptDiv)

}

function confirmed(buttonYes) {
	deleteSong(buttonYes.dataset.id)
	document.querySelector('.acceptpopup')?.remove()
	document.querySelector('div[data-id="'+buttonYes.dataset.id+'"]')?.remove()
}

function cancel() {
	document.querySelector('.acceptpopup')?.remove()
	document.querySelector('.edit_screen')?.remove()
}

document.addEventListener("click", e => {
   if (e.target.closest(".img")) {
      document.getElementById("infile").click();
   }
})

function editPopUp(button) {
	const song = button.closest('.one_song')
	const imgCart = song.querySelector('.img_song').src
	const songId = song.dataset.id
	const songRash = song.dataset.rash
	const songTitle = song.dataset.title
	const songName = song.dataset.name
	let random = Math.floor(Math.random(100) * 1000)
	let form = document.createElement('form')
	form.enctype = 'multipart/form-data'
	form.method = "POST"
	let inputId = document.createElement('input')
	inputId.type = 'hidden'
	inputId.name = 'id[]'
	inputId.value = songId
	let editDiv = document.createElement('div')
	editDiv.className = 'edit_screen'
	let menuDiv = document.createElement('div')
	menuDiv.className = 'edit_menu'
	let closeDiv = document.createElement('div')
	closeDiv.className = 'close'
	let h3 = document.createElement('h3')
	h3.innerHTML = "Edit audio"
	let buttonImg = document.createElement('button')
	buttonImg.setAttribute("onclick","cancel()")
	let img = document.createElement('img')
	img.src = "/img/close _menu.png"
	let screenDiv = document.createElement('div')
	screenDiv.className = 'screen_menu'
	let imgDiv = document.createElement('div')
	imgDiv.className = 'img'
	let inpImg = document.createElement('input')
	inpImg.className = 'upload_img'
	inpImg.id = 'infile'
	inpImg.type = 'file'
	inpImg.name = 'img_file'
	inpImg.accept = 'image/*'
	let imgSong = document.createElement('img')
	imgSong.src = imgCart
	imgSong.id = 'avatar'
	let changeDiv = document.createElement('div')
	changeDiv.className = 'change'
	let h3Change = document.createElement('h3')
	h3Change.innerHTML = "Edit photo"
	let inputDiv = document.createElement('div')
	inputDiv.className = 'input_div'
	let inputAuthor = document.createElement('input')
	inputAuthor.type = 'text'
	inputAuthor.name = 'author'
	inputAuthor.placeholder = 'Author'
	inputAuthor.value = songName
	let inputTitle = document.createElement('input')
	inputTitle.type = 'text'
	inputTitle.name = 'title'
	inputTitle.placeholder = 'Title'
	inputTitle.value = songTitle
	let buttonSave = document.createElement('button')
	buttonSave.name = 'save'
	let h3Save = document.createElement('h3')
	h3Save.innerHTML = "Save"

	document.body.appendChild(form)
	form.appendChild(inputId)
	form.appendChild(editDiv)
	editDiv.appendChild(menuDiv)
	menuDiv.appendChild(closeDiv)
	closeDiv.appendChild(h3)
	closeDiv.appendChild(buttonImg)
	buttonImg.appendChild(img)
	menuDiv.appendChild(screenDiv)
	screenDiv.appendChild(imgDiv)
	imgDiv.appendChild(inpImg)
	imgDiv.appendChild(imgSong)
	imgDiv.appendChild(changeDiv)
	changeDiv.appendChild(h3Change)
	screenDiv.appendChild(inputDiv)
	inputDiv.appendChild(inputAuthor)
	inputDiv.appendChild(inputTitle)
	menuDiv.appendChild(buttonSave)
	buttonSave.appendChild(h3Save)

}