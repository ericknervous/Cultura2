<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Internet Ágil Hotspot - Recadastro</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.inputmask.min.js"></script>

<script>
    $(document).ready(function () {
    $('#cpf').inputmask('999.999.999-99');
    $('#tel').inputmask('(99)99999-9999');
    $('#cep').inputmask('99.999-999');
    $('#data_nascimento').inputmask('99/99/9999');
    });
</script>

</head>

<div class="ie-fixMinHeight">
    <div class="main">
        <div class="wrap animated fadeIn">
            <form action="?page=salvar" method="POST">
                <input type="hidden" name="dst" value="$(link-orig)" />
                <input type="hidden" name="popup" value="true" />
                <img class="logo" data-name="Layer 1" src="img/Agil_Prefeitura.png" alt="Internet Agil"><br>
                <input name="tipo_usuario" id="tipo_usuario" type="text" placeholder="IXC" class="form-control" value="Recadastro" style="display: none;"> <!--campo para dizer se o cliente é de IXC ou Cadastro normal, aqui vai ser sempre IXC -->

                <input type="hidden" name="acao" value="novoCadastro">

                <div class="mb-3">
                    <label>
                        <img class="ico" src="img/arquivo.png" alt="#" />
                        <input name="cpf" id="cpf" inputmode="numeric" type="text" placeholder="CPF" class="form-control" maxlength="14" required>
                    </label>
                    <label>
                        <img class="ico" src="img/arquivo.png" alt="#" />
                        <input name="data_nascimento" id="data_nascimento" type="text" placeholder="Data de Nascimento" class="form-control" required>
                    </label>
                    <div class="mb-3">
                     <button type="submit" class="botao">Validar Cadastro</button>
                    </div> 
                </input>
            </form>

