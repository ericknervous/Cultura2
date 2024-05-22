<?php
$ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

switch ($_REQUEST["acao"]) {
    case "cadastrar":
        $email = $_POST["email"];
        $nome_sobrenome = $_POST["nome_sobrenome"];
        $telefone = $_POST["telefone"];
        $cpf = $_POST["cpf"];
        $data_nascimento = $_POST["data_nascimento"]; // Inserir no cadastro
        // $nome_login = $_POST["nome_login"];
        $senha = $_POST["senha"];
        $cep = $_POST["cep"];
        $rua = $_POST["rua"];
        $bairro = $_POST["bairro"];
        $cidade = $_POST["cidade"];
        $tipo_usuario = $_POST["tipo_usuario"];//campo para dizer se o cliente é de IXC ou Cadastro normal
        $uf = $_POST["uf"];
        $numero = $_POST["numero"]; // Adicionado o campo número
        

        // Verificar a conexão
        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        $sql = "INSERT INTO usuarios2 (email, nome_sobrenome, telefone, cpf, data_nascimento, senha, cep, rua, bairro, cidade, tipo_usuario, data_cadastro, uf, numero, ip_local) VALUES 
        ('{$email}', '{$nome_sobrenome}', '{$telefone}', '{$cpf}', '{$data_nascimento}', '{$senha}', '{$cep}', '{$rua}', '{$bairro}', '{$cidade}','{$tipo_usuario}', NOW(), '{$uf}', '{$numero}', '{$ip}')";
        

        if ($conn->query($sql) === TRUE) {
        } else {
            echo "Erro ao inserir dados: " . $conn->error;
        }
        $mikrotik_api = new RouterOSAPI();
        $mikrotik_api->connect("192.168.99.2", "api_hotspot", "Cmc1303!");
        
        $profile = $mikrotik_api->comm("/ip/hotspot/user/add", array(
          "name" => $cpf,
          "password" => $senha,
          "profile" => "default",
        ));

        // Desconexão do Mikrotik e banco de dados
        $mikrotik_api->disconnect();
        mysqli_close($conn);   


        print "<script>alert('Cadastrado com sucesso! Realize o login na próxima página.');</script>";
        //print "<script>location.href='login_cadastro.html';</script>"; 
        print "<script>location.href='http://192.168.3.1/login_cadastro.html';</script>"; 


        break;
        
        case "novoCadastro":

            $cpf = $_POST["cpf"];
            $data_nascimento = $_POST["data_nascimento"]; 

            $mikrotik_api = new RouterOSAPI();
            $mikrotik_api->connect("192.168.99.2", "api_hotspot", "Cmc1303!");
            // Verificar a conexão
            if ($conn->connect_error) {
                die("Falha na conexão: " . $conn->connect_error);
            }
            
            // Buscar usuário no banco de dados
           // Executar a consulta
            $sql = "SELECT * FROM usuarios2 WHERE cpf = '{$cpf}'";
            $result = mysqli_query($conn, $sql);

            // Verificar se a consulta foi executada com sucesso
            if (!$result) {
                die("Falha na consulta: " . mysqli_error($conn));
            }

            // Verificar se o usuário foi encontrado
            if (mysqli_num_rows($result) >= 1) {

                $user = $result->fetch_assoc();
            
                // Obter informações do usuário
                $email = $user["email"];
                $nome_sobrenome = $user["nome_sobrenome"];
                $telefone = $user["telefone"];
                $cpf = $user["cpf"];
                // $nome_login = $user["nome_login"];
                $senha = $user["senha"];
                $cep = $user["cep"];
                $rua = $user["rua"];
                $bairro = $user["bairro"];
                $cidade = $user["cidade"];
                $tipo_usuario = $_POST["tipo_usuario"];//campo para dizer se o cliente é de IXC ou Cadastro normal
                $uf = $user["uf"];
                $numero = $user["numero"];
                $data_nascimento = $user["data_nascimento"];

                // Inserir nova linha com informações copiadas
                $sql = "INSERT INTO usuarios2 (email, nome_sobrenome, telefone, cpf, data_nascimento, senha, cep, rua, bairro, cidade, tipo_usuario, data_cadastro, uf, numero, ip_local) VALUES 
                ('{$email}', '{$nome_sobrenome}', '{$telefone}', '{$cpf}', '{$data_nascimento}', '{$senha}', '{$cep}', '{$rua}', '{$bairro}', '{$cidade}','{$tipo_usuario}', NOW(), '{$uf}', '{$numero}', '{$ip}')";
                
                $profile = $mikrotik_api->comm("/ip/hotspot/user/add", array(
                  "name" => $cpf,
                  "password" => $senha,
                  "profile" => "default",
                ));
                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Validado com sucesso!');</script>";
                    //print "<script>location.href='login_cadastro.html';</script>"; 
                   print "<script>location.href='http://192.168.3.1/login_cadastro.html';</script>"; 
                } else {
                    echo "<script>alert('Erro ao recadastrar: ' . $conn->error);</script>";
                }
            
            } else {
                echo "<script>alert('Usuário não encontrado!');</script>";
                print "<script>location.href='?page=novo';</script>";
                return;
            }
            
            // Desconexão do Mikrotik e banco de dados
            $mikrotik_api->disconnect();
            mysqli_close($conn);   

            break;
         }

    // case "editar":
    //     $email = $_POST["email"];
    //     $nome_sobrenome = $_POST["nome_sobrenome"];
    //     $telefone = $_POST["telefone"];
    //     $cpf = $_POST["cpf"];
    //     $nome_login = $_POST["nome_login"];
    //     $senha = $_POST["senha"];

    //     //Aqui vou fazer a atualização do cadastro, puxando pelo ID (id=".$_REQUEST["id"];)
    //     $sql = "UPDATE usuarios SET  
    //             email= '{$email}',
    //             nome_sobrenome= '{$nome_sobrenome}',
    //             telefone = '{$telefone}',
    //             cpf= '{$cpf}',
    //             nome_login= '{$nome_login}',
    //             senha= '{$senha}'
    //         WHERE
    //             id=".$_REQUEST["id"];
                
    //     $res = $conn->query($sql);

    //         if ($res == true) {
    //             print "<script>alert('Edição salva com sucesso!');</script>";
    //             print "<script>location.href='?page=listar';</script>";
    //         } else {
    //         print "<script>alert('Não foi possivel salvar as alterações');</script>";
    //         print "<script>location.href='?page=listar';</script>";
    //     }          
    //     break; 

    // case "excluir":
        
    //     $sql = "DELETE FROM usuarios WHERE  id=".$_REQUEST["id"];
                
    //     $res = $conn->query($sql);

    //     if ($res == true) {
    //         print "<script>alert('Excluído com Sucesso!');</script>";
    //         print "<script>location.href='?page=listar';</script>";
    //     } else {
    //     print "<script>alert('Não foi possivel excluir');</script>";
    //     print "<script>location.href='?page=listar';</script>";
    // }      

    //     break;


