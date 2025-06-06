<?php
session_start();

// Verifica se o administrador está logado
function verificarAdminLogado() {
    if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
        // Redireciona para página de login
        header('Location: loginadm.html');
        exit;
    }
}

// Função para garantir que usuário inativo não possa acessar
function verificarStatusAdmin() {
    if (isset($_SESSION['admin_id'])) {
        include_once 'conexao.php';
        
        try {
            $stmt = $pdo->prepare("SELECT status FROM admin WHERE admin_id = ?");
            $stmt->execute([$_SESSION['admin_id']]);
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Se o admin estiver inativo, fazer logout
            if ($dados && $dados['status'] === 'INATIVO') {
                session_destroy();
                header('Location: loginadm.html?erro=inativo');
                exit;
            }
        } catch (PDOException $e) {
            // Log do erro em algum lugar
            // Em caso de erro, continuar normalmente
        }
    }
}

// Verifica sessão em cada carregamento
verificarAdminLogado();
verificarStatusAdmin();
