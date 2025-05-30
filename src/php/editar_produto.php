<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $produto_id   = $_POST['produto_id'];
    $nome         = $_POST['nome'];
    $preco        = $_POST['preco'];
    $categoria_id = $_POST['categoria_id'];
    $quantidade   = $_POST['quantidade'];
    $descricao    = $_POST['descricao'];
    $status       = 'ativo'; // status padrão

    // Atualiza dados do produto
    $stmt = $pdo->prepare("UPDATE produto SET nome = ?, preco = ?, status = ?, descricao = ?, quantidade = ? WHERE id = ?");
    $stmt->execute([$nome, $preco, $status, $descricao, $quantidade, $produto_id]);

    // Atualiza a categoria (1 por produto)
    $stmt = $pdo->prepare("UPDATE produto_categoria SET categoria_id = ? WHERE produto_id = ?");
    $stmt->execute([$categoria_id, $produto_id]);

    // Se uma nova imagem foi enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $img_tmp  = $_FILES['imagem']['tmp_name'];
        $img_nome = uniqid() . '-' . $_FILES['imagem']['name'];
        $destino  = '../../src/images/' . $img_nome;

        if (move_uploaded_file($img_tmp, $destino)) {
            $url = '/src/images/' . $img_nome;

            // Verifica se o produto já tem uma imagem
            $stmt = $pdo->prepare("SELECT id FROM produto_media WHERE produto_id = ?");
            $stmt->execute([$produto_id]);

            if ($stmt->rowCount() > 0) {
                // Atualiza a imagem existente
                $stmt = $pdo->prepare("UPDATE produto_media SET url = ? WHERE produto_id = ?");
                $stmt->execute([$url, $produto_id]);
            } else {
                // Insere uma nova imagem
                $stmt = $pdo->prepare("INSERT INTO produto_media (produto_id, url) VALUES (?, ?)");
                $stmt->execute([$produto_id, $url]);
            }
        }
    }

    // Redireciona após sucesso
    echo "<script>alert('Produto atualizado com sucesso!'); location.href='/src/listadeprodutos.html';</script>";
} else {
    // Se acessado sem POST
    echo "<script>alert('Requisição inválida.'); location.href='/src/listadeprodutos.html';</script>";
    exit;
}
?>
