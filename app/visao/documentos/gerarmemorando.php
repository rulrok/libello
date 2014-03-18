<title>Gerar Memorando</title>
<script src="publico/js/jquery/jquery-te-1.0.5.min.js" type="text/javascript"></script>
<script src="publico/js/documentos.js" type="text/javascript"></script>
<link href='publico/css/jquery-te-Style.css' rel='stylesheet' type="text/css"/>
<link href='publico/css/documentos.css' rel='stylesheet' type="text/css"/>
<script src="biblioteca/tinymce/js/tinymce/jquery.tinymce.min.js"></script>
<script src="biblioteca/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">


    $(document).ready(function() {
       
       Form.instancia.iniciarForm();
       

        $('#b_gerar').on('click', function() {
            bloqueia();
            if (confirm('Atenção, o memorando será gerado e registrado permanentemente! Tem certeza?')) {
                formularioAjax(undefined, undefined, null, function(i) {
                    window.open('index.php?c=documentos&a=visualizarMemorando&idv=' + i.id, '_blank');
                    document.paginaAlterada = false;
                    document.location.reload();
                });

                capturaNumMemorando();
            }
            desbloqueia();
        });

        $('#b_salvar').on('click', function() {
            bloqueia();
            if (confirm('Atenção, o memorando será salvo! Tem certeza?')) {
                formularioAjax(undefined, undefined, null, function(i) {
                    document.paginaAlterada = false;
                });
                $('#i_numMemorando').val('-1');
                $('#ajaxForm').submit();

            }

            desbloqueia();
        });

       
    });
</script>

<form  id="ajaxForm" name="form1" target="_blank" action='index.php?c=documentos&a=verificarnovomemorando' method="post">
<div id="documento_form" style='' border="0" align="center">
        <div style="position: relative;padding:50px 90px;padding-bottom: 120px;">
            <img id="cabecalho" style="" src="publico/imagens/oficio/cabecalho.jpg" />
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
                <input type="text" required id="tratamento" name="tratamento" onkeyup="liberarCadastro()" size="15"/><span class="classeExemploOficio"> Ex: Ao Sr.</span>
            </div>
            <div  class="left_align">
                <input type="text" required id="cargo_destino" name="cargo_destino" onkeyup="liberarCadastro()" size="40"/><span class="classeExemploOficio"> Ex: Chefe do departamento de Administração</span>
            </div>
            <div id="assunto_div" class="left_align">
                Assunto: <input type="text" required id="assunto" name="assunto" onkeyup="liberarCadastro()" size="50"/><span class="classeExemploOficio"> Ex: Administração. Instalação de microcomputadores </span>
            </div>
            <div id="corpo_div" >
                <textarea style="" id="corpo" value="" name="corpo" ></textarea>
            </div>
            <div style="margin-bottom: 80px;" class="left_align">
                Atenciosamente,
            </div>
            <div id='remetentes_holder'>
                
            </div>
<!--            <div id="div_remetente1" class="remetente_div" name="div_remetente1">

                <p>______________________________________</p>
                <div style="padding-left: 152px;margin-bottom: 2px">
                    <input type="text" required id="remetente" name="remetente" onkeyup="liberarCadastro()" size="50" /><span class="classeExemploOficio"> Ex: Prof. Dr. Gabriel G... </span>
                </div>
                <div style="padding-left: 193px;">
                    <input type="text" required id="cargo_remetente" name="cargo_remetente" onkeyup="liberarCadastro()" size="25" /><span class="classeExemploOficio"> Ex: Coordenador CEAD</span>
                    <a title="Adicionar Remetente" id=""  onclick="new Form().adicionarRemetente();" class="btn" href="javascript:void(0);" ><i class="icon-plus"></i></a>
                </div>
            </div>
            <br></br>
            <div id="div_remetente2" name="div_remetente2" style="display:none;">
                <span>____________________________________</span>
                <input type="text" id="remetente2" name="remetente2" onkeyup="liberarCadastro()" size="50" style="margin-left: 125px"/><span class="classeExemploOficio"> Ex: Prof. Dr. Gabriel G... </span>
                <input type="text" id="cargo_remetente2" name="cargo_remetente2" onkeyup="liberarCadastro()" size="25" style="margin-left: 110px"/><span class="classeExemploOficio"> Ex: Coordenador CEAD</span>
                <a  title="Remover Remetente" id="" href="javascript:void(0);" onclick="removerRemetente();" class="btn" ><i class="icon-minus"></i></a>
            </div>-->
        </div>
    </div>
    
    <div id="menu_documento" >
        <h5>Memorando</h5>
        <div><button  class="btn reset" id="b_limpar" title="limpar" type="reset"><i class="icon-erase"></i></button></div>
        <div><button class="btn" type="button" title="Salvar Rascunho" disabled="true" name="b_salvar" id="b_salvar" ><i class="icon-save"></i></button></div>
        <div><button  class="btn" type="button" title="Gerar documento" disabled="true" name="b_gerar" id="b_gerar" ><i class="icon-gerar"></i></button></div>
    </div>
    <input type="hidden" name="i_numMemorando" value="-1" id="i_numMemorando"/>
    <input type="hidden" name="i_remetente" id="i_remetente" value="0"/>
    <button type="submit" id="b_submit" style="display: none;"></button>


</form>
