<?php
// Caminho do arquivo do banco de dados SQLite
// TEM UM ERRO POIS TODOS AS SESSÇOES ESTÁ SAINDO A MENSAGEM DE CONEXÃO DE BANCO DE DADOS AO INVÊS DE UM SÓ LOCAL.
$databasePath = __DIR__ . '/../bd/classkey.db';

$dsn = "sqlite:$databasePath";

try {
    // Criando a conexão com o banco de dados SQLite
    $pdo = new PDO($dsn);
    echo "Conexão com o banco de dados SQLite foi bem-sucedida";
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados SQLite: " . $e->getMessage();
}
