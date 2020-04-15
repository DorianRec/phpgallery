// Get the modal
var modal = document.getElementById("myModal");
// Get the image and insert it inside the modal - use its "alt" text as a caption
//var img = document.getElementById("myImg");
var images = document.getElementsByClassName("image");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");

var imageIndex = 0;

function setImageIndex(n) {
    setImage(imageIndex = n);
}

function setImage(n) {
    modalImg.src = images[n].src;
    captionText.innerHTML = images[n].alt;
}

function openModal() {
    modal.style.display = "block";
}

function closeModal() {
    modal.style.display = "none";
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    modal.style.display = "none";
};