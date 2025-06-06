document.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);
  const id = params.get("id");

  if (!id) {
    alert("ID do produto não informado.");
    return;
  }

  fetch(`src/php/buscar_produto.php?id=${id}`)
    .then(res => res.json())
    .then(produto => {
      if (produto.erro) {
        alert(produto.erro);
        return;
      }

      document.getElementById("produtoId").value = produto.produto_id;
      document.getElementById("nome").value = produto.nome;
      document.getElementById("preco").value = produto.preco;
      document.getElementById("descricao").value = produto.descricao || '';
      document.getElementById("quantidade").value = produto.quantidade || '';
      document.getElementById("categoria-options").value = produto.categoria_id;
      document.getElementById("id-produto").textContent = `(${produto.produto_id})`;

      if (produto.imagem_url) {
        const img = document.getElementById("imagem-preview");
        const placeholder = document.getElementById("sem-imagem");
        img.src = produto.imagem_url;
        img.style.display = "block";
        placeholder.style.display = "none";
      }
    });

  document.getElementById("form-produto").addEventListener("submit", function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch("src/php/editar_produto.php", {
      method: "POST",
      body: formData
    })
      .then(res => res.json())
      .then(response => {
        if (response.mensagem) {
          alert(response.mensagem);
          window.location.href = "listadeprodutos.html";
        } else {
          alert(response.erro || "Erro desconhecido ao salvar.");
        }
      })
      .catch(() => {
        alert("Erro ao salvar alterações.");
      });
  });
});
