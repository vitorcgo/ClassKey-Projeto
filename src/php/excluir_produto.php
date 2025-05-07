<?php
include 'conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    echo json_encode(['erro' => 'Requisição inválida ou produto_id não fornecido.']);
    exit;
}

$id = $_POST['id'];

try {
    // Buscar a imagem relacionada ao produto
    $stmtImagem = $pdo->prepare("SELECT url FROM produto_media WHERE produto_id = ?");
    $stmtImagem->execute([$id]);
    $imagem = $stmtImagem->fetch(PDO::FETCH_ASSOC);

    if ($imagem && !empty($imagem['url'])) {
        $caminhoImagem = '../' . $imagem['url']; // Caminho ajustado para src/images
        if (file_exists($caminhoImagem)) {
            unlink($caminhoImagem); // Excluir a imagem do servidor
        }
    }

    // Excluir o registro de mídia
    $stmtDelMedia = $pdo->prepare("DELETE FROM produto_media WHERE produto_id = ?");
    $stmtDelMedia->execute([$id]);

    // Excluir o produto
    $stmt = $pdo->prepare("DELETE FROM produto WHERE produto_id = ?");
    $stmt->execute([$id]);

    echo 'sucesso';
} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro ao excluir: ' . $e->getMessage()]);
}
