// Fonction pour calculer la hauteur disponible pour le forum
function setForumHeight() {
    const navbarHeight = document.querySelector('#navbar').offsetHeight;
    const footerHeight = document.querySelector('#footer').offsetHeight;
    const availableHeight = window.innerHeight - navbarHeight - footerHeight;
    document.getElementById('forum').style.minHeight = availableHeight + 'px';
}

// Appele la fonction après le chargement du DOM
document.addEventListener('DOMContentLoaded', setForumHeight);

// Appele la fonction à chaque changement de taille de la fenêtre
  window.addEventListener('resize', setForumHeight);