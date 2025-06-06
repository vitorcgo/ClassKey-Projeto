document.addEventListener("DOMContentLoaded", function() {
    fetch('src/php/categoriaoptions.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Falha na requisição');
            }
            return response.json();
        })
        .then(data => {
            console.log('Dados recebidos:', data);  // Exibe os dados no console

            const select = document.getElementById('categoria-options');
            console.log('Elemento select:', select);  // Verifica se o select está sendo encontrado corretamente

            // Limpa as opções anteriores
            select.innerHTML = '<option value="">Escolha a Categoria</option>';

            if (Array.isArray(data)) {
                data.forEach(categoria => {
                    console.log('Criando opção:', categoria);  // Verifica cada categoria sendo criada

                    const option = document.createElement('option');
                    option.value = categoria.categoria_id;  // Use a chave correta para o ID
                    option.textContent = categoria.categoria;  // Use a chave correta para o nome
                    option.style.color = 'black';  // A cor do texto será preta
                    select.appendChild(option);
                });
            } else {
                console.error('Dados de categoria inválidos:', data);
            }
        })
        .catch(error => {
            console.error('Erro ao carregar categorias:', error);
        });
});
