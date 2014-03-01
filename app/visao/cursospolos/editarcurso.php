<title>Editar curso</title>
<!--Início da página-->
<form class="tabela centralizado" id="ajaxForm2" method="post" action="index.php?c=cursospolos&a=verificaredicaocurso">
    <fieldset>
        <legend>Dados</legend>
        <p class="centralizado textoCentralizado textoNegrito">Campos com <img src="publico/imagens/icones/campo_obrigatorio.png" alt="Campo obrigatório"> são obrigatórios</p>
        <br/>
        <input hidden="true" readonly="true" type="text" class="input-small" id="cursoID" name="cursoID" value="<?php echo $this->cursoID ?>" />

        <span class="line">
            <label>Curso</label>
            <input required autofocus type="text" class="input-xlarge" id="nomecurso" name="nomecurso" value="<?php echo $this->curso ?>" />
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
    <button disabled class=" btn btn-primary btn-right" type="submit" >Atualizar Dados</button>
    <button class=" btn btn-left" type="button" onclick="history.back();">Voltar</button>

</form>

<script>
    $(document).ready(function() {
        varrerCampos();
        formularioAjax();
        $('[name=area]').val("<?php echo $this->idArea ?>");
        $('[name=tipocurso]').val("<?php echo $this->idTipoCurso ?>");
    });

</script>