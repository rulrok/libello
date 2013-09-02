<?php
$controladorAux = new ControladorDocumentos();
?>
<script src="publico/js/jquery/jquery.dataTables.js"></script>

<style>
    .btn_oficio{
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        margin:0;
        border-right:0;
        margin-right:-4px;
    }
    .btn_memorando{
        margin:0;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .label_oficio_memorando{
        background-color:rgb(153,153,153);
        margin-right:-4px;
        line-height: 30px;
        padding:0 12px;
        display: inline-block;
        font-size: 11.844px;
        font-weight: bold;
        color: rgb(255, 255, 255);
        text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.25);
        white-space: nowrap;
        vertical-align: baseline;
    }

</style>



<div style="text-align:center;">
    <input class="btn btn_oficio" type="button" id="b_oficio" value="Ofícios" onclick="mostraOpcao('oficio')" style="height: 30px; width: 150px;"/>
    <input class="btn btn_memorando" type="button" id="b_memorando" value="Memorandos" onclick="mostraOpcao('memorando')" style="height: 30px; width: 150px;"/>
</div>


<div id="tabela1" class="tabelaConteudo" style="display: none;">


    <form id="form1" name="form1" method="post">

        <div style="text-align:center;cursor:default;" >
            <div align="right" style="" class="label_oficio_memorando">Visualizar: </div>
            <label>
                <select id="comboOficioTipo" name="comboOficioTipo">
                    <option value="default" selected="selected" >--Selecione uma opção--</option>
                    <option value="todos">Todos</option>
                    <option value="validos">Válidos</option>
                    <option value="invalidos">Invalidados</option>
                    <option value="aberto">Em aberto</option>
                </select>
            </label>
        </div>


        <div id="msg_aproveitarOficio" hidden="true">
            <label>Deseja realmente aproveitar/editar este ofício?</label>
            <label>
                <input class="btn" type="submit"  name="b_simAproveitar" id="b_simAproveitar" onclick="confirmaAcao('sim', 'aproveitarOficio');" value="Sim" />
            </label>
            <label>
                <input class="btn" type="button" value="Não" onclick="confirmaAcao('nao', 'aproveitarOficio');" name="b_naoAproveitar" id="b_naoAproveitar" />
            </label>
        </div>
        <div id="msg_invalidarOficio" hidden="true">
            <label>Deseja realmente invalidar este ofício?</label>
            <label>
                <input class="btn" type="button"  name="b_simInvalidar" id="b_simInvalidar" onclick="confirmaAcao('sim', 'invalidarOficio');" value="Sim" />
            </label>
            <label>
                <input class="btn" type="button" value="Não" onclick="confirmaAcao('nao', 'invalidarOficio');" name="b_naoInvalidar" id="b_naoInvalidar" />
            </label>
        </div>
        <div id="msg_deletarOficio" hidden="true">
            <label>Deseja realmente deletar este ofício?</label>
            <label>
                <input class="btn" type="button"  name="b_simDeletar" id="b_simDeletar" onclick="confirmaAcao('sim', 'deletarOficio');" value="Sim" />
            </label>
            <label>
                <input class="btn" type="button" value="Não" onclick="confirmaAcao('nao', 'deletarOficio');" name="b_naoDeletar" id="b_naoDeletar" />
            </label>
        </div>


        <input type="hidden" name="i_idOficio" id="i_idOficio"/>
        <input type="hidden" name="i_controleAproveitar" id="i_controleAproveitar"/>
    </form>


    <div style="display: none;" id="tabelaTodosOficios">
        <?php $oficios = documentoDAO::consultar();
        require('estruturas_auxiliares/menuGerenciar.php'); ?>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>

        <?php
        $num_linhas = count($oficios);
        for ($i = 0; $i < $num_linhas; $i++) {
            //se nao eh documento aproveitavel
            if ($oficios[$i]->getEstadoEdicao() == 0) {
                echo "<tr id=" . $oficios[$i]->getIdOficio() . ">";
                echo "<td width='30%' id='assunto'>" . $oficios[$i]->getAssunto() . "</td>";
                //se eh documento invalido
                if ($oficios[$i]->getEstadoValidacao() == 0) {
                    echo "<td width='30%' id='destino'>" . $oficios[$i]->getDestino() . "</td>";
                    echo "<td width='10%' id='numeracao' align='center'>" . $oficios[$i]->getNumOficio() . "</td>";
                    echo "<td width='15%' id='data'>" . $oficios[$i]->getData() . "</td>";
                    echo "<td width='10%' id='validacao' align='center'>" . "Inválido" . "</td>";
//                    echo "<td width='5%' align='center'> <input type='button' title='Aproveitar documento' id='b_apr-" . $oficios[$i]["idoficio"] . "' value='' onclick='confirmaAproveitamento(this.id);' class='classeBotaoAproveitar' />  </td>";
//                    echo "<td width='5%' align='center'> <input type='button' title='Invalidar documento' id='b_inv-" . $oficios[$i]["idoficio"] . "' value='' onclick='confirmaInvalidacao(this.id);' class='classeBotaoInvalidar' />  </td>";
                    //se eh valido
                } else {
                    echo "<td width='30%' id='destino'>" . $oficios[$i]->getDestino() . "</td>";
                    echo "<td width='10%' id='numeracao' align='center'>" . $oficios[$i]->getNumOficio() . "</td>";
                    echo "<td width='15%' id='data'>" . $oficios[$i]->getData() . "</td>";
                    echo "<td width='10%' id='validacao' align='center'>" . "Válido" . "</td>";
//                    echo "<td width='5%' align='center'> <input type='button' title='Aproveitar documento' id='b_apr-" . $oficios[$i]["idoficio"] . "' value='' onclick='confirmaAproveitamento(this.id);' class='classeBotaoAproveitar' />  </td>";
//                    echo "<td width='5%' align='center'> <input type='button' title='Invalidar documento' id='b_inv-" . $oficios[$i]["idoficio"] . "' value='' onclick='confirmaInvalidacao(this.id);' class='classeBotaoInvalidar' />  </td>";
                }
            } else {
                if ($oficios[$i]->getIdUsuario() == $_SESSION['idUsuario']) {
                    echo "<tr id=" . $oficios[$i]->getIdOficio() . ">";
                    echo "<td width='30%' id='assunto'>" . $oficios[$i]->getAssunto() . "</td>";
                    echo "<td width='30%' id='destino'>" . $oficios[$i]->getDestino() . "</td>";
                    echo "<td width='10%' id='numeracao' align='center'>" . "Em aberto" . "</td>";
                    echo "<td width='15%' id='data'>" . $oficios[$i]->getData() . "</td>";
                    echo "<td width='10%' id='validacao' align='center'>" . "Válido" . "</td>";
//                    echo "<td width='5%' align='center'> <input type='button' title='Visualizar documento' id='b_vis-" . $oficios[$i]["idoficio"] . "' value='' onclick='visualizarOficio(this.id);' class='classeBotaoVisualizar' />  </td>";
//                    echo "<td width='5%' align='center'> <input type='button' title='Editar documento' id='b_edt-" . $oficios[$i]["idoficio"] . "' value='' onclick='confirmaAproveitamento(this.id);' class='classeBotaoEditar' />  </td>";
//                    echo "<td width='5%' align='center'> <input type='button' title='Deletar documento' id='b_del-" . $oficios[$i]["idoficio"] . "' value='' onclick='confirmaInvalidacao(this.id);' class='classeBotaoInvalidar' />  </td>";
                }
            }
        }
        ?>

        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
