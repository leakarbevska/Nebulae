/*Script that adds event listeners on the original and modal picture (on each nebula page)
   in order to display/close on click the modal image */

let modal = document.getElementById("myModal");
let img = document.getElementById("originalImg");
let modalImg = document.getElementById("modalImg");

img.addEventListener("click", displayImage);
modalImg.addEventListener("click", closeImage);


function displayImage(){
  let caption  = document.getElementById("caption");
  caption.innerHTML = this.alt;
  modal.style.display = "block";
  modalImg.src = this.src;
}

function closeImage() { 
  modal.style.display = "none";
}
