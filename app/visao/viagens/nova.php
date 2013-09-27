<title>Nova viagem</title>
<!-- Início da página -->
<form class="table centered" id="ajaxForm" method="post" action="index.php?c=viagens&a=verificarnova">
    <fieldset>
        <legend>Dados da viagem</legend>
        <p class="centered centeredText boldedText">Campos com <img src="publico/imagens/icones/campo_obrigatorio.png"> são obrigatórios</label>
        <div class="line">
            <label for='curso'>Curso vinculado</label>
            <?php echo $this->cursos ?>
        </div>
        <div class="line" >
            <label for='polo'>Polo destino</label>
            <?php echo $this->polos ?>
        </div>
        <hr>
        <div class="line">
            <label for='dataIda'>Data ida</label>
            <input type="text" readonly required id="dataIda" class=" input-large campoData" placeholder="Clique para escolher" name="dataIda" >
            <label for='horaIda'>Hora ida</label>
            <input type="text" readonly required id="horaIda" class=" input-large campoHora" placeholder="Clique para escolher" name="horaIda" value='00:00'>
        </div>
        <div class="line">
            <label for='dataVolta'>Data volta</label>
            <input type="text" readonly required id="dataVolta" class=" input-large campoData" placeholder="Clique para escolher" name="dataVolta" >
            <label for='horaVolta'>Hora volta</label>
            <input type="text" readonly required id="horaVolta" class=" input-large campoHora" placeholder="Clique para escolher" name="horaVolta" value='00:00' >
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
                <option value="planejada">Planejada</option>
            </select>
        </div>
        <div class="line">
            <label for='diarias'>Diárias</label>
            <input required type="number" min="0.5" step="0.5" id="diarias" class=" input-large" name="diarias" value='0.5' title='Quantidade de diárias' data-content="Valores como 0.5, 1, 1.5, 2, 2.5 etc">
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
                <?php echo $this->passageiros ?>
            </div>
            <br/>
        </fieldset>
    </fieldset>
    <input class="btn btn-large" type="reset" value="Limpar">
    <input class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit" value="Cadastrar">

</form>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<script src='publico/js/jquery/jquery-ui-timepicker-addon.js' type='text/javascript'></script>

<script>
    $(document).ready(function() {

//        var tecla = document.createElement("p");
        var teclaSpan = document.getElementById("tecla");
        if (OSName === "MacOS") {
            var texto = document.createTextNode("Command " + String.fromCharCode(8984));
        } else {
            texto = document.createTextNode("CTRL");
        }
        teclaSpan.appendChild(texto);
        b();
        varrerCampos();
        $("#passageiros").chosen({display_disabled_options: false, display_selected_options: false, placeholder_text_multiple: "Selecione os passageiros", width: "650px"});
        $("select").not("#passageiros").chosen();
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
//                    $(this).attr({selected: 'selected'});
//                });
//            });
//        });
        $(".line input").popover({trigger: 'focus', container: 'body'});
        formularioAjax();

        $("input[type=reset]").bind("click", function() {
            $("select").val('').trigger("chosen:updated");
        });
    });
</script>