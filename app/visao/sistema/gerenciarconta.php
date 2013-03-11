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
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SERVER['REQUEST_METHOD'] = null;

    $nome = $_POST['nome'];
    echo $nome;
    exit;
}
?>
<script>
    $('form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            cache: false,
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                $(".contentWrap").empty().append(data);
            }
        });

    });
</script>
<p class="centered centeredText">Campos com <img src="publico/images/icons/importante.png"> são obrigatórios</p>
<form class="table centered" method="post" action="index.php?c=sistema&a=gerenciarconta">
    <fieldset>
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
                <input type="password">
            </span>
            <span class="line">
                <p>Confirmar senha</p>
                <input type="password">
            </span>
        </fieldset>
        <hr>
        <span class="line">
            <p>Senha atual</p>
            <input class="campoObrigatorio" type="password">
        </span>
    </fieldset>
    <input type="submit" value="Atualizar dados">
</form>
