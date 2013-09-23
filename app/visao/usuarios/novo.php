<title>Inserir novo usuário</title>
<!-- Início da página -->
<script src="publico/js/jquery/jquery.form.js"></script>
<script src="publico/js/ajaxForms.js"></script> 
<form class="table centered" id="ajaxForm" method="post" action="index.php?c=usuarios&a=verificarnovo">
    <fieldset>
        <legend>Informações sobre o usuário</legend>
        <p class="centered centeredText boldedText">Campos com <img src="publico/imagens/icones/campo_obrigatorio.png"> são obrigatórios</label>
        <div class="line">
            <label>Nome</label>
            <input required type="text" id="nome" class="input-xlarge" placeholder="Primeiro nome apenas" name="nome"   data-content="Apenas letras.">
        </div>
        <div class="line">
            <label>Sobrenome</label>
            <input required type="text" id="sobrenome" class="input-xlarge" placeholder="Demais nomes" name="sobrenome"  data-content="Apenas letras e espaços.">
        </div>
        <div class="line">
            <label>E-mail</label>
            <input required type="email" id="email" class="input-large" placeholder="email@dominio.com" name="email" data-content="O email será usado como login.">
        </div>
        <div class="line">
            <label>Data de nascimento</label>
            <input type="text" readonly id="dataNascimento" class=" input-large campoData" placeholder="Clique para escolher" name="dataNascimento" >
        </div>
        <div class="line">
            <label>Senha</label>
            <input required type="password"  name="senha" class="input-large" data-content="Quaisquer caracteres exceto 'espaço'.Mínimo de seis caracteres.">
        </div>

        <div class="line">
            <label>Confirmar Senha</label>
            <input required type="password" class="input-large" name="confsenha" >
        </div>

        <div class="line">
            <label>Papel</label>
            <?php echo $this->comboPapeis ?>
        </div>
        <br/>
        <fieldset>
            <legend>Permissões por ferramenta</legend>
            <?php echo $this->comboPermissoes ?>
        </fieldset>
    </fieldset>
    <input class="btn btn-large" type="reset" value="Limpar">
    <input class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit" value="Cadastrar">

</form>
<script>
    $(document).ready(function() {
        $("#dataNascimento").datepick();
        $(".line input").popover({trigger: 'focus', container: 'body'});
        varrerCampos();
        formularioAjax();
    });
</script>
