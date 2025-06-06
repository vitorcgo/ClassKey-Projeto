document.getElementById('form-categoria').addEventListener('submit', function (event) {
    event.preventDefault();

    const categoriaInput = document.getElementById('categoria');
    const categoria = categoriaInput.value.trim();

    if (!categoria) {
      alert('Por favor, insira o nome da categoria.');
      return;
    }

    fetch('src/php/cadastro_categoria.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `categoria=${encodeURIComponent(categoria)}`
    })
    .then(res => res.json())  // aqui está a principal mudança
    .then(jsonData => {
      if (jsonData.status === 'sucesso') {
        alert(jsonData.mensagem);
        categoriaInput.value = '';
      } else {
        alert(jsonData.mensagem);
      }
    })
    .catch(err => {
      console.error('Erro ao enviar ou processar a resposta:', err);
      alert('Erro ao enviar os dados. Tente novamente.');
    });
  });