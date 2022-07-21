const body = document.querySelector('.js-body');

// je check si le mode nuit est activé dans le local storage,
// si oui je l'active avec le CSS
if (localStorage.getItem('nightActivated') === 'true') {
    body.classList.add('night-activated');
}

const nightToggleBtn = document.querySelector('.js-night-toggle');

nightToggleBtn.addEventListener('click', function() {

    // si le mode nuit est activé, je le désactive
    if (body.classList.contains('night-activated')) {
        body.classList.remove('night-activated');
        // je supprime le mode nuit du local storage
        localStorage.removeItem('nightActivated');
    // si le mode nuit n'est pas activé, je l'active
    } else {
        body.classList.add('night-activated');
        // j'enregistre le mode nuit dans le local storage
        localStorage.setItem('nightActivated', "true");
    }

});
