<?php

$current_uri = $_SERVER['REQUEST_URI'];
$public_pages = array(
    'index.html',
);

// Skip checking for public pages
foreach ($public_pages as $page) {
    if (strpos($current_uri, $page) !== false) {
        return;
    }
}

// Check if it's an admin page or needs auth
if (strpos($current_uri, '/src/') !== false && 
    (isset($_GET['session_check']) || 
     strpos($current_uri, 'adm') !== false || 
     strpos($current_uri, 'painel') !== false || 
     strpos($current_uri, 'produto') !== false || 
     strpos($current_uri, 'categoria') !== false)) {

    // Start the session
    session_start();
    
    // Check if user is logged in
    if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
        // Redirect to login page
        header('Location: index.html');
        exit;
    }
}
