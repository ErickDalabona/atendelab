<?php
$host = "127.0.0.1";
$db   = "atendelab";
$user = "root";
$pass = "";
$port = "3307";
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["erro" => "Erro na conexao com o banco."]);
    exit;
}
