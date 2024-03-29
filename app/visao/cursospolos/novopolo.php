<title>Inserir novo polo</title>
<!-- Início da página -->
<form class="tabela centralizado" id="ajaxForm" method="post" action="index.php?c=cursospolos&a=verificarnovopolo">
    <fieldset>
        <legend>Inserir novo polo</legend>
        <span class="line">
            <label for="nomepolo">Nome</label>
            <input required autofocus type="text" class="input-xlarge" id="nomepolo" name="nomepolo" />
        </span>
        <span class="line">
            <label for="estado">Estado</label>
            <select required class="input-large" id="estado" name="estado" data-placeholder="Selecione um estado"></select>
        </span>
        <span class="line">
            <label for="cidade">Cidade</label>
            <select required class="input-xlarge" id="cidade" name="cidade" data-placeholder="Seleciona uma cidade"></select>
        </span>
    </fieldset>
    <input class="btn btn-large" type="reset" value="Limpar" onclick="$('#estado').val(0);
            liberarCadastro();">
    <button class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit">Cadastrar</button>
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
            $("#estado").chosen({allow_single_deselect: true});
            $("#cidade").chosen();

            $("input[type=reset]").bind("click", function() {
                $("#estado").val('').trigger("chosen:updated");
                $("#cidade").empty().trigger("chosen:updated");
                liberarCadastro();
            });
        });

        $('#estado').change(function() {
            setTimeout(function() {

                $("#cidade").val('').trigger("chosen:updated");
                liberarCadastro();
            }, "200");
        });
</script>