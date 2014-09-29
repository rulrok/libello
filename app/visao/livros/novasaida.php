<title>Registrar nova saída de livro</title>
<!--Início da página-->
<form class="tabela centralizado" id="ajaxForm" method="post" action="index.php?c=livros&a=registrarsaida">
    <fieldset>
        <legend>Saída de livro</legend>
        <input hidden="true" readonly="true" type="text" class="input-small" id="livroID" name="livroID" value="<?php echo $this->livroID ?>" />
        <div class="line">
            <label for="livro">livro</label>
            <input required readonly type="text" class="input-xlarge ignorar" id="livro" name="livro" value="<?php echo $this->livro->get_nomelivro(); ?>" />
        </div>
        <hr/>
        <div class="line">
            <label for="dataSaida">Data de saída</label>
            <input type="text" autofocus required id="dataSaida" on class="campoData" name="dataSaida" />
        </div>
        <div class="line">
            <label for="polo">Polo de Destino</label> 
            <select id="polo" name="polo">
                <?php echo $this->polos; ?>
            </select>
        </div>

        <div class="line">
            <label for="quantidade">Quantidade</label>
            <input required type="number" min="1" max="<?php echo $this->livro->get_quantidade(); ?>" class="input-medium" id="quantidade" name="quantidade" title="Quantidade a sair" data-content="Máximo: <?php echo $this->livro->get_quantidade(); ?>" value="1">
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
                $($(".line")[2]).after("<div class='line'><label for='destinoManual'>Nome do destino</label><input type='text' required id='destinoManual' class='input-xlarge' name='destinoManual'/></div>")
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