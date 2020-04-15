var modal = document.getElementById("myModal");
var images = document.getElementsByClassName("image");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");

var imageIndex = 0;

function setImageIndex(n) {
    if (n < 0) {
        alert("n must not be 0!");
        return;
    }
    setImage(imageIndex = n);
}

function incrementImageIndex() {
    setImage((++imageIndex) % images.length);
}

function decrementImageIndex(n) {
    setImage((--imageIndex + images.length) % images.length);
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

/*
Handle key presses
 */
document.onkeydown = checkKey;

function checkKey(e) {

    e = e || window.event; // TODO deprecated

    if (e.keyCode == 27) {
        // escape key
        closeModal();
    } else if (e.keyCode == '38') {
        // up arrow
    } else if (e.keyCode == '40') {
        // down arrow
    } else if (e.keyCode == '37') {
        // left arrow
        decrementImageIndex();
    } else if (e.keyCode == '39') {
        // right arrow
        incrementImageIndex();
    }

}