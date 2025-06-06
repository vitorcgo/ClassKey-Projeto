<?php
session_start();
header("Content-Type: application/json");

include 'conexao.php';

$usuario = $_POST['email-admin'] ?? '';
$senha   = $_POST['senha-admin'] ?? '';

if (empty($usuario) || empty($senha)) {
    echo json_encode(["sucesso" => false, "mensagem" => "Preencha todos os campos."]);
    exit;
}

try {
    // Buscar o usuário no banco
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE usuario = ? AND status != 'INATIVO'");
    $stmt->execute([$usuario]);
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($dados) {
        if (password_verify($senha, $dados['senha'])) {
            // Atualiza a data do último acesso (compatível com SQLite)
            $updateStmt = $pdo->prepare("UPDATE admin SET data_ultimo_acesso = datetime('now') WHERE admin_id = ?");
            $updateStmt->execute([$dados['admin_id']]);

            // Define variáveis de sessão
            $_SESSION['admin_logado'] = true;
            $_SESSION['admin_id'] = $dados['admin_id'];
            $_SESSION['admin_usuario'] = $dados['usuario'];

            echo json_encode(["sucesso" => true]);
            exit;
        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Senha incorreta."]);
        }
    } else {
        echo json_encode(["sucesso" => false, "mensagem" => "Usuário não encontrado ou inativo."]);
    }

} catch (PDOException $e) {
    echo json_encode(["sucesso" => false, "mensagem" => "Erro ao fazer login: " . $e->getMessage()]);
}
