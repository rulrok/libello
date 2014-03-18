<title>Cadastrar novo equipamento</title>
<!--Início da página -->
<form class="tabela centralizado" id="ajaxForm" method="post" action="index.php?c=equipamentos&a=verificarnovo">
    <fieldset>
        <legend>Registro de novo equipamento</legend>
        <span class="line">
            <label for="equipamento">Equipamento</label>
            <input required autofocus type="text" class="input-xlarge" id="equipamento" name="equipamento" title="Equipamento" data-content="O nome do equipamento apenas" />
        </span>
        <div class="line">
            <label for="descricoes">Descrições</label>
            <textarea type="textarea" rows="8" id="descricoes" name="descricoes" class="input-xlarge" title="Descrições" data-content="Alguma característica do equipamento. Limite de 1000 caracteres." ></textarea>           
            <div id="chars">1000</div>
        </div>
        <div class="line">
            <label for="dataEntrada">Data de entrada</label>
            <input type="text" readonly id="dataEntrada" class="campoData" name="dataEntrada" />
        </div>
        <hr/>
        <div class="line">
            <label for="tipo">Tipo</label>
            <div class="btn-toolbar" style="position:relative;left:15px;margin-bottom: 5px;">
                <div class="btn-group">
                    <a class="btn btn-info" id="custeio"  value="custeio" checked><i class="icon-headphones"></i> Custeio</a>
                    <a class="btn" id="patrimonio"  value="patrimonio"><i class="icon-briefcase"></i> Patrimônio</a>
                </div>
                <div class="hidden">
                    <input type="radio" name="tipo" id="radioCusteio" value="custeio" checked/>
                    <input type="radio" name="tipo" id="radioPatrimonio" value="patrimonio"/>
                </div>
            </div>
        </div>
        <br/>
        <!-- custeio -->
        <span class="custeio">
            <span class="line">
                <label for="quantidade">Quantidade</label>
                <input required type="number" min="1" class="input-medium" id="quantidade" name="quantidade"/>
            </span>
        </span>

        <!-- Patrimonios -->
        <span class="patrimonios hidden" hidden>
            <span class="line">
                <span class="btn-group" id="controlePatrimonio">
                    <button disabled="true" type="button" class="btn btn-danger disabled" id="removerPatrimonio" onclick="removerPatrimonioAdicionado();" style="display: table-cell;"> <i class="icon-white icon-minus-sign"></i> </button>
                    <button type="button" class="btn btn-success" id="adicionarPatrimonio" onclick="adicionarNovoPatrimonio();" style="display: table-cell;"> <i class="icon-white icon-plus-sign"></i> </button>
                </span>
                <span>&nbsp;&nbsp;&nbsp;Quantidade de itens:</span>
                <span id="quantidadePatrimonios">1</span>
            </span>
            <div id="linhasPatrimonios">
                <span class="line patrimonio-1">
                    <label for="numeroPatrimonio-1">Código Patrimônio</label>
                    <input readonly type="text" class="input-medium" id="numeroPatrimonio-1" name="numeroPatrimonio-1" />
                </span>
            </div>
        </span>

    </fieldset>
    <button class="btn btn-large" type="reset" onclick="botaoLimpar();" >Limpar</button>

    <button class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit">Cadastrar</button>
</form>

<script src="publico/js/patrimonios.js"></script>
<script>
        var elem = $("#chars");
        $("#descricoes").limiter(1000, elem);
        $(".line input").popover({trigger: 'focus', container: 'body'});
        $(".line textarea").popover({trigger: 'focus', container: 'body'});


        $(document).ready(function() {

            varrerCampos();
            formularioAjax();

            $("#dataEntrada").datepick();

        });
</script>