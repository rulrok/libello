<title>Editar subcategoria</title>
<!--Início da página-->
<form class="table centered" id="ajaxForm" method="post" action="index.php?c=imagens&a=verificaredicaosubcategoria">
    <fieldset>
        <legend>Dados</legend>
        <p class="centered centeredText boldedText">Campos com <img src="publico/imagens/icones/campo_obrigatorio.png"> são obrigatórios</p>
            <br/>
            <input hidden="true" readonly="true" type="text" class="input-small" id="subcategoriaID" name="subcategoriaID" value="<?php echo $this->subcategoriaID ?>" />
            <input hidden="true" readonly="true" type="text" class="input-small" id="categoriapaiID" name="categoriapaiID" value="<?php echo $this->categoriapaiID ?>" />

            <span class="line">
                <label for="subcategoria">Nome</label>
                <input required autofocus type="text" class="input-xlarge" id="subcategoria" name="subcategoria" value="<?php echo $this->subcategoria ?>" />
            </span>
            <span class="line">
                <label for="categoriapai">Categoria Pai</label>
                <?php echo $this->comboBoxCategoriaPai; ?>
            </span>
    </fieldset>
    <button class=" btn btn-left" type="button" onclick="history.back();">Voltar</button>
    <button disabled class=" btn btn-primary btn-right" type="submit" >Atualizar Dados</button>

</form>

<script>
    $(document).ready(function() {
        varrerCampos();
        formularioAjax();
        $('[name=categoriapai]').val("<?php echo $this->categoriapaiID ?>");
    });

</script>