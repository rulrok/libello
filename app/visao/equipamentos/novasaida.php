<title>Registrar nova saída de equipamento</title>
<!--Início da página-->
<form class="tabela centralizado" id="ajaxForm" method="post" action="index.php?c=equipamentos&a=registrarsaida">
    <fieldset>
        <legend>Saída de equipamento</legend>
        <input hidden="true" readonly="true" type="text" class="input-small" id="equipamentoID" name="equipamentoID" value="<?php echo $this->equipamentoID ?>" />
        <div class="line">
            <label for="equipamento">Equipamento</label>
            <input required readonly type="text" class="input-xlarge ignorar" id="equipamento" name="equipamento" value="<?php echo $this->equipamento->get_nomeEquipamento(); ?>" />
        </div>
        <hr/>
        <div class="line">
            <label for="dataSaida">Data de saída</label>
            <input type="text" autofocus required id="dataSaida" on class="campoData" name="dataSaida" />
        </div>
        <div class="line">
            <label for="polo">Polo de Destino</label>
            <!--<input required type="text" class="input-xlarge" id="destino" name="destino" title="Destino" data-content="A localização para onde o equipamento está saindo." />-->           
            <select id="polo" name="polo">
                <?php echo $this->polos; ?>
            </select>
        </div>

        <div class="line">
            <label for="quantidade">Quantidade</label>
            <input required type="number" min="1" max="<?php echo $this->equipamento->get_quantidade(); ?>" class="input-medium" id="quantidade" name="quantidade" title="Quantidade a sair" data-content="Máximo: <?php echo $this->equipamento->get_quantidade(); ?>" value="1">
        </div>
        <br/>
        <fieldset>
            <legend>Responsável</legend>
            <div class="line">
                <label for="responsavel">Responsável</label>
                <select id="responsavel" name="responsavel">
                    <?php echo $this->responsavel; ?>
                </select>
            </div>
        </fieldset>


    </fieldset>
    <button disabled class="btn btn-large btn-success btn-primary btn-right" type="submit" value="Cadastrar">Cadastrar</button>

</form>

<script>
    $(document).ready(function () {
        $("#dataSaida").datepicker();
        $(".line input").popover({trigger: 'focus', container: 'body'});
        formularioAjax({
            successFn: function () {
                document.paginaAlterada = false;
                history.back();
            }
        });
        varrerCampos();

        var campoPolo = document.getElementById("polo");
        optg = document.createElement("optgroup");
        optg.title = "outro";
        optg.label = "Outro";
        opt = document.createElement("option");
        opt.value = "outro";
        opt.text = "Outro destino";
        optg.appendChild(opt);
        campoPolo.appendChild(optg);
        document.viagens_campoDestinoAlternativo = false;

        $("#polo").on('change', function () {
            if ($("#polo option:selected").prop("value") === "outro") {
                $($(".line")[2]).after("<div class='line'><label for='destinoManual'>Nome do destino</label><input type='text' required id='destinoManua l' class='input-xlarge' name='destinoManual'/></div>");
                varrerCampos();
                document.viagens_campoDestinoAlternativo = true;
            } else if (document.viagens_campoDestinoAlternativo) {
                document.viagens_campoDestinoAlternativo = false;
                $($(".line")[3]).remove();
            }
        });
    });

    $("#responsavel").chosen({display_disabled_options: false, display_selected_options: true, inherit_select_classes: true, placeholder_text_multiple: "Selecione o responsavel pela saída", width: "450px"});
</script>