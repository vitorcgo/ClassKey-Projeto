fetch('src/php/obter_usuario.php')
    .then(response => response.text())
    .then(nome => {
        const nomeUsuario = document.getElementById('nome-usuario');
        nomeUsuario.innerHTML = 'Bem-vindo, <span style="color: rgb(138, 43, 226);">' + nome + '</span>';
    })
    .catch(error => {
        const nomeUsuario = document.getElementById('nome-usuario');
        nomeUsuario.innerHTML = 'Bem-vindo, <span style="color: rgb(138, 43, 226);">Visitante</span>';
        console.error('Erro ao carregar o nome do usuário:', error);
        Swal.fire({
            icon: 'warning',
            title: 'Atenção',
            text: 'Não foi possível carregar as informações do usuário.'
        });
    });
