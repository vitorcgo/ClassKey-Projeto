<?php
include 'conexao.php';
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'ID do produto não informado']);
    exit;
}

$id = intval($_GET['id']);

// JOIN para categoria e imagem
$stmt = $pdo->prepare("
    SELECT 
        p.*, 
        pc.categoria_id,
        pm.url AS imagem_url
    FROM produto p
    LEFT JOIN produto_categoria pc ON p.produto_id = pc.produto_id
    LEFT JOIN produto_media pm ON p.produto_id = pm.produto_id
    WHERE p.produto_id = ?
");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    http_response_code(404);
    echo json_encode(['erro' => 'Produto não encontrado']);
    exit;
}

echo json_encode($produto);