<?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    <div id="tabelaOficiosValidos" hidden="true">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
<?php require 'estruturas_auxiliares/topTable.php'; ?>


        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
<?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    <div id="tabelaOficiosInvalidos" hidden="true">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
<?php require 'estruturas_auxiliares/topTable.php'; ?>


        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
<?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    <div id="tabelaOficiosEmAberto" hidden="true">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>

        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
<?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>

</div>
<div id="tabela2" class="tabelaConteudo" style="display: none;">


    <form id="form2" name="form2" method="post">
        <div style="text-align:center;cursor:default;" >
            <div align="right" style="" class="label_oficio_memorando">Visualizar: </div>
            <label>
                <select id="comboMemorandoTipo" name="comboMemorandoTipo">
                    <option value="default" selected="selected" >--Selecione uma opção--</option>
                    <option value="todos">Todos</option>
                    <option value="validos">Válidos</option>
                    <option value="invalidos">Inválidos</option>
                    <option value="aberto">Em aberto</option>                                                
                </select>
            </label>
        </div>

        <div id="msg_aproveitarMemorando" hidden="true">
            <label>Deseja realmente aproveitar/editar este memorando?</label>
            <label>
                <input type="submit"  name="b_simAproveitarMem" id="b_simAproveitarMem" onclick="confirmaAcaoMemorando('sim', 'aproveitarMemorando');" value="Sim" />
            </label>
            <label>
                <input type="button" value="Não" onclick="confirmaAcaoMemorando('nao', 'aproveitarMemorando');" name="b_naoAproveitarMem" id="b_naoAproveitarMem" />
            </label>
        </div>
        <div id="msg_invalidarMemorando" hidden="true">
            <label>Deseja realmente invalidar este memorando?</label>
            <label>
                <input type="button"  name="b_simInvalidarMem" id="b_simInvalidarMem" onclick="confirmaAcaoMemorando('sim', 'invalidarMemorando');" value="Sim" />
            </label>
            <label>
                <input type="button" value="Não" onclick="confirmaAcaoMemorando('nao', 'invalidarMemorando');" name="b_naoInvalidarMem" id="b_naoInvalidarMem" />
            </label>
        </div>
        <div id="msg_deletarMemorando" hidden="true">
            <label>Deseja realmente deletar este memorando?</label>
            <label>
                <input type="button"  name="b_simDeletarMem" id="b_simDeletarMem" onclick="confirmaAcaoMemorando('sim', 'deletarMemorando');" value="Sim" />
            </label>
            <label>
                <input type="button" value="Não" onclick="confirmaAcaoMemorando('nao', 'deletarMemorando');" name="b_naoDeletarMem" id="b_naoDeletarMem" />
            </label>
        </div>


        <input type="hidden" name="i_idMemorando" id="i_idMemorando"/>
        <input type="hidden" name="i_controleAproveitarMem" id="i_controleAproveitarMem"/>
    </form>

    <div style="display: none;" id="tabelaTodosMemorandos">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>

