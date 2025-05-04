<?php
include 'conexao.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT * FROM categoria");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($categorias);
} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro ao buscar categorias: ' . $e->getMessage()]);
}