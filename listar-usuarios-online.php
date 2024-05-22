<?php

// Consulta SQL para buscar os usuários
$sql = "SELECT user, uptime, session_time_left, bytes_in, bytes_out FROM users_active2";

$result = $conn->query($sql);


// Cria um array para armazenar os dados
$data = array();

while ($row = $result->fetch_assoc()) {
  $data[] = array(
    "user" => $row["user"],
    "uptime" => $row["uptime"],
    "session_time_left" => $row["session_time_left"],
    "bytes_in" => $row["bytes_in"],
    "bytes_out" => $row["bytes_out"],
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
          <th>Usuário</th>
          <th>Tempo de Atividade</th>
          <th>Tempo Restante da Sessão</th>
          <th>Bytes Recebidos</th>
          <th>Bytes Enviados</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data as $row) { ?>
          <tr>
            <td><?php echo $row['user']; ?></td>
            <td><?php echo $row['uptime']; ?></td>
            <td><?php echo $row['session_time_left']; ?></td>
            <td><?php echo $row['bytes_in']; ?></td>
            <td><?php echo $row['bytes_out']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  
  <script>
    $(document).ready(function() {
      $('#tabela_usuarios').DataTable({
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json"
        },
        "layout": {
         "topStart": {
            "buttons": ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
          },
        },
      });
    });
  </script>
</body>
</html>
