<title>Editar curso</title>
<!--Início da página-->
<script src = "publico/js/jquery/jquery.form.js"></script>
<script src="publico/js/ajaxForms.js"></script> 

<form class="table centered" id="ajaxForm" method="post" action="index.php?c=cursospolos&a=verificaredicaocurso">
    <fieldset>
        <legend>Dados</legend>
        <p class="centered centeredText boldedText">Campos com <img src="publico/imagens/icones/campo_obrigatorio.png"> são obrigatórios</label>
            <br/>
            <input hidden="true" readonly="true" type="text" class="input-small" id="cursoID" name="cursoID" value="<?php echo $this->cursoID ?>" />

            <span class="line">
                <label>Curso</label>
                <input required type="text" class="input-xlarge" id="nomecurso" name="nomecurso" value="<?php echo $this->curso ?>" />
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
    <input disabled class=" btn btn-primary btn-right" type="submit" disabled value="Atualizar dados">

</form>


<script type="text/javascript" src="publico/js/validarCampos.js"></script>


<script>

    $('[name=area]').val("<?php echo $this->idArea ?>");
    $('[name=tipocurso]').val("<?php echo $this->idTipoCurso ?>");

</script>