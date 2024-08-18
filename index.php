<?php
include 'db_connect.php';

try {
    $stmt = $pdo->query('SELECT * FROM produtos');
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar produtos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <title>Lista de Produtos</title>
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
        <h2>Lista de Produtos</h2>
        <ul class="container-products">
            <?php foreach ($produtos as $produto): ?>
                <li>
                    <a href="detalhe_produto.php?id=<?= $produto['id'] ?>">
                        <img src="<?= $produto['imagem'] ?>" alt="<?= $produto['nome'] ?>">
                        <?= htmlspecialchars($produto['nome']) ?> - R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                    </a>
                    
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <footer>
        <p>&copy; <?= date('Y') ?> Minha Loja de Produtos Saudáveis. Todos os direitos reservados.</p>
    </footer>
</body>
</html>