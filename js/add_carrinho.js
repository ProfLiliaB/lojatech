const dialog = document.getElementById('avisos');
const errorMessage = document.getElementById('errorMessage');
const fechar = document.getElementById('fechar');
const selecionaTodos = document.querySelectorAll('.comprar');

selecionaTodos.forEach(button => {
    button.addEventListener('click', () => {
        adicionarCarrinho(button)
    });
});

document.querySelectorAll('.apagar').forEach(apag => {
    apag.addEventListener('click', () => {
        fetch('limpa_carrinho.php?id=' + apag.value)
            .then((resp) => {
                if (resp.ok) {
                    return resp.text();
                } else {
                    throw new Error('Erro ao remover');
                }
            })
            .then((retorno) => {
                errorMessage.innerHTML = retorno;
                dialog.show();
                setTimeout(() => fecharDialog(), 3000);
            })
            .catch((erro) => {
                console.error('Erro:', erro.message);
                errorMessage.innerHTML = 'Erro ao remover o produto.';
                dialog.show();
            });
    });
});
fechar.addEventListener('click', () => {
    fecharDialog();
})
function fecharDialog() {
    dialog.close();
}
function adicionarCarrinho(button) {
    fetch('add_carrinho.php?id=' + button.value)
        .then((resp) => {
            if (resp.ok) {
                return resp.text();
            } else {
                throw new Error('Erro ao adicionar ao carrinho');
            }
        })
        .then((retorno) => {
            errorMessage.innerHTML = retorno;
            dialog.show();
            setTimeout(() => fecharDialog(), 3000);
        })
        .catch((erro) => {
            console.error('Erro:', erro.message);
            errorMessage.innerHTML = 'Erro ao adicionar o produto.';
            dialog.show();
            setTimeout(() => fecharDialog(), 3000);
        });
}
