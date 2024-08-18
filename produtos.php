<?php
include 'db_connect.php';

try {
    $stmt = $pdo->query('SELECT * FROM produtos');
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar produtos: " . $e->getMessage());
}
?>