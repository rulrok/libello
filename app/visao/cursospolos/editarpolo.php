<title>Editar polo</title>
<!--Início da página-->
<form class="tabela centralizado" id="ajaxForm" method="post" action="index.php?c=cursospolos&a=verificaredicaopolo">
    <fieldset>
        <legend>Dados</legend>
            <br/>
            <input hidden="true" readonly="true" type="text" class="input-small" id="poloID" name="poloID" value="<?php echo $this->poloID ?>" />

            <span class="line">
                <label for="polo">Polo</label>
                <input required autofocus type="text" class="input-xlarge" id="nomepolo" id="polo" name="nomepolo" value="<?php echo $this->polo ?>" />
            </span>
            <span class="line">
                <label for="estado">Estado</label>
                <select required class="input-large" id="estado" name="estado"></select>
            </span>
            <span class="line">
                <label for="cidade">Cidade</label>
                <select required class="input-xlarge" id="cidade" name="cidade"></select>
            </span>

    </fieldset>
    <button class=" btn btn-left" type="button" onclick="history.back();">Voltar</button>
    <button disabled class=" btn btn-primary btn-right" type="submit" >Atualizar dados</button>

</form>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<script src="publico/js/cidades-estados.js"></script>
<script>
        $(document).ready(function() {
            var flag = true;
            varrerCampos();
            formularioAjax();
            new dgCidadesEstados({
                cidade: $('#cidade').get(0),
                estado: $('#estado').get(0)
            });
            $("#cidade").chosen();

            $('#estado').val("<?php echo $this->estadoViagem ?>");
            $('#estado').change();
            $("#estado").chosen();
            $('#estado').change(function() {
                setTimeout(function() {
                    if (!flag) {
                        $("#cidade").val('').trigger("chosen:updated");
                    }
                }, "200");
            });
            $('#cidade').val("<?php echo $this->cidade ?>").trigger("chosen:updated");
            flag = false;
        });
</script>
