<?php
include 'db_connect.php';

$id = $_GET['id'] ?? null;
$produto = null;

if ($id !== null) {
    try {
        $stmt = $pdo->prepare('SELECT * FROM produtos WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produto) {
            echo "<p class='error'>Produto não encontrado!</p>";
            exit;
        }
    } catch (PDOException $e) {
        die("Erro ao buscar produto: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    try {
        $stmt = $pdo->prepare('UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco WHERE id = :id');
        $stmt->execute(['nome' => $nome, 'descricao' => $descricao, 'preco' => $preco, 'id' => $id]);
        header('Location: alterar.php');
        exit;
    } catch (PDOException $e) {
        die("Erro ao atualizar produto: " . $e->getMessage());
    }
}

$search = $_GET['search'] ?? '';
$produtos = [];

try {
    $stmt = $pdo->prepare('SELECT id, nome, preco FROM produtos WHERE nome LIKE :search ORDER BY nome');
    $stmt->execute(['search' => "%$search%"]);
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
    <link rel="stylesheet" href="./assets/css/alterar.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Alterar Produto</title>
    <script>
        $(document).ready(function() {
            $('.deleteLink').on('click', function(e) {
                e.preventDefault();
                const link = $(this).attr('href');
                if (confirm('Tem certeza que deseja excluir este produto?')) {
                    window.location.href = link;
                }
            });

            <?php if (isset($_GET['error']) && $_GET['error'] == 'not_found'): ?>
                alert('Produto não encontrado!');
            <?php endif; ?>
        });
    </script>
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
        <h2>Alterar Produto</h2>
        <form action="alterar.php" method="GET">
            <label for="search">Buscar Produto:</label>
            <input type="text" id="search" name="search" value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Buscar</button>
        </form>
        
        <?php if ($produto): ?>
        <h3>Alterar Produto</h3>
        <form action="alterar.php?id=<?= $id ?>" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>
            
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required><?= htmlspecialchars($produto['descricao']) ?></textarea>
            
            <label for="preco">Preço:</label>
            <input type="text" id="preco" name="preco" value="<?= htmlspecialchars($produto['preco']) ?>" required>
            
            <button type="submit">Salvar Alterações</button>
        </form>
        <?php endif; ?>
        
        <h3>Lista de Produtos</h3>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?= htmlspecialchars($produto['nome']) ?></td>
                    <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                    <td>
                        <a href="detalhe_produto.php?id=<?= $produto['id'] ?>">Visualizar</a> |
                        <a href="alterar.php?id=<?= $produto['id'] ?>">Alterar</a> |
                        <a href="delete_product.php?id=<?= $produto['id'] ?>" class="deleteLink">Remover</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>