import ros_api
import pymysql
import time
from time import sleep
from datetime import datetime

# Configuração da API Mikrotik
api_host = "192.168.99.4"
api_username = "api_hotspot"
api_password = "Cmc1303!"

# Configuração do banco de dados
db_host = "45.6.167.108"
db_user = "cadastromikrotik"
db_password = "Cmc1303!"
db_database = "cadastro_cultura2S"
db_table = "users_active2"

# Conexão com a API Mikrotik
router = ros_api.Api(api_host, user=api_username, password=api_password)

# Loop infinito para atualização a cada 1 minuto
while True:
    # Obter os clientes ativos
    clientes_ativos = router.talk("/ip/hotspot/active/print")
    # Conexão ao banco de dados
    conexao = pymysql.connect(
        host=db_host,
        user=db_user,
        password=db_password,
        database=db_database,
    )

    # Cursor para executar comandos SQL
    cursor = conexao.cursor()
    
    # Converte o timestamp antes de imprimir
    def converter_timestamp(timestamp):
        # Converte o timestamp para um objeto datetime
        data_hora = datetime.fromtimestamp(timestamp)

        # Formata a data e hora de acordo com o formato desejado
        return data_hora.strftime("%Y-%m-%d %H:%M:%S")

    timestamp_chamada = time.time()

# Mensagens para exibir no log
    mensagem_log1= f"|| CULTURA {converter_timestamp(timestamp_chamada)}|| FLUSH HOSTS EXECUTADO"
    mensagem_log2= f"|| CULTURA {converter_timestamp(timestamp_chamada)}|| LIMPEZA DE DADOS EXECUTADO"
    mensagem_log3= f"|| CULTURA {converter_timestamp(timestamp_chamada)}|| ATUALIZADO"

    # Executa flush hosts para não sobrecarregar de solicitações e deleta dados da tabela antes de inserir novos
    cursor.execute("FLUSH HOSTS")
    print(mensagem_log1)    
    cursor.execute(f"DELETE FROM {db_table}")
    print(mensagem_log2)

    # Loop para inserir os dados de cada cliente
    for cliente in clientes_ativos:
        # Comando SQL para inserir o cliente
        sql_insert = """
        INSERT INTO {} (id, server, user, address, mac_address, login_by, uptime, session_time_left, idle_time, keepalive_timeout, bytes_in, bytes_out, packets_in, packets_out, radius, data)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, NOW())
        """.format(db_table)

        # Parâmetros do comando SQL
        parametros = (
            cliente[".id"],
            cliente["server"],
            cliente["user"],
            cliente["address"],
            cliente["mac-address"],
            cliente["login-by"],
            cliente["uptime"],
            cliente["session-time-left"],
            cliente["idle-time"],
            cliente["keepalive-timeout"],
            cliente["bytes-in"],
            cliente["bytes-out"],
            cliente["packets-in"],
            cliente["packets-out"],
            cliente["radius"],
        )

        # Execução do comando SQL
        cursor.execute(sql_insert, parametros)

    # Commit das alterações no banco de dados
    conexao.commit()

    # Fechamento do cursor e da conexão
    cursor.close()
    conexao.close()

    print(mensagem_log3)

    # Aguarda 1 minuto antes da próxima atualização
    sleep(60)