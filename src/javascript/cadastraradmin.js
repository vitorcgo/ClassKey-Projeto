document.querySelector('form').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevenir o envio padrão do formulário

    const email = document.getElementById('cadastroadmin').value;
    const senha = document.getElementById('passwordadmin').value;

    // Verificar se os campos estão preenchidos
    if (!email || !senha) {
        alert('Preencha todos os campos.');
        return;
    }

    // Enviar dados via fetch para o PHP
    fetch('src/php/cadastrar_admin.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `email=${encodeURIComponent(email)}&senha=${encodeURIComponent(senha)}`
    })
    .then(res => res.text())  // Processar a resposta como texto
    .then(resposta => {
        // Verificar se a resposta do PHP foi 'sucesso'
        if (resposta === 'sucesso') {
            alert('Administrador cadastrado com sucesso!');
            document.querySelector('form').reset(); // Limpar o formulário
        } else {
            alert('Erro: ' + resposta); // Exibir o erro retornado pelo PHP
        }
    })
    .catch(err => {
        alert('Erro ao enviar os dados: ' + err); // Se ocorrer um erro na requisição
    });
});
