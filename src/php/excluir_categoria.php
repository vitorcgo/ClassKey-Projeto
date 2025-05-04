<?php
include 'conexao.php';

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $pdo->prepare("DELETE FROM categoria WHERE categoria_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo 'sucesso';
    } else {
        echo 'erro';
    }
} else {
    echo 'id_invalido';
}
