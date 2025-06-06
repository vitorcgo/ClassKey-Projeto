document.addEventListener('DOMContentLoaded', () => {
    // Get category ID from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const categoriaId = urlParams.get('id');
    
    if (!categoriaId) {
        Swal.fire({
            icon: 'error',
            title: 'Erro',
            text: 'ID da categoria não especificado'
        });
        window.location.href = 'listadecategoria.html';
        return;
    }
    
    // Set the hidden input field value
    document.getElementById('categoria_id').value = categoriaId;
    
    // Fetch category data
    fetch(`src/php/listar_categorias.php?id=${categoriaId}`)
        .then(res => res.json())
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                const categoria = data[0];
                
                // Populate form fields
                document.getElementById('categoria').value = categoria.categoria;
                document.getElementById('status').value = categoria.status || 'ATIVO';
                
                // Update page title with category name
                document.title = `Editar Categoria: ${categoria.categoria} | Sistema de Gerenciamento`;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Categoria não encontrada'
                });
                window.location.href = 'listadecategoria.html';
            }
        })
        .catch(err => {
            console.error('Erro ao carregar dados da categoria:', err);
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Erro ao carregar dados da categoria'
            });
        });
    
    // Handle form submission
    const form = document.getElementById('form-editar-categoria');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const formData = new FormData(form);
        
        fetch('src/php/editar_categoria.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(resposta => {
            if (resposta === 'sucesso') {
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Categoria atualizada com sucesso!'
                }).then(() => {
                    window.location.href = 'listadecategoria.html';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Erro ao atualizar categoria: ' + resposta
                });
            }
        })
        .catch(err => {
            console.error('Erro ao enviar formulário:', err);
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Erro ao processar a requisição'
            });
        });
    });
});