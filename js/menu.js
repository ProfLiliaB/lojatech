const nav = document.querySelector('#nav ul');
const hamburguer = document.getElementById('hamburguer');

hamburguer.addEventListener('click', ()=>{
    nav.classList.toggle('toggle');
    if(nav.className == 'toggle') {
        hamburguer.innerHTML = '<i class="fa fa-close"></i>';
    } else {
        hamburguer.innerHTML = '<i class="fa fa-bars"></i>';
    }
})