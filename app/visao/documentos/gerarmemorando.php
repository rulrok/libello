<title>Gerar Memorando</title>
<script src="publico/js/jquery/jquery-te-1.0.5.min.js" type="text/javascript"></script>
<script src="publico/js/documentos.js" type="text/javascript"></script>
<link href='publico/css/jquery-te-Style.css' rel='stylesheet' type="text/css"/>
<link href='publico/css/documentos.css' rel='stylesheet' type="text/css"/>
<script src="biblioteca/tinymce/js/tinymce/jquery.tinymce.min.js"></script>
<script src="biblioteca/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">


    $(document).ready(function() {
        tinymce.init({selector: 'textarea',
            toolbar: "forecolor backcolor",
            tools: 'inserttable',
            skin: 'lightgray',
            plugins: 'contextmenu advlist directionality charmap preview visualblocks image table textcolor spellchecker link',
            contextmenu: "link image inserttable | cell row column deletetable | forecolor backcolor"
        });
        //$('html, body').animate({scrollTop: 0},'fast');
        varrerCampos();

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

        $('#ajaxForm *').on('keyup', function() {
            liberarCadastro();
        });

        $('.reset').on('click', function() {
            setTimeout(function() {


                $('#ajaxForm input').change();

            }, 50);
        });

        var documento_form = $('#documento_form');
        var posicao_doc = documento_form.position();
        var menu = $('#menu_documento');

        $('#menu_documento').css({left: (posicao_doc.left) + 'px', top: (posicao_doc.top + 300) + 'px'});
    });
</script>

<form  id="ajaxForm" name="form1" target="_blank" action='index.php?c=documentos&a=verificarnovomemorando' method="post">

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
                Mem. nº/Ano/CEAD - 
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
                Em <?php echo $this->comboDia ?> de <?php echo $this->comboMes ?> de <?php echo date("Y"); ?>
            </td>
        </tr>
        <tr height="40"><td></td></tr>
        <tr height="10">
            <td>
                <input type="text" id="tratamento" name="tratamento" size="15"/><span class="classeExemploOficio"> Ex: Ao Sr.</span>
            </td>
        </tr>                                
        <tr height="10">
            <td>
                <input type="text" id="cargo_destino" name="cargo_destino"  size="40"/><span class="classeExemploOficio"> Ex: Chefe do departamento de Administração</span>
            </td>
        </tr>
        <tr height="40"><td></td></tr>
        <tr height="30">
            <td>
                Assunto: <input type="text" id="assunto" name="assunto"  size="50"/><span class="classeExemploOficio"> Ex: Administração. Instalação de microcomputadores </span>
            </td>
        </tr>
        <tr height="40"><td></td></tr>
        <tr height="30">
            <td align="left">
                <div style="text-align: none;">
                    <textarea  id="corpo" name="corpo" ></textarea>
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

        <tr height="200"><td>
                <div id="div_remetente1" name="div_remetente1">
                    <table>
                        <tr height="20">
                            <td align="center">
                                <span>____________________________________</span>
                            </td>
                        </tr>
                        <tr height="20">
                            <td align="center">
                                <input type="text" id="remetente" name="remetente"  size="50" style="margin-left: 125px"/><span class="classeExemploOficio"> Ex: Prof. Dr. Gabriel G... </span>
                            </td>
                        </tr>
                        <tr height="20">
                            <td align="center">
                                <input type="text" id="cargo_remetente" name="cargo_remetente"  size="25" style="margin-left: 110px"/><span class="classeExemploOficio"> Ex: Coordenador CEAD</span>
                            </td>
                            <td>
                                <a id="add_rem" title="Adicionar Remetente" href="javascript:void(0);" value="" onclick="adicionarRemetente();" class="btn" >
                                    <i class="icon-plus"></i>
                                </a>
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
                                <input type="text" id="remetente2" name="remetente2"  size="50" style="margin-left: 125px"/><span class="classeExemploOficio"> Ex: Prof. Dr. Gabriel G... </span>
                            </td>
                        </tr>
                        <tr height="20">
                            <td align="center">
                                <input type="text" id="cargo_remetente2" name="cargo_remetente2"  size="25" style="margin-left: 110px"/><span class="classeExemploOficio"> Ex: Coordenador CEAD</span>
                            </td>
                            <td>
                                <a  title="Remover Remetente" href="javascript:void(0);" value="" onclick="removerRemetente();" class="btn" >
                                    <i class="icon-minus"></i>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </td></tr>
        <tr height="80"><td></td></tr>
    </table>
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
