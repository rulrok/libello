<title>Novo descritor</title>
<!-- Início da página -->
<form id="ajaxForm"  method="POST" action="index.php?c=imagens&a=verificarNovoDescritor">
    <fieldset>
        <legend>Inserir novo descritor</legend>
        <center>
            <span class="line">
                <span>
                    <label for="descritor_1">1.</label>
                    <input type="checkbox" id="inserir_novo_descritor_1" class="checkbox_novo_descritor"/>
                    <select id="descritor_1" class="input-xlarge .cb_descritor">
                        <option value="default">-- Escolha um descritor --</option>
                    </select>
                    <input type="text" id="novo_descritor_1" class="hidden input-xlarge"/>
                </span>
                <span>
                    <label for="descritor_2">2.</label>
                    <input type="checkbox" id="inserir_novo_descritor_2" class="checkbox_novo_descritor"/>
                    <select id="descritor_2" class="input-xlarge .cb_descritor">
                        <option value="default">-- Escolha um descritor --</option>
                    </select>
                    <input type="text" id="novo_descritor_2" class="hidden input-xlarge"/>
                </span>
                <span>
                    <label for="descritor_3">3.</label>
                    <input type="checkbox" id="inserir_novo_descritor_3" class="checkbox_novo_descritor"/>
                    <select id="descritor_3" class="input-xlarge .cb_descritor">
                        <option value="default">-- Escolha um descritor --</option>
                    </select>
                    <input type="text" id="novo_descritor_3" class="hidden input-xlarge"/>
                </span>
                <span>
                    <label for="descritor_4">4.</label>
                    <input type="checkbox" disabled checked id="inserir_novo_descritor_4"class="checkbox_novo_descritor"/>
    <!--                <select id="descritor_4">
                        <option value="default">-- Escolha um descritor --</option>
                    </select>-->
                    <input type="text" id="novo_descritor_4" class="input-xlarge"/>
                </span>
            </span>
        </center>
    </fieldset>
    <button type="submit" class="btn btn-large btn-success btn-primary btn-right" >Cadastrar</button>
</form>
<script>
    var cb_descritores = $(".cb_descritor");
//        console.log(cb_descritores);
    $.each(cb_descritores, function() {
        atualizar_combobox(this);
    });
    formularioAjax();
    function esconder(id) {
        $(id).addClass('hidden');
    }
    function exibir(id) {
        $(id).removeClass('hidden');
    }
    function atualizar_combobox(combo_box) {
        $(combo_box).on('change', function() {
            var desnum = parseInt($(this).attr("numero"));
            if (desnum > 0 && desnum < 4) {
                var wrap_id = "#descritor" + (desnum + 1) + "_wrap";
//                console.log(wrap_id);
                if ($(this).val() != "default") {
                    var $url = "index.php?c=imagens&a=obterDescritor&n=" + desnum + "&p=" + $(this).val();
                    console.log($url);
                    $(wrap_id).load($url, function(response, status, xhr) {
                        if (status == "error") {
                            $(this).val("default");
//                        var msg = "Problema ao recuperar os descritores. Tente novamente. ";
//                        $("#descritor2_wrap").html(msg + xhr.status + " " + xhr.statusText);
                        } else if (status == "success") {
//                                liberarCadastro();
                            atualizar_combobox($("#descritor" + (desnum + 1)));
                        }
                    });
                } else {
                    $(wrap_id).load("index.php?c=imagens&a=obterDescritor");
                }
            }
        });
    }
    $(document).ready(function() {
        $("input[type=checkbox]").each(function() {
            $(this).on('click', function() {
                var id = this.id;
                id = id.substr(13);
                var valorId = id.substr(10);
                var nomeId = id.substring(0, 10);
                if (this.checked) {
                    for (var i = valorId; i < 5; i++) {
                        esconder(("#" + nomeId) + i);
                        exibir(("#novo_" + nomeId) + i);
                        $("#inserir_novo_descritor_" + i).prop('checked', true);
                        if (i > valorId)
                            $("#inserir_novo_descritor_" + i).prop('disabled', true);
                    }
                } else {
                    exibir("#" + id);
                    esconder("#novo_" + id);
                    var sucessor = parseInt(valorId) + 1;
                    if (sucessor < 4)
                        $("#inserir_novo_descritor_" + sucessor).prop('disabled', false);
                }
            });
        });
    });
</script>