<title>Editar curso</title>
<!--Início da página-->
<form class="tabela centralizado" id="ajaxForm2" method="post" action="index.php?c=cursospolos&a=verificaredicaocurso">
    <fieldset>
        <legend>Dados</legend>
        <br/>
        <input hidden="true" readonly="true" type="text" class="input-small" id="cursoID" name="cursoID" value="<?php echo $this->cursoID ?>" />

        <span class="line">
            <label for="nomecurso">Curso</label>
            <input required autofocus type="text" class="input-xlarge" id="nomecurso" value="<?php echo $this->curso ?>" name="nomecurso"  data-content="Não aceita números, use letras para representar algarismos romanos. " />
        </span>
        <span class="line">
            <label for="area">Área</label>
            <select id="area" name="area">
                <?php echo $this->comboArea ?>
            </select>
        </span>
        <span class="line">
            <label for="tipocurso">Tipo</label>
            <select id="tipocurso" name="tipocurso">
                <?php echo $this->comboTipoCurso ?>
            </select>
        </span>

    </fieldset>
    <button disabled class=" btn btn-primary btn-right" type="submit" >Atualizar Dados</button>
    <button class=" btn btn-left" type="button" onclick="history.back();">Voltar</button>

</form>

<script>
    var elem = $("#chars");
    $(".line input").popover({trigger: 'focus', container: 'body'});

    $(document).ready(function() {
        varrerCampos();
        formularioAjax();
        $('[name=area]').val("<?php echo $this->idArea ?>");
        $('[name=tipocurso]').val("<?php echo $this->idTipoCurso ?>");
    });

</script>