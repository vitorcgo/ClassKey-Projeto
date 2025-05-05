<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email-admin'] ?? '';
    $senha = $_POST['senha-admin'] ?? '';

    // Verifica se o admin existe no banco
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE usuario = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($senha, $admin['senha'])) {
        // Atualiza a data de último acesso
        $stmtUpdate = $pdo->prepare("UPDATE admin SET data_ultimo_acesso = ? WHERE admin_id = ?");
        $stmtUpdate->execute([date('Y-m-d H:i:s'), $admin['admin_id']]);

        // Cria a sessão do administrador (opcional, para controle de login)
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['usuario'] = $admin['usuario'];

        // Redireciona para o painel ou página do administrador
        header('Location: /src/painel.html');
        exit;
    } else {
        echo 'Desculpe cara, você errou a senha do administrador, tente novamente!.';
    }
}
?>
