
<script src="publico/js/jquery/jquery-te-1.0.5.min.js" type="text/javascript"></script>
<link href='publico/css/jquery-te-Style.css' rel='stylesheet' type="text/css"/>
<script type="text/javascript">

    $(document).ready(function() {
        $("#corpo").jqte();
        if ($("#remetente2").val() != "" && $("#cargo_remetente2").val() != "") {
            $("#div_remetente2").show();
            $("#add_rem").hide();
            $("#i_remetente").val("1");
        }
        var sigla = $("#i_sigla");
        $("#sigla").val(sigla.val());
        varrerCampos();
    });

    function confirmaAcao(acao) {
      bloqueia();
        if (acao == 'gerar') {
            $('#ajaxForm').attr('target', '_blank');
            formularioAjax(undefined, undefined, null, function(i) {
                window.open('app/modelo/documentos/visualizarOficio.php?idv='+i.id, '_blank');
                document.paginaAlterada = false;
                        document.location.hash='#!documentos|aproveitarOficio&id='+i.id;
            });
            var conf = confirm('Atenção, o ofício será gerado e registrado permanentemente! Tem certeza?');
            if (conf) {
                capturaNumOficio();
            }
            desbloqueia();
        } else {
            if (acao == 'salvar') {
                formularioAjax(undefined, undefined,null,function(i){
                    document.paginaAlterada = false;
                        document.location.reload();
                });
                var conf = confirm('Atenção, o ofício será salvo! Tem certeza?');
                if (conf) {
                    $('#i_numOficio').val('-1');
                    $('#ajaxForm').submit();
                }
                desbloqueia();
            }
        }
    }

    function bloqueia() {
        $('#tratamento').attr({readonly: 'true'});
        $('#destino').attr({readonly: 'true'});
        $('#cargo_destino').attr({readonly: 'true'});
        $('#assunto').attr({readonly: 'true'});
        $('#referencia').attr({readonly: 'true'});
        $('#corpo').attr({readonly: 'true'});
        $('#remetente').attr({readonly: 'true'});
        $('#cargo_remetente').attr({readonly: 'true'});
        if ($('#i_remetente').val() == "1") {
            $('#remetente2').attr({readonly: 'true'});
            $('#cargo_remetente2').attr({readonly: 'true'});
        }
        $('#b_gerar').attr({disabled: 'true'});
        $('#b_salvar').attr({disabled: 'true'});
        $('#b_voltar').attr({disabled: 'true'});
    }

    function desbloqueia() {
        $('#tratamento').removeAttr('readonly');
        $('#destino').removeAttr('readonly');
        $('#cargo_destino').removeAttr('readonly');
        $('#assunto').removeAttr('readonly');
        $('#referencia').removeAttr('readonly');
        $('#corpo').removeAttr('readonly');
        $('#remetente').removeAttr('readonly');
        $('#cargo_remetente').removeAttr('readonly');
        if ($('#i_remetente').val() == "0") {
            $('#remetente2').removeAttr('readonly');
            $('#cargo_remetente2').removeAttr('readonly');
        }
        $('#b_gerar').removeAttr('disabled');
        $('#b_salvar').removeAttr('disabled');
    }

    function liberarCadastro() {
        if ($('#i_remetente').val() == "0") {
            if (($('#tratamento').val() != '') && ($('#destino').val() != '') && ($('#cargo_destino').val() != '') && ($('#assunto').val() != '') && ($('#referencia').val() != '') && ($('#corpo').val() != '') && ($('#remetente').val() != '') && ($('#cargo_remetente').val() != '')) {
                $('#b_gerar').removeAttr('disabled');
                $('#b_salvar').removeAttr('disabled');
            }
            else if (($('#tratamento').val() == '') || ($('#destino').val() == '') || ($('#cargo_destino').val() == '') || ($('#assunto').val() == '') || ($('#referencia').val() == '') || ($('#corpo').val() == '') || ($('#remetente').val() == '') || ($('#cargo_remetente').val() == '')) {
                $('#b_gerar').attr({disabled: 'true'});
                $('#b_salvar').attr({disabled: 'true'});
            }
        }
        else if ($('#i_remetente').val() == "1") {
            if (($('#tratamento').val() != '') && ($('#destino').val() != '') && ($('#cargo_destino').val() != '') && ($('#assunto').val() != '') && ($('#referencia').val() != '') && ($('#corpo').val() != '') && ($('#remetente').val() != '') && ($('#cargo_remetente').val() != '') && ($('#remetente2').val() != '') && ($('#cargo_remetente2').val() != '')) {
                $('#b_gerar').removeAttr('disabled');
                $('#b_salvar').removeAttr('disabled');
            }
            else if (($('#tratamento').val() == '') || ($('#destino').val() == '') || ($('#cargo_destino').val() == '') || ($('#assunto').val() == '') || ($('#referencia').val() == '') || ($('#corpo').val() == '') || ($('#remetente').val() == '') || ($('#cargo_remetente').val() == '') || ($('#remetente2').val() == '') || ($('#cargo_remetente2').val() == '')) {
                $('#b_gerar').attr({disabled: 'true'});
                $('#b_salvar').attr({disabled: 'true'});
            }
        }
    }

    function capturaNumOficio() {

        $.getJSON('app/modelo/documentos/capturarNumDocumento.php', {valor: 1}, function(j) {
            $('#i_numOficio').val(j);

            $("#ajaxForm").submit();
            
        });
    }

    function adicionarRemetente() {
        $("#div_remetente2").show();
        $("#add_rem").hide();
        $("#i_remetente").val("1");
    }

    function removerRemetente() {
        $("#div_remetente2").hide();
        $("#add_rem").show();
        $("#i_remetente").val("0");
    }



