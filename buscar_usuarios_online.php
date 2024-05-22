<?php
// Conexão com o banco de dados
include("config.php");        

// Consulta SQL para buscar os usuários
$sql = "SELECT user, uptime, session_time_left, bytes_in, bytes_out FROM users_active2";

$result = $conn->query($sql);

if ($result->num_rows === 0) {
  echo "";
  exit();
}

// Cria um string para armazenar os dados
$data = "";

while ($row = $result->fetch_assoc()) {
  $data .= $row["user"] . "," . $row["uptime"] . "," . $row["session_time_left"] . "," . $row["bytes_in"] . "," . $row["bytes_out"] . "\n";
}

echo $data;