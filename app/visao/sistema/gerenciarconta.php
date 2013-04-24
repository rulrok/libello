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
    $controlador = new ControladorSistema();
    $controlador->acaoValidarAlteracoesConta();
else:
    ?>
    <!--Início da página -->
    <script src="publico/js/jquery.form.js"></script>
    <script src="publico/js/ajaxForms.js"></script> 
    <form class="table centered" id="ajaxForm" method="post" action="index.php?c=sistema&a=gerenciarconta">
        <fieldset>
            <legend>Dados</legend>
            <p class="centered centeredText boldedText">Campos com <img src="publico/images/icons/campo_obrigatorio.png"> são obrigatórios</label>
            <div class="line">
                <label>Nome</label>
                <input required name="nome" class="campoObrigatorio" type="text" value="<? echo $this->nome ?>">
            </div>
            <div class="line">
                <label>Sobrenome</label>
                <input required name="sobrenome" class="campoObrigatorio" type="text" value="<? echo $this->sobrenome ?>">
            </div>
            <div class="line">
                <label>email</label>
                <input required type="text" class="campoObrigatorio" name="email" value="<? echo $this->email ?>">
            </div>
            <div class="line">
                <label>Data de nascimento</label>
                <input type="text" readonly id="dataNascimento" class="campoData" name="dataNascimento" value="<? echo $this->dataNascimento ?>" >
            </div>
            <div class="line">
                <label>login</label>
                <input id="login" type="text" name="login" disabled value="<? echo $this->login ?>">
            </div>
            <div class="line">
                <label>Papel no sistema</label>
                <input id="papel" type="text" name="papel" disabled value="<? echo $this->papel ?>">
            </div>
            <br/>
            <fieldset>
                <legend>Atualizar senha (opcional) </legend>
                <div class="line">
                    <label>Nova senha</label>
                    <input onblur="querMudarSenha()" name="senha" type="password">
                </div>
                <div class="line">
                    <label>Confirmar senha</label>
                    <input onblur="querMudarSenha()" name="confSenha" type="password">
                </div>
            </fieldset>
            <hr>
            <div class="line">
                <label>Senha atual</label>
                <input required name="senhaAtual" class="campoObrigatorio" type="password">
            </div>
        </fieldset>
        
            <input class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit" value="Atualizar">
        
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