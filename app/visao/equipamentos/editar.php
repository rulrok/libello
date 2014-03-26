<title>Editando equipamento</title>
<!--Início da página-->
<form class="tabela centralizado" id="ajaxForm" method="post" action="index.php?c=equipamentos&a=verificaredicao">
    <fieldset>
        <legend>Alterar dados do equipamento</legend>
        <input hidden="true" readonly="true" type="text" class="input-small" id="equipamentoID" name="equipamentoID" value="<?php echo $this->equipamentoID ?>" />
        <span class="line">
            <label for="equipamento">Equipamento</label>
            <input required autofocus type="text" class="input-xlarge" id="equipamento" name="equipamento" value="<?php echo $this->equipamento ?>" />
        </span>
        <div class="line">
            <label for="descricao">Descrições</label>
            <textarea type="textarea" rows="8" id="descricao" name="descricao" class="input-xlarge" title="Descrições" data-content="Limite de 1000 caracteres." placeholder="Sem descrição" ><?php echo $this->descricao; ?></textarea>           
            <div id="chars">1000</div>
        </div>
        <div class="line">
            <label for="dataEntrada">Data de entrada</label>
            <input type="text" id="dataEntrada" class="campoData" id="dataEntrada" name="dataEntrada" value="<?php echo $this->dataEntrada ?>"/>
        </div>
        <hr/>
        <?php if ($this->equipamentoEditavel): ?>
            <div class="line">
                <label for="tipo">Tipo</label>
                <div class="btn-toolbar" style="position:relative;left:15px;margin-bottom: 5px;">
                    <div class="btn-group">
                        <a class="btn btn-info" id="custeio"  value="custeio" checked><i class="icon-headphones"></i> Custeio</a>
                        <a class="btn" id="patrimonio"  value="patrimonio"><i class="icon-briefcase"></i> Patrimônio</a>
                    </div>
                    <div hidden>
                        <input type="radio" name="tipo" id="radioCusteio" value="custeio" checked/>
                        <input type="radio" name="tipo" id="radioPatrimonio" value="patrimonio"/>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info"><i class="icon-warning-sign"> </i> O tipo não pode ser alterado pois já houve algum <br/>registro de baixa, saída ou retorno.</div>
                <div class="line">  
                    <label for="tipo">Tipo</label>
                    <div class="btn-toolbar"  style="position:relative;left:15px;margin-bottom: 5px;" > 
                        <div class="btn-group">
                            <a class="btn btn-info disabled" id="custeio"  value="custeio" checked data-content="asdasd"><i class="icon-headphones"></i> Custeio</a>
                            <a class="btn disabled" id="patrimonio"  value="patrimonio" data-content="asdasd"><i class="icon-briefcase"></i> Patrimônio</a>
                        </div>
                    </div>
                    <div hidden>
                        <input type="radio" name="tipo" id="radioCusteio" value="custeio" checked/>
                        <input type="radio" name="tipo" id="radioPatrimonio" value="patrimonio"/>
                    </div>
                <?php endif; ?>
            </div>
            <br/>
            <!-- custeio -->
            <span class="custeio">
                <span class="line">
                    <label for="quantidade">Quantidade</label>
                    <input required type="number" min="1" class="input-medium" id="quantidade" name="quantidade" value="<?php echo $this->quantidade ?>"/>
                </span>
            </span>

            <!-- Patrimonios -->
            <span class="patrimonios" hidden>

                <div id="linhasPatrimonios">
                    <span class="line patrimonio-1">
                        <label for="numeroPatrimonio">Código Patrimônio</label>
                        <input readonly type="text" class="input-medium" id="numeroPatrimonio" name="numeroPatrimonio" value="<?php echo $this->numeroPatrimonio ?>"/>
                    </span>
                </div>
            </span>
    </fieldset>
    <button class=" btn btn-left" type="button" onclick="history.back();">Voltar</button>
    <button disabled class=" btn btn-primary btn-right" type="submit">Atualizar dados</button>

</form>

<script src="publico/js/patrimonios.js"></script>
<script>
    $(document).ready(function() {
        var elem = $("#chars");
        $("#descricao").limiter(1000, elem);
        varrerCampos();
        formularioAjax();
        $("#dataEntrada").datepicker();
        $(".line input").popover({trigger: 'focus', container: 'body'});
        $(".line textarea").popover({trigger: 'focus', container: 'body'});

        var numeroPatrimonio;
        //Gambiarra master
        numeroPatrimonio = <?php echo "'" . $this->numeroPatrimonio . "'"; ?>;
        if (numeroPatrimonio == "") {
            $("#custeio").click();
        } else {
            $("#patrimonio").click();
        }
        var editavel;
        editavel = <?php echo "'" . $this->equipamentoEditavel . "'"; ?>;
        if (!editavel) {
            $("#custeio").unbind("click");
            $("#patrimonio").unbind("click");
        }

    });
</script>