document.addEventListener("click", e => {
   if (e.target.closest(".upploadAudio")) {
      document.getElementById("file").click();
   }
   if (e.target.closest(".add_img")) {
      document.getElementById("change_img").click();
   }
})

document.getElementById('file').addEventListener('change', function(){
  if( this.value ){
   let changeBg = document.getElementById('change_bg')
   changeBg.style = 'background: green;'
   changeBg.querySelector('h2').innerHTML = 'Audio added'
  }
})

function replaceImg(input) {
   if (input.files && input.files[0]) {
      let reader = new FileReader()
      reader.onload = function (e) {
         let res = e.target.result
         const img = document.getElementById("avatar")
         img.src = res
      };
    reader.readAsDataURL(input.files[0]);
   }
}