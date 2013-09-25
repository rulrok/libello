<title>Nova viagem</title>
<!-- Início da página -->
<style>
    .ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
    .ui-timepicker-div dl { text-align: left; }
    .ui-timepicker-div dl dt { float: left; clear:left; padding: 0 0 0 5px; }
    .ui-timepicker-div dl dd { margin: 0 10px 10px 40%; }
    .ui-timepicker-div td { font-size: 90%; }
    .ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }

    .ui-timepicker-rtl{ direction: rtl; }
    .ui-timepicker-rtl dl { text-align: right; padding: 0 5px 0 0; }
    .ui-timepicker-rtl dl dt{ float: right; clear: right; }
    .ui-timepicker-rtl dl dd { margin: 0 40% 10px 10px; }
</style>
<form class="table centered" id="ajaxForm" method="post" action="index.php?c=viagens&a=verificarnova">
    <fieldset>
        <legend>Dados da viagem</legend>
        <p class="centered centeredText boldedText">Campos com <img src="publico/imagens/icones/campo_obrigatorio.png"> são obrigatórios</label>
        <div class="line">
            <label for='curso'>Curso vinculado</label>
            <?php echo $this->cursos ?>
        </div>
        <div class="line" for='polo'>
            <label>Polo destino</label>
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
            <input type="number" min="0.5" step="0.5" id="diarias" class=" input-large" name="diarias" value='0.5' title='Quantidade de diárias' data-content="Valores como 0.5, 1, 1.5, 2, 2.5 etc">
        </div>
        <hr>
        <fieldset>
            <legend>Passageiros</legend>
            <div class="line" style='display: table'>
                <!--<label for='nome'>Passageiros</label>-->
                <?php echo $this->passageiros ?>
                <div class='btn-toolbar' style='display: table-cell'>
                    <div class='btn-group-vertical' style="display: inline-block;">
                        <a type="button" class="btn" id="add" ><i class='icon-arrow-right'></i></a>
                        <a type="button" class="btn disabled" ><i class=''></i></a>
                        <a type="button" class="btn" id="rem"><i class='icon-arrow-left'></i></a>
                    </div>
                </div>
                <select required size="7" multiple="multiple" class="passageiros selecaoPassageiros" name="passageiros[]" style='display: table-cell'>
                </select>
            </div>
            <div class='alert alert-info' style="margin: 0">
                <span class='label label-info'>Dica </span> &nbsp;&nbsp;Você pode escolher vários passageiros ao mesmo tempo segurando CTRL
                <a class="close" data-dismiss="alert" href="#">&times;</a>
            </div>
        </fieldset>
    </fieldset>
    <input class="btn btn-large" type="reset" value="Limpar">
    <input class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit" value="Cadastrar">

</form>
<script src='publico/js/jquery/jquery-ui-timepicker-addon.js' type='text/javascript'></script>

<script>
    $(document).ready(function() {
        b();
        $('#add').click(function() {
            $('.passageirosPossiveis option:selected').each(function() {
                $('.passageiros').append('<option selected="selected" value="' + $(this).val() + '">' + $(this).text() + '</option>');
                $(this).remove();
            });
        });

        $('#rem').click(function() {
            $('.passageiros option:selected').each(function() {
                $('.passageirosPossiveis').append('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
                $(this).remove();
                $(".passageiros option").each(function() {
                    $(this).attr({selected: 'selected'});
                });
            });
        });
        $(".line input").popover({trigger: 'focus', container: 'body'});
        varrerCampos();
        formularioAjax();
    });
</script>