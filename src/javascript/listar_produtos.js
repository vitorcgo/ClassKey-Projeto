let todosOsProdutos = []; // Armazena a lista original para filtragem

document.addEventListener('DOMContentLoaded', () => {
    fetch('src/php/listar_produtos.php')
        .then(res => res.json())
        .then(produtos => {
            // Registrar no console para debugging
            console.log('Produtos carregados:', produtos);
            todosOsProdutos = produtos;
            renderizarTabela(produtos);

            // Ativa filtro ao digitar
            const barraPesquisa = document.getElementById('barra-pesquisa');
            if (barraPesquisa) {
                barraPesquisa.addEventListener('input', () => {
                    const termo = barraPesquisa.value.trim().toLowerCase();

                    const filtrados = todosOsProdutos.filter(produto => {
                        const nome = produto.nome.toLowerCase();
                        const id = String(produto.produto_id);
                        const categoria = (produto.categoria_nome || '').toLowerCase();
                        return nome.includes(termo) || id.includes(termo) || categoria.includes(termo);
                    });

                    renderizarTabela(filtrados);
                });
            }
        })
        .catch(err => console.error('Erro ao carregar produtos:', err));
});

// 🔁 Função para renderizar os produtos na tabela
function renderizarTabela(produtos) {
    const corpoTabela = document.getElementById('tabela-produtos');
    corpoTabela.innerHTML = '';

    if (!Array.isArray(produtos)) {
        Swal.fire({
            icon: 'error',
            title: 'Erro de dados',
            text: 'Dados inválidos retornados: ' + JSON.stringify(produtos)
        });
        return;
    }

    produtos.forEach(produto => {
        const imagemUrl = produto.imagem_url || '/img/placeholder.png';
        const status = produto.status.toUpperCase();
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
            <td>${produto.categoria_nome || 'Sem categoria'}</td>
            <td>R$${parseFloat(produto.preco).toFixed(2)}</td>
            <td>${produto.quantidade}</td>
            <td>${produto.produto_id}</td>
            <td>
                <button class="btn-editar">
                    <a href="editarprodutos.html?id=${produto.produto_id}">Editar</a>
                </button>
                <button class="btn-excluir" data-id="${produto.produto_id}">Excluir</button>
            </td>
        `;
        corpoTabela.appendChild(tr);
    });

    document.querySelectorAll('.btn-excluir').forEach(btn => {
        btn.addEventListener('click', excluirProduto);
    });
}

function excluirProduto(event) {
    const id = event.target.getAttribute('data-id');

    fetch('src/php/excluir_produto.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}`
    })
    .then(res => res.text())
    .then(resposta => {
        if (resposta === 'sucesso') {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: 'Produto excluído com sucesso!'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Erro ao excluir: ' + resposta
            });
        }
    });
}

function toggleStatus(botao, produtoId) {
    const novoStatus = botao.textContent.trim().toUpperCase() === 'ATIVO' ? 'INATIVO' : 'ATIVO';

    fetch('src/php/atualizar_status_produto.php', {
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
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Erro ao alterar status: ' + resposta
            });
        }
    });
}
