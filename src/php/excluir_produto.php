<?php
include 'conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_id'])) {
    $id = $_POST['admin_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM admin WHERE admin_id = ?");
        $stmt->execute([$id]);
        echo json_encode(['sucesso' => true]);
    } catch (PDOException $e) {
        echo json_encode(['erro' => 'Erro ao excluir: ' . $e->getMessage()]);
    }
    exit;
}
