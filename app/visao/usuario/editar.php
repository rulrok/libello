
<!--Início da página-->
<script src = "publico/js/jquery.form.js"></script>
<script src="publico/js/ajaxForms.js"></script> 

<form class="table centered" id="ajaxForm" method="post" action="index.php?c=usuario&a=gerenciarconta">
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
            <input type="text" name="email" value="<? echo $this->email ?>">
        </div>
        <div class="line">
            <label>Data de nascimento</label>
            <input type="text" readonly id="dataNascimento" class="campoData" name="dataNascimento" value="<? echo $this->dataNascimento ?>" >
        </div>
        <!--        <div class="line">
                    <label>Papel no sistema</label>
                    <input id="papel" type="text" name="papel" disabled value="<? echo $this->papel ?>">
                </div>-->

    </fieldset>
    <input class=" btn btn-primary btn-right" type="submit" disabled value="Atualizar dados">

</form>


<script type="text/javascript" src="publico/js/validarCampos.js"></script>


<script>
    $(function() {
        $("#dataNascimento").datepick();
    });
</script>

