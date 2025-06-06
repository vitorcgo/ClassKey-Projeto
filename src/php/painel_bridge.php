<?php

include 'verificar_sessao.php';


$admin_nome = isset($_SESSION['admin_usuario']) ? $_SESSION['admin_usuario'] : 'Administrador';
?>
