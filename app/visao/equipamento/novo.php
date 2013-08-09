<?php if (isset($this->mensagem_usuario) && $this->mensagem_usuario !== null) :
    ?>
    <script>
        showPopUp(
    <?php echo "\"" . $this->mensagem_usuario . "\""; ?>
        ,<?php echo "\"" . $this->tipo_mensagem . "\"" ?>
        );
    </script>
    <?php
    unset($this->mensagem_usuario);
endif;
if ($_SERVER['REQUEST_METHOD'] == 'POST') :
    $controlador = new ControladorEquipamento();
    $controlador->acaoNovo();
else:
    ?>
    <!--Início da página -->
    <script src="publico/js/jquery/jquery.form.js"></script>
    <script src="publico/js/ajaxForms.js"></script> 

    <form class="table centered" id="ajaxForm" method="post" action="index.php?c=equipamento&a=novo">
        <fieldset>
            <legend>Registro de novo equipamento</legend>
            <span class="line">
                <label>Equipamento</label>
                <input required type="text" class="input-xlarge" id="equipamento" name="equipamento" value="<?php echo $this->equipamento ?>" />
            </span>
            <div class="line">
                <label>Data de entrada</label>
                <input type="text" readonly id="dataEntrada" class="campoData" name="dataEntrada" value="<?php echo $this->dataEntrada ?>" >
            </div>
            <span class="line">
                <label>Quantidade</label>
                <input required type="text" class="input-medium" id="quantidade" name="quantidade" value="<?php echo $this->quantidade ?>" />
            </span>
            <div class="line">
                <label>Tipo</label>
                <select required id="tipoPatrimonio" name="tipoPatrimonio">
                    <option value="default">-- Escolha uma opção --</option>
                    <option value="custeio">Custeio</option>
                    <option value="permanente">Permanente</option>
                </select>
            </div>
            <span class="line">
                <label>Patrimônio</label>
                <input disabled="true" type="text" class="input-medium" id="patrimonio" name="patrimonio" value="<?php echo $this->quantidade ?>" />
            </span>
        </fieldset>
        <input class="btn btn-large" type="reset" value="Limpar">
        <input class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit" value="Cadastrar">

    </form>

    <script src="publico/js/validarCampos.js"></script>
    <script src="publico/js/cidades-estados.js"></script>
    <script>
        $(function() {
            $("#dataEntrada").datepick();
        });
        
        $("#tipoPatrimonio").on("change",function(){
            var value = $("#tipoPatrimonio").val();
            console.debug(value);
            if (value !== "permanente"){
                $("#patrimonio").attr({required:"true"});
                $("#obrigatorio").remove();
            } else {
                $("#patrimonio").removeAttr({required:"true"});
                $("#patrimonio").removeClass("campoErrado");
                $("#patrimonio").after("<img id=\"obrigatorio\" src=\"publico/imagens/icones/campo_obrigatorio.png\">");
            }
        })
    </script>
<?php
endif;
?>