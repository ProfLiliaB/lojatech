const items = document.querySelectorAll('.item');
var atual = 0;
function exibeSlides() {
    if (atual >= items.length) {
        atual = 0;
    }
    items.forEach((item)=>{
        item.style.display = "none";
    });
    items[atual].style.display = "block";
    atual++;
}
setInterval(exibeSlides, 3000);