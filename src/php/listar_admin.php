<?php
include 'conexao.php';
header('Content-Type: application/json');

date_default_timezone_set('America/Sao_Paulo');  // Define o fuso horário para São Paulo

try {
    // Buscar administradores com data de criação e último acesso
    $stmt = $pdo->query("SELECT admin_id, usuario, senha, data_criacao, data_ultimo_acesso FROM admin");
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($admins);
} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro ao buscar administradores: ' . $e->getMessage()]);
}
?>
