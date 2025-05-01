<?php
session_start();
require 'conexao.php'; // inclui a conexão

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email-admin'];
    $senha = $_POST['senha-admin'];

    // Consulta preparada (evita SQL Injection)
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Login bem-sucedido
        $_SESSION['admin'] = $usuario['email'];
        header('Location: loginadmin.php');
        exit;
    } else {
        // Falha no login
        $_SESSION['mensagem_erro'] = "E-mail ou senha incorretos!";
        header('Location: loginadmin.html');
        exit;
    }
}
?>