<?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    <div id="tabelaMemorandosValidos" hidden="true">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>

<?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    <div id="tabelaMemorandosInvalidos" hidden="true">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>

<?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    <div id="tabelaMemorandosEmAberto" hidden="true">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>

<?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
</div>
<script type="text/javascript">
    var tab_todosOficios, tab_todosValidos, tab_todosInvalidos,
            tab_todosAberto, tab_todosMemorando, tab_memorandosValidos, tab_memorandosInvalidos, tab_memorandosAberto;

    $(document).ready(function() {
        tab_todosOficios = $('#historico').dataTable({"bJQueryUI": true});
//        tab_todosValidos = $('#tabela_oficiosValidos').dataTable({"bJQueryUI": true});
//        tab_todosInvalidos = $('#tabela_oficiosInvalidos').dataTable({"bJQueryUI": true});
//        tab_todosAberto = $('#tabela_oficiosAberto').dataTable({"bJQueryUI": true});
//        tab_todosMemorando = $('#tabela_todosMemorandos').dataTable({"bJQueryUI": true});
//        tab_memorandosValidos = $('#tabela_memorandosValidos').dataTable({"bJQueryUI": true});
//        tab_memorandosInvalidos = $('#tabela_memorandosInvalidos').dataTable({"bJQueryUI": true});
//        tab_memorandosAberto = $('#tabela_memorandosAberto').dataTable({"bJQueryUI": true});


        var selected = $($("#historico tr")[1]).addClass('row_selected');

        if ($("#numeracao",selected).text() != "Em aberto") {
            $(".n_editavel").show();
        } else {
            $(".editavel").show();
        }

        tab_todosOficios.$('tr').mousedown(function(e) {
            tab_todosOficios.$('tr.row_selected').removeClass('row_selected');
            $(this).addClass('row_selected');
            selectedElement = this;
            if ($("#numeracao",selectedElement).text()!="Em aberto") {
                $(".n_editavel").show();
                $(".editavel").hide();
                //alert($("#numeracao",selectedElement).text());
            } else {
                $(".editavel").show();
                $(".n_editavel").hide();
            }
        });

        $('#comboOficioTipo').change(function() {
            var valor = $('#comboOficioTipo option:selected').val();

//            $('#tabelaTodosMemorandos').hide();
//            $('#tabelaMemorandosValidos').hide();
//            $('#tabelaMemorandosInvalidos').hide();
//            $('#tabelaMemorandosEmAberto').hide();
            if (valor == "todos") {
                $('#tabelaTodosOficios').show();
                $('#tabelaOficiosValidos').hide();
                $('#tabelaOficiosInvalidos').hide();
                $('#tabelaOficiosEmAberto').hide();
            } else {
                if (valor == 'validos') {
                    $('#tabelaTodosOficios').hide();
                    $('#tabelaOficiosValidos').show();
                    $('#tabelaOficiosInvalidos').hide();
                    $('#tabelaOficiosEmAberto').hide();
                } else {
                    if (valor == 'invalidos') {
                        $('#tabelaTodosOficios').hide();
                        $('#tabelaOficiosValidos').hide();
                        $('#tabelaOficiosInvalidos').show();
                        $('#tabelaOficiosEmAberto').hide();
                    } else {
                        if (valor == 'aberto') {
                            $('#tabelaTodosOficios').hide();
                            $('#tabelaOficiosValidos').hide();
                            $('#tabelaOficiosInvalidos').hide();
                            $('#tabelaOficiosEmAberto').show();
                        }
                    }
                }
            }
        });

        $('#comboMemorandoTipo').change(function() {
            var valor = $('#comboMemorandoTipo option:selected').val();
//            $('#tabelaTodosOficios').hide();
//            $('#tabelaOficiosValidos').hide();
//            $('#tabelaOficiosInvalidos').hide();
//            $('#tabelaOficiosEmAberto').hide();
            if (valor == "todos") {
                $('#tabelaTodosMemorandos').show();
                $('#tabelaMemorandosValidos').hide();
                $('#tabelaMemorandosInvalidos').hide();
                $('#tabelaMemorandosEmAberto').hide();
            } else {
                if (valor == 'validos') {
                    $('#tabelaTodosMemorandos').hide();
                    $('#tabelaMemorandosValidos').show();
                    $('#tabelaMemorandosInvalidos').hide();
                    $('#tabelaMemorandosEmAberto').hide();
                } else {
                    if (valor == 'invalidos') {
                        $('#tabelaTodosMemorandos').hide();
                        $('#tabelaMemorandosValidos').hide();
                        $('#tabelaMemorandosInvalidos').show();
                        $('#tabelaMemorandosEmAberto').hide();
                    } else {
                        if (valor == 'aberto') {
                            $('#tabelaTodosMemorandos').hide();
                            $('#tabelaMemorandosValidos').hide();
                            $('#tabelaMemorandosInvalidos').hide();
                            $('#tabelaMemorandosEmAberto').show();
                        }
                    }
                }
            }
        });
//          $('.btn_invalidar').live('click', function() {
//            var r = confirm("Tem certeza? O documento será permanentemente invalidado!");
//            if (r) {
//                var id = $(this).attr('id');
//                var name = $(this).attr('name');
//                $.ajax({
//                    dataType: 'json',
//                    data: {id: id},
//                    url: '../paginasAuxiliares/acoes.php?acao=invalidar_' + name,
//                    success: function(data) {
//                        if (data) {
//                            //atualizar tabela
//                        }
//                    }
//                });
//
//            }
//        });

//        $('.btn_deletar').live('click', function() {
//
//        });
    });

    function mostraOpcao(opcao) {
        if (opcao == 'oficio') {

            $('#tabela1').show();
            $('#tabela2').hide();
        } else if (opcao == 'memorando') {
            $('#tabela1').hide();
            $('#tabela2').show();
        }
    }
