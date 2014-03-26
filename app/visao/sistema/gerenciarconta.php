<title>Gerenciar própria conta</title>
<!-- Início da página -->
<form class="tabela centralizado" id="ajaxForm" method="post" action="index.php?c=sistema&a=validaralteracoesconta">
    <fieldset>
        <legend>Dados</legend>
        <div class="line">
            <label for="nome">Nome</label>
            <input required autofocus id="nome" name="nome"  type="text" value="<?php echo $this->nome ?>"/>
        </div>
        <div class="line">
            <label for="sobrenome">Sobrenome</label>
            <input required id="sobrenome" name="sobrenome"  type="text" value="<?php echo $this->sobrenome ?>"/>
        </div>
        <div class="line">
            <label for="email">email</label>
            <input required disabled type="text" id="email" name="email" value="<?php echo $this->email ?>"/>
        </div>
        <div class="line">
            <label for="dataNascimento">Data de nascimento</label>
            <input type="text" id="dataNascimento" class="campoData" name="dataNascimento" value="<?php echo $this->dataNascimento ?>" />
        </div>
        <div class="line">
            <label for="papel">Papel no sistema</label>
            <input id="papel" type="text" name="papel" disabled value="<?php echo $this->papel ?>"/>
        </div>
        <br/>
        <fieldset>
            <legend>Atualizar senha (opcional)</legend>
            <div class="line">
            <label for="senhaAtual">Senha atual</label>
            <input required id="senhaAtual" name="senhaAtual"  type="password"/>
            </div>
            <div class="line">
                <label for="senha">Nova senha</label>
                <input onblur="querMudarSenha()" id="senha" name="senha" type="password"/>
            </div>
            <div class="line">
                <label for="confSenha">Confirmar senha</label>
                <input onblur="querMudarSenha()" id="confSenha" name="confSenha" type="password"/>
            </div>
        </fieldset>
        <hr>
    </fieldset>

    <button class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit">Atualizar</button>

</form>

<script>
    $(document).ready(function() {
        varrerCampos();
        formularioAjax({
            idFormulario: "ajaxForm"
            , resetarFormulario: false
            , alwaysFn: function() {
                $("#senhaAtual").val('');
            }
            , completeFn: function() {
                $("#nomeusuarioHeader").empty();
                $("#nomeusuarioHeader").html($("#nome").val());
            }
        });
        $("#dataNascimento").datepicker();
    });
</script>