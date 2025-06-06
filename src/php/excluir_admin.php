<?php
include 'conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_id'])) {
    $id = $_POST['admin_id'];

    try {
        // Deletando o administrador
        $stmt = $pdo->prepare("DELETE FROM admin WHERE admin_id = ?");
        $stmt->execute([$id]);

        // Verificar se a exclusão foi bem-sucedida
        if ($stmt->rowCount() > 0) {
            echo json_encode(['sucesso' => true]);
        } else {
            echo json_encode(['erro' => 'Administrador não encontrado ou já excluído.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['erro' => 'Erro ao excluir: ' . $e->getMessage()]);
    }
    exit;
}

echo json_encode(['erro' => 'Método não permitido']);
?>
