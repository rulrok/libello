
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
                    <option id="option_oficio_default" value="default" selected="selected" >--Selecione uma opção--</option>
                    <option id="option_oficio_todos" value="todos">Todos</option>
                    <option id="option_oficio_validos" value="validos">Válidos</option>
                    <option id="option_oficio_invalidos" value="invalidos">Invalidados</option>
                    <option id="option_oficio_emAberto" value="aberto">Em aberto</option>
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


    <div style="display: none;" id="todosOficios">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>

        <?php
        echo $controladorAux->listarOficios();
        ?>

        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    <div id="oficiosValidos" style="display:none;">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>

        <?php
        echo $controladorAux->listarOficios('validos');
        ?>

        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    <div id="oficiosInvalidos" hidden="true">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>

        <?php
        echo $controladorAux->listarOficios('invalidos');
        ?>

        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    <div id="oficiosEmAberto" hidden="true">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>

        <?php
        echo $controladorAux->listarOficios('emAberto');
        ?>

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

    <div style="display: none;" id="todosMemorandos">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>
        <?php
        echo $controladorAux->listarMemorandos();
        ?>
        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    <div id="memorandosValidos" hidden="true">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>
        <?php
        echo $controladorAux->listarMemorandos('validos');
        ?>
        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    <div id="memorandosInvalidos" hidden="true">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>
        <?php
        echo $controladorAux->listarMemorandos('invalidos');
        ?>
        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    <div id="memorandosEmAberto" hidden="true">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>
        <?php
        echo $controladorAux->listarMemorandos('emAberto');
        ?>
        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
</div>
<script type="text/javascript">
        var tab_todosOficios, tab_todosValidos, tab_todosInvalidos,
                tab_todosAberto, tab_todosMemorando, tab_memorandosValidos, tab_memorandosInvalidos, tab_memorandosAberto;


        function mostraOpcao(opcao) {
            if (opcao == 'oficio') {
                $('#b_oficio').addClass('active');
                $('#b_memorando').removeClass('active');
                $('#tabela1').show();
                $('#tabela2').hide();
            } else if (opcao == 'memorando') {
                $('#b_memorando').addClass('active');
                $('#b_oficio').removeClass('active');
                $('#tabela1').hide();
                $('#tabela2').show();
            }
        }
