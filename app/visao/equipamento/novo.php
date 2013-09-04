<!--Início da página -->

<form class="table centered" id="ajaxForm" method="post" action="index.php?c=equipamento&a=verificarnovo">
    <fieldset>
        <legend>Registro de novo equipamento</legend>
        <span class="line">
            <label>Equipamento</label>
            <input required type="text" class="input-xlarge" id="equipamento" name="equipamento"  />
        </span>
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
                <input required type="text" class="input-medium" id="quantidade" name="quantidade" />
            </span>
        </span>

        <!-- Patrimonios -->
        <span class="patrimonios" hidden>
            <span class="line">
                <span class="btn-group" id="controlePatrimonio">
                    <button disabled="true" type="button" class="btn btn-danger disabled" id="removerPatrimonio" onclick="removerPatrimonioAdicionado();" style="display: table-cell;"> <i class="icon-white icon-minus-sign"></i> </button>
                    <button type="button" class="btn btn-success" id="adicionarPatrimonio" onclick="adicionarNovoPatrimonio();" style="display: table-cell;"> <i class="icon-white icon-plus-sign"></i> </button>
                </span>
                <label>&nbsp;&nbsp;&nbsp;Quantidade de patrimônios</label>
                <input readonly type="text" class="input-small" id="quantidadePatrimonios" name="quantidadePatrimonios" value="1"/>
            </span>
            <div id="linhasPatrimonios">
                <span class="line patrimonio-1">
                    <label>Código Patrimônio</label>
                    <input readonly type="text" class="input-medium" id="numeroPatrimonio-1" name="numeroPatrimonio-1"/>
                </span>
            </div>
        </span>

    </fieldset>
    <input class="btn btn-large" type="reset" value="Limpar" onclick="botaoLimpar();" >

    <input class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit" value="Cadastrar">
</form>

<script src="publico/js/validarCampos.js"></script>
<script src="publico/js/ajaxForms.js"></script>
<script>

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
                        }

                        $(document).ready(function() {



                            $(function() {
                                $("#dataEntrada").datepick();
                            });

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
                                $(".custeio").prop("hidden", true);
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