function toggleStatusADM(button) {
    const produtoLinha = button.closest('tr');
    const btnEditar = produtoLinha.querySelector('.btn-editar');

    if (button.classList.contains('verde')) {
        button.classList.remove('verde');
        button.classList.add('vermelho');
        button.textContent = 'DESATIVADO';
        produtoLinha.classList.add('desativado');
        btnEditar.disabled = true;
        btnEditar.style.opacity = 0.5;

    } else {
        button.classList.remove('vermelho');
        button.classList.add('verde');
        button.textContent = 'ATIVO';
        produtoLinha.classList.remove('desativado');
        btnEditar.disabled = false;
        btnEditar.style.opacity = 1;

    }
}
