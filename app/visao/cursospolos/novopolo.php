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
    $controlador = new ControladorCursospolos();
    $controlador->acaoVerificarNovoPolo();
else:
    ?>
    <!--Início da página -->
    <script src="publico/js/jquery/jquery.form.js"></script>
    <script src="publico/js/ajaxForms.js"></script> 
    <form class="table centered" id="ajaxForm" method="post" action="index.php?c=cursospolos&a=novopolo">
        <fieldset>
            <legend>Inserir novo polo</legend>
            <span class="line">
                <label>Nome</label>
                <input required type="text" class="input-xlarge" id="nomepolo" name="nomepolo" value="<?php echo $this->nome; ?>" />
            </span>
            <span class="line">
                <label>Estado</label>
                <select required class="input-large" id="estado" name="estado"></select>
            </span>
            <span class="line">
                <label>Cidade</label>
                <select required class="input-xlarge" id="cidade" name="cidade"></select>
            </span>
        </fieldset>
        <input class="btn btn-large" type="reset" value="Limpar" onclick="$('#estado').val(0);
            liberarCadastro();">
        <input class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit" value="Cadastrar">
    </form>


    <script src="publico/js/cidades-estados.js"></script>
    <script>
        $(document).ready(function() {
            new dgCidadesEstados({
                cidade: $('#cidade').get(0),
                estado: $('#estado').get(0)
            });
        });
        
        $('#estado').val("<?php echo $this->estado ?>");
        $('#estado').change();
        $('#cidade').val("<?php echo $this->cidade ?>");
    </script>
    <script src="publico/js/validarCampos.js"></script>
<?php
endif;
?>