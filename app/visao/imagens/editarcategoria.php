<title>Editar categoria</title>
<!--Início da página-->
<form class="table centered" id="ajaxForm" method="post" action="index.php?c=imagens&a=verificaredicaocategoria">
    <fieldset>
        <legend>Dados</legend>
        <p class="centered centeredText boldedText">Campos com <img src="publico/imagens/icones/campo_obrigatorio.png"> são obrigatórios</p>
            <br/>
            <input hidden="true" readonly="true" type="text" class="input-small" id="categoriaID" name="categoriaID" value="<?php echo $this->categoriaID ?>" />

            <span class="line">
                <label>Nome</label>
                <input required type="text" class="input-xlarge" id="categoria" name="categoria" value="<?php echo $this->categoria ?>" />
            </span>
    </fieldset>
    <button class=" btn btn-left" type="button" onclick="history.back();">Voltar</button>
    <button disabled class=" btn btn-primary btn-right" type="submit" >Atualizar Dados</button>

</form>

<script>
    $(document).ready(function() {
        varrerCampos();
        formularioAjax();
    });

</script>