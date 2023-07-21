// Fonction pour changer le style de 2 classes (display none to block et inversement)
function changeStyle(element1, element2) {
    document.getElementsByClassName(element1)[0].style.display = 'none';
    document.getElementsByClassName(element2)[0].style.display = 'block';
}