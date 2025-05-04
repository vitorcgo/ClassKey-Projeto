document.addEventListener('DOMContentLoaded', () => {
    fetch('./php/listar_categorias.php')
        .then(res => res.json())
        .then(categorias => {
            const corpoTabela = document.getElementById('corpo-tabela');
            corpoTabela.innerHTML = '';

            categorias.forEach(categoria => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${categoria.categoria_id}</td>
                    <td>${categoria.categoria}</td>
                    <td>
                        <button class="btn-excluir" data-id="${categoria.categoria_id}">Excluir</button>
                    </td>
                `;
                corpoTabela.appendChild(tr);
            });

            // Adiciona eventos aos botões de excluir
            document.querySelectorAll('.btn-excluir').forEach(btn => {
                btn.addEventListener('click', excluirCategoria);
            });
        })
        .catch(err => console.error('Erro ao carregar categorias:', err));
});

function excluirCategoria(event) {
    const id = event.target.getAttribute('data-id');

    fetch('./php/excluir_categoria.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}`
    })
    .then(res => res.text())
    .then(resposta => {
        if (resposta === 'sucesso') {
            alert('Categoria excluída com sucesso!');
            location.reload();
        } else {
            alert('Erro ao excluir: ' + resposta);
        }
    });
}