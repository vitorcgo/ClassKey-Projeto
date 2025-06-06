<?php
include 'conexao.php';

header('Content-Type: application/json');

try {
    // Check if a specific category ID is requested
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM categoria WHERE categoria_id = ?");
        $stmt->execute([$id]);
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Get all categories
        $stmt = $pdo->query("SELECT * FROM categoria");
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    echo json_encode($categorias);
} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro ao buscar categorias: ' . $e->getMessage()]);
}