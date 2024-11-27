const nav = document.querySelector("header nav ul");
const hamburguer = document.getElementById("hamburguer");
hamburguer.addEventListener("click", () => {
  nav.classList.toggle("toggle");
  if (nav.className == "toggle") {
    hamburguer.innerHTML = '<i class="icofont icofont-close"></i>';
  } else {
    hamburguer.innerHTML = '<i class="icofont icofont-navigation-menu"></i>';
  }
});
//============================= NOTIFICAÇÕES ====================================
const abreSub = document.getElementById("abreNotas");
const subMenu = document.getElementById("sub_menu_notas");
abreSub.addEventListener("click", () => {
  if (subMenu.style.display === "none") {
    subMenu.style.display = "block";
  } else {
    subMenu.style.display = "none";
  }
});
async function verificarNotificacoes() {
  try {
    const response = await fetch("./admin/notifica.php");
    const data = await response.text();
    let n = parseInt(data);
    const badge = document.getElementById("notificacao");
    if (n > 0) {
      badge.classList.add("visivel");
    } else {
      badge.classList.remove("visivel");
    }
    badge.textContent = n;
  } catch (error) {
    console.error("Erro ao verificar notificações:", error);
  }
}
async function listaNotificacoes() {
  try {
    const resposta = await fetch("./admin/notifica_lista.php");
    const lista = await resposta.text();
    subMenu.innerHTML = lista;
  } catch (error) {
    console.error("Erro ao listar notificações:", error);
  }
}
setInterval(verificarNotificacoes, 5000);
setInterval(listaNotificacoes, 5000);
verificarNotificacoes();
listaNotificacoes();
