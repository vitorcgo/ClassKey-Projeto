
<?php
session_start();
require_once('conexao.php');

// Verifica se está logado como admin
if (!isset($_SESSION['admin_logado'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados conforme os names do HTML
    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $categoria = $_POST['categoria-options'];
    //$quantidade = $_POST['qtd'];
    //$descricao = $_POST['descricao'];

    // Validação básica
    if (empty($nome) || empty($valor) || empty($categoria)) {
        echo "<div class='mensagem-erro'>Por favor, preencha todos os campos!</div>";
        exit();
    }

    if ($valor < 0 ) {
        echo "<div class='mensagem-erro'>Por favor, preencha o preco com um valor positivo!</div>";
    }
    /*if ($desconto > 99)
    {
        echo "<div class='mensagem-erro'>O desconto não pode ser de 100%!</div>";
    }*/

    try {
        $sql = "INSERT INTO produto (nome, preco, status) 
        VALUES (:nome, :preco, :status)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $valor, PDO::PARAM_STR);
        $status = 'ativo'; 
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->execute();

        $produto_id = $pdo->lastInsertId();

        $sqlRelacao = "INSERT INTO produto_categoria (produto_id, categoria_id) 
               VALUES (:produto_id, :categoria_id)";
        $stmtRel = $pdo->prepare($sqlRelacao);
        $stmtRel->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmtRel->bindParam(':categoria_id', $categoria, PDO::PARAM_INT);
        $stmtRel->execute();



        echo "<div class='mensagem-sucesso'>Produto cadastrado com sucesso!</div>";
    } catch (PDOException $e) {
        echo "<div class='mensagem-erro'>Erro ao cadastrar: " . $e->getMessage() . "</div>";
    }
}
?>
