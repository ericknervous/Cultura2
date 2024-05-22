<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Internet Ágil Hotspot - Cadastro</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.inputmask.min.js"></script>
    <script src="js/script.js"></script>
</head>
<script>
    require_once "config.php";
</script>
<div class="ie-fixMinHeight">
    <div class="main">
        <div class="wrap animated fadeIn">
            <form onsubmit="return validarFormulario()" action="?page=salvar" method="POST">
                <!-- Inicio do Formulário, puxando a verificação pelo validarFormulario -->
                <input type="hidden" name="dst" value="https://www.google.com/" />
                <input type="hidden" name="popup" value="true" />
                <img class="logo" data-name="Layer 1" src="img/Agil_Prefeitura.png" alt="Internet Agil"><br>
                <input type="hidden" name="acao" value="cadastrar">
                <input name="bairro" id="bairro" type="text" placeholder="Bairro" class="form-control"
                    style="display: none;">
                <input name="cidade" id="cidade" type="text" placeholder="Cidade" class="form-control"
                    style="display: none;">
                <input name="tipo_usuario" id="tipo_usuario" type="text" placeholder="Cadastro" class="form-control" value="Cadastro"style="display: none;"> <!--campo para dizer se o cliente é de IXC ou Cadastro normal, aqui vai ser sempre Cadastro -->

                <input name="rua" id="rua" type="text" placeholder="Rua" class="form-control" style="display: none;">
                <input name="uf" id="uf" type="text" placeholder="Estado" class="form-control" style="display: none;">

                <div class="mb-3">
                    <label>
                        <img class="ico" src="img/e-mail.png" alt="#" />
                        <input name="email" type="text" placeholder="E-mail" class="form-control" required>
                    </label>
                    <label>
                        <img class="ico" src="img/user.svg" alt="#" />
                        <input name="nome_sobrenome" type="text" placeholder="Nome Completo" class="form-control"
                            required>
                    </label>
                    <label>
                        <img class="ico" src="img/arquivo.png" alt="#" />
                        <input name="cpf" id="cpf" inputmode="numeric" type="text" placeholder="CPF"
                            class="form-control" maxlength="14" required>
                    </label>
                    <label>
                        <img class="ico" src="img/arquivo.png" alt="#" />
                        <input name="data_nascimento" id="data_nascimento" type="text" placeholder="Data de Nascimento"
                            class="form-control" required>
                    </label>
                    <label>
                        <img class="ico" src="img/telefone.png" alt="#" />
                        <input name="telefone" id="tel" type="text" inputmode="numeric" placeholder="Telefone"
                            class="form-control" required>
                    </label>
                    <label>
                        <img class="ico" src="img/adress.png" alt="#" />
                        <input name="cep" id="cep" inputmode="numeric" type="text" placeholder="CEP"
                            class="form-control" onblur="buscarCep(this.value)" required>
                    </label>
                    <label>
                        <img class="ico" src="img/adress.png" alt="#" />
                        <input name="enderecoCompleto" id="enderecoCompleto" type="text" placeholder="Endereço Completo"
                            class="form-control" required>
                    </label>
                    <label>
                        <img class="ico" src="img/home.png" alt="#" />
                        <input name="numero" id="numero" type="text" inputmode="numeric" placeholder="Nº da Residência"
                            inputmode="numeric" class="form-control" required>
                    </label>
                    <label>
                        <img class="ico" src="img/password.svg" alt="#" />
                        <input name="senha" id="senha" type="password" placeholder="Senha" class="form-control"
                            required>
                    </label>
                    <label>
                        <img class="ico" src="img/password.svg" alt="#" />
                        <input name="confirmarSenha" id="confirmarSenha" type="password" placeholder="Confirme a Senha"
                            class="form-control" required>
                    </label>
                    <div class="mb-3">
                        <br><button type="submit" class="botao">Cadastrar</button>
                    </div>
                    </input>
            </form>