<title>Gerar Oficio</title>
<script src="publico/js/jquery/jquery-te-1.0.5.min.js" type="text/javascript"></script>
<script src="publico/js/documentos.js" type="text/javascript"></script>
<link href='publico/css/jquery-te-Style.css' rel='stylesheet' type="text/css"/>
<link href='publico/css/documentos.css' rel='stylesheet' type="text/css"/>
<script src="biblioteca/tinymce/js/tinymce/jquery.tinymce.min.js"></script>
<script src="biblioteca/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">

   

    $(document).ready(function() {
         tinymce.init({selector:'textarea', skin:'lightgray', plugins:'advlist image table textcolor spellchecker link'});
        //    $('html, body').animate({scrollTop: 0}, 'fast');
        varrerCampos();
        $('#b_gerar').on('click', function() {
            bloqueia();
            if (confirm('Atenção, o ofício será gerado e registrado permanentemente! Tem certeza?')) {
                formularioAjax(undefined, undefined, null, function(i) {
                    window.open('index.php?c=documentos&a=visualizarOficio&idv=' + i.id, '_blank');
                    document.paginaAlterada = false;
                    document.location.reload();
                });

                capturaNumOficio();
            }
            desbloqueia();
        });

        $('#b_salvar').on('click', function() {
            bloqueia();
            if (confirm('Atenção, o rascunho do ofício será salvo! Tem certeza?')) {
                formularioAjax(undefined, undefined, null, function(i) {
                    document.paginaAlterada = false;
                });
                $('#i_numOficio').val('-1');
                $('#ajaxForm').submit();

            }

            desbloqueia();
        });

        $('#ajaxForm input').on('change', function() {
            liberarCadastro();
            // alert('work'); 
        });
        $('.reset').on('click', function() {
            setTimeout(function() {


                $('#ajaxForm input').change();

            },50);
        });
        
        var documento_form = $('#documento_form');
        var posicao_doc = documento_form.position();
        var menu = $('#menu_documento');
        
        $('#menu_documento').css({left:(posicao_doc.left )+'px', top:(posicao_doc.top + 300)+'px'});
        $('#corpo').on('change',function(){
           $('#corpo').val('_'); 
        });
    });



</script>

