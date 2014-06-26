<title>Novo descritor</title>
<!-- Início da página -->
<br/>
<form class="tabela centralizado" id="ajaxForm"  method="POST" action="index.php?c=imagens&a=verificarNovoDescritor">
    <fieldset>
        <legend>Inserir novo descritor</legend>
        <div class="line">
            <label for="descritor_1">Nível 1</label>
            <input type="checkbox" id="inserir_novo_descritor_1" name="inserir_novo_descritor_1"  class="checkbox_novo_descritor" data-toggle="Novo" title="Novo descritor" />
            <select id="descritor_1" name="descritor_1" class="input-xlarge cb_descritor" required>
                <?php echo $this->comboBoxDescritor; ?>
            </select>
            <input type="text" id="novo_descritor_1" name="novo_descritor_1" class="hidden input-xlarge"/>
        </div>
        <br/>
        <div class="line">
            <label for="descritor_2">Nível 2</label>
            <input type="checkbox" id="inserir_novo_descritor_2" name="inserir_novo_descritor_2" class="checkbox_novo_descritor" data-toggle="Novo" title="Novo descritor"/>
            <select id="descritor_2" name="descritor_2" class="input-xlarge cb_descritor" required>
                <option value="default">-- Escolha um descritor --</option>
            </select>
            <input type="text" id="novo_descritor_2" name="novo_descritor_2" class="hidden input-xlarge"/>
        </div>
        <br/>
        <div class="line">
            <label for="descritor_3">Nível 3</label>
            <input type="checkbox" id="inserir_novo_descritor_3" name="inserir_novo_descritor_3" class="checkbox_novo_descritor" data-toggle="Novo" title="Novo descritor"/>
            <select id="descritor_3" name="descritor_3" class="input-xlarge cb_descritor" required>
                <option value="default">-- Escolha um descritor --</option>
            </select>
            <input type="text" id="novo_descritor_3" name="novo_descritor_3" class="hidden input-xlarge"/>
        </div>
        <br/>
        <div class="line">
            <label for="descritor_4"> Nível 4</label>
            <input type="checkbox" disabled checked id="inserir_novo_descritor_4" name="inserir_novo_descritor_4" class="checkbox_novo_descritor" data-toggle="Novo" title="Último descritor sempre é requerido"/>
<!--                <select id="descritor_4">
                <option value="default">-- Escolha um descritor --</option>
            </select>-->
            <input required type="text" id="novo_descritor_4" name="novo_descritor_4" class="input-xlarge"/>
        </div>
    </fieldset>
    <button type="reset" class="btn btn-large btn-left" >Limpar</button>
    <button type="submit" disabled class="btn btn-large btn-success btn-primary btn-right" >Cadastrar</button>
</form>
<script>

    function esconder(id) {
        $(id).addClass('hidden');
        $(id).removeAttr('required');
        $(id).prop('disabled', true);
        $(".campoVarrido").removeClass("campoVarrido");
        $(".imagemCampoObrigatorio").remove();
        varrerCampos();
    }
    function exibir(id) {
        $(id).removeClass('hidden');
        $(id).attr('required', true);
        $(id).removeProp('disabled');
        $(".campoVarrido").removeClass("campoVarrido");
        $(".imagemCampoObrigatorio").remove();
        varrerCampos();
    }
    function atualizar_combobox(combo_box) {
        $(combo_box).on('change', function() {
            var desnum = parseInt(this.id.substr(10));
//            console.log(desnum);
            if (desnum > 0 && desnum < 4) {
                var wrap_id = "#descritor_" + (desnum + 1);
//                console.log(wrap_id);
//                console.log(this.name);
                if (this.selectedIndex !== 0) {
                    var $url = "index.php?c=imagens&a=obterDescritor&n=" + desnum + "&p=" + this.value;
//                    console.log($url);
                    $(wrap_id).load($url, function(response, status, xhr) {
                        if (status == "error") {
                            $(this).val("default");
//                        var msg = "Problema ao recuperar os descritores. Tente novamente. ";
//                        $("#descritor2_wrap").html(msg + xhr.status + " " + xhr.statusText);
                        } else if (status == "success") {
//                                liberarCadastro();
                            atualizar_combobox($("#descritor_" + (desnum + 1)));
                        }
                    });
                } else {
                    $(wrap_id).load("index.php?c=imagens&a=obterDescritor");
                }
            }
        });
    }

    function configurarComboBox() {
        if (!$('#inserir_novo_descritor_1').prop('checked') && !$('#inserir_novo_descritor_2').prop('checked') && !$('#inserir_novo_descritor_3').prop('checked')) {
            $("#novo_descritor_4").val('');
            $("#novo_descritor_4").focus();
            return;
        }

        if ($('#inserir_novo_descritor_1').prop('checked')) {
            nomeNivel1 = $("#novo_descritor_1").val();
            $('#inserir_novo_descritor_1').trigger('click');
        } else {
            nomeNivel1 = $("#descritor_1 option:selected").text();
        }
        if ($('#inserir_novo_descritor_2').prop('checked')) {
            nomeNivel2 = $("#novo_descritor_2").val();
            $('#inserir_novo_descritor_2').trigger('click');
        } else {
            nomeNivel2 = $("#descritor_2 option:selected").text();
        }
        if ($('#inserir_novo_descritor_3').prop('checked')) {
            nomeNivel3 = $("#novo_descritor_3").val();
            $('#inserir_novo_descritor_3').trigger('click');
        } else {
            nomeNivel3 = $("#descritor_3 option:selected").text();
        }

        $("#descritor_1").load(
                'index.php?c=imagens&a=auxcombonivel1',
                function(responseText, textStatus, XMLHttpRequest) {
                    console.log(textStatus);
                    $("#novo_descritor_1").val('');
                    $("#descritor_1 option:contains('" + nomeNivel1 + "')").prop('selected', true);
                    $("#descritor_1").trigger('change');

                    setTimeout(function() {
                        $("#novo_descritor_2").val('');
                        $("#descritor_2 option:contains('" + nomeNivel2 + "')").prop('selected', true);
                        $("#descritor_2").trigger('change');

                        setTimeout(function() {
                            $("#novo_descritor_3").val('');
                            $("#descritor_3 option:contains('" + nomeNivel3 + "')").prop('selected', true);
                            $("#descritor_3").trigger('change');

                            $("#novo_descritor_4").val('');
                            $("#novo_descritor_4").focus();
                        }, 400);
                    }, 400);
                }
        );
    }
    $(document).ready(function() {
        $("button[type=reset]").on('click', function() {
            if ($('#inserir_novo_descritor_1').prop('checked'))
                $('#inserir_novo_descritor_1').trigger('click');
            if ($('#inserir_novo_descritor_2').prop('checked'))
                $('#inserir_novo_descritor_2').trigger('click');
            if ($('#inserir_novo_descritor_3').prop('checked'))
                $('#inserir_novo_descritor_3').trigger('click');
            setTimeout(function() {
                liberarCadastro();
            }, 200);
        });
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
        var cb_descritores = $(".cb_descritor");
        $.each(cb_descritores, function() {
            atualizar_combobox(this);
        });

        formularioAjax({successFn: configurarComboBox, resetarFormulario: false});

        $("#inserir_novo_descritor_1").tooltip({placement: 'top'});
        $("#inserir_novo_descritor_2").tooltip({placement: 'top'});
        $("#inserir_novo_descritor_3").tooltip({placement: 'top'});
        $("#inserir_novo_descritor_4").tooltip({placement: 'down'});
        varrerCampos();
    });
</script>