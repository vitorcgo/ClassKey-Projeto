<?php
// get_counts.php
include 'conexao.php'; // Inclui o arquivo de conexão

$counts = [];

try {
    // Função auxiliar para obter a contagem de uma tabela
    function getTableCount($pdo, $tableName) {
        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM " . $tableName);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'];
    }

    // Obter contagem para 'produto'
    $counts['totalProdutos'] = getTableCount($pdo, 'produto');

    // Obter contagem para 'categoria'
    $counts['totalCategorias'] = getTableCount($pdo, 'categoria');

    // Obter contagem para 'admin'
    $counts['totalAdministradores'] = getTableCount($pdo, 'admin');

    // Retorna os dados como JSON
    echo json_encode($counts);

} catch (PDOException $e) {
    // Captura e retorna erros de conexão ou consulta
    http_response_code(500); // Erro interno do servidor
    echo json_encode(["erro" => "Erro no banco de dados ao obter contagens: " . $e->getMessage()]);
}

// Não é necessário fechar a conexão explicitamente com PDO para SQLite,
// ela será fechada quando o script terminar.

?>