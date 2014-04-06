<title>Oficio</title>
<script src="publico/js/documentos.js" type="text/javascript"></script>
<script src="biblioteca/tinymce/js/tinymce/jquery.tinymce.min.js"></script>
<script src="biblioteca/tinymce/js/tinymce/tinymce.min.js"></script>
<link href='publico/css/documentos.css' rel='stylesheet' type="text/css"/>

<form id="ajaxForm" name="form1" method="post" action='index.php?c=documentos&a=verificarnovooficio' target="_blank" >
    <div id="documento_form" style='' border="0" align="center">
        <div style="position: relative;">
            <img id="cabecalho" style="" src="publico/imagens/cabecalho-documentos/cabecalho.jpg" />
            <div class="left_align" style="">
                Ofício nº/Ano/CEAD -
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
                <input type="text" required id="tratamento" value="<?php echo $this->tratamento; ?>" name="tratamento" onkeyup="liberarCadastro()" size="15"/><span class="classeExemploOficio"> Ex: Ao Sr.</span>
            </div>
            <div class="left_align">
                <input type="text" required id="destino" value="<?php echo $this->destino; ?>" name="destino" onkeyup="liberarCadastro()" size="30"/><span class="classeExemploOficio"> Ex: Paulo Márcio de Faria e Silva</span>
            </div>
            <div  class="left_align">
                <input type="text" required id="cargo_destino"  value="<?php echo $this->cargo_destino; ?>"  name="cargo_destino" onkeyup="liberarCadastro()" size="40"/><span class="classeExemploOficio"> Ex: Reitor da Universidade Federal de Alfenas</span>
            </div>
            <div id="assunto_div" class="left_align">
                Assunto: <input type="text" required id="assunto" value="<?php echo $this->assunto; ?>"  name="assunto" onkeyup="liberarCadastro()" size="50"/><span class="classeExemploOficio"> Ex: Indicação de nome para... </span>
            </div>
            <div class="left_align">
                <input type="text" required id="referencia" value="<?php echo $this->referencia; ?>"  name="referencia" onkeyup="liberarCadastro()" size="25"/><span class="classeExemploOficio"> Ex: Magnífico Reitor, </span>
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
    <div id="menu_documento" style="">
        <h4>Ofício</h4>
        <div><button  class="btn reset" id="b_limpar" title="limpar" type="reset"><i class="icon-erase"></i></button></div>
        <div><button class="btn" type="button" title="Salvar Rascunho" disabled="true" name="b_salvar" id="b_salvar" ><i class="icon-save"></i></button></div>
        <div><button  class="btn" type="button" title="Gerar documento" disabled="true" name="b_gerar" id="b_gerar" ><i class="icon-gerar"></i></button></div>
<!--                                        <input type="button" class="btn" value="Voltar" name="b_voltar" name="b_voltar" onclick=""/>-->
    </div>            

    <input type="hidden" name="i_numOficio" id="i_numOficio" value='-1'/>
    <input type="hidden" name="remetente" id="remetente" value="<?php echo($this->remetente); ?>"/>
    <input type="hidden" name="cargo_remetente" id="cargo_remetente" value="<?php echo($this->cargo_remetente); ?>"/>
    <input type="hidden" name="i_sigla" id="i_sigla" value="<?php echo($this->sigla); ?>"/>
    <input type="hidden" name="i_idoficio" id="i_idoficio" value="<?php echo $this->idoficio; ?>"/>
    <input type="hidden" name="nada" id="acao" value="<?php echo $this->action; ?>"/>
</form>           

<script type="text/javascript">
    $(document).ready(function() {
        FormDocumentos.instancia.iniciarForm();
        formularioAjax(undefined, undefined, null, function(i) {
            if (i.documento != undefined) {
                window.open('index.php?c=documentos&a=visualizarOficio&idv=' + i.id, '_blank');
                $('[type=reset]').click();
                if (document.location.hash != '#!documentos|oficio') {
                    document.ignorarHashChange = true;
                    document.location.hash = '#!documentos|oficio';
                }
                $('#acao').val('gerar');
                $('#i_idoficio').val('<?php echo fnEncrypt(-1); ?>');
            } else {
                if ($('#acao').val() != "editar") {
                    document.ignorarHashChange = true;
                    document.location.hash = '#!documentos|oficio&id=' + i.id;
                    $('#acao').val('editar');
                    $('#i_idoficio').val(i.id);
                }
            }
        }, null, false);

        $('#b_gerar').on('click', function() {
            bloqueia();
            if (confirm('Atenção, o ofício será gerado e registrado permanentemente! Tem certeza?')) {
                capturaNumOficio();
            }
            desbloqueia();
        });

        $('#b_salvar').on('click', function() {
            bloqueia();
            if (confirm('Atenção, o rascunho do ofício será salvo! Tem certeza?')) {

                concatenarAssinaturas();
                $('#i_numOficio').val('-1');
                $('#ajaxForm').submit();
            }
            desbloqueia();
        });

        var sigla = $("#i_sigla");
        $("#sigla").val(sigla.val());
        liberarCadastro();

    });

</script>