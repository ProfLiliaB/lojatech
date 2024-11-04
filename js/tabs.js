const tabs_items = document.querySelectorAll('.tabs_item');//divs
const tabs_menu = document.querySelectorAll('.tabs_menu li');
console.log(tabs_menu);
tabs_menu.forEach((item_menu)=>{
    item_menu.addEventListener('click', (clicado)=>{
        tabs_menu.forEach(item => {
            item.classList.remove('active');
        });
        clicado.preventDefault();
        clicado.target.classList.add('active');
        const tabId = clicado.target.getAttribute('data-id').substr(1);
        tabs_items.forEach(item => {
            if (item.id === tabId) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    });
});