<?php
include 'conexao.php';  // Conexão com o banco

header('Content-Type: application/json');

// Verifica se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['cadastroadmin'] ?? '');
    $senha = $_POST['passwordadmin'] ?? '';
    $nome = 'Administrador';
    $ativo = 1;

    if (empty($email) || empty($senha)) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Por favor, preencha todos os campos.']);
        exit;
    }

    try {
        // Verifica se o e-mail já existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM ADMINISTRADOR WHERE ADM_EMAIL = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $existe = $stmt->fetchColumn();

        if ($existe > 0) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Já existe um administrador com esse e-mail.']);
            exit;
        }

        // Criptografa a senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Insere o novo administrador
        $sql = "INSERT INTO ADMINISTRADOR (ADM_NOME, ADM_EMAIL, ADM_SENHA, ADM_ATIVO)
                VALUES (:nome, :email, :senha, :ativo)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha_hash);
        $stmt->bindParam(':ativo', $ativo);
        $stmt->execute();

        echo json_encode(['status' => 'sucesso', 'mensagem' => 'Administrador cadastrado com sucesso!']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao cadastrar: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Requisição inválida.']);
}
?>

