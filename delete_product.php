<?php
include 'db_connect.php';

$id = $_GET['id'] ?? null;

if ($id !== null) {
    try {
        $stmt = $pdo->prepare('DELETE FROM produtos WHERE id = :id');
        $stmt->execute(['id' => $id]);
        header('Location: index.php');
        exit;
    } catch (PDOException $e) {
        die("Erro ao remover produto: " . $e->getMessage());
    }
} else {
    echo "ID de produto não fornecido!";
    exit;
}
?>
