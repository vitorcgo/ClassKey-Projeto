<?php
session_start();
require_once('conexao.php');

// Verifica se está logado como admin
if (!isset($_SESSION['admin_logado'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados conforme os names do HTML
    $email = trim($_POST['cadastroadmin']);
    $senha = $_POST['passwordadmin'];

    // Nome genérico (já que seu formulário não tem campo de nome)
    $nome = 'Administrador'; 
    $ativo = 1;

    // Validação básica
    if (empty($email) || empty($senha)) {
        echo "<div class='mensagem-erro'>Por favor, preencha todos os campos!</div>";
        exit();
    }

    // Criptografa a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO ADMINISTRADOR (ADM_NOME, ADM_EMAIL, ADM_SENHA, ADM_ATIVO) 
                VALUES (:nome, :email, :senha, :ativo)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha_hash, PDO::PARAM_STR);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->execute();

        echo "<div class='mensagem-sucesso'>Administrador cadastrado com sucesso!</div>";
    } catch (PDOException $e) {
        echo "<div class='mensagem-erro'>Erro ao cadastrar: " . $e->getMessage() . "</div>";
    }
}
?>
