<title>Gerar Memorando</title>
<script src="publico/js/documentos.js" type="text/javascript"></script>
<script src="biblioteca/tinymce/js/tinymce/jquery.tinymce.min.js"></script>
<script src="biblioteca/tinymce/js/tinymce/tinymce.min.js"></script>
<link href='publico/css/documentos.css' rel='stylesheet' type="text/css"/>

<form  id="ajaxForm" name="form1" target="_blank" action='index.php?c=documentos&a=verificarnovomemorando' method="post">
    <div id="documento_form" style='' border="0" align="center">
        <div style="position: relative;padding:50px 90px;padding-bottom: 120px;">
            <img id="cabecalho" style="" src="publico/imagens/cabecalho-documentos/cabecalho.jpg" />
            <div class="left_align" style="">
                Mem. nº/Ano/CEAD -
                <select id='sigla' name='sigla'>
                    <option value='TEC'>TEC</option>
                    <option value='ADM'>ADM</option>
                    <option value='PED'>PED</option>
                </select>
                <span class="classeExemploOficio"> Sigla</span>
            </div>
            <div id="data_div">
                Alfenas, <?php echo $this->comboDia; ?> de <?php echo $this->comboMes; ?> de <?php echo date("Y"); ?>
            </div>
            <div class="left_align">
                <input type="text" value="<?php echo $this->tratamento; ?>" required id="tratamento" name="tratamento" onkeyup="liberarCadastro()" size="15"/><span class="classeExemploOficio"> Ex: Ao Sr.</span>
            </div>
            <div  class="left_align">
                <input value="<?php echo $this->cargo_destino; ?>" type="text" required id="cargo_destino" name="cargo_destino" onkeyup="liberarCadastro()" size="40"/><span class="classeExemploOficio"> Ex: Chefe do departamento de Administração</span>
            </div>
            <div id="assunto_div" class="left_align">
                Assunto: <input type="text" value="<?php echo $this->assunto; ?>" required id="assunto" name="assunto" onkeyup="liberarCadastro()" size="50"/><span class="classeExemploOficio"> Ex: Administração. Instalação de microcomputadores </span>
            </div>
            <div id="corpo_div" >
                <textarea style="" id="corpo" value="" name="corpo" ><?php echo $this->corpo; ?></textarea>
            </div>
            <div style="margin-bottom: 80px;" class="left_align">
                Atenciosamente,
            </div>
            <div id='remetentes_holder'>

            </div>

        </div>
    </div>

    <div id="menu_documento" >
        <h5>Memorando</h5>
        <div><button  class="btn reset" id="b_limpar" title="limpar" type="reset"><i class="icon-erase"></i></button></div>
        <div><button class="btn" type="button" title="Salvar Rascunho" disabled="true" name="b_salvar" id="b_salvar" ><i class="icon-save"></i></button></div>
        <div><button  class="btn" type="button" title="Gerar documento" disabled="true" name="b_gerar" id="b_gerar" ><i class="icon-gerar"></i></button></div>
    </div>
    <input id='remetente' value="<?php echo $this->remetente; ?>" type='hidden' name='remetente' />
    <input id='cargo_remetente' value="<?php echo $this->cargo_remetente; ?>" type='hidden' name='cargo_remetente'/>
    <input type="hidden" name="i_numMemorando" value="-1" id="i_numMemorando"/>
    <input type="hidden" name="i_sigla" id="i_sigla" value="<?php echo($this->sigla); ?>"/>
    <input type="hidden" name="i_idmemorando" id="i_idmemorando" value="<?php echo $this->idmemorando; ?>"/>
    <input type="hidden" name="nada" id="acao" value="<?php echo $this->action; ?>"/>


</form>

<script type="text/javascript">
    $(document).ready(function() {

        FormDocumentos.instancia.iniciarForm();
        formularioAjax(undefined, undefined, null, function(i) {
            if (i.documento != undefined) {
                window.open('index.php?c=documentos&a=visualizarMemorando&idv=' + i.id, '_blank');
                $('[type=reset]').click();
                if (document.location.hash != '#!documentos|memorando'){
                    document.ignorarHashChange = true;
                    document.location.hash = '#!documentos|memorando';
                }
                $('#acao').val('gerar');
                $('#i_idmemorando').val('<?php echo fnEncrypt(-1); ?>');
            }
            else {
                if ($('#acao').val() != "editar") {
                    document.ignorarHashChange = true;
                    document.location.hash = '#!documentos|memorando&id=' + i.id;
                    $('#acao').val('editar');
                    $('#i_idmemorando').val(i.id);
                }
            }
        }, null, false);

        $('#b_gerar').on('click', function() {
            bloqueia();
            if (confirm('Atenção, o memorando será gerado e registrado permanentemente! Tem certeza?')) {
                capturaNumMemorando();
            }
            desbloqueia();
        });

        $('#b_salvar').on('click', function() {
            bloqueia();
            if (confirm('Atenção, o memorando será salvo! Tem certeza?')) {
                concatenarAssinaturas();
                $('#i_numMemorando').val('-1');
                $('#ajaxForm').submit();
            }
            desbloqueia();
        });

        var sigla = $("#i_sigla");
        $("#sigla").val(sigla.val());
        liberarCadastro();

    });
</script>