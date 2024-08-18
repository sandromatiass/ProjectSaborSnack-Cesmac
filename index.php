<?php
include 'produtos.php';
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
    </header>
    <div class="container">
    <h2>Lista de Produtos</h2>
    <ul class="container-products">
        <?php foreach ($produtos as $index => $produto): ?>
            <li>
                <a href="detalhe_produto.php?id=<?= $index ?>">
                    <img src="<?= $produto['imagem'] ?>" alt="<?= $produto['nome'] ?>">
                    <?= $produto['nome'] ?> - R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    </div>
</body>
<footer>
    <p>&copy; <?= date('Y') ?> Minha Loja de Produtos Saudáveis. Todos os direitos reservados.</p>
</footer>
</html>