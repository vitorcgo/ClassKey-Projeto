<?php
session_start();
require 'conexao.php'; // inclui a conexão

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email-admin'];
    $senha = $_POST['senha-admin'];
}

// TERMINAR DE EDITAR ESSA SESSION