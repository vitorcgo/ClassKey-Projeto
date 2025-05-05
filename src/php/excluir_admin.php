<?php
include 'conexao.php';

header('Content-Type: application/json');

if (!isset($_POST['id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'ID do administrador não fornecido.']);
    exit();
}

$id = intval($_POST['id']);

try {
    $stmt = $pdo->prepare("DELETE FROM admin WHERE admin_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'sucesso', 'mensagem' => 'Administrador excluído com sucesso.']);
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao excluir administrador.']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro no banco de dados: ' . $e->getMessage()]);
}
?>
