document.addEventListener('DOMContentLoaded', () => {
    fetch('./php/listar_produtos.php')
        .then(res => res.json())
        .then(produtos => {
            console.log(produtos); // Verifique o conteúdo da resposta

            const corpoTabela = document.getElementById('tabela-produtos');
            corpoTabela.innerHTML = '';

            if (Array.isArray(produtos)) {
                produtos.forEach(produto => {
                    const imagemUrl = produto.imagem_url || '/img/placeholder.png';
                    const status = produto.status.toUpperCase(); // garante maiúsculo
                    const classeStatus = status === 'ATIVO' ? 'verde' : 'vermelho';

                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>
                            <div class="produto-imagem">
                                <img src="${imagemUrl}" alt="Imagem" width="200" height="200">
                            </div>
                        </td>
                        <td>${produto.nome}</td>
                        <td>
                            <button class="status-btn ${classeStatus}" 
                                onclick="toggleStatus(this, ${produto.produto_id})">
                                ${status}
                            </button>
                        </td>
                        <td>${produto.categoria_nome || 'Sem categoria'}</td>  <!-- Exibe a categoria -->
                        <td>R$${parseFloat(produto.preco).toFixed(2)}</td>
                        <td>${produto.quantidade}</td>
                        <td>${produto.produto_id}</td>
                        <td>
                            <button class="btn-editar">
                                <a href="/src/editarprodutos.html?id=${produto.produto_id}">Editar</a>
                            </button>
                            <button class="btn-excluir" data-id="${produto.produto_id}">Excluir</button>
                        </td>
                    `;
                    corpoTabela.appendChild(tr);
                });
            } else {
                alert('Dados inválidos retornados: ' + JSON.stringify(produtos));
            }

            document.querySelectorAll('.btn-excluir').forEach(btn => {
                btn.addEventListener('click', excluirProduto);
            });
        })
        .catch(err => console.error('Erro ao carregar produtos:', err));
});

function excluirProduto(event) {
    const id = event.target.getAttribute('data-id');

    fetch('php/excluir_produto.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}`
    })
    .then(res => res.text())
    .then(resposta => {
        if (resposta === 'sucesso') {
            alert('Produto excluído com sucesso!');
            location.reload();
        } else {
            alert('Erro ao excluir: ' + resposta);
        }
    });
}

function toggleStatus(botao, produtoId) {
    const novoStatus = botao.textContent.trim().toUpperCase() === 'ATIVO' ? 'INATIVO' : 'ATIVO';

    fetch('php/atualizar_status_produto.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${produtoId}&status=${novoStatus}`
    })
    .then(res => res.text())
    .then(resposta => {
        if (resposta === 'sucesso') {
            botao.textContent = novoStatus;
            botao.classList.toggle('verde');
            botao.classList.toggle('vermelho');
        } else {
            alert('Erro ao alterar status: ' + resposta);
        }
    });
}
