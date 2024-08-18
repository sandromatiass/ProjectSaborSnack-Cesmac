<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagemTmp = $_FILES['imagem']['tmp_name'];
        $imagemNome = $_FILES['imagem']['name'];
        $imagemCaminho = './assets/image/' . basename($imagemNome);

        if (move_uploaded_file($imagemTmp, $imagemCaminho)) {
            $imagemUrl = $imagemCaminho;
        } else {
            die("Erro ao mover o arquivo da imagem.");
        }
    } else {
        die("Erro no upload da imagem.");
    }

    try {
        $stmt = $pdo->prepare('INSERT INTO produtos (nome, descricao, preco, imagem) VALUES (:nome, :descricao, :preco, :imagem)');
        $stmt->execute([
            'nome' => $nome,
            'descricao' => $descricao,
            'preco' => $preco,
            'imagem' => $imagemUrl
        ]);
        header('Location: index.php');
        exit;
    } catch (PDOException $e) {
        die("Erro ao adicionar produto: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/adicionar.css">
    <title>Adicionar Produto</title>
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
        <h2>Adicionar Produto</h2>
        <form action="adicionar.php" method="POST" enctype="multipart/form-data" class="container_form">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required></textarea>
            
            <label for="preco">Preço:</label>
            <input type="text" id="preco" name="preco" required>
            
            <label for="imagem">Imagem:</label>
            <input type="file" id="imagem" name="imagem" accept="image/*" class="uploadImg" required>
            
            <button type="submit">Adicionar Produto</button>
        </form>
    </div>
</body>
</html>
