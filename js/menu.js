const nav = document.querySelector('header nav ul')
const hamburguer = document.getElementById('hamburguer')
hamburguer.addEventListener('click', () => {
    nav.classList.toggle('toggle')
    if (nav.className == 'toggle') {
        hamburguer.innerHTML = '<i class="icofont icofont-close"></i>'
    } else {
        hamburguer.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
    }
})