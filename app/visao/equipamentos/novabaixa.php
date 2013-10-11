<title>Registrar baixar para equipamento</title>
<!--Início da página-->
<form class="table centered" id="ajaxForm" method="post" action="index.php?c=equipamentos&a=registrarbaixa">
    <fieldset>
        <legend>Baixa de equipamento</legend>
        <input hidden="true" readonly="true" type="text" class="input-small" id="equipamentoID" name="equipamentoID" value="<?php echo $this->equipamentoID ?>" />
        <input hidden="true" readonly="true" type="text" class="input-small" id="saidaID" name="saidaID" value="<?php echo $this->saidaID ?>" />
        <input hidden="true" readonly="true" type="text" class="input-small" id="quantidadeMaxima" name="quantidadeMaxima" value="<?php echo $this->quantidadeMaxima ?>" />
        <div class="line">
            <label for="equipamento">Equipamento</label>
            <input required readonly type="text" class="input-xlarge ignorar" id="equipamento" name="equipamento" value="<?php echo $this->equipamento->get_nomeEquipamento(); ?>" />
        </div>
        <hr/>
        <div class="line">
            <label for="dataBaixa">Data de baixa</label>
            <input type="text"  required id="dataBaixa" on class="campoData" name="dataBaixa" />
        </div>
        <div class="line">
            <label for="quantidade">Quantidade</label>
            <input required type="number" min="1" max="<?php echo $this->quantidadeMaxima; ?>" class="input-medium" id="quantidade" name="quantidade" title="Quantidade a dar baixa" data-content="Máximo: <?php echo $this->quantidadeMaxima; ?>" value="1">
        </div>
        <div class="line">
            <label for="observacoes">Observações</label>
            <textarea type="textarea" rows="8" id="observacoes" name="observacoes" title="Observacoes" data-content="Registre algo que seja importante, como o estado em que o equipamento se encontrava." ></textarea>
            <div id="chars">1000</div>
        </div>
    </fieldset>
    <button disabled class="btn btn-large btn-success btn-primary btn-right" type="submit" disabled>Cadastrar</button>

</form>

<script>
    $(document).ready(function() {
        var elem = $("#chars");
        $("#observacoes").limiter(1000, elem);
        var dataMinima = "<?php echo $this->dataMinima; ?>";
        dataMinima = dataMinima.split("/");
        dataMinima = dataMinima[1] + "/" + dataMinima[0] + "/" + dataMinima[2];
        $("#dataBaixa").datepick({
            dateFormat: 'dd/mm/yyyy',
            minDate: new Date(dataMinima)
        });
        $(".line input").popover({trigger: 'focus', container: 'body'});
        $(".line textarea").popover({trigger: 'focus', container: 'body'});
        formularioAjax("ajaxForm", undefined,
                function() {
                    $("input[type=submit]").prop("disabled", true);
                },
                function() {
                    setTimeout(function() {
                        document.paginaAlterada = false;
                        history.back();
                    }, 1000);
                }
        );
        varrerCampos();
    });

</script>