</script>

<form id="ajaxForm" name="form1" action='index.php?c=documentos&a=verificaratualizacaooficio' method="post" target="_blank" >
    <table align="center">

        <tr>
            <td align="center" colspan="2">
                <h5>Ofício</h5>
            </td>
        </tr>
    </table>
    <table style='width: 794px; height: 1123px; font-family:"Times New Roman",Georgia,Serif; font-size: 15px; background-color: #FFF;' border="0" align="center">
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
                <input type="text" id="tratamento" name="tratamento" onkeyup="liberarCadastro()" value="<?php echo $this->tratamento; ?>" size="15"/><span class="classeExemploOficio"> Ex: Ao Sr.</span>
            </td>
        </tr>
        <tr height="10">
            <td>
                <input type="text" id="destino" name="destino" onkeyup="liberarCadastro()" value="<?php echo $this->destino; ?>" size="30"/><span class="classeExemploOficio"> Ex: Paulo Márcio de Faria e Silva</span>
            </td>
        </tr>
        <tr height="10">
            <td>
                <input type="text" id="cargo_destino" name="cargo_destino" onkeyup="liberarCadastro()" value="<?php echo $this->cargo_destino; ?>" size="40"/><span class="classeExemploOficio"> Ex: Reitor da Universidade Federal de Alfenas</span>
            </td>
        </tr>
        <tr height="40"><td></td></tr>
        <tr height="30">
            <td>
                Assunto: <input type="text" id="assunto" name="assunto" onkeyup="liberarCadastro()" value="<?php echo $this->assunto; ?>" size="50"/><span class="classeExemploOficio"> Ex: Indicação de nome para... </span>
            </td>
        </tr>
        <tr height="40"><td></td></tr>
        <tr height="30">
            <td align="left">
                <input type="text" id="referencia" name="referencia" onkeyup="liberarCadastro()" value="<?php echo $this->referencia; ?>" size="25"/><span class="classeExemploOficio"> Ex: Magnífico Reitor, </span>
            </td>
        </tr>
        <tr height="40"><td></td></tr>
        <tr height="30">
            <td align="left">
                <div >
                    <textarea style="max-height: 500px;min-height: 200px;max-width: 625px;min-width: 625px" id="corpo" value="" name="corpo" onkeyup="liberarCadastro()" value="<?php echo $this->corpo; ?>">Corpo do Ofício</textarea>
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
                                <input type="text" id="remetente" name="remetente" onkeyup="liberarCadastro()" value="<?php echo $this->remetente; ?>" size="50" style="margin-left: 125px"/><span class="classeExemploOficio"> Ex: Prof. Dr. Gabriel G... </span>
                            </td>
                        </tr>
                        <tr height="20">
                            <td align="center">
                                <input type="text" id="cargo_remetente" name="cargo_remetente" onkeyup="liberarCadastro()" value="<?php echo $this->cargo_remetente; ?>" size="25" style="margin-left: 110px"/><span class="classeExemploOficio"> Ex: Coordenador CEAD</span>
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
                                <input type="text" id="remetente2" name="remetente2" onkeyup="liberarCadastro()" value="<?php echo $this->remetente2; ?>" size="50" style="margin-left: 125px"/><span class="classeExemploOficio"> Ex: Prof. Dr. Gabriel G... </span>
                            </td>
                        </tr>
                        <tr height="20">
                            <td align="center">
                                <input type="text" id="cargo_remetente2" name="cargo_remetente2" onkeyup="liberarCadastro()" value="<?php echo $this->cargo_remetente2; ?>" size="25" style="margin-left: 110px"/><span class="classeExemploOficio"> Ex: Coordenador CEAD</span>
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
    <table align="center">
        <tr height="30"><td></td></tr>
        <tr>
            <td align="center" colspan="2">
                <button class="btn" type="reset">Limpar</button>
                <input type="button" class="btn" value="Gerar" disabled="true" name="b_gerar" id="b_gerar" onclick="confirmaAcao('gerar');"/>
                <input type="button" class="btn" value="Salvar" disabled="true" name="b_salvar" id="b_salvar" onclick="confirmaAcao('salvar');"/>
<!--                                        <input type="button" class="btn" value="Voltar" name="b_voltar" name="b_voltar" onclick=""/>-->
            </td>
        </tr>

        </tr>
        <tr>
            <td>
                <input type="hidden" name="i_numOficio" id="i_numOficio" />
                <input type="hidden" name="i_idoficio" id="i_idoficio" value="<?php echo $this->idoficio; ?>"/>
                <input type="hidden" name="i_remetente" id="i_remetente" value="0"/>
                <input type="hidden" name="i_sigla" id="i_sigla" value="<?php echo($this->sigla); ?>"/>
            </td>
        </tr>
        <tr height="30"><td></td></tr>
    </table>
</form>
