<?php
include 'conexao.php';

if (isset($_POST['categoria']) && !empty(trim($_POST['categoria']))) {
    $categoria = trim($_POST['categoria']);

    try {
        // Verifica se já existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM categoria WHERE categoria = :categoria");
        $stmt->bindParam(':categoria', $categoria);
        $stmt->execute();
        $existe = $stmt->fetchColumn();

        if ($existe > 0) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Essa categoria já existe.']);
            exit;
        }

        // Insere
        $stmt = $pdo->prepare("INSERT INTO categoria (categoria) VALUES (:categoria)");
        $stmt->bindParam(':categoria', $categoria);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Categoria cadastrada com sucesso!']);
        } else {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao cadastrar categoria.']);
        }

    } catch (PDOException $e) {
        // Se o erro for de chave duplicada (constraint UNIQUE)
        if ($e->getCode() == '23000') {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Essa categoria já foi cadastrada.']);
        } else {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro no banco: ' . $e->getMessage()]);
        }
    }
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'O campo categoria não pode estar vazio.']);
}

?>