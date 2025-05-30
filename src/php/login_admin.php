<?php
session_start();
$_SESSION['admin_logado'] = true;
header("Access-Control-Allow-Origin: ");
header("Location: painel.html");
header("Content-Type: application/json");

include 'conexao.php';

$usuario = $_POST['email-admin'] ?? '';
$senha   = $_POST['senha-admin'] ?? '';

if (empty($usuario) || empty($senha)) {
    echo json_encode(["sucesso" => false, "mensagem" => "Preencha todos os campos."]);
    exit;
}

// Buscar o usuário no banco
$stmt = $conn->prepare("SELECT FROM usuarios WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $dados = $result->fetch_assoc();

    // Verifica a senha com hash
    if (password_verify($senha, $dados['senha-admin'])) {
        $_SESSION['usuario_logado'] = $usuario;
        echo json_encode(["sucesso" => true]);
    } else {
        echo json_encode(["sucesso" => false, "mensagem" => "Senha incorreta."]);
    }
} else {
    echo json_encode(["sucesso" => false, "mensagem" => "Usuário não encontrado."]);
}

$stmt->close();
$conn->close();
?>