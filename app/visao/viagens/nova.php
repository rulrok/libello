<title>Nova viagem</title>
<!-- Início da página -->
<form class="tabela centralizado" id="ajaxForm" method="post" action="index.php?c=viagens&a=verificarnova">
    <fieldset>
        <legend>Dados da viagem</legend>
        <div class="line">
            <label for='curso'>Curso vinculado</label>
            <select required class="input-large" id="curso" name="curso">
                <?php echo $this->cursos; ?>
            </select>
        </div>
        <div class="line" >
            <label for='polo'>Polo destino</label>
            <select required class="input-large" id="polo" name="polo">
                <?php echo $this->polos; ?>
            </select>
        </div>
        <div class="line">
            <label for="responsavel">Responsável</label>
            <select required size="7" class="input-xxxlarge" id="responsavel" name="responsavel">
                <?php echo $this->usuarios; ?>
            </select>
        </div>
        <hr>
        <div class="line">
            <label for='dataIda'>Data ida</label>
            <input type="text" readonly required id="dataIda" class=" input-large campoData" placeholder="Clique para escolher" name="dataIda" >
            <label for='horaIda'>Hora ida</label>
            <input type="text" readonly required id="horaIda" class=" input-large campoHora" placeholder="Clique para escolher" name="horaIda" >
        </div>
        <div class="line">
            <label for='dataVolta'>Data volta</label>
            <input type="text" readonly required id="dataVolta" class=" input-large campoData" placeholder="Clique para escolher" name="dataVolta" >
            <label for='horaVolta'>Hora volta</label>
            <input type="text" readonly required id="horaVolta" class=" input-large campoHora" placeholder="Clique para escolher" name="horaVolta"  >
        </div>
        <hr>
        <div class="line">
            <label for='motivo'>Motivo da viagem</label>
            <select required id="motivo" class="input-xlarge" name="motivo">
                <option value="default" selected>-- Escolha um motivo --</option>
                <option value="acompanhamento">Acompanhamento</option>
                <option value="aula">Aula</option>
                <option value="avaliação">Avaliação</option>
                <option value="revisão">Revisão</option>
                <option value="outro">Outro</option>
            </select>
        </div>
        <div class="line">
            <label for='estado'>Estado da viagem</label>
            <select required id="estado" class="input-xlarge" name="estado">
                <option value="default">-- Escolha uma opção --</option>
                <option value="planejada">Planejada</option>
            </select>
        </div>
        <div class="line">
            <label for='diarias'>Diárias</label>
            <input required type="number" min="0.5" step="0.5" id="diarias" class=" input-large" name="diarias"  title='Quantidade de diárias' data-content="Valores como 0.5, 1, 1.5, 2, 2.5 etc">
        </div>
        <hr>
        <fieldset>
            <legend>Passageiros</legend>
            <div class='alert alert-info'>
                <span class='label label-info'>Dica </span> Escolha vários passageiros ao mesmo tempo segurando a tecla <span class="badge" id="tecla"></span>
                <a class="close" data-dismiss="alert" href="#">&times;</a>
            </div>
            <div class="line" style='display: table'>
                <!--<label for='passageiros'>Passageiros</label>-->
                <select required multiple size="7" class="input-xxxlarge" id="passageiros" name="passageiros[]">
                    <?php echo $this->usuarios ?>
                </select>
            </div>
            <br/>
        </fieldset>
    </fieldset>
    <button class="btn btn-large" type="reset">Limpar</button>
    <button class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit">Cadastrar</button>

</form>
<script src='publico/js/datasComRange.js' type='text/javascript'></script>
<script>
    $(document).ready(function() {

        //Descobre o SO para exibir texto correto sobre tecla CTRL ou Command (Mac)
        var teclaSpan = document.getElementById("tecla");
        if (OSName === "MacOS") {
            var texto = document.createTextNode("Command " + String.fromCharCode(8984));
        } else {
            texto = document.createTextNode("CTRL");
        }
        teclaSpan.appendChild(texto);


        configurarCamposDataHora('#dataIda', '#dataVolta');
        varrerCampos();
        $("#responsavel").chosen({display_disabled_options: false, display_selected_options: true, inherit_select_classes: true, placeholder_text_multiple: "Selecione o responsavel pela viagem", width: "450px"});
        $("#passageiros").chosen({display_disabled_options: false, display_selected_options: false, inherit_select_classes: true, placeholder_text_multiple: "Selecione os passageiros", width: "750px"});
//        $("select").not("#passageiros").chosen();
//        $("div .line:has('select.campoErrado')").addClass("campoErrado")
//        
//        $('#add').click(function() {
//            $('.passageirosPossiveis option:selected').each(function() {
//                $('.passageiros').append('<option selected="selected" value="' + $(this).val() + '">' + $(this).text() + '</option>');
//                $(this).remove();
//            });
//        });
//
//        $('#rem').click(function() {
//            $('.passageiros option:selected').each(function() {
//                $('.passageirosPossiveis').append('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
//                $(this).remove();
//                $(".passageiros option").each(function() {
//                    $(this).prop({selected: 'selected'});
//                });
//            });
//        });
        $(".line input").popover({trigger: 'focus', container: 'body'});
        formularioAjax();

        $("button[type=reset]").bind("click", function() {
            $("select").val('').trigger("chosen:updated");
            $("div.chosen-container li.search-choice").remove();
            $("div.chosen-container li.search-field").addClass("default");
            setTimeout(function() {
                liberarCadastro();
            }, "200");
        });

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
                $($(".line")[1]).after("<div class='line'><label for='destinoManual'>Nome do destino</label><input type='text' required id='destinoManual' class='input-xlarge' name='destinoManual'/></div>")
                varrerCampos();
                document.viagens_campoDestinoAlternativo = true;
            } else if (document.viagens_campoDestinoAlternativo) {
                document.viagens_campoDestinoAlternativo = false;
                $($(".line")[2]).remove();
            }
        });
    });
</script>