//
//    function confirmaAproveitamento(id) {
//        bloqueia();
//        var op = id.substr(2, 3);
//        id = id.substr(6, 6);
//        $('#i_controleAproveitar').val(op);
//        $('#i_idOficio').val(id);
//        $('#msg_aproveitarOficio').show();
//        $('#msg_invalidarOficio').hide();
//    }
//
//    function confirmaInvalidacao(id) {
//        bloqueia();
//        var op = id.substr(2, 3);
//        id = id.substr(6, 6);
//        $('#i_idOficio').val(id);
//        if (op == 'del') {
//            $('#msg_aproveitarOficio').hide();
//            $('#msg_deletarOficio').show();
//            $('#msg_invalidarOficio').hide();
//        } else {
//            $('#msg_aproveitarOficio').hide();
//            $('#msg_deletarOficio').hide()
//            $('#msg_invalidarOficio').show();
//        }
//    }
//
//    function visualizarOficio(id) {
//        id = id.substr(6, 6);
//        window.open('../../../includes/relatoriosPDF/visualizarOficio_1.php?id=' + id + '', 'Visualizar Documento', 'location=no');
//    }
//
//    function visualizarMemorando(id) {
//        id = id.substr(6, 6);
//        window.open('../../../includes/relatoriosPDF/visualizarMemorando.php?id=' + id + '', 'Visualizar Documento', 'location=no');
//    }
//
//    function confirmaAproveitamentoMemorando(id) {
//        bloqueia();
//        var op = id.substr(2, 3);
//        id = id.substr(6, 6);
//        $('#i_controleAproveitarMem').val(op);
//        $('#i_idMemorando').val(id);
//        $('#msg_aproveitarMemorando').show();
//        $('#msg_invalidarMemorando').hide();
//    }
//
//    function confirmaInvalidacaoMemorando(id) {
//        bloqueia();
//        var op = id.substr(2, 3);
//        id = id.substr(6, 6);
//        $('#i_idMemorando').val(id);
//        if (op == 'del') {
//            $('#msg_aproveitarMemorando').hide();
//            $('#msg_deletarMemorando').show();
//            $('#msg_invalidarMemorando').hide();
//        } else {
//            $('#msg_aproveitarMemorando').hide();
//            $('#msg_deletarMemorando').hide()
//            $('#msg_invalidarMemorando').show();
//        }
//    }
//
//    function bloqueia() {
//        $('.classeBotaoVisualizar').attr({disabled: 'true'}).removeClass('classeBotaoVisualizar').addClass('classeBotaoVisualizarDesativado');
//        $('.classeBotaoAproveitar').attr({disabled: 'true'}).removeClass('classeBotaoAproveitar').addClass('classeBotaoAproveitarDesativado');
//        $('.classeBotaoEditar').attr({disabled: 'true'}).removeClass('classeBotaoEditar').addClass('classeBotaoEditarDesativado');
//        $('.classeBotaoInvalidar').attr({disabled: 'true'}).removeClass('classeBotaoInvalidar').addClass('classeBotaoInvalidarDesativado');
//    }
//
//    function desbloqueia() {
//        $('.classeBotaoVisualizarDesativado').removeAttr('disabled').removeClass('classeBotaoVisualizarDesativado').addClass('classeBotaoVisualizar');
//        $('.classeBotaoAproveitarDesativado').removeAttr('disabled').removeClass('classeBotaoAproveitarDesativado').addClass('classeBotaoAproveitar');
//        $('.classeBotaoEditarDesativado').removeAttr('disabled').removeClass('classeBotaoEditarDesativado').addClass('classeBotaoEditar');
//        $('.classeBotaoInvalidarDesativado').removeAttr('disabled').removeClass('classeBotaoInvalidarDesativado').addClass('classeBotaoInvalidar');
//    }

//    function confirmaAcao(resp, acao) {
//        if (resp == "sim") {
//            $('#form1').attr({action: '../paginasAuxiliares/acoes.php?acao=' + acao});
//            document.form1.submit();
//        } else if (resp == "nao") {
//            desbloqueia();
//            $('#msg_aproveitarOficio').hide();
//            $('#msg_invalidarOficio').hide();
//            $('#msg_deletarOficio').hide();
//        }
//    }
//
//    function confirmaAcaoMemorando(resp, acao) {
//        if (resp == "sim") {
//            $('#form2').attr({action: '../paginasAuxiliares/acoes.php?acao=' + acao});
//            document.form2.submit();
//        } else if (resp == "nao") {
//            desbloqueia();
//            $('#msg_aproveitarMemorando').hide();
//            $('#msg_invalidarMemorando').hide();
//            $('#msg_deletarMemorando').hide();
//        }
//    }
</script>


