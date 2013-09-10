<title>Editar polo</title>
<!--Início da página-->
<form class="table centered" id="ajaxForm" method="post" action="index.php?c=cursospolos&a=verificaredicaopolo">
    <fieldset>
        <legend>Dados</legend>
        <p class="centered centeredText boldedText">Campos com <img src="publico/imagens/icones/campo_obrigatorio.png"> são obrigatórios</label>
            <br/>
            <input hidden="true" readonly="true" type="text" class="input-small" id="poloID" name="poloID" value="<?php echo $this->poloID ?>" />

            <span class="line">
                <label>Polo</label>
                <input required type="text" class="input-xlarge" id="nomepolo" name="nomepolo" value="<?php echo $this->polo ?>" />
            </span>
            <span class="line">
                <label>Estado</label>
                <select required class="input-large" id="estado" name="estado"></select>
            </span>
            <span class="line">
                <label>Cidade</label>
                <select required class="input-xlarge" id="cidade" name="cidade"></select>
            </span>

    </fieldset>
    <input disabled class=" btn btn-primary btn-right" type="submit" disabled value="Atualizar dados">

</form>

<script src="publico/js/cidades-estados.js"></script>
<script>
    $(document).ready(function() {
        varrerCampos();
        formularioAjax();
        new dgCidadesEstados({
            cidade: $('#cidade').get(0),
            estado: $('#estado').get(0)
        });

        $('#estado').val("<?php echo $this->estado ?>");
        $('#estado').change();
        $('#cidade').val("<?php echo $this->cidade ?>");
    });
</script>
