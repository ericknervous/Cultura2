<?php

// Consulta SQL para buscar os usuários
$sql = "SELECT email, nome_sobrenome, telefone, cpf, data_cadastro, rua, bairro, cidade, ip_local FROM usuarios2";

$result = $conn->query($sql);


// Cria um array para armazenar os dados
$data = array();

while ($row = $result->fetch_assoc()) {
  $data[] = array(
    "email" => $row["email"],
    "nome_sobrenome" => $row["nome_sobrenome"],
    "telefone" => $row["telefone"],
    "cpf" => $row["cpf"],
    "rua" => $row["rua"],
    "bairro" => $row["bairro"],
    "cidade" => $row["cidade"],
    "ip_local" => $row["ip_local"],
    "data_cadastro" => $row["data_cadastro"],
  );
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Internet Ágil - Sistema Administrativo</title>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
  <link rel="stylesheet" src="./css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css">
</head>
<body>
  <div class="container">
    <table id="tabela_usuarios" class="table table-striped table-bordered">
      <thead>
        <tr>
        <th>Cadastrado em</th>
        <th>Nome</th>
        <th>Telefone</th>
        <th>Email</th>
        <th>CPF</th>
        <th>Cidade</th>
        <th>Bairro</th>
        <th>Rua</th>
        <th>IP</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data as $row) { ?>
          <tr>
          <td><?php echo $row['data_cadastro']; ?></td>
          <td><?php echo $row['nome_sobrenome']; ?></td>
          <td><?php echo $row['telefone']; ?></td>
          <td><?php echo $row['email']; ?></td>
          <td><?php echo $row['cpf']; ?></td>
          <td><?php echo $row['cidade']; ?></td>
          <td><?php echo $row['bairro']; ?></td>
          <td><?php echo $row['rua']; ?></td>
          <td><?php echo $row['ip_local']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  
  <script>
    $(document).ready(function() {
      $('#tabela_usuarios').DataTable({
        "pagingType": 'simple_numbers',
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json"
        },
        "layout": {
         "topStart": {
            "buttons": ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
          },
        },
        "scrollX": 'true',
        "scrollCollapse": 'true',
        "scrollY": '450px'
      });
    });
  </script>
</body>
</html>
