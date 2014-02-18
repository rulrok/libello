<title>Cadastrar novo equipamento</title>
<!--Início da página -->
<form class="table centered" id="ajaxForm" method="post" action="index.php?c=equipamentos&a=verificarnovo">
    <fieldset>
        <legend>Registro de novo equipamento</legend>
        <span class="line">
            <label>Equipamento</label>
            <input required autofocus type="text" class="input-xlarge" id="equipamento" name="equipamento" title="Equipamento" data-content="O nome do equipamento apenas" />
        </span>
        <div class="line">
            <label for="descricoes">Descrições</label>
            <textarea type="textarea" rows="8" id="descricoes" name="descricoes" class="input-xlarge" title="Descrições" data-content="Alguma característica do equipamento. Limite de 1000 caracteres." ></textarea>           
            <div id="chars">1000</div>
        </div>
        <div class="line">
            <label>Data de entrada</label>
            <input type="text" readonly id="dataEntrada" class="campoData" name="dataEntrada" />
        </div>
        <hr/>
        <div class="line">
            <label>Tipo</label>
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
                <label>Quantidade</label>
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
                <label>&nbsp;&nbsp;&nbsp;Quantidade de patrimônios</label>
                <input readonly required type="text" class="input-small ignorar" id="quantidadePatrimonios" name="quantidadePatrimonios" value="1"/>
            </span>
            <div id="linhasPatrimonios">
                <span class="line patrimonio-1">
                    <label>Código Patrimônio</label>
                    <input readonly type="text" class="input-medium" id="numeroPatrimonio-1" name="numeroPatrimonio-1" title="Código do Patrimônio" data-content="Equipamentos idênticos com número de patrimônio variados podem ser cadastrados em lote. Para isso, clique em no botão '+'"/>
                </span>
            </div>
        </span>

    </fieldset>
    <button class="btn btn-large" type="reset" onclick="botaoLimpar();" >Limpar</button>

    <button class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit">Cadastrar</button>
</form>

<script>
                        var elem = $("#chars");
                        $("#descricoes").limiter(1000, elem);
                        $(".line input").popover({trigger: 'focus', container: 'body'});
                        $(".line textarea").popover({trigger: 'focus', container: 'body'});
                        var quantidadePatrimonios = 1;
                        var codigoHtml = "";

                        function adicionarNovoPatrimonio() {
                            quantidadePatrimonios++;
                            $("#removerPatrimonio").removeClass("disabled");
                            $("#removerPatrimonio").prop("disabled", false);
                            $("#quantidadePatrimonios").val(quantidadePatrimonios);

                            $("span.patrimonio-" + (quantidadePatrimonios - 1)).after(novoCodigoHtml());
                            varrerCampos();
                        }

                        function removerPatrimonioAdicionado() {
                            if (quantidadePatrimonios > 1) {
                                $("span.patrimonio-" + (quantidadePatrimonios)).remove();
                                quantidadePatrimonios--;
                                $("#quantidadePatrimonios").val(quantidadePatrimonios);
                            }
                            if (quantidadePatrimonios <= 1) {
                                quantidadePatrimonios = 1;
                                $("#removerPatrimonio").addClass("disabled");
                                $("#removerPatrimonio").prop("disabled", true);
                            }
                        }

                        function novoCodigoHtml() {
                            return codigoHtml.
                                    replace("<n>", quantidadePatrimonios).
                                    replace("<n>", quantidadePatrimonios).
                                    replace("<n>", quantidadePatrimonios);

                        }

                        function botaoLimpar() {
                            $("span.patrimonio-2").nextAll().andSelf().remove();
                            quantidadePatrimonios = 1;
                            removerPatrimonioAdicionado();
                            liberarCadastro();
                            $("#chars").text("1000");
                        }

                        $(document).ready(function() {

                            varrerCampos();
                            formularioAjax();

                            $("#dataEntrada").datepick();


                            $("#custeio").on("click", function() {
                                if (!$(this).hasClass("btn-info")) {
                                    $(this).toggleClass("btn-info");
                                    $("#patrimonio").toggleClass("btn-info");
                                }

                                $("input[id^=numeroPatrimonio]").prop("required", false);
                                $("input[id^=numeroPatrimonio]").prop("readonly", true);
                                $(".patrimonios").prop("hidden", true);
                                $(".patrimonios").addClass("hidden");
                                $(".custeio").removeClass("hidden");
                                $(".custeio input").prop("required", true);
                                $(".patrimonios input").prop("required", false);
                                $("input[id^=numeroPatrimonio]").removeClass("campoErrado")
//                                $(".obrigatorio").remove(); //remove a imagem do asterisco de todos os campos

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
                                $(".patrimonios").removeClass("hidden");
                                $(".custeio").addClass("hidden");
                                $(".custeio input").prop("required", false);
                                $(".patrimonios input").prop("required", true);
                                $("input[id^=numeroPatrimonio]").removeClass("campoErrado");
//                                if ($(".obrigatorio").length === 0) {
//                                    $("input[id^=numeroPatrimonio]").after("<img class=\"obrigatorio\" src=\"publico/imagens/icones/campo_obrigatorio.png\">");
//                                }
                                if (codigoHtml === "") {
                                    codigoHtml = $("#linhasPatrimonios").last().html().replace("-1", "-<n>").replace("-1", "-<n>").replace("-1", "-<n>");
                                    varrerCampos();
                                }

                                $("#radioPatrimonio").click();
                                $("#submit").prop("disabled", true);
                            });

                        });
</script>