<?php if (isset($this->mensagem_usuario) && $this->mensagem_usuario !== null) : ?>
    <script>
        showPopUp(
    <?php echo "\"" . $this->mensagem_usuario . "\""; ?>
        ,<?php echo "\"" . $this->tipo_mensagem . "\"" ?>
        );
    </script>
    <?php
    unset($this->mensagem_usuario);
endif;
if ($_SERVER['REQUEST_METHOD'] == 'POST') :
    $controlador = new ControladorUsuario();
    $controlador->acaoVerificarNovo();
else:
    ?>
    <!--Início da página -->
    <script src="publico/js/jquery.form.js"></script>
    <script src="publico/js/ajaxForms.js"></script> 
    <form class="table centered" id="ajaxForm" method="post" action="index.php?c=usuario&a=novo">
        <fieldset>
            <legend>Informações sobre o usuário</legend>
            <p class="centered centeredText boldedText">Campos com <img src="publico/imagens/icones/campo_obrigatorio.png"> são obrigatórios</label>
            <div class="line">
                <label>Nome</label>
                <input required type="text" id="nome" class="input-xlarge" placeholder="Primeiro nome apenas" name="nome" value="<?php echo $this->nome ?>"  data-content="Apenas letras.">
            </div>
            <div class="line">
                <label>Sobrenome</label>
                <input required type="text" id="sobrenome" class="input-xlarge" placeholder="Demais nomes" name="sobrenome" value="<?php echo $this->sobrenome ?>"  data-content="Apenas letras e espaços.">
            </div>
            <div class="line">
                <label>E-mail</label>
                <input required type="text" id="email" class="input-large" placeholder="email@dominio.com" name="email" value="<?php echo $this->email ?>" data-content="O email será usado como login.">
            </div>
            <div class="line">
                <label>Data de nascimento</label>
                <input type="text" readonly id="dataNascimento" class=" input-large campoData" placeholder="Clique para escolher" name="dataNascimento" value="<?php echo $this->dataNascimento ?>">
            </div>
            <!--            <div class="line">
                            <label>Login</label>
                            <input required type="text"  name="login" class="input-large" value="<?php echo $this->login ?>"  data-content="Apenas letras minúsculas. Mínimo de três caracteres.">
                        </div>-->

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
    <script type="text/javascript" src="publico/js/validarCampos.js"></script>


    <script>
        $(function() {
            $("#dataNascimento").datepick();
        });


        $(".line input").popover({trigger: 'focus', container: 'body'});

    </script>
<?php
endif;
?>