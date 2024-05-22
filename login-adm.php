<?php

// Conexão com o banco de dados
require_once "config.php";

// Recebendo dados do formulário
$login = $_POST["login"];
$senha = $_POST["senha"];

// Validando login e senha
$sql = "SELECT * FROM users_login2 WHERE Login = '$login' AND Senha = '$senha'";
$result = mysqli_query($conn, $sql);

// Se o usuário for encontrado, redireciona para a área administrativa
if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('Login ou senha incorretos! Verifique as informações e tente novamente.');</script>";
    return true;
} else {
    session_start();
    $_SESSION["login"] = $login;
    header("Location: index_administrador.php");
}