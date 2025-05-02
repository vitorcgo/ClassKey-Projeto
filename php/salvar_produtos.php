<?php
// Caminho relativo para o banco de dados SQLite
$databasePath = __DIR__ . '/bd/classkey.db';

$dsn = "sqlite:$databasePath";

try {
    // Criando a conexão com o banco de dados SQLite
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Habilita a exibição de erros
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados SQLite: " . $e->getMessage());
}

// Pegando os dados do formulário
$nome = $_POST['nome-do-produtos'] ?? '';
$preco = $_POST['valor'] ?? 0;
$categoria_nome = $_POST['categoria-options'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$status = 'ativo'; // Pode ser ajustado

// Inserir o produto
$stmt = $conn->prepare("INSERT INTO produto (nome, preco, status) VALUES (?, ?, ?)");
$stmt->bind_param("sds", $nome, $preco, $status);
$stmt->execute();
$produto_id = $stmt->insert_id;
$stmt->close();

// Verificar se categoria já existe
$stmt = $conn->prepare("SELECT categoria_id FROM categoria WHERE categoria = ?");
$stmt->bind_param("s", $categoria_nome);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $categoria_id = $row['categoria_id'];
} else {
    // Inserir nova categoria
    $stmtInsert = $conn->prepare("INSERT INTO categoria (categoria) VALUES (?)");
    $stmtInsert->bind_param("s", $categoria_nome);
    $stmtInsert->execute();
    $categoria_id = $stmtInsert->insert_id;
    $stmtInsert->close();
}
$stmt->close();

// Associar categoria ao produto
$stmt = $conn->prepare("INSERT INTO produto_categoria (produto_id, categoria_id) VALUES (?, ?)");
$stmt->bind_param("ii", $produto_id, $categoria_id);
$stmt->execute();
$stmt->close();

$conn->close();

echo "Produto cadastrado com sucesso!";
?>
