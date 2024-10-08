<?php
include 'db_connect.php';

$id = $_GET['id'] ?? null;

if ($id !== null) {
    try {
        $stmt = $pdo->prepare('SELECT * FROM produtos WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produto) {
            echo "Produto não encontrado!";
            exit;
        }
    } catch (PDOException $e) {
        die("Erro ao buscar produto: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/detailsProduct.css">
    <title>Detalhes do Produto</title>
</head>
<body>
    <header>
        <h1>Sabor Saudável</h1>
        <nav>
            <ul>
                <li><a href="index.php">Início</a></li>
                <li><a href="adicionar.php">Adicionar Produto</a></li>
                <li><a href="alterar.php">Alterar Produto</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h2>Detalhes do Produto</h2>
        <div class="container-details">
            <img src="<?= $produto['imagem'] ?>" alt="<?= htmlspecialchars($produto['nome']) ?>" style="width: 300px; height: auto;">
            <p><strong>Nome:</strong> <?= htmlspecialchars($produto['nome']) ?></p>
            <p><strong>Descrição:</strong> <?= htmlspecialchars($produto['descricao']) ?></p>
            <p><strong>Preço:</strong> R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
            <a href="index.php" class="backLink">Voltar para a lista de produtos</a>
        </div>
    </div>
    <footer>
        <p>&copy; <?= date('Y') ?> Minha Loja de Produtos Saudáveis. Todos os direitos reservados.</p>
    </footer>
</body>
</html>