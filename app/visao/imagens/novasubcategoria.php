<title>Inserir nova subsubcategoria</title>
<!-- Início da página -->
<form class="table centered" id="ajaxForm" method="post" action="index.php?c=imagens&a=verificarnovasubcategoria">
    <fieldset>
        <legend>Inserir nova subcategoria</legend>
        <span class="line">
            <label for="categoriapai">Categoria pai</label>
            <?php echo $this->comboBoxCategoriaPai; ?>
        </span>
        <span class="line">
            <label for="subcategoria">Nome da subcategoria</label>
            <input required type="text" class="input-xlarge" id="subcategoria" name="subcategoria" />
        </span>
    </fieldset>
    <button class="btn btn-large" type="reset">Limpar</button>
    <button class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit">Cadastrar</button>

</form>

<script>
    $(document).ready(function() {
        varrerCampos();
        formularioAjax();
        $("#categoriapai").chosen({display_disabled_options: false, display_selected_options: true, inherit_select_classes: true, placeholder_text_multiple: "Selecione a categoria pai", width: "450px"});
    });
</script>
