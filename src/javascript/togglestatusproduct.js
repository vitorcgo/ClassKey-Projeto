function toggleStatus(button) {
    const produtoLinha = button.closest('tr');
    const btnEditar = produtoLinha.querySelector('.btn-editar');
    const produtoId = produtoLinha.querySelectorAll('td')[5].textContent;

    if (button.classList.contains('verde')) {
        button.classList.remove('verde');
        button.classList.add('vermelho');
        button.textContent = 'SEM ESTOQUE';
        produtoLinha.classList.add('desativado');
        btnEditar.disabled = true;
        btnEditar.style.opacity = 0.5;

        localStorage.setItem(`status-${produtoId}`, 'vermelho');
    } else {
        button.classList.remove('vermelho');
        button.classList.add('verde');
        button.textContent = 'ATIVO';
        produtoLinha.classList.remove('desativado');
        btnEditar.disabled = false;
        btnEditar.style.opacity = 1;

        localStorage.setItem(`status-${produtoId}`, 'verde');
    }
}

function aplicarStatusSalvo() {
    const produtos = document.querySelectorAll('.produto');
    produtos.forEach((produto) => {
        const produtoId = produto.querySelector('.produto-id').textContent;
        const statusSalvo = localStorage.getItem(`status-${produtoId}`);
        const button = produto.querySelector('.status-btn');
        const btnEditar = produto.querySelector('.btn-editar');

        if (statusSalvo === 'vermelho') {
            button.classList.remove('verde');
            button.classList.add('vermelho');
            button.textContent = 'SEM ESTOQUE';
            produto.classList.add('desativado');
            btnEditar.disabled = true;
            btnEditar.style.opacity = 0.5;
        } else if (statusSalvo === 'verde') {
            button.classList.remove('vermelho');
            button.classList.add('verde');
            button.textContent = 'ATIVO';
            produto.classList.remove('desativado');
            btnEditar.disabled = false;
            btnEditar.style.opacity = 1;
        }
    });
}

document.addEventListener('DOMContentLoaded', aplicarStatusSalvo);