<?php
include 'conexao.php';  // Conexão com o banco

if (isset($_POST['categoria']) && !empty(trim($_POST['categoria']))) {
    $categoria = trim($_POST['categoria']);

    try {
        // Prepara e executa a inserção no banco de dados
        $stmt = $pdo->prepare("INSERT INTO categoria (categoria) VALUES (:categoria)");
        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Categoria cadastrada com sucesso!']);
        } else {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao cadastrar categoria.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao conectar ao banco: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'O campo categoria não pode estar vazio.']);
}
?>