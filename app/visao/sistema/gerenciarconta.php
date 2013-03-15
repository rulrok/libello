<!--<div class="popup" style="
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #000;
    z-index: 9999;
    opacity: 0.6;
">
    <p class="centered" style="position:absolute;">daskldalsjdlasjdlkasjdklj</p>
</div>
-->
<form class="table centered" method="post" action="index.php?c=sistema&a=gerenciarconta">
    <fieldset>
        <p class="centered centeredText boldedText">Campos com <img src="publico/images/icons/campo_obrigatorio.png"> são obrigatórios</p>
        <legend>Dados</legend>
        <span class="line">
            <p>Nome</p>
            <input name="nome" class="campoObrigatorio" type="text" value="<? echo $this->nome ?>">
        </span>
        <span class="line">
            <p>Sobrenome</p>
            <input name="sobrenome" class="campoObrigatorio" type="text" value="<? echo $this->sobrenome ?>">
        </span>
        <span class="line">
            <p>email</p>
            <input type="text" value="<? echo $this->email ?>">
        </span>
        <span class="line">
            <p>login</p>
            <input type="text" disabled="true" value="<? echo $this->login ?>">
        </span>
        <span class="line">
            <p>Papel no sistema</p>
            <input type="text" disabled="true" value="<? echo $this->papel ?>">
        </span>
        <br/>
        <fieldset>
            <legend>Atualizar senha (opcional) </legend>
            <span class="line">
                <p>Nova senha</p>
                <input onblur="querMudarSenha()" name="senha" type="password">
            </span>
            <span class="line">
                <p>Confirmar senha</p>
                <input onblur="querMudarSenha()" name="confsenha" type="password">
            </span>
        </fieldset>
        <hr>
        <span class="line">
            <p>Senha atual</p>
            <input name="senhaAtual" class="campoObrigatorio" type="password">
        </span>
    </fieldset>
    <input type="submit" disabled="true" value="Atualizar dados">
</form>
