<?php
// Caminho do arquivo do banco de dados SQLite
$databasePath = __DIR__ . '/../bd/classkey.db';

$dsn = "sqlite:$databasePath";

try {
    // Criando a conexão com o banco de dados SQLite
    $pdo = new PDO($dsn);
    echo "Conexão com o banco de dados SQLite foi bem-sucedida";
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados SQLite: " . $e->getMessage();
}
