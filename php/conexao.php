<?php 
//configuracoes do banco de dados

$host = 'localhost';
$db = 'classkey'
$user = 'root';
$pass = '';
$chartset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$chartset";

//Criando a conexao com o banco de dados

try {$pdo = new PDO($dsn, $user, $pass);
    echo"Conexao com o banco de dados foi bem sucedida";
}
catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados <p>". $e;
}