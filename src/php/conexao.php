<?php
$databasePath = realpath(__DIR__ . '/db/classkey.db');

if ($databasePath === false) {
    die("Erro: o arquivo do banco de dados não foi encontrado.");
}

$dsn = "sqlite:$databasePath";

try {
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // ✅ Remova ou comente a linha abaixo
    // echo "Conexão com o banco de dados SQLite foi bem-sucedida";
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}