class RouterosAPI
{
    var $debug     = false; //  Show debug information
    var $connected = false; //  Connection state
    var $port      = 8728;  //  Port to connect to (default 8729 for ssl)
    var $ssl       = false; //  Connect using SSL (must enable api-ssl in IP/Services)
    var $certless  = false; //  Set SSL SECLEVEL=0 to allow SSL with no certificates
    var $timeout   = 3;     //  Connection attempt timeout and data read timeout
    var $attempts  = 5;     //  Connection attempt count
    var $delay     = 3;     //  Delay between connection attempts in seconds

    var $socket;            //  Variable for storing socket resource
    var $error_no;          //  Variable for storing connection error number, if any
    var $error_str;         //  Variable for storing connection error text, if any

    /* Check, can be var used in foreach  */
    public function isIterable($var)
    {
        return $var !== null
                && (is_array($var)
                || $var instanceof Traversable
                || $var instanceof Iterator
                || $var instanceof IteratorAggregate
                );
    }

    /**
     * Print text for debug purposes
     *
     * @param string      $text       Text to print
     *
     * @return void
     */
    public function debug($text)
    {
        if ($this->debug) {
            echo $text . "\n";
        }
    }


    /**
     *
     *
     * @param string        $length
     *
     * @return void
     */
    public function encodeLength($length)
    {
        if ($length < 0x80) {
            $length = chr($length);
        } elseif ($length < 0x4000) {
            $length |= 0x8000;
            $length = chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
        } elseif ($length < 0x200000) {
            $length |= 0xC00000;
            $length = chr(($length >> 16) & 0xFF) . chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
        } elseif ($length < 0x10000000) {
            $length |= 0xE0000000;
            $length = chr(($length >> 24) & 0xFF) . chr(($length >> 16) & 0xFF) . chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
        } elseif ($length >= 0x10000000) {
            $length = chr(0xF0) . chr(($length >> 24) & 0xFF) . chr(($length >> 16) & 0xFF) . chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
        }

        return $length;
    }