//
        function mouseTabela(tab) {
            tab.$('tr').mousedown(function(e) {

                $(this).parent().parent().find('tr.row_selected').removeClass('row_selected');
                $(this).addClass('row_selected');
                var selectedElement = this;
                if ($("#numeracao", selectedElement).text() != "Em aberto") {
                    $(".n_editavel").show();
                    $(".editavel").hide();
                    if($('#validacao', selectedElement).text() === 'Inválido'){
                        $('.btn-invalidar').addClass('disabled');
                        $('.btn-invalidar').attr({disabled:true});
                    }else{
                        $('.btn-invalidar').removeClass('disabled');
                        $('.btn-invalidar').removeAttr('disabled');
                    }
                } else {
                    $(".editavel").show();
                    $(".n_editavel").hide();
                }
            });
        }


        $(document).ready(function() {
        
            $('#todosOficios .tabelaDeEdicao').attr('id', 'tabelaTodosOficios');
            //configurarTabela({idTabela:'tabelaTodosOficios',editar:'',deletar:'',adicionar:''});
            $('#oficiosValidos .tabelaDeEdicao').attr('id', 'tabelaOficiosValidos');
            $('#oficiosInvalidos .tabelaDeEdicao').attr('id', 'tabelaOficiosInvalidos');
            $('#oficiosEmAberto .tabelaDeEdicao').attr('id', 'tabelaOficiosEmAberto');
            $('#todosMemorandos .tabelaDeEdicao').attr('id', 'tabelaTodosMemorandos');
            $('#memorandosValidos .tabelaDeEdicao').attr('id', 'tabelaMemorandosValidos');
            $('#memorandosInvalidos .tabelaDeEdicao').attr('id', 'tabelaMemorandosInvalidos');
            $('#memorandosEmAberto .tabelaDeEdicao').attr('id', 'tabelaMemorandosEmAberto');

            tab_todosOficios = $('#tabelaTodosOficios').dataTable({"bJQueryUI": true});
            tab_todosValidos = $('#tabelaOficiosValidos').dataTable({"bJQueryUI": true});
            tab_todosInvalidos = $('#tabelaOficiosInvalidos').dataTable({"bJQueryUI": true});
            tab_todosAberto = $('#tabelaOficiosEmAberto').dataTable({"bJQueryUI": true});
            tab_todosMemorandos = $('#tabelaTodosMemorandos').dataTable({"bJQueryUI": true});
            tab_memorandosValidos = $('#tabelaMemorandosValidos').dataTable({"bJQueryUI": true});
            tab_memorandosInvalidos = $('#tabelaMemorandosInvalidos').dataTable({"bJQueryUI": true});
            tab_memorandosAberto = $('#tabelaMemorandosEmAberto').dataTable({"bJQueryUI": true});

            mouseTabela(tab_todosOficios);
            mouseTabela(tab_todosValidos);
            mouseTabela(tab_todosInvalidos);
            mouseTabela(tab_todosAberto);
            mouseTabela(tab_todosMemorandos);
            mouseTabela(tab_memorandosValidos);
            mouseTabela(tab_memorandosInvalidos);
            mouseTabela(tab_memorandosAberto);

            function select(tab) {

                $(' tr.row_selected').each(function() {
                    $(this).removeClass('row_selected');
                });
                var selectedElement = $($('#' + tab.attr('id') + ' tr')[1]).addClass('row_selected');
                if ($("#numeracao", selectedElement).text() != "Em aberto") {
                    $(".n_editavel").show();
                    if($('#validacao', selectedElement).text() === 'Inválido'){
                        $('.btn-invalidar').addClass('disabled');
                        $('.btn-invalidar').attr({disabled:true});
                    }else{
                        $('.btn-invalidar').removeClass('disabled');
                        $('.btn-invalidar').removeAttr('disabled');
                    }
                } else {
                    $(".editavel").show();
                }
            }

             $('#comboOficioTipo').change(function() {
                var valor = $('#comboOficioTipo option:selected').val();
                $('#todosOficios').hide();
                $('#oficiosValidos').hide();
                $('#oficiosInvalidos').hide();
                $('#oficiosEmAberto').hide();
                $(".n_editavel").hide();
                $(".editavel").hide();
                if (valor == "todos") {
                    select(tab_todosOficios);
                    $('#todosOficios').show();
                } else {
                    if (valor == 'validos') {
                        select(tab_todosValidos);
                        $('#oficiosValidos').show();
                    } else {
                        if (valor == 'invalidos') {
                            select(tab_todosInvalidos);
                            $('#oficiosInvalidos').show();
                        } else {
                            if (valor == 'aberto') {
                                select(tab_todosAberto);
                                $('#oficiosEmAberto').show();
                            }
                        }
                    }
                }
            }); 

            $('#comboMemorandoTipo').change(function() {
                var valor = $('#comboMemorandoTipo option:selected').val();
                $('#todosMemorandos').hide();
                $('#memorandosValidos').hide();
                $('#memorandosInvalidos').hide();
                $('#memorandosEmAberto').hide();
                $(".n_editavel").hide();
                $(".editavel").hide();
                if (valor == "todos") {
                    select(tab_todosMemorandos);
                    $('#todosMemorandos').show();

                } else {
                    if (valor == 'validos') {
                        select(tab_memorandosValidos);
                        $('#memorandosValidos').show();
                    } else {
                        if (valor == 'invalidos') {
                            select(tab_memorandosInvalidos);
                            $('#memorandosInvalidos').show();
                        } else {
                            if (valor == 'aberto') {
                                select(tab_memorandosAberto);
                                $('#memorandosEmAberto').show();
                            }
                        }
                    }
                }
            });

            $('.btn-visualizar').on('click', function() {
                if ($('#tabela1').css('display') != 'none')
                    window.open('app/modelo/relatoriosPDF/visualizarOficio.php?id=' + $('.row_selected td.campoID').text());
                else if ($('#tabela2').css('display') != 'none') {
                    window.open('app/modelo/relatoriosPDF/visualizarMemorando.php?id=' + $('.row_selected td.campoID').text());
                }
            });

            $('.btn-invalidar').on('click', function() {
                var r = confirm("Tem certeza? O documento será permanentemente invalidado!");
                if (r) {
                    var tipo = $('tr.row_selected').attr('tipo');
                    var doc = $('tr.row_selected').attr('doc');
                    var id = $('tr.row_selected .campoID').text();
                  
                    $.getJSON("publico/ajax/documentos/acoes.php?acao=invalidar" + doc + "&i_id" + doc + "=" + id,
                            function(data) {
                               ajax('index.php?c=documentos&a=historico&doc='+doc+'&tipo='+tipo);
                            }
                    );
                }
            });
            
            $('.btn-deletar').on('click', function() {
                var r = confirm("Tem certeza? O documento será permanentemente excluido!");
                if (r) {
                    var id = $('tr.row_selected .campoID').text();
                    var tipo = $('tr.row_selected').attr('tipo');
                    var doc = $('tr.row_selected').attr('doc');
                    //alert(id);
                    $.getJSON("publico/ajax/documentos/acoes.php?acao=deletar" + doc + "&i_id" + doc + "=" + id,
                            function(data) {
                                ajax('index.php?c=documentos&a=historico&doc='+doc+'&tipo='+tipo);
                            }
                    );
                }
            });
            
            $('.btn-editar').on('click',function(){
                var doc = $('tr.row_selected').attr('doc');
                var temp = doc[0].toUpperCase()+doc.slice(1);
                var id = $('tr.row_selected .campoID').text();
                //editar ele altera o valor no banco
                ajax('index.php?c=documentos&a=editar'+temp+"&id="+id);
            });
            
            $('.btn-aproveitar').on('click',function(){
                var doc = $('tr.row_selected').attr('doc');
                var temp = doc[0].toUpperCase()+doc.slice(1);
                var id = $('tr.row_selected .campoID').text();
                //aproveitar usa os valores de um e gera ou salva outra instancia do documento
                ajax('index.php?c=documentos&a=aproveitar'+temp+'&id='+id);
            });

        });


</script>
<?php
if(isset($_GET['doc']) && isset($_GET['tipo'])){
?>
<script>
    var doc_select = <?php echo '"'.$_GET['doc'].'"';?>;
    var tipo_select = <?php echo '"'.$_GET['tipo'].'"';?>;
    $(document).ready(function(){
        $('.btn_'+doc_select).click();
        $('#option_'+doc_select+'_default').removeAttr('selected');
        $('#option_'+doc_select+'_'+tipo_select).attr('selected','selected');
        var temp = doc_select.charAt(0).toUpperCase() + doc_select.slice(1);
        $('#combo'+temp+'Tipo').trigger('change');
    });
</script>
<?php
}
?>