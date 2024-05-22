<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Internet Ágil Hotspot - Já Sou Cliente Ágil</title>
    <?php
    session_start();
    ?>
</head>
<script>
    // Para CPF
    window.onload = function() {
        var input = document.getElementById('entradaCPF');

        input.addEventListener('input', function(evt) {
            var valor = input.value;
            valor = valor.replace(/\D/g, ''); // Remove tudo exceto números
            valor = valor.substring(0, 11); // Limita o tamanho máximo para 11 caracteres

            // Aplica a máscara
            if (valor.length > 3) {
                valor = valor.substring(0, 3) + '.' + valor.substring(3);
            }
            if (valor.length > 7) {
                valor = valor.substring(0, 7) + '.' + valor.substring(7);
            }
            if (valor.length > 11) {
                valor = valor.substring(0, 11) + '-' + valor.substring(11);
            }

            input.value = valor;
        });
    };
</script>

</head>

<body>
    <!-- -->

    <div class="ie-fixMinHeight">

        <div class="wrap animated fadeIn">

            <label>
                <p class="info $(if error)alert$(endif)">
                    Digite seu CPF para buscarmos seu cadastro Ágil.
                </p>
            </label>
            <label>
                <form method="post" action="novoJacliente.php">
                    <input type="hidden" name="entradaCPF" value="<?php echo htmlspecialchars($entradaCPF); ?>">
                    <!-- Seus outros campos e botões aqui -->
                </form>
                <img class="ico" src="img/arquivo.png" alt="#" />
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="text" name="entradaCPF" id="entradaCPF" placeholder="CPF" class="form-control" maxlength="14" required>
                    <input type="submit" name="submit" value="Buscar">
                </form>
            </label>
            <script>
                document.getElementById("meuFormulario").addEventListener("submit", function(event) {
                    event.preventDefault(); // Impede o envio padrão do formulário

                    var entradaCPF = document.getElementById("entradaCPF").value;
                    // Redireciona para pg2.php e passa o valor do CPF como parâmetro na URL
                    window.location.href = "novoJaCliente.php?entradaCPF=" + encodeURIComponent(entradaCPF);
                });
            </script>
        </div>
        <?php
        global $entradaCPF;
        // $entradaCPF = 0; 
        // Verifica se o formulário foi submetido CPF
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtém o valor digitado pelo usuário
            $entradaCPF = $_POST['entradaCPF'];
        }

        require(__DIR__ . DIRECTORY_SEPARATOR . 'WebserviceClient.php');
        $host = 'https://ixc.cmctelecom.com.br/webservice/v1';
        $token = '90:972588e1d58f808c754f93cf700e7b8de69267c6126e2a74b1c2d81c6659bc16'; //token gerado no cadastro do usuario (verificar permissões)
        $selfSigned = true; //true para certificado auto assinado
        //$cpf = $_GET['cpf'];
        $api = new IXCsoft\WebserviceClient($host, $token, $selfSigned);
        $params = array(
            'qtype' => 'cliente.cnpj_cpf', //campo de filtro //cliente.id
            'query' => $entradaCPF, //valor para consultar //1
            'oper' => '=', /*operador da consulta (coloque >= para trazer todos os clientes, 
                    no caso que tenham id maior que 1 onsequentemente trazendo todos) */ // >=
            'page' => '1', //página a ser mostrada
            'rp' => '2',/*quantidade de registros por página. Pode aumentar o "rp" pra um valor como 1000 
    e posteriormente passar a mesma
    requisição e ir alterando o campo "page" que é paginação 
    (trará 1000 registros por página, se trocar pra 5 por exemplo irá trazer o cliente 5000 até o cliente 6000 */
            'sortname' => 'cliente.id', //campo para ordenar a consulta
            'sortorder' => 'desc' //ordenação (asc= crescente | desc=decrescente)

        );

        $api->get('cliente', $params);
        $retorno = $api->getRespostaConteudo(true); // false para json | true para array

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //Echo para mostrar TODOS os campos do cadastro do cliente
        //echo "<pre>";
        //print_r($retorno);
        //echo "</pre>";

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //Aqui ele só vai puxar o campo CPF no array da API, e salvando em uma variável (teste2)
        function imprimirElementoPorCampo($array, $campoBuscado)
        {
            global $teste2;
            foreach ($array as $chave => $valor) {
                if ($chave === $campoBuscado) {
                    //echo $valor . "<br>"; //aqui ele mostra o CPF digitado, vou deixar comentado para não mostrar, pois mostra no inicio também
                    $teste2 = $valor;
                } elseif (is_array($valor)) {
                    imprimirElementoPorCampo($valor, $campoBuscado);
                }
            }
        }

        // Chamada da função para imprimir o elemento correspondente ao campo 'cnpj_cpf'
        imprimirElementoPorCampo($retorno, 'cnpj_cpf');
        // echo "Valor do teste2 >>>>>>>>>>>> " . $teste2 . "<br>";

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //Imprimir apenas os campos que eu quero do array, na consulta.
        function imprimirElementoPorCampo2($array, $camposBuscados)
        {
            global $teste3;
            foreach ($array as $chave => $valor) {
                if (in_array($chave, $camposBuscados)) {
                    echo $chave . ": " . $valor . "<br>";
                    $teste3[] = $valor;
                } elseif (is_array($valor)) {
                    imprimirElementoPorCampo2($valor, $camposBuscados);
                }
            }
        }

        // Chama a função para imprimir os campos que eu desejo
        $camposDesejados = ['email', 'razao', 'telefone_celular', 'cpf', 'data_nascimento', 'cep', 'numero']; // Defina os campos que deseja exibir
        //imprimirElementoPorCampo2($retorno, $camposDesejados); //Aqui vai imprimir na tela (Echo) todos os campos do cliente

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    

        // Aqui eu vou pegar cada campo que eu quero do array  e guardar em uma variável
        function obterValoresPorCampo($array, $camposBuscados)
        {
            $valores = array();
            foreach ($array as $chave => $valor) {
                if (in_array($chave, $camposBuscados)) {
                    $valores[$chave] = $valor;
                } elseif (is_array($valor)) {
                    $valores = array_merge($valores, obterValoresPorCampo($valor, $camposBuscados));
                }
            }
            return $valores;
        }

        // Exemplo de uso:
        $camposDesejados = ['email', 'razao', 'telefone_celular', 'cpf', 'data_nascimento', 'cep', 'numero']; // Defina os campos que deseja obter os valores
        $valoresDosCampos = obterValoresPorCampo($retorno, $camposDesejados);

        // Agora você pode acessar os valores dos campos desejados usando as chaves do array retornado
        if (isset($valoresDosCampos['email'])) {
            $email = $valoresDosCampos['email'];
            // echo "Esse é o E-mail do(a) Cliente: " . $email . "<br>";
        }

        if (isset($valoresDosCampos['razao'])) {
            $razao = $valoresDosCampos['razao'];
            // echo "Esse é o Nome do(a) Cliente: " . $razao . "<br>";
        }

        if (isset($valoresDosCampos['telefone_celular'])) {
            $celular = $valoresDosCampos['telefone_celular'];
            // echo "Esse é o Celular do(a) Cliente: " . $celular . "<br>";
        }

        if (isset($valoresDosCampos['cpf'])) {
            $cpf = $valoresDosCampos['cpf'];
            // echo "Esse é o CPF do(a) Cliente: " . $cpf . "<br>";
        }

        if (isset($valoresDosCampos['data_nascimento'])) {
            $data_nascimento = $valoresDosCampos['data_nascimento'];
            // echo "Essa é a Data de Nascimento do(a) Cliente: " . $data_nascimento . "<br>";
        }

        if (isset($valoresDosCampos['cep'])) {
            $cep = $valoresDosCampos['cep'];
            // echo "Esse é o CEP do(a) Cliente: " . $cep . "<br>";
        }

        if (isset($valoresDosCampos['numero'])) {
            $numero = $valoresDosCampos['numero'];
            // echo "Esse é o Numero de Endereço do(a) Cliente: " . $numero . "<br>";
        }
        //////////////////////////////////////////////////////////////////////////////   

        // Aqui ele vai verificar se o CPF na API corresponde ao digitado, se sim manda para tal tela, se não, para outra
        if (!empty($teste2) && $teste2 == $entradaCPF) {

            echo "<script>alert('CPF Encontrado com sucesso!');</script>";
            echo "<script>window.location.href = 'index.php?page=novoJaCliente';</script>";



            //Preciso pegar o valor do CPF para mandar para outra tela e já preencher
            //Além do CPF, quero mandar os demais valores 
            //Enviar valores 
            $valor = $entradaCPF;

            $valor2 = $email;
            $valor3 = $razao;
            $valor4 = $celular;
            $valor5 = $data_nascimento;
            $valor6 = $cep;
            $valor7 = $numero;


            $_SESSION["variavel"] = $valor;


            $_SESSION["variavel2"] = $valor2;
            $_SESSION["variavel3"] = $valor3;
            $_SESSION["variavel4"] = $valor4;
            $_SESSION["variavel5"] = $valor5;
            $_SESSION["variavel6"] = $valor6;
            $_SESSION["variavel7"] = $valor7;
        } elseif ($teste2 == null) {

            echo "<script>alert('CPF não encontrado! Por favor cadastre-se... ');</script>";
            // Redireciona para a página 'index.php?page=novo' após a exibição da mensagem
            echo "<script>window.location.href = 'index.php?page=novo';</script>";
        }
