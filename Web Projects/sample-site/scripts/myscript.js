/*var myHeading = document.querySelector("h1");
myHeading.textContent = "Be Kind";*/

var pandaImage = document.querySelector('img');
pandaImage.onclick = function() {
    var myImage = pandaImage.getAttribute('src');
    if (myImage === "images/panda.jpg") {
        pandaImage.setAttribute("src", "images/bird.jpg");
    } else {
        pandaImage.setAttribute("src", "images/panda.jpg");
    }

};
var nameButton = document.querySelector('button');
var myHeading = document.querySelector("h1");

function setUserName() {
    var myName = window.prompt("Please enter your name.");
    localStorage.setItem('name', myName);
    myHeading.textContent = 'Have a nice day, ' + myName;

}
if (!localStorage.getItem('name')) {
    setUserName();
} else {
    var storedName = localStorage.getItem('name');
    myHeading.textContent = 'Have a nice day, ' + storedName;

}
nameButton.onclick = function() {
    setUserName();
};