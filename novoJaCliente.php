<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Internet Ágil Hotspot - Cadastro Para CLiente Àgil</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.inputmask.min.js"></script>
    <script src="js/script.js"></script>
</head>
<script>
    require_once "config.php";
</script>

<script>
    // Chamar a função buscarCep com o valor do campo assim que a página for carregada
    window.onload = function() {
        var valorCep = document.getElementById('cep').value;
        buscarCep(valorCep);
    };
</script>


<?php
session_start();


if (isset($_SESSION["variavel"])) {
    // Obtém o valor da variável da sessão
    $valor = $_SESSION["variavel"];
}
// Echos para verificar se o valores de sessão vieram mesmo
// echo "Valor do que veio da Session Valor >>>>>>>>>>>> " . $valor . "<br>";


$valor2 = $_SESSION["variavel2"];
$valor3 = $_SESSION["variavel3"];
$valor4 = $_SESSION["variavel4"];
$valor5 = $_SESSION["variavel5"];
$valor6 = $_SESSION["variavel6"];
$valor7 = $_SESSION["variavel7"];

// Echos para verificar se o valores de sessão vieram mesmo
// echo "Valor do que veio da Session Valor2 >>>>>>>>>>>> " . $valor2 . "<br>";
// echo "Valor do que veio da Session Valor3 >>>>>>>>>>>> " . $valor3 . "<br>";
// echo "Valor do que veio da Session Valor4 >>>>>>>>>>>> " . $valor4 . "<br>";
// echo "Valor do que veio da Session Valor5 >>>>>>>>>>>> " . $valor5 . "<br>";
// echo "Valor do que veio da Session Valor6 >>>>>>>>>>>> " . $valor6 . "<br>";
// echo "Valor do que veio da Session Valor7 >>>>>>>>>>>> " . $valor7 . "<br>";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//Aqui é o completo, para visualizar no echo a váriavel, acima não preciso visualizar
// if (isset($_SESSION["variavel"])) {
//     // Obtém o valor da variável da sessão
//     $valor = $_SESSION["variavel"];
//     echo "Valor da variável: " . $valor;
// }    else {
//         echo "Valor da variável não encontrado na sessão.";
//     }
?>
<div class="ie-fixMinHeight">
    <div class="main">
        <div class="wrap animated fadeIn">
            <form onsubmit="return validarFormulario()" action="?page=salvar" method="POST">
                <!-- Inicio do Formulário, puxando a verificação pelo validarFormulario -->
                <input type="hidden" name="dst" value="https://www.google.com/" />
                <input type="hidden" name="popup" value="true" />
                <img class="logo" data-name="Layer 1" src="img/Agil_Prefeitura.png" alt="Internet Agil"><br>
                <input type="hidden" name="acao" value="cadastrar">
                <input name="bairro" id="bairro" type="text" placeholder="Bairro" class="form-control" style="display: none;">
                <input name="cidade" id="cidade" type="text" placeholder="Cidade" class="form-control" style="display: none;">
                <input name="tipo_usuario" id="tipo_usuario" type="text" placeholder="IXC" class="form-control" value="IXC" style="display: none;"> <!--campo para dizer se o cliente é de IXC ou Cadastro normal, aqui vai ser sempre IXC -->

                <input name="rua" id="rua" type="text" placeholder="Rua" class="form-control" style="display: none;">
                <input name="uf" id="uf" type="text" placeholder="Estado" class="form-control" style="display: none;">
                <div class="mb-3">
                    <label>
                        <!-- <img class="ico" src="img/e-mail.png" alt="#" /> para não dar conflito nos icones co ma mensagem lá
                        de baixo, vou comentar todos os icones acima -->
                        <input name="email" type="text" placeholder="E-mail" class="form-control" value="<?php echo htmlspecialchars($valor2); ?>" style="display: none;" required>
                    </label>
                    <label>
                        <!-- <img class="ico" src="img/user.svg" alt="#" /> -->
                        <input name="nome_sobrenome" id="nome_completo" type="text" placeholder="Nome Completo" class="form-control" value="<?php echo htmlspecialchars($valor3); ?>" style="display: none;" required>
                    </label><br>

                    <label>
                        <p class="info $(if error)alert$(endif)">
                            O seu Login será o seu CPF.
                        </p>
                    </label>
                    <label>
                        <img class="ico" src="img/arquivo.png" alt="#" />
                        <input name="cpf" id="cpf" inputmode="numeric" type="text" placeholder="CPF" class="form-control" maxlength="14" value="<?php echo htmlspecialchars($valor); ?>" required readonly>
                    </label>
                    <!-- <label>
                        <img class="ico" src="img/arquivo.png" alt="#" />
                        <input name="data_nascimento" id="data_nascimento" type="text" placeholder="Data de Nascimento" class="form-control" value="<?php echo htmlspecialchars($valor5); ?>"  required>
                    </label> -->


                    <label>
                        <img class="ico" src="img/arquivo.png" alt="#" />
                        <?php
                        // Formata a data para o formato brasileiro (DD/MM/AAAA)
                        $data_formatada = date('d/m/Y', strtotime($valor5));
                        ?>
                        <input name="data_nascimento" id="data_nascimento" type="text" placeholder="Data de Nascimento" class="form-control" value="<?php echo htmlspecialchars($data_formatada); ?>" style="display: none;" required>

                    </label>

                    <label>
                        <img class="ico" src="img/telefone.png" alt="#" />
                        <input name="telefone" id="tel" type="text" inputmode="numeric" placeholder="Telefone" class="form-control" value="<?php echo htmlspecialchars($valor4); ?>" style="display: none;" required>
                    </label>
                    <label>
                        <img class="ico" src="img/adress.png" alt="#" />
                        <input name="cep" input type="text" id="cep" value="<?php echo htmlspecialchars(str_replace('-', '', $valor6)); ?>" style="display: none;" required>
                    </label> <!-- Dessa forma ele já carrega o CEP e já busca atualizando o campo de Endereço Completo -->
                    <label>
                        <img class="ico" src="img/adress.png" alt="#" />
                        <input name="enderecoCompleto" id="enderecoCompleto" type="text" placeholder="Endereço Completo" class="form-control" style="display: none;" required>
                    </label>
                    <label>
                        <img class="ico" src="img/home.png" alt="#" />
                        <input name="numero" id="numero" type="text" inputmode="numeric" placeholder="Nº da Residência" inputmode="numeric" class="form-control" value="<?php echo htmlspecialchars($valor7); ?>" style="display: none;" required>
                    </label>
                    <label>
                        <img class="ico" src="img/password.svg" alt="#" />
                        <input name="senha" id="senha" type="password" placeholder="Senha" class="form-control" required>
                    </label>
                    <label>
                        <img class="ico" src="img/password.svg" alt="#" />
                        <input name="confirmarSenha" id="confirmarSenha" type="password" placeholder="Confirme a Senha" class="form-control" required>
                    </label>
                    <div class="mb-3">
                        <br><button type="submit" class="botao">Cadastrar</button>
                    </div>
                    </input>

            </form>