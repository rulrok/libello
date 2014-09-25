<title>Registrar retorno de livro</title>
<!--Início da página-->
<form class="tabela centralizado" id="ajaxForm" method="post" action="index.php?c=livros&a=registrarretorno">
    <fieldset>
        <legend>Retorno de livro</legend>
        <input hidden="true" readonly="true" type="text" class="input-small" id="saidaID" name="saidaID" value="<?php echo $this->saidaID ?>" />
        <input hidden="true" readonly="true" type="text" class="input-small" id="livroID" name="livroID" value="<?php echo $this->livroID ?>" />
        <input hidden="true" readonly="true" type="text" class="input-small" id="quantidadeMaxima" name="quantidadeMaxima" value="<?php echo $this->quantidadeMaxima ?>" />
        <div class="line">
            <label for="livro">livro</label>
            <input required readonly type="text" class="input-xlarge ignorar" id="livro" name="livro" value="<?php echo $this->livro->get_nomelivro(); ?>" />
        </div>
        <hr/>
        <div class="line">
            <label for="dataRetorno">Data de retorno</label>
            <input type="text" autofocus required id="dataRetorno" on class="campoData" name="dataRetorno" />
        </div>
        <div class="line">
            <label for="observacoes">Observações</label>
            <textarea type="textarea" rows="8" id="observacoes" name="observacoes" title="Observacoes" data-content="Registre algo que seja importante, como o estado em que o livro retornou." ></textarea>           
        </div>

        <div class="line">
            <label for="quantidade">Quantidade</label>
            <input required type="number" min="1" max="<?php echo $this->quantidadeMaxima; ?>" class="input-medium" id="quantidade" name="quantidade" title="Quantidade a retornar" data-content="Máximo: <?php echo $this->quantidadeMaxima ?>" value="1">
        </div>

    </fieldset>
    <button disabled class="btn btn-large btn-success btn-primary btn-right" type="submit" disabled >Cadastrar retorno</button>

</form>

<script>
    $(document).ready(function () {
        $("#dataRetorno").datepicker();

        var dataMinima = "<?php echo $this->dataSaida; ?>";
        dataMinima = dataMinima.split("/");
        dataMinima = dataMinima[1] + "/" + dataMinima[0] + "/" + dataMinima[2];
        $("#dataRetorno").datepicker({
            dateFormat: 'dd/mm/yyyy',
            minDate: new Date(dataMinima)
        });
        $(".line input").popover({trigger: 'focus', container: 'body'});
        $(".line textarea").popover({trigger: 'focus', container: 'body'});
        formularioAjax({
            successFn: function () {
                document.paginaAlterada = false;
                history.back();
            }
        });
        varrerCampos();
    });
</script>