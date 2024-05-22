<?php

require_once "config.php"; 

$sql = "SELECT id, email, nome_sobrenome, telefone, cpf, data_cadastro, cep, rua, numero, bairro, cidade, uf, ip_local, nome_login FROM usuarios2"; // Replace "usuarios" with your table name
$res = $conn->query($sql);

$dados = array();
while ($row = $res->fetch_assoc()) {
  $dados[] = $row;
}

echo json_encode($dados);