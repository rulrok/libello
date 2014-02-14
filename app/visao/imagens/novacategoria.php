<title>Inserir nova categoria</title>
<!-- Início da página -->
<form class="table centered" id="ajaxForm" method="post" action="index.php?c=imagens&a=verificarnovacategoria">
    <fieldset>
        <legend>Inserir nova categoria</legend>
        <span class="line">
            <label for="categoria">Nome da categoria</label>
            <input required type="text" class="input-xlarge" id="categoria" name="categoria" />
        </span>
<!--        <span class="line">
            <label>Área</label>
        <?php // echo $this->comboArea; ?>
        </span>-->
<!--        <span class="line">
            <label>Tipo</label>
        <?php // echo $this->comboTipoCurso; ?>
        </span>-->
    </fieldset>
    <button class="btn btn-large" type="reset">Limpar</button>
    <button class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit">Cadastrar</button>

</form>

<script>
    $(document).ready(function() {
        varrerCampos();
        formularioAjax();
    });
</script>
