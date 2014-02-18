<title>Inserir novo curso</title>
<!-- Início da página -->
<form class="table centered" id="ajaxForm" method="post" action="index.php?c=cursospolos&a=verificarnovocurso">
    <fieldset>
        <legend>Inserir novo curso</legend>
        <span class="line">
            <label>Curso</label>
            <input required autofocus type="text" class="input-xlarge" id="nomecurso" name="nomecurso" />
        </span>
        <span class="line">
            <label>Área</label>
            <?php echo $this->comboArea ?>
        </span>
        <span class="line">
            <label>Tipo</label>
            <?php echo $this->comboTipoCurso ?>
        </span>
    </fieldset>
    <button class="btn btn-large" type="reset">Limpar</button>
    <button class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit">Cadastrar</button>

</form>

<script src="publico/js/cidades-estados.js"></script>
<script>
    $(document).ready(function() {
        varrerCampos();
        formularioAjax();
    });
</script>
