document.addEventListener("click", e => {
   if (e.target.closest(".clicked_btn")) {
      document.getElementById("infile").click();
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

function openPassword () {
   let form = document.querySelector('.form_log')
   let h1 = document.createElement('h4')
   h1.innerHTML = "Old password"
   
   let input = document.createElement('input')
   input.name = "oldpassword"
   input.className = "data"
   input.type = "password"

   let input2 = document.createElement('input')
   input2.name = "newpassword"
   input2.className = "data"
   input2.type = "password"

   let h2 = document.createElement('h4')
   h2.innerHTML = "New password"

   form.appendChild(h1)
   form.appendChild(input)
   form.appendChild(h2)
   form.appendChild(input2)

   document.querySelector('.cp').remove()
}