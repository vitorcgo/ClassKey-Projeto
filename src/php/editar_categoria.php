<?php
include 'conexao.php';

// Carregar categoria para edição
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM categoria WHERE categoria_id = ?");
        $stmt->execute([$id]);
        $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($categoria) {
            header('Content-Type: application/json');
            echo json_encode($categoria);
        } else {
            echo json_encode(['erro' => 'Categoria não encontrada']);
        }
    } catch (PDOException $e) {
        echo json_encode(['erro' => 'Erro ao carregar categoria: ' . $e->getMessage()]);
    }
}

// Atualizar categoria
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se os dados necessários foram enviados
    if (isset($_POST['categoria_id'], $_POST['categoria'])) {
        $id = intval($_POST['categoria_id']);
        $nome = trim($_POST['categoria']);
        $status = isset($_POST['status']) ? $_POST['status'] : 'ATIVO';
        
        // Validação básica
        if (empty($nome)) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Nome da categoria é obrigatório']);
            exit;
        }
        
        try {
            $stmt = $pdo->prepare("UPDATE categoria SET categoria = ?, status = ? WHERE categoria_id = ?");
            if ($stmt->execute([$nome, $status, $id])) {
                echo json_encode(['status' => 'sucesso', 'mensagem' => 'Categoria atualizada com sucesso']);
            } else {
                echo json_encode(['status' => 'erro', 'mensagem' => 'Falha ao atualizar categoria']);
            }
        } catch (PDOException $e) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro no banco de dados: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Dados incompletos']);
    }
}