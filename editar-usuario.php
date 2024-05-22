<h1> Editar Usuário</h1>

<?php
 $sql = "SELECT * FROM usuarios2 WHERE id=".$_REQUEST["id"];
 $res = $conn ->query($sql);
 $row = $res ->fetch_object ();

?>

<form action="?page=salvar" method="POST">
    <input type="hidden" name="acao" value="editar">
    <input type="hidden" name="id" value="<?php  print $row->id; ?>">

    <div class="mb-3">
        <label>E-mail</label>
        <input type="email" name="email" value="<?php  print $row->email; ?>" class="form-control"> 
<!--  value=" php print $row->email que vai trazer no campo os dados atuais-->

    </div>
    <div class="mb-3">
        <label>Nome e Sobrenome</label>
        <input type="text" name="nome_sobrenome" value="<?php  print $row->nome_sobrenome; ?>" class="form-control">
    </div>
    <div class="mb-3">
        <label>Telefone</label>
        <input type="text" name="telefone" value="<?php  print $row->telefone; ?>" class="form-control">
    </div>
    <div class="mb-3">
        <label>CPF</label>
        <input type="text" name="cpf" value="<?php  print $row->cpf;  ?>" class="form-control">        
    </div>
    <div class="mb-3">
        <label>Nome de Login</label>
        <input type="text" name="nome_login" value="<?php  print $row->nome_login;  ?>" class="form-control">
    </div>
    <div class="mb-3">
        <label>Senha</label>
        <input type="text" name="senha" value="<?php  print $row->senha; ?>" class="form-control">
        <!-- aqui vamos exibir a senha para que possa ser editada, mudando o campo type de password para text --> 
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Enviar</button>
    </div> 
</form> 
