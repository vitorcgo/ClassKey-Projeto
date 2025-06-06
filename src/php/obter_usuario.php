<?php
session_start(); // Inicia a sessão

// Verifica se o nome do usuário está armazenado na sessão
if (isset($_SESSION['admin_usuario'])) {
    echo $_SESSION['admin_usuario']; // Exibe o nome do usuário logado
} else {
    echo 'Visitante'; // Caso o usuário não esteja logado
}
?>
