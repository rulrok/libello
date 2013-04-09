<?php if (isset($this->mensagem_usuario) && $this->mensagem_usuario !== null) : ?>
    <script>
        showPopUp(
    <?php echo "\"" . $this->mensagem_usuario . "\""; ?>
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
            <p class="centered centeredText boldedText">Campos com <img src="publico/images/icons/campo_obrigatorio.png"> são obrigatórios</p>
            <div class="line">
                <p>Nome</p>
                <input required type="text" id="nome" class="campoObrigatorio" name="nome" value="<? echo $this->nome ?>"  style="width: 265px">
            </div>
            <div class="line">
                <p>Sobrenome</p>
                <input required type="text" id="sobrenome" class="campoObrigatorio" name="sobrenome" value="<? echo $this->sobrenome ?>" style="width: 265px">
            </div>
            <div class="line">
                <p>E-mail</p>
                <input type="text" id="email" name="email" value="<? echo $this->email ?>" style="width: 265px">
            </div>
            <div class="line">
                <p>Data de nascimento</p>
                <input type="text" readonly id="dataNascimento" class="campoData" name="dataNascimento" value="<? echo $this->dataNascimento ?>" style="width: 265px">
            </div>
            <div class="line">
                <p>Login</p>
                <input required type="text" class="campoObrigatorio" name="login" value="<? echo $this->login ?>">
            </div>

            <div class="line">
                <p>Senha</p>
                <input required type="password" class="campoObrigatorio" name="senha" style="width: 100px">
            </div>

            <div class="line">
                <p>Confirmar Senha</p>
                <input required type="password" class="campoObrigatorio" name="confsenha" style="width: 100px">
            </div>

            <div class="line">
                <p>Papel</p>
                <select name="papel" class="campoObrigatorio">
                    <option value="default" selected="selected"> -- Selecione uma opção --</option>
                    <option value="0">Administrador </option>
                    <option value="1">Gestor </option>
                    <option value="2">Professor </option>
                    <option value="3">Coordenador </option>
                    <option value="4">Estudante </option>
                </select>
            </div>
            <br/>
            <fieldset>
                <legend>Permissões por ferramenta</legend>
                <?php echo $this->comboPermissoes ?>
            </fieldset>
        </fieldset>
        <input disabled id="submit" type="submit" value="Cadastrar">
        <input type="reset" value="Limpar">
    </form>
    <script type="text/javascript" src="publico/js/validarCampos.js"></script>


    <script>
        $(function() {
            $("#dataNascimento").datepick();
        });
    </script>
<?php
endif;
?>