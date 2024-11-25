const dialog = document.getElementById("avisos");
const errorMessage = document.getElementById("errorMessage");
const fechar = document.getElementById("fechar");
function cadastroGeral(dados, url) {
  fetch(url, {
    body: dados,
    method: "POST",
  })
    .then((resposta) => {
      if (resposta.ok) {
        return resposta.text();
      } else {
        throw new Error("Erro ao cadastrar!");
      }
    })
    .then((retorno) => {
      errorMessage.innerHTML = retorno;
      dialog.show();
      setTimeout(() => fecharDialog(), 3000);
    })
    .catch((erro) => {
      console.error("Erro:", erro.message);
      dialog.show();
    });
}
fechar.addEventListener("click", () => {
  fecharDialog();
});
function fecharDialog() {
  dialog.close();
}
function limparFormulario(form) {
  form.reset();
}