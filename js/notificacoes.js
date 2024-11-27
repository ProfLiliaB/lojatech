// try {
//   let id = 1;
//   const response = await fetch("notifica_atualiza.php", {
//     method: "POST",
//     headers: {
//       "Content-Type": "application/x-www-form-urlencoded",
//     },
//     body: `id=${id}`,
//   });
//   const data = await response.json();
//   console.log(data);
// } catch (error) {
//   console.error("Erro ao enviar a requisição:", error);
// }
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
    const response = await fetch("./notifica.php");
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
    const resposta = await fetch("./notifica_lista.php");
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
