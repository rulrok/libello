<title>Editando equipamento</title>
<!--Início da página-->
<form class="table centered" id="ajaxForm" method="post" action="index.php?c=equipamentos&a=verificaredicao">
    <fieldset>
        <legend>Alterar dados do equipamento</legend>
        <input hidden="true" readonly="true" type="text" class="input-small" id="equipamentoID" name="equipamentoID" value="<?php echo $this->equipamentoID ?>" />
        <span class="line">
            <label>Equipamento</label>
            <input required type="text" class="input-xlarge" id="equipamento" name="equipamento" value="<?php echo $this->equipamento ?>" />
        </span>
        <div class="line">
            <label for="descricao">Descrições</label>
            <textarea type="textarea" rows="8" id="descricao" name="descricao" class="input-xlarge" title="Descrições" data-content="Limite de 1000 caracteres." placeholder="Sem descrição" ><?php echo $this->descricao; ?></textarea>           
            <div id="chars">1000</div>
        </div>
        <div class="line">
            <label>Data de entrada</label>
            <input type="text" readonly id="dataEntrada" class="campoData" name="dataEntrada" value="<?php echo $this->dataEntrada ?>"/>
        </div>
        <hr/>
        <div class="line">
            <label>Tipo</label>
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
        </div>
        <br/>
        <!-- custeio -->
        <span class="custeio">
            <span class="line">
                <label>Quantidade</label>
                <input required type="number" min="1" class="input-medium" id="quantidade" name="quantidade" value="<?php echo $this->quantidade ?>"/>
            </span>
        </span>

        <!-- Patrimonios -->
        <span class="patrimonios" hidden>

            <div id="linhasPatrimonios">
                <span class="line patrimonio-1">
                    <label>Código Patrimônio</label>
                    <input readonly type="text" class="input-medium" id="numeroPatrimonio" name="numeroPatrimonio" value="<?php echo $this->numeroPatrimonio ?>"/>
                </span>
            </div>
        </span>

    </fieldset>
    <input disabled class=" btn btn-primary btn-right" type="submit" disabled value="Atualizar dados">

</form>

<script>
    $(document).ready(function() {
        var elem = $("#chars");
        $("#descricao").limiter(1000, elem);
        varrerCampos();
        formularioAjax();
        $("#dataEntrada").datepick();
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

    });
</script>