<form id="ajaxForm" name="form1" method="post" action='index.php?c=documentos&a=verificarnovooficio' target="_blank" >
   

    <table id="documento_form" style='' border="0" align="center">
        <tr height="189">
            <td width="113" rowspan="20"></td>
            <td width="625" align="center">
                <img src="publico/imagens/oficio/cabecalho.jpg" />
            </td>
            <td width="56" rowspan="20"></td>
        </tr>
        <tr height="30">
            <td>
                Ofício nº/Ano/CEAD - 
                <select id='sigla' name='sigla'>
                    <option value='TEC'>TEC</option>
                    <option value='ADM'>ADM</option>
                    <option value='PED'>PED</option>
                </select>
                <span class="classeExemploOficio"> Sigla</span>
            </td>
        </tr>
        <tr height="30">
            <td align="right">
                Alfenas, <?php echo $this->comboDia; ?> de <?php echo $this->comboMes; ?> de <?php echo date("Y"); ?>
            </td>
        </tr>
        <tr height="40"><td></td></tr>
        <tr height="10">
            <td>
                <input type="text" required id="tratamento" name="tratamento" onkeyup="liberarCadastro()" size="15"/><span class="classeExemploOficio"> Ex: Ao Sr.</span>
            </td>
        </tr>
        <tr height="10">
            <td>
                <input type="text" required id="destino" name="destino" onkeyup="liberarCadastro()" size="30"/><span class="classeExemploOficio"> Ex: Paulo Márcio de Faria e Silva</span>
            </td>
        </tr>
        <tr height="10">
            <td>
                <input type="text" required id="cargo_destino" name="cargo_destino" onkeyup="liberarCadastro()" size="40"/><span class="classeExemploOficio"> Ex: Reitor da Universidade Federal de Alfenas</span>
            </td>
        </tr>
        <tr height="40"><td></td></tr>
        <tr height="30">
            <td>
                Assunto: <input type="text" required id="assunto" name="assunto" onkeyup="liberarCadastro()" size="50"/><span class="classeExemploOficio"> Ex: Indicação de nome para... </span>
            </td>
        </tr>
        <tr height="40"><td></td></tr>
        <tr height="30">
            <td align="left">
                <input type="text" required id="referencia" name="referencia" onkeyup="liberarCadastro()" size="25"/><span class="classeExemploOficio"> Ex: Magnífico Reitor, </span>
            </td>
        </tr>
        <tr height="40"><td></td></tr>
        <tr height="30">
            <td align="left">
                <div >
                    <textarea style="" id="corpo" value="" name="corpo" ></textarea>
                </div>
            </td>
        </tr>
        <tr height="40"><td></td></tr>
        <tr height="30">
            <td align="left">
                Atenciosamente,
            </td>
        </tr>
        <tr height="30"><td></td></tr>
        <tr height="200">
            <td>
                <div id="div_remetente1" name="div_remetente1">
                    <table>
                        <tr height="20">
                            <td align="center">
                                <span>____________________________________</span>
                            </td>
                        </tr>
                        <tr height="20">
                            <td align="center">
                                <input type="text" required id="remetente" name="remetente" onkeyup="liberarCadastro()" size="50" style="margin-left: 125px"/><span class="classeExemploOficio"> Ex: Prof. Dr. Gabriel G... </span>
                            </td>
                        </tr>
                        <tr height="20">
                            <td align="center">
                                <input type="text" required id="cargo_remetente" name="cargo_remetente" onkeyup="liberarCadastro()" size="25" style="margin-left: 110px"/><span class="classeExemploOficio"> Ex: Coordenador CEAD</span>
                            </td>
                            <td>
                                <a title="Adicionar Remetente" id=""  onclick="adicionarRemetente();" class="btn" href="javascript:void(0);" ><i class="icon-plus"></i></a>
                            </td>
                        </tr>
                    </table>
                </div>
                <br></br>
                <div id="div_remetente2" name="div_remetente2" style="display:none;">
                    <table>
                        <tr height="20">
                            <td align="center">
                                <span>____________________________________</span>
                            </td>
                        </tr>
                        <tr height="20">
                            <td align="center">
                                <input type="text" id="remetente2" name="remetente2" onkeyup="liberarCadastro()" size="50" style="margin-left: 125px"/><span class="classeExemploOficio"> Ex: Prof. Dr. Gabriel G... </span>
                            </td>
                        </tr>
                        <tr height="20">
                            <td align="center">
                                <input type="text" id="cargo_remetente2" name="cargo_remetente2" onkeyup="liberarCadastro()" size="25" style="margin-left: 110px"/><span class="classeExemploOficio"> Ex: Coordenador CEAD</span>
                            </td>
                            <td>
                                <a  title="Remover Remetente" id="" href="javascript:void(0);" onclick="removerRemetente();" class="btn" ><i class="icon-minus"></i></a>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr height="80"><td></td></tr>
    </table>
    <div id="menu_documento" style="">
        <h4>Ofício</h4>
        <div><button  class="btn reset" id="b_limpar" title="limpar" type="reset"><i class="icon-erase"></i></button></div>
        <div><button class="btn" title="Salvar Rascunho" disabled="true" name="b_salvar" id="b_salvar" ><i class="icon-save"></i></button></div>
        <div><button  class="btn" title="Gerar documento" disabled="true" name="b_gerar" id="b_gerar" ><i class="icon-gerar"></i></button></div>
<!--                                        <input type="button" class="btn" value="Voltar" name="b_voltar" name="b_voltar" onclick=""/>-->
    </div>            

    <input type="hidden" name="i_numOficio" id="i_numOficio" value='-1'/>
    <input type="hidden" name="i_remetente" id="i_remetente" value="0"/>

</form>
