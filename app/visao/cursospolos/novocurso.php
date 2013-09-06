<title>Inserir novo curso</title>
<!-- Início da página -->
<script src="publico/js/jquery/jquery.form.js"></script>
<script src="publico/js/ajaxForms.js"></script> 

<form class="table centered" id="ajaxForm" method="post" action="index.php?c=cursospolos&a=verificarnovocurso">
    <fieldset>
        <legend>Inserir novo curso</legend>
        <span class="line">
            <label>Curso</label>
            <input required type="text" class="input-xlarge" id="nomecurso" name="nomecurso" />
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
    <input class="btn btn-large" type="reset" value="Limpar">
    <input class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit" value="Cadastrar">

</form>

<script src="publico/js/validarCampos.js"></script>
<script src="publico/js/cidades-estados.js"></script>
<script>
    $('[name=area]').val("<?php echo $this->area ?>");
//        $('#estado').change();
    $('[name=tipocurso]').val("<?php echo $this->tipocurso ?>");
</script>
