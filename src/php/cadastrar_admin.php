<?php
include 'conexao.php';  // Conexão com o banco de dados

date_default_timezone_set('America/Sao_Paulo');  // Define o fuso horário para São Paulo

// Verificar se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber os dados do formulário
    $usuario = $_POST['email'] ?? '';  // O campo 'email' agora será 'usuario' na tabela
    $senha = $_POST['senha'] ?? '';

    // Verificar se os campos estão preenchidos
    if (empty($usuario) || empty($senha)) {
        echo 'Campos obrigatórios não preenchidos.';
        exit;
    }

    // Criptografar a senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Data atual para criação e último acesso
    $dataCriacao = date('Y-m-d H:i:s');
    $dataUltimoAcesso = $dataCriacao;

    try {
        // Inserir os dados no banco de dados
        $stmt = $pdo->prepare("INSERT INTO admin (usuario, senha, data_criacao, data_ultimo_acesso) VALUES (?, ?, ?, ?)");
        $stmt->execute([$usuario, $senhaHash, $dataCriacao, $dataUltimoAcesso]);

        // Se inserido com sucesso
        echo 'sucesso';
    } catch (PDOException $e) {
        // Se ocorrer erro, exibir mensagem de erro
        echo 'Erro ao cadastrar: ' . $e->getMessage();
    }
}
?>
