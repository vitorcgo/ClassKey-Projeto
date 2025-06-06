
window.onload = function() {
    const params = new URLSearchParams(window.location.search);
    const id = params.get("id");

    if (id) {
        fetch(`src/php/get_produtos.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.erro) {
                    alert(data.erro);
                    return;
                }

                document.getElementById("nome").value = data.nome;
                document.getElementById("preco").value = data.preco;
                document.getElementById("quantidade").value = data.quantidade;
                document.getElementById("descricao").value = data.descricao;
                document.getElementById("categoria-options").value = data.categoria_id;

                const inputHidden = document.createElement("input");
                inputHidden.type = "hidden";
                inputHidden.name = "produto_id";
                inputHidden.value = data.id;
                document.getElementById("form-produto").appendChild(inputHidden);

                // Atualizar preview da imagem se houver
                if (data.imagem_url) {
                    document.getElementById("preview").innerHTML = `<img src="${data.imagem_url}" width="200">`;
                }
            });
    }
}

