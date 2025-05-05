<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    try {
        $stmt = $pdo->prepare("DELETE FROM produto WHERE produto_id = ?");
        $stmt->execute([$id]);
        echo 'sucesso';
    } catch (PDOException $e) {
        echo 'erro: ' . $e->getMessage();
    }
} else {
    echo 'erro: ID inválido';
}
