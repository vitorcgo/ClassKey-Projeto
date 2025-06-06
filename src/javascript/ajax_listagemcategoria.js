let todasAsCategorias = []; // Armazena a lista original para filtragem

document.addEventListener('DOMContentLoaded', () => {
    fetch('src/php/listar_categorias.php')
        .then(res => res.json())
        .then(categorias => {
            // Removed console.log for production
            todasAsCategorias = categorias;
            renderizarTabela(categorias);
            
            // Ativa filtro ao digitar
            const barraPesquisa = document.getElementById('barra-pesquisa');
            if (barraPesquisa) {
                barraPesquisa.addEventListener('input', () => {
                    const termo = barraPesquisa.value.trim().toLowerCase();

                    const filtrados = todasAsCategorias.filter(categoria => {
                        const nome = categoria.categoria.toLowerCase();
                        const id = String(categoria.categoria_id);
                        return nome.includes(termo) || id.includes(termo);
                    });

                    renderizarTabela(filtrados);
                });
            }
        })
        .catch(err => {
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Erro ao carregar categorias: ' + err
            });
        });
});

// 🔁 Função para renderizar as categorias na tabela
function renderizarTabela(categorias) {
    const corpoTabela = document.getElementById('corpo-tabela');
    corpoTabela.innerHTML = '';

    if (!Array.isArray(categorias)) {
        Swal.fire({
            icon: 'error',
            title: 'Erro',
            text: 'Dados inválidos retornados: ' + JSON.stringify(categorias)
        });
        return;
    }

    categorias.forEach(categoria => {
        const status = categoria.status ? categoria.status.toUpperCase() : 'ATIVO';
        const classeStatus = status === 'ATIVO' ? 'verde' : 'vermelho';

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${categoria.categoria_id}</td>
            <td>${categoria.categoria}</td>
            <td>
                <button class="status-btn ${classeStatus}" 
                    onclick="toggleStatus(this, ${categoria.categoria_id})">
                    ${status}
                </button>
            </td>
            <td>
                <button class="btn-editar">
                    <a href="editarcategoria.html?id=${categoria.categoria_id}"><i class="ti ti-edit"></i> Editar</a>
                </button>
                <button class="btn-excluir" data-id="${categoria.categoria_id}"><i class="ti ti-trash"></i> Excluir</button>
            </td>
        `;
        corpoTabela.appendChild(tr);
    });

    document.querySelectorAll('.btn-excluir').forEach(btn => {
        btn.addEventListener('click', excluirCategoria);
    });
}

function excluirCategoria(event) {
    // Get the ID from the button or closest parent with data-id
    const button = event.target.closest('.btn-excluir');
    const id = button.getAttribute('data-id');

    Swal.fire({
        title: 'Tem certeza?',
        text: 'Deseja realmente excluir esta categoria?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
        fetch('src/php/excluir_categoria.php', {
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
                    text: 'Categoria excluída com sucesso!'
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
    }
}

function toggleStatus(botao, categoriaId) {
    const novoStatus = botao.textContent.trim().toUpperCase() === 'ATIVO' ? 'INATIVO' : 'ATIVO';

    fetch('src/php/atualizar_status_categoria.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${categoriaId}&status=${novoStatus}`
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