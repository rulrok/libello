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
            <p class="centered centeredText boldedText">Campos com <img src="publico/images/icons/campo_obrigatorio.png"> são obrigatórios</label>
            <div class="line">
                <label>Nome</label>
                <input required type="text" id="nome" class="campoObrigatorio" placeholder="Primeiro nome apenas" name="nome" value="<? echo $this->nome ?>"  data-content="Apenas letras.">
            </div>
            <div class="line">
                <label>Sobrenome</label>
                <input required type="text" id="sobrenome" class="campoObrigatorio" placeholder="Demais nomes" name="sobrenome" value="<? echo $this->sobrenome ?>"  data-content="Apenas letras e espaços.">
            </div>
            <div class="line">
                <label>E-mail</label>
                <input required type="text" id="email" class="campoObrigatorio" placeholder="email@dominio.com" name="email" value="<? echo $this->email ?>">
            </div>
            <div class="line">
                <label>Data de nascimento</label>
                <input type="text" readonly id="dataNascimento" class="campoData" placeholder="Clique para escolher" name="dataNascimento" value="<? echo $this->dataNascimento ?>">
            </div>
            <div class="line">
                <label>Login</label>
                <input required type="text" class="campoObrigatorio" name="login" value="<? echo $this->login ?>"  data-content="Apenas letras minúsculas. Mínimo de três caracteres.">
            </div>

            <div class="line">
                <label>Senha</label>
                <input required type="password" class="campoObrigatorio" name="senha"  data-content="Quaisquer caracteres exceto 'espaço'.Mínimo de seis caracteres.">
            </div>

            <div class="line">
                <label>Confirmar Senha</label>
                <input required type="password" class="campoObrigatorio" name="confsenha" >
            </div>

            <div class="line">
                <label>Papel</label>
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
            <input class="btn btn-large" type="reset" value="Limpar">
            <input class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit" value="Cadastrar">
        
    </form>
    <script type="text/javascript" src="publico/js/validarCampos.js"></script>


    <script>
        $(function() {
            $("#dataNascimento").datepick();
        });


        $(".line input").popover({trigger:'focus',container:'body'});

    </script>
<?php
endif;
?>