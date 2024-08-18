<?php
$servername = "sql110.infinityfree.com";
$username = "if0_37133280"; 
$password = "uEinzJuPjWjsV"; 
$dbname = "if0_37133280_sabor_2024"; 


try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>