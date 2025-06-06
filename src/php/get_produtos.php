<?php
include 'conexao.php';

$produto_id = $_GET['id'] ?? null;

if ($produto_id) {
    $stmt = $pdo->prepare("SELECT p.*, pc.categoria_id, pm.url AS imagem_url
                           FROM produto p
                           LEFT JOIN produto_categoria pc ON p.id = pc.produto_id
                           LEFT JOIN produto_media pm ON p.id = pm.produto_id
                           WHERE p.id = ?");
    $stmt->execute([$produto_id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produto) {
        echo json_encode($produto);
        exit;
    }
}

http_response_code(404);
echo json_encode(["erro" => "Produto não encontrado"]);
