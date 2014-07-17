<title>Inserir novo curso</title>
<!-- Início da página -->
<form class="tabela centralizado" id="ajaxForm" method="post" action="index.php?c=cursospolos&a=verificarnovocurso">
    <fieldset>
        <legend>Inserir novo curso</legend>
        <span class="line">
            <label for="nomecurso">Curso</label>
            <input required autofocus type="text" class="input-xlarge" id="nomecurso" name="nomecurso" data-content="Não aceita números, use letras para representar algarismos romanos. " />
        </span>
        <span class="line">
            <label for="area">Área</label>
            <select required class="input-large" id="area" name="area">
                <?php echo $this->comboArea ?>
            </select>
        </span>
        <span class="line">
            <label for="tipocurso">Tipo</label>
            <select required class="input-large" id="tipocurso" name="tipocurso">
                <?php echo $this->comboTipoCurso ?>
            </select>
        </span>
    </fieldset>
    <button class="btn btn-large" type="reset">Limpar</button>
    <button class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit">Cadastrar</button>

</form>

<script src="publico/js/cidades-estados.js"></script>
<script>
    var elem = $("#chars");
    $(".line input").popover({trigger: 'focus', container: 'body' });
    
    $(document).ready(function() {
        varrerCampos();
        formularioAjax();

        $("button[type=reset]").bind("click", function() {
            setTimeout(liberarCadastro,200);
        });
    });
</script>
