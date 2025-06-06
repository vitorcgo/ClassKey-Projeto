<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['status'])) {
    $id = intval($_POST['id']);
    $status = $_POST['status'];

    try {
        $stmt = $pdo->prepare("UPDATE categoria SET status = ? WHERE categoria_id = ?");
        $stmt->execute([$status, $id]);
        echo 'sucesso';
    } catch (PDOException $e) {
        echo 'erro: ' . $e->getMessage();
    }
} else {
    echo 'erro: dados inválidos';
}