<title>Editando livro</title>
<!--Início da página-->
<form class="tabela centralizado" id="ajaxForm" method="post" action="index.php?c=livros&a=verificaredicao">
    <fieldset>
        <legend>Alterar dados do livro</legend>
        <input hidden="true" readonly="true" type="text" class="input-small" id="livroID" name="livroID" value="<?php echo $this->livroID ?>" />
        <span class="line">
            <label for="livro">Nome do Livro</label>
            <input required autofocus type="text" class="input-xlarge" id="livro" name="livro" value="<?php echo $this->livro ?>" />
        </span>
        <span class="line">
            <label for="grafica">Nome da Gráfica</label>
            <input required type="text" class="input-xlarge" id="grafica" name="grafica" value="<?php echo $this->grafica ?>" />
        </span>
        <div class="line">
            <label for="descricao">Descrições</label>
            <textarea type="textarea" rows="8" id="descricao" name="descricao" class="input-xlarge" title="Descrições" data-content="Limite de 1000 caracteres." placeholder="Sem descrição" ><?php echo $this->descricao; ?></textarea>           
            <div id="chars">1000</div>
        </div>
        <div class="line">
            <label for="dataEntrada">Data de entrada</label>
            <input type="text" id="dataEntrada" class="campoData" name="dataEntrada" value="<?php echo $this->dataEntrada ?>"/>
        </div>
        <div class="line">
            <label for="area">Área</label>
            <select id="area" name="area" class="input-xlarge">
                <?php echo $this->comboBoxAreas; ?>
            </select>
        </div>
        <hr/>
        <?php if ($this->livroEditavel): ?>
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

<script>
    $(document).ready(function() {
        var elem = $("#chars");
        $("#descricao").limiter(1000, elem);
        var area;
        //Gambiarra master
        area = <?php echo "'" . $this->area . "'"; ?>;
        $("#area").val(area);
        varrerCampos();
        formularioAjax();
        $("#dataEntrada").datepicker();
        $(".line input").popover({trigger: 'focus', container: 'body'});
        $(".line textarea").popover({trigger: 'focus', container: 'body'});

        $("#custeio").on("click", function() {
            if (!$(this).hasClass("btn-info")) {
                $(this).toggleClass("btn-info");
                $("#patrimonio").toggleClass("btn-info");
            }

            $("input[id^=numeroPatrimonio]").prop("required", false);
            $("input[id^=numeroPatrimonio]").prop("readonly", true);
            $(".patrimonios").prop("hidden", true);
            $(".custeio").prop("hidden", false);
            $(".custeio input").prop("required", true);
            $(".patrimonios input").prop("required", false);
            $("input[id^=numeroPatrimonio]").removeClass("campoErrado")

            $("#radioCusteio").click();
            liberarCadastro();
        });

        $("#patrimonio").on("click", function() {

            if (!$(this).hasClass("btn-info")) {
                $(this).toggleClass("btn-info");
                $("#custeio").toggleClass("btn-info");
            }

            $("input[id^=numeroPatrimonio]").prop("required", true);
            $("input[id^=numeroPatrimonio]").prop("readonly", false);
            $(".patrimonios").prop("hidden", false);
            $(".custeio").prop("hidden", true);
            $(".custeio input").prop("required", false);
            $(".patrimonios input").prop("required", true);
            $("input[id^=numeroPatrimonio]").removeClass("campoErrado");

            $("#radioPatrimonio").click();
            $("#submit").prop("disabled", true);
            varrerCampos();
        });

        var numeroPatrimonio;
        //Gambiarra master
        numeroPatrimonio = <?php echo "'" . $this->numeroPatrimonio . "'"; ?>;
        if (numeroPatrimonio == "") {
            $("#custeio").click();
        } else {
            $("#patrimonio").click();
        }
        var editavel;
        editavel = <?php echo "'" . $this->livroEditavel . "'"; ?>;
        if (!editavel) {
            $("#custeio").unbind("click");
            $("#patrimonio").unbind("click");
        }



    });
</script>