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
            <!--<input required type="text" class="input-xlarge" id="destino" name="destino" title="Destino" data-content="A localização para onde o livro está saindo." />-->           
            <?php echo $this->polos; ?>
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
                <?php echo $this->responsavel; ?>
            </div>
        </fieldset>


    </fieldset>
    <button disabled class="btn btn-large btn-success btn-primary btn-right" type="submit" value="Cadastrar">Cadastrar</button>

</form>

<script>
    $(document).ready(function() {
        $("#dataSaida").datepicker();
        $(".line input").popover({trigger: 'focus', container: 'body'});
//        $("select[name=papel]").on("change", function(e) {
//            var id = $(this).val();
//            if (id > 0) {
//                buscarUsuarios(id, this);
//            }
//        });
        formularioAjax({
            idFormulario: "ajaxForm",
            successFn: function() {
                setTimeout(function() {
                    document.paginaAlterada = false;
                    history.back();
                }, 1000);
            },
            completeFn: function() {
                $("button[type=submit]").prop("disabled", true);
            }}

        );
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

        $("#polo").on('change', function() {
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

//    function buscarUsuarios(idPapel) {
//        document.paginaAlterada = false;
//        var retorno = ajax("index.php?c=livros&a=listarUsuarios&idPapel=" + idPapel, null, false, false);
//        document.paginaAlterada = true;
//        var json = extrairJSON(retorno);
//        var cb;
//        if (json.length > 0) {
//            cb = '<option value="default">-- Selecione um usuário --</option>';
//            for (var i = 0; i < json.length; i++) {
////            console.log(retorno[i]);
//                cb += '\n<option value="' + json[i].idUsuario + '">' + (i + 1) + ": " + json[i].Nome + '</option>';
//            }
//        } else {
//            cb = '<option value="default">-- Não existem usuários desse tipo --</option>';
//        }
////        console.log(cb);
//        $("#cb_usuarios").empty();
//        $("#cb_usuarios").append(cb);
//    }
    $("#responsavel").chosen({display_disabled_options: false, display_selected_options: true, inherit_select_classes: true, placeholder_text_multiple: "Selecione o responsavel pela saída", width: "450px"});
</script>