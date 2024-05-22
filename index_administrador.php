<?php
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION["login"])) {
    // Redirecionar para a página de login
    header("Location: login-administrativo.html");
    exit();
}

?>
<script>
    window.addEventListener('unload', function () {
        // Enviar uma requisição AJAX para destruir a sessão
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'logout.php', true);
        xhr.send();
    });
</script>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <title>Internet Ágil Hotspot - Área de Administradores</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
  <link rel="stylesheet" href="./style_navbar.css">
  <link rel="stylesheet" href="css/style_adm.css">
  <link rel="stylesheet" href="css/jquery.dataTables.min.css">


  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</head>

<body>
<?php
    if (isset($_SESSION["login"])) {
        ?>
<nav class="navbar navbar-expand-custom navbar-mainbg">
        <a class="navbar-brand navbar-logo" href="#">Internet Ágil</a>
 <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
        <a class="nav-link" href="?page=listar_cadastro"><i class="far fa-copy"></i>Listar Usuários</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="?page=listar_online"><i class="far fa-address-book"></i> Usuários Online</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?page=termos"><i class="far fa-clone"></i> Exemplo</a>
      </li>
    </ul>
  </div>
</nav>
<?php
    }
    ?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2eWLxcpzxjxlVHmLrfnpFUq6/BgCMV9uhzmyiQlWKfbmrX9Gq538Q8hCwX" crossorigin="anonymous"></script>

</body>

</html>


<!-- Essa div faz com que em vez de abrir asinformações em outra página, trava na mesma em uma divisória (div).-->
<div class="container">
    <div class="'row">
        <div class="col mt-5">

         <!-- Trazer as páginas nos botões, ficando tudo na mesma página -->
        <?php   
            include("config.php");         
            switch (@$_REQUEST["page"]) {
                case "listar_cadastro":
                    include("listar-usuarios-cadastro.php");
                    break;
                case "listar_online":
                    include("listar-usuarios-online.php");
                    break;              
                default:
                    print "<h1><br>Bem vindo! <br>Selecione a opção no menu acima.</h1>";
            }
        ?>
        </div>
    </div>
</div>

    <script src="js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>



</body>

</html>