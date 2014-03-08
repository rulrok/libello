<title>Editar Memorando</title>

<script src="publico/js/jquery/jquery-te-1.0.5.min.js" type="text/javascript"></script>
<link href='publico/css/jquery-te-Style.css' rel='stylesheet' type="text/css"/>
<link href='publico/css/documentos.css' rel='stylesheet' type="text/css"/>
<script src="biblioteca/tinymce/js/tinymce/jquery.tinymce.min.js"></script>
<script src="biblioteca/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="publico/js/documentos.js" type="text/javascript"></script>
<script type="text/javascript">

    $(document).ready(function() {
        Form.instancia.iniciarForm();
        
        $('#b_gerar').on('click', function() {
            bloqueia();
            if (confirm('Atenção, o memorando será gerado e registrado permanentemente! Tem certeza?')) {
                formularioAjax(undefined, undefined, null, function(i) {
                    window.open('index.php?c=documentos&a=visualizarMemorando&idv=' + i.id, '_blank');
                    document.paginaAlterada = false;
                    document.location.hash = '#!documentos|gerarMemorando';
                });

                capturaNumOficio();
            }
            desbloqueia();
        });

        $('#b_salvar').on('click', function() {
            bloqueia();
            if (confirm('Atenção, o rascunho do memorando será salvo! Tem certeza?')) {
                formularioAjax(undefined, undefined, null, function(i) {
                    document.paginaAlterada = false;
                    document.location.hash = '#!documentos|gerarMemorando';
                });
                $('#i_numMemorando').val('-1');
                $('#b_submit').click();

            }

            desbloqueia();
        });
        
        var sigla = $("#i_sigla");
        $("#sigla").val(sigla.val());
        liberarCadastro();
    });

</script>
<form id="ajaxForm" name="form1" method="post" action='index.php?c=documentos&a=verificaratualizacaomemorando' target="_blank" >


    <div id="documento_form" style='' border="0" align="center">
        <div style="position: relative;padding:50px 90px;padding-bottom: 120px;">
            <img id="cabecalho" style="" src="publico/imagens/oficio/cabecalho.jpg" />
            <div class="left_align" style="">
                Memorando nº/Ano/CEAD -
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
                <input type="text" required id="tratamento" value="<?php echo $this->tratamento; ?>" name="tratamento"  size="15"/><span class="classeExemploOficio"> Ex: Ao Sr.</span>
            </div>
            <div  class="left_align">
                <input type="text" required id="cargo_destino"  value="<?php echo $this->cargo_destino; ?>"  name="cargo_destino"  size="40"/><span class="classeExemploOficio"> Ex: Reitor da Universidade Federal de Alfenas</span>
            </div>
            <div id="assunto_div" class="left_align">
                Assunto: <input type="text" required id="assunto" value="<?php echo $this->assunto; ?>"  name="assunto" size="50"/><span class="classeExemploOficio"> Ex: Indicação de nome para... </span>
            </div>
            <div id="corpo_div" >
                <textarea style="" id="corpo" value=""  name="corpo" ><?php echo $this->corpo; ?></textarea>
            </div>
            <div style="margin-bottom: 80px;" class="left_align">
                Atenciosamente,
            </div>
            <div id='remetentes_holder'>

            </div>
        </div>
    </div>
    <div id="menu_documento" style="">
        <h4>Memorando</h4>
        <div><button  class="btn reset" id="b_limpar" title="limpar" type="reset"><i class="icon-erase"></i></button></div>
        <div><button class="btn" type="button" title="Salvar Rascunho" disabled="true" name="b_salvar" id="b_salvar" ><i class="icon-save"></i></button></div>
        <div><button  class="btn" type="button" title="Gerar documento" disabled="true" name="b_gerar" id="b_gerar" ><i class="icon-gerar"></i></button></div>
<!--                                        <input type="button" class="btn" value="Voltar" name="b_voltar" name="b_voltar" onclick=""/>-->
    </div>            

    <input type="hidden" name="i_numMemorando" id="i_numMemorando" value='-1'/>
    <input type="hidden" name="remetente" id="remetente" value="<?php echo($this->remetente); ?>"/>
    <input type="hidden" name="cargo_remetente" id="cargo_remetente" value="<?php echo($this->cargo_remetente); ?>"/>
    <input type="hidden" name="i_sigla" id="i_sigla" value="<?php echo($this->sigla); ?>"/>
    <input type="hidden" name="i_idmemorando" id="i_idmemorando" value="<?php echo $this->idmemorando; ?>"/>
    <button type="submit" id="b_submit" style="display: none;"></button>
</form>
