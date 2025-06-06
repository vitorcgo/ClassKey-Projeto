<?php
// Conexão com o banco de dados
include 'conexao.php';

// Consultar as categorias
$categorias = $pdo->query("SELECT * FROM categoria")->fetchAll(PDO::FETCH_ASSOC);

// Retornar as categorias em formato JSON
echo json_encode($categorias);
?>