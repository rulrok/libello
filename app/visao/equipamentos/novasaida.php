<title>Registrar nova saída de equipamento</title>
<!--Início da página-->
<form class="table centered" id="ajaxForm" method="post" action="index.php?c=equipamentos&a=registrarsaida">
    <fieldset>
        <legend>Saída de equipamento</legend>
        <input hidden="true" readonly="true" type="text" class="input-small" id="equipamentoID" name="equipamentoID" value="<?php echo $this->equipamentoID ?>" />
        <div class="line">
            <label>Equipamento</label>
            <input required readonly type="text" class="input-xlarge ignorar" id="equipamento" name="equipamento" value="<?php echo $this->equipamento->get_nomeEquipamento(); ?>" />
        </div>
        <hr/>
        <div class="line">
            <label>Data de saída</label>
            <input type="text"  required id="dataSaida" on class="campoData" name="dataSaida" />
        </div>
        <div class="line">
            <label>Destino</label>
            <input required type="text" class="input-xlarge" id="destino" name="destino" title="Destino" data-content="A localização para onde o equipamento está saindo." />           
        </div>

        <div class="line">
            <label>Quantidade</label>
            <input required type="number" min="1" max="<?php echo $this->equipamento->get_quantidade(); ?>" class="input-medium" id="quantidade" name="quantidade" title="Quantidade a sair" data-content="Máximo: <?php echo $this->equipamento->get_quantidade(); ?>" value="1">
        </div>
        <br/>
        <fieldset>
            <legend>Responsável</legend>
            <!--            <div class="line">
                            <label>Tipo</label>
            <?php //echo $this->comboboxPapeis ?>
                        </div>
                        <div class="line">
                            <label>Usuário</label>
                            <select class="input-xlarge cb_usuarios" id="cb_usuarios" name="responsavel" required>
                                <option value="default">-- Escolha um tipo de usuário --</option>
                            </select>
                        </div>-->
            <div class="line">
                <label for="responsavel">Responsável</label>
                <?php echo $this->responsavel; ?>
            </div>
        </fieldset>


    </fieldset>
    <input disabled class="btn btn-large btn-success btn-primary btn-right" type="submit" disabled value="Cadastrar">

</form>

<script>
    $(document).ready(function() {
        $("#dataSaida").datepick();
        $(".line input").popover({trigger: 'focus', container: 'body'});
        $("select[name=papel]").on("change", function(e) {
            var id = $(this).val();
            if (id > 0) {
                buscarUsuarios(id, this);
            }
        });
        formularioAjax("ajaxForm", undefined,
                function() {
                    $("input[type=submit]").prop("disabled", true);
                },
                function() {
                    setTimeout(function() {
                        history.back();
                    }, 1000);
                }
        );
        varrerCampos();
    });

//    function buscarUsuarios(idPapel) {
//        document.paginaAlterada = false;
//        var retorno = ajax("index.php?c=equipamentos&a=listarUsuarios&idPapel=" + idPapel, null, false, false);
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