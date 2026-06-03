<?php
$host = "127.0.0.1";
$usuario = "root";
$senha = "";
$banco = "atendelab";
$porta = 3307;

$conexao = new mysqli($host, $usuario, $senha, $banco, $porta);

if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

echo "Conexão bem-sucedida com o banco atendelab!";
?>