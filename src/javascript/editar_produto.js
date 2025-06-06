document.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);
  const id = params.get("id");

  if (!id) {
    Swal.fire({
      icon: 'error',
      title: 'Erro',
      text: 'ID do produto não informado.'
    });
    return;
  }

  fetch(`src/php/buscar_produto.php?id=${id}`)
    .then(res => res.json())
    .then(produto => {
      if (produto.erro) {
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: produto.erro
        });
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
          Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: response.mensagem
          }).then(() => {
            window.location.href = "listadeprodutos.html";
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Erro',
            text: response.erro || "Erro desconhecido ao salvar."
          });
        }
      })
      .catch(() => {
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: "Erro ao salvar alterações."
        });
      });
  });
});
