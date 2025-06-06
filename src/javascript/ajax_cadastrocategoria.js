document.getElementById('form-categoria').addEventListener('submit', function (event) {
    event.preventDefault();

    const categoriaInput = document.getElementById('categoria');
    const categoria = categoriaInput.value.trim();

    if (!categoria) {
      Swal.fire({
        icon: 'warning',
        title: 'Atenção',
        text: 'Por favor, insira o nome da categoria.'
      });
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
        Swal.fire({
          icon: 'success',
          title: 'Sucesso',
          text: jsonData.mensagem
        });
        categoriaInput.value = '';
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: jsonData.mensagem
        });
      }
    })
    .catch(err => {
      console.error('Erro ao enviar ou processar a resposta:', err);
      Swal.fire({
        icon: 'error',
        title: 'Erro',
        text: 'Erro ao enviar os dados. Tente novamente.'
      });
    });
  });