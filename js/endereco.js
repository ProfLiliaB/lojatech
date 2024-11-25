let campo = document.getElementById("cep");
campo.addEventListener("input", (e) => {
  var cep = campo.value;
  cep = cep.replace(/\D/g, "");
  if (cep.length > 7) {
    let validacep = /^[0-9]{8}$/;
    if (validacep.test(cep)) {
      document.getElementById("numero").focus();
      fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then((resp) => {
          if (resp.ok) {
            return resp.json();
          } else {
            console.log("Erro na resposta!");
          }
        })
        .then((conteudo) => {
          document.getElementById("rua").value = conteudo.logradouro;
          document.getElementById("bairro").value = conteudo.bairro;
          document.getElementById("cidade").value = conteudo.localidade;
          document.getElementById("uf").value = conteudo.uf;              
        });
    } else {
      errorMessage.innerHTML = "CEP Inválido!";
      dialog.show();
      setTimeout(() => fecharDialog(), 3000);
    }
  } else {
    limpa_formulario();
  }
});
function limpa_formulario() {
  document.getElementById("rua").value = "";
  document.getElementById("bairro").value = "";
  document.getElementById("cidade").value = "";
  document.getElementById("uf").value = "";
}
