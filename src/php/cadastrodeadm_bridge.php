<?php
// Include session validation
include 'verificar_sessao.php';

// Get admin info for personalization
$admin_nome = isset($_SESSION['admin_usuario']) ? $_SESSION['admin_usuario'] : 'Administrador';
?>