    /**
     * Login to RouterOS
     *
     * @param string      $ip         Hostname (IP or domain) of the RouterOS server
     * @param string      $login      The RouterOS username
     * @param string      $password   The RouterOS password
     *
     * @return boolean                If we are connected or not
     */
    public function connect($ip, $login, $password)
    {
        for ($ATTEMPT = 1; $ATTEMPT <= $this->attempts; $ATTEMPT++) {
            $this->connected = false;
            $PROTOCOL = ($this->ssl ? 'ssl://' : '' );
            $CERTLESS = ($this->certless ? ':@SECLEVEL=0' : '' );
            $context = stream_context_create(array('ssl' => array('ciphers' => 'ADH:ALL' . $CERTLESS, 'verify_peer' => false, 'verify_peer_name' => false)));
            $this->debug('Connection attempt #' . $ATTEMPT . ' to ' . $PROTOCOL . $ip . ':' . $this->port . '...');
            $this->socket = @stream_socket_client($PROTOCOL . $ip.':'. $this->port, $this->error_no, $this->error_str, $this->timeout, STREAM_CLIENT_CONNECT,$context);
            if ($this->socket) {
                socket_set_timeout($this->socket, $this->timeout);
                $this->write('/login', false);
                $this->write('=name=' . $login, false);
                $this->write('=password=' . $password);
                $RESPONSE = $this->read(false);
                if (isset($RESPONSE[0])) {
                    if ($RESPONSE[0] == '!done') {
                        if (!isset($RESPONSE[1])) {
                            // Login method post-v6.43
                            $this->connected = true;
                            break;
                        } else {
                            // Login method pre-v6.43
                            $MATCHES = array();
                            if (preg_match_all('/[^=]+/i', $RESPONSE[1], $MATCHES)) {
                                if ($MATCHES[0][0] == 'ret' && strlen($MATCHES[0][1]) == 32) {
                                    $this->write('/login', false);
                                    $this->write('=name=' . $login, false);
                                    $this->write('=response=00' . md5(chr(0) . $password . pack('H*', $MATCHES[0][1])));
                                    $RESPONSE = $this->read(false);
                                    if (isset($RESPONSE[0]) && $RESPONSE[0] == '!done') {
                                        $this->connected = true;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
                fclose($this->socket);
            }
            sleep($this->delay);
        }

        if ($this->connected) {
            $this->debug('Connected...');
        } else {
            $this->debug('Error...');
        }
        return $this->connected;
    }


    /**
     * Disconnect from RouterOS
     *
     * @return void
     */
    public function disconnect()
    {
        // let's make sure this socket is still valid.  it may have been closed by something else
        if( is_resource($this->socket) ) {
            fclose($this->socket);
        }
        $this->connected = false;
        $this->debug('Disconnected...');
    }


    /**
     * Parse response from Router OS
     *
     * @param array       $response   Response data
     *
     * @return array                  Array with parsed data
     */
    public function parseResponse($response)
    {
        if (is_array($response)) {
            $PARSED      = array();
            $CURRENT     = null;
            $singlevalue = null;
            foreach ($response as $x) {
                if (in_array($x, array('!fatal','!re','!trap'))) {
                    if ($x == '!re') {
                        $CURRENT =& $PARSED[];
                    } else {
                        $CURRENT =& $PARSED[$x][];
                    }
                } elseif ($x != '!done') {
                    $MATCHES = array();
                    if (preg_match_all('/[^=]+/i', $x, $MATCHES)) {
                        if ($MATCHES[0][0] == 'ret') {
                            $singlevalue = $MATCHES[0][1];
                        }
                        $CURRENT[$MATCHES[0][0]] = (isset($MATCHES[0][1]) ? $MATCHES[0][1] : '');
                    }
                }
            }

            if (empty($PARSED) && !is_null($singlevalue)) {
                $PARSED = $singlevalue;
            }

            return $PARSED;
        } else {
            return array();
        }
    }


    /**
     * Parse response from Router OS
     *
     * @param array       $response   Response data
     *
     * @return array                  Array with parsed data
     */
    public function parseResponse4Smarty($response)
    {
        if (is_array($response)) {
            $PARSED      = array();
            $CURRENT     = null;
            $singlevalue = null;
            foreach ($response as $x) {
                if (in_array($x, array('!fatal','!re','!trap'))) {
                    if ($x == '!re') {
                        $CURRENT =& $PARSED[];
                    } else {
                        $CURRENT =& $PARSED[$x][];
                    }
                } elseif ($x != '!done') {
                    $MATCHES = array();
                    if (preg_match_all('/[^=]+/i', $x, $MATCHES)) {
                        if ($MATCHES[0][0] == 'ret') {
                            $singlevalue = $MATCHES[0][1];
                        }
                        $CURRENT[$MATCHES[0][0]] = (isset($MATCHES[0][1]) ? $MATCHES[0][1] : '');
                    }
                }
            }
            foreach ($PARSED as $key => $value) {
                $PARSED[$key] = $this->arrayChangeKeyName($value);
            }
            return $PARSED;
            if (empty($PARSED) && !is_null($singlevalue)) {
                $PARSED = $singlevalue;
            }
        } else {
            return array();
        }
    }


    /**
     * Change "-" and "/" from array key to "_"
     *
     * @param array       $array      Input array
     *
     * @return array                  Array with changed key names
     */
    public function arrayChangeKeyName(&$array)
    {
        if (is_array($array)) {
            foreach ($array as $k => $v) {
                $tmp = str_replace("-", "_", $k);
                $tmp = str_replace("/", "_", $tmp);
                if ($tmp) {
                    $array_new[$tmp] = $v;
                } else {
                    $array_new[$k] = $v;
                }
            }
            return $array_new;
        } else {
            return $array;
        }
    }


    /**
     * Read data from Router OS
     *
     * @param boolean     $parse      Parse the data? default: true
     *
     * @return array                  Array with parsed or unparsed data
     */
    public function read($parse = true)
    {
        $RESPONSE     = array();
        $receiveddone = false;
        while (true) {
            // Read the first byte of input which gives us some or all of the length
            // of the remaining reply.
            $BYTE   = ord(fread($this->socket, 1));
            $LENGTH = 0;
            // If the first bit is set then we need to remove the first four bits, shift left 8
            // and then read another byte in.
            // We repeat this for the second and third bits.
            // If the fourth bit is set, we need to remove anything left in the first byte
            // and then read in yet another byte.
            if ($BYTE & 128) {
                if (($BYTE & 192) == 128) {
                    $LENGTH = (($BYTE & 63) << 8) + ord(fread($this->socket, 1));
                } else {
                    if (($BYTE & 224) == 192) {
                        $LENGTH = (($BYTE & 31) << 8) + ord(fread($this->socket, 1));
                        $LENGTH = ($LENGTH << 8) + ord(fread($this->socket, 1));
                    } else {
                        if (($BYTE & 240) == 224) {
                            $LENGTH = (($BYTE & 15) << 8) + ord(fread($this->socket, 1));
                            $LENGTH = ($LENGTH << 8) + ord(fread($this->socket, 1));
                            $LENGTH = ($LENGTH << 8) + ord(fread($this->socket, 1));
                        } else {
                            $LENGTH = ord(fread($this->socket, 1));
                            $LENGTH = ($LENGTH << 8) + ord(fread($this->socket, 1));
                            $LENGTH = ($LENGTH << 8) + ord(fread($this->socket, 1));
                            $LENGTH = ($LENGTH << 8) + ord(fread($this->socket, 1));
                        }
                    }
                }
            } else {
                $LENGTH = $BYTE;
            }

            $_ = "";

            // If we have got more characters to read, read them in.
            if ($LENGTH > 0) {
                $_      = "";
                $retlen = 0;
                while ($retlen < $LENGTH) {
                    $toread = $LENGTH - $retlen;
                    $_ .= fread($this->socket, $toread);
                    $retlen = strlen($_);
                }
                $RESPONSE[] = $_;
                $this->debug('>>> [' . $retlen . '/' . $LENGTH . '] bytes read.');
            }

            // If we get a !done, make a note of it.
            if ($_ == "!done") {
                $receiveddone = true;
            }

            $STATUS = socket_get_status($this->socket);
            if ($LENGTH > 0) {
                $this->debug('>>> [' . $LENGTH . ', ' . $STATUS['unread_bytes'] . ']' . $_);
            }

            if ((!$this->connected && !$STATUS['unread_bytes']) || ($this->connected && !$STATUS['unread_bytes'] && $receiveddone) || $STATUS['timed_out']) {
                break;
            }
        }

        if ($parse) {
            $RESPONSE = $this->parseResponse($RESPONSE);
        }

        return $RESPONSE;
    }


    /**
     * Write (send) data to Router OS
     *
     * @param string      $command    A string with the command to send
     * @param mixed       $param2     If we set an integer, the command will send this data as a "tag"
     *                                If we set it to boolean true, the funcion will send the comand and finish
     *                                If we set it to boolean false, the funcion will send the comand and wait for next command
     *                                Default: true
     *
     * @return boolean                Return false if no command especified
     */
    public function write($command, $param2 = true)
    {
        if ($command) {
            $data = explode("\n", $command);
            foreach ($data as $com) {
                $com = trim($com);
                fwrite($this->socket, $this->encodeLength(strlen($com)) . $com);
                $this->debug('<<< [' . strlen($com) . '] ' . $com);
            }

            if (gettype($param2) == 'integer') {
                fwrite($this->socket, $this->encodeLength(strlen('.tag=' . $param2)) . '.tag=' . $param2 . chr(0));
                $this->debug('<<< [' . strlen('.tag=' . $param2) . '] .tag=' . $param2);
            } elseif (gettype($param2) == 'boolean') {
                fwrite($this->socket, ($param2 ? chr(0) : ''));
            }

            return true;
        } else {
            return false;
        }
    }


    /**
     * Write (send) data to Router OS
     *
     * @param string      $com        A string with the command to send
     * @param array       $arr        An array with arguments or queries
     *
     * @return array                  Array with parsed
     */
    public function comm($com, $arr = array())
    {
        $count = count($arr);
        $this->write($com, !$arr);
        $i = 0;
        if ($this->isIterable($arr)) {
            foreach ($arr as $k => $v) {
                switch ($k[0]) {
                    case "?":
                        $el = "$k=$v";
                        break;
                    case "~":
                        $el = "$k~$v";
                        break;
                    default:
                        $el = "=$k=$v";
                        break;
                }

                $last = ($i++ == $count - 1);
                $this->write($el, $last);
            }
        }

        return $this->read();
    }

    /**
     * Standard destructor
     *
     * @return void
     */
    public function __destruct()
    {
        $this->disconnect();
    }
}