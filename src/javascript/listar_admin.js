document.addEventListener('DOMContentLoaded', () => {
    fetch('php/listar_admin.php')
        .then(res => res.json())
        .then(admins => {
            const tbody = document.querySelector('.tabela-adm tbody');
            tbody.innerHTML = ''; // Limpa a tabela antes de adicionar os novos dados

            admins.forEach(admin => {
                // Formatar as datas para exibição
                const dataCriacao = admin.data_criacao ? new Date(admin.data_criacao).toLocaleString() : '---';
                const dataUltimoAcesso = admin.data_ultimo_acesso ? new Date(admin.data_ultimo_acesso).toLocaleString() : '---';

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${admin.admin_id}</td>
                    <td>${admin.usuario}</td>
                    <td>${admin.senha}</td>
                    <td>${dataCriacao}</td>
                    <td>${dataUltimoAcesso}</td>
                    <td>
                        <button class="btn-excluir" data-id="${admin.admin_id}">Excluir</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            // Adicionar evento de exclusão para os botões
            document.querySelectorAll('.btn-excluir').forEach(btn => {
                btn.addEventListener('click', excluirAdmin);
            });
        })
        .catch(err => console.error('Erro ao carregar administradores:', err));
});

function excluirAdmin(event) {
    const adminId = event.target.getAttribute('data-id');

    if (!confirm('Tem certeza que deseja excluir este administrador?')) return;

    fetch('php/excluir_admin.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `admin_id=${adminId}`
    })
    .then(res => res.json())
    .then(resposta => {
        if (resposta.sucesso) {
            alert('Administrador excluído com sucesso!');
            location.reload(); // Recarregar a página para refletir as mudanças
        } else {
            alert('Erro ao excluir: ' + (resposta.erro || 'Erro desconhecido'));
        }
    })
    .catch(err => {
        console.error('Erro na exclusão:', err);
        alert('Erro ao excluir administrador.');
    });
}
