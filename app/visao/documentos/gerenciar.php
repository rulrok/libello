<title>Gerenciar Documentos</title>

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
        text-align:center;
    }

</style>



<div style="text-align:center;">
    <button class="btn btn_oficio ignorar"
            id="b_oficio" 
            onclick="mostraOpcao('oficio')" 
            style="height: 30px; width: 150px;"
            >Ofícios</button>
    <button class="btn btn_memorando ignorar" 
            id="b_memorando" 
            onclick="mostraOpcao('memorando')" 
            style="height: 30px; width: 150px;"
            >Memorandos</button>
</div>


<div id="tabela1" class="tabelaConteudo" style="display: none;">

    <div style="text-align:center;cursor:default;" >
        <div align="right" style="" class="label_oficio_memorando">Visualizar: </div>
        <label style="text-align:center;display:inline-block;">
            <select id="comboOficioTipo" name="comboOficioTipo" class="ignorar">
                <option id="option_oficio_default" value="default" selected="selected" >--Selecione uma opção--</option>
                <option id="option_oficio_todos" value="todos">Todos</option>
                <option id="option_oficio_validos" value="validos">Válidos</option>
                <option id="option_oficio_invalidos" value="invalidos">Invalidados</option>
                <option id="option_oficio_aberto" value="aberto">Em aberto</option>
            </select>
        </label>
    </div>

    <div style="display: none;" id="todosOficios">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>

        <?php
        echo $this->todosOficios;
        ?>

        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    <div id="oficiosValidos" style="display:none;">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>

        <?php
        echo $this->oficiosValidos;
        ?>

        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    <div id="oficiosInvalidos" hidden="true">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>

        <?php
        echo $this->oficiosInvalidos;
        ?>

        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    <div id="oficiosEmAberto" hidden="true">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>

        <?php
        echo $this->oficiosEmAberto;
        ?>

        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>

</div>
<div id="tabela2" class="tabelaConteudo" style="display: none;">


    <div style="text-align:center;cursor:default;" >
        <div align="right" style="" class="label_oficio_memorando">Visualizar: </div>
        <label style="text-align:center;display:inline-block;">
            <select id="comboMemorandoTipo" name="comboMemorandoTipo" class="ignorar">
                <option id="option_memorando_default" value="default" selected="selected" >--Selecione uma opção--</option>
                <option id="option_memorando_todos" value="todos">Todos</option>
                <option id="option_memorando_validos" value="validos">Válidos</option>
                <option id="option_memorando_invalidos" value="invalidos">Inválidos</option>
                <option id="option_memorando_aberto" value="aberto">Em aberto</option>                                                
            </select>
        </label>
    </div>


    <div style="display: none;" id="todosMemorandos">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>
        <?php
        echo $this->todosMemorandos;
        ?>
        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    <div id="memorandosValidos" hidden="true">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>
        <?php
        echo $this->memorandosValidos;
        ?>
        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    <div id="memorandosInvalidos" hidden="true">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>
        <?php
        echo $this->memorandosInvalidos;
        ?>
        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    <div id="memorandosEmAberto" hidden="true">
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>
        <?php
        echo $this->memorandosEmAberto;
        ?>
        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
</div>

<form id="form_visualizar" target="_blank" method="post" action="">
    <input type="hidden" id="idv" name="idv" />
</form>

<script type="text/javascript">
                var tab_todosOficios, tab_todosValidos, tab_todosInvalidos,
                        tab_todosAberto, tab_todosMemorando, tab_memorandosValidos,
                        tab_memorandosInvalidos, tab_memorandosAberto;
                var url_inicial = '#!documentos|gerenciar';
                var doc = null, tipo_oficio = null, tipo_memorando = null;

                function mostraOpcao(opcao) {
                    if (opcao == 'oficio') {
                        $('#b_oficio').addClass('active');
                        $('#b_memorando').removeClass('active');
                        $('#tabela1').show();
                        $('#tabela2').hide();

                        if (doc != 'oficio') {
                            doc = 'oficio';
                            document.ignorarHashChange = true;
                            if (tipo_oficio == null) {
                                document.location.hash = url_inicial + '&doc=' + doc;

                            } else {
                                document.location.hash = url_inicial + '&doc=' + doc + tipo_oficio;
                            }
                        }

                    } else if (opcao == 'memorando') {
                        $('#b_memorando').addClass('active');
                        $('#b_oficio').removeClass('active');
                        $('#tabela1').hide();
                        $('#tabela2').show();
                        if (doc != 'memorando') {
                            doc = 'memorando';
                            document.ignorarHashChange = true;
                            if (tipo_memorando == null) {
                                document.location.hash = url_inicial + '&doc=' + doc;

                            } else {
                                document.location.hash = url_inicial + '&doc=' + doc + tipo_memorando;
                            }
                        }
                    }
                }
//
                function mouseTabela(tab) {
                    tab.$('tr').mousedown(function(e) {

                        $(this).parent().parent().find('tr.row_selected').removeClass('row_selected');
                        $(this).addClass('row_selected');
                        var selectedElement = this;
                        if ($(".numeracao", selectedElement).text() != "Em aberto") {
                            $(".n_editavel").show();
                            $(".editavel").hide();
                            if ($('.validacao', selectedElement).text() === 'Inválido') {
                                $('.btn-invalidar').addClass('disabled');
                                $('.btn-invalidar').attr({disabled: true});
                            } else {
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
                    $('#oficiosValidos .tabelaDeEdicao').attr('id', 'tabelaOficiosValidos');
                    $('#oficiosInvalidos .tabelaDeEdicao').attr('id', 'tabelaOficiosInvalidos');
                    $('#oficiosEmAberto .tabelaDeEdicao').attr('id', 'tabelaOficiosEmAberto');
                    $('#todosMemorandos .tabelaDeEdicao').attr('id', 'tabelaTodosMemorandos');
                    $('#memorandosValidos .tabelaDeEdicao').attr('id', 'tabelaMemorandosValidos');
                    $('#memorandosInvalidos .tabelaDeEdicao').attr('id', 'tabelaMemorandosInvalidos');
                    $('#memorandosEmAberto .tabelaDeEdicao').attr('id', 'tabelaMemorandosEmAberto');

                    tab_todosOficios = $('#tabelaTodosOficios').dataTable({"aaSorting": [[1, "asc"]]});
                    tab_todosValidos = $('#tabelaOficiosValidos').dataTable({"aaSorting": [[1, "asc"]]});
                    tab_todosInvalidos = $('#tabelaOficiosInvalidos').dataTable({"aaSorting": [[1, "asc"]]});
                    tab_todosAberto = $('#tabelaOficiosEmAberto').dataTable({"aaSorting": [[1, "asc"]]});
                    tab_todosMemorandos = $('#tabelaTodosMemorandos').dataTable({"aaSorting": [[1, "asc"]]});
                    tab_memorandosValidos = $('#tabelaMemorandosValidos').dataTable({"aaSorting": [[1, "asc"]]});
                    tab_memorandosInvalidos = $('#tabelaMemorandosInvalidos').dataTable({"aaSorting": [[1, "asc"]]});
                    tab_memorandosAberto = $('#tabelaMemorandosEmAberto').dataTable({"aaSorting": [[1, "asc"]]});

                    mouseTabela(tab_todosOficios);
                    mouseTabela(tab_todosValidos);
                    mouseTabela(tab_todosInvalidos);
                    mouseTabela(tab_todosAberto);
                    mouseTabela(tab_todosMemorandos);
                    mouseTabela(tab_memorandosValidos);
                    mouseTabela(tab_memorandosInvalidos);
                    mouseTabela(tab_memorandosAberto);

                    function select(tab) {//selecionar primeiro elemento da tabela

                        $(' tr.row_selected').each(function() {
                            $(this).removeClass('row_selected');
                        });
                        var selectedElement = $($('#' + tab.attr('id') + ' tr')[1]).addClass('row_selected');
                        if ($(".numeracao", selectedElement).text() != "Em aberto") {
                            $(".n_editavel").show();
                            if ($('.validacao', selectedElement).text() === 'Inválido') {
                                $('.btn-invalidar').addClass('disabled');
                                $('.btn-invalidar').attr({disabled: true});
                            } else {
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
                            if (tipo_oficio != '&tipo=todos') {
                                tipo_oficio = '&tipo=todos';
                                document.ignorarHashChange = true;
                                document.location.hash = url_inicial + '&doc=' + doc + tipo_oficio;
                            }
                        } else {
                            if (valor == 'validos') {
                                select(tab_todosValidos);
                                $('#oficiosValidos').show();
                                if (tipo_oficio != '&tipo=validos') {
                                    tipo_oficio = '&tipo=validos';
                                    document.ignorarHashChange = true;
                                    document.location.hash = url_inicial + '&doc=' + doc + tipo_oficio;
                                }
                            } else {
                                if (valor == 'invalidos') {
                                    select(tab_todosInvalidos);
                                    $('#oficiosInvalidos').show();
                                    if (tipo_oficio != '&tipo=invalidos') {
                                        tipo_oficio = '&tipo=invalidos';
                                        document.ignorarHashChange = true;
                                        document.location.hash = url_inicial + '&doc=' + doc + tipo_oficio;
                                    }
                                } else {
                                    if (valor == 'aberto') {
                                        select(tab_todosAberto);
                                        $('#oficiosEmAberto').show();
                                        if (tipo_oficio != '&tipo=aberto') {
                                            tipo_oficio = '&tipo=aberto';
                                            document.ignorarHashChange = true;
                                            document.location.hash = url_inicial + '&doc=' + doc + tipo_oficio;
                                        }
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
                            if (tipo_memorando != '&tipo=todos') {
                                tipo_memorando = '&tipo=todos';
                                document.ignorarHashChange = true;
                                document.location.hash = url_inicial + '&doc=' + doc + tipo_memorando;
                            }
                        } else {
                            if (valor == 'validos') {
                                select(tab_memorandosValidos);
                                $('#memorandosValidos').show();
                                if (tipo_memorando != '&tipo=validos') {
                                    tipo_memorando = '&tipo=validos';
                                    document.ignorarHashChange = true;
                                    document.location.hash = url_inicial + '&doc=' + doc + tipo_memorando;
                                }
                            } else {
                                if (valor == 'invalidos') {
                                    select(tab_memorandosInvalidos);
                                    $('#memorandosInvalidos').show();
                                    if (tipo_memorando != '&tipo=invalidos') {
                                        tipo_memorando = '&tipo=invalidos';
                                        document.ignorarHashChange = true;
                                        document.location.hash = url_inicial + '&doc=' + doc + tipo_memorando;
                                    }
                                } else {
                                    if (valor == 'aberto') {
                                        select(tab_memorandosAberto);
                                        $('#memorandosEmAberto').show();
                                        if (tipo_memorando != '&tipo=aberto') {
                                            tipo_memorando = '&tipo=aberto';
                                            document.ignorarHashChange = true;
                                            document.location.hash = url_inicial + '&doc=' + doc + tipo_memorando;
                                        }
                                    }
                                }
                            }
                        }
                    });

                    $('.btn-visualizar').on('click', function() {
                        if ($('#tabela1').css('display') != 'none') {
                            $('#form_visualizar').attr('action', 'app/modelo/relatoriosPDF/visualizarOficio.php');
                            $('#idv').val($('.row_selected td.campoID').text());
                            $('#form_visualizar').submit();
                        }
                        else if ($('#tabela2').css('display') != 'none') {
                            $('#form_visualizar').attr('action', 'app/modelo/relatoriosPDF/visualizarMemorando.php');
                            $('#idv').val($('.row_selected td.campoID').text());
                            $('#form_visualizar').submit();
                        }
                    });

                    $('.btn-invalidar').on('click', function() {
                        var r = confirm("Tem certeza? O documento será permanentemente invalidado!");
                        if (r) {
                            var doc = $('tr.row_selected').attr('doc');
                            var id = $('tr.row_selected .campoID').text();
                            $.getJSON("app/visao/documentos/acoes.php?acao=invalidar" + doc + "&i_id" + doc + "=" + id,
                                    function(data) {
                                        //document.ignorarHashChange = false;
                                        document.paginaAlterada = false;
                                        document.location.reload();
                                        //document.location.href = '#!documentos|gerenciar&doc=' + doc + '&tipo=' + tipo;
                                    }
                            );
                        }
                    });

                    $('.btn-deletar').on('click', function() {
                        var r = confirm("Tem certeza? O documento será permanentemente excluido!");
                        if (r) {
                            var id = $('tr.row_selected .campoID').text();
                            var doc = $('tr.row_selected').attr('doc');
                            $.getJSON("app/visao/documentos/acoes.php?acao=deletar" + doc + "&i_id" + doc + "=" + id,
                                    function(data) {
                                        //document.ignorarHashChange = false;
                                        document.paginaAlterada = false;
                                        document.location.reload();
                                        //document.location.href = '#!documentos|gerenciar&doc=' + doc + '&tipo=' + tipo;
                                    }
                            );
                        }
                    });

                    $('.btn-editar').on('click', function() {
                        var doc = $('tr.row_selected').attr('doc');
                        var temp = doc[0].toUpperCase() + doc.slice(1);
                        var id = $('tr.row_selected .campoID').text();
                        document.location.href = '#!documentos|editar' + temp + "&id=" + id;
                    });

                    $('.btn-aproveitar').on('click', function() {
                        var doc = $('tr.row_selected').attr('doc');
                        var temp = doc[0].toUpperCase() + doc.slice(1);
                        var id = $('tr.row_selected .campoID').text();
                        document.location.href = '#!documentos|aproveitar' + temp + '&id=' + id;
                    });

                });


</script>
<?php
if (isset($_GET['doc'])) {//reload, delete ou invalidar usam isso para voltar na pagina certa
    ?>
    <script>
        var doc_select = <?php echo '"' . $_GET['doc'] . '"'; ?>;
        $(document).ready(function() {
            doc = doc_select;
            $('.btn_' + doc_select).click();
        });
    </script>
    <?php
}
if (isset($_GET['tipo'])) {
    ?>
    <script>
        var tipo_select = <?php echo '"' . $_GET['tipo'] . '"'; ?>;
        $(document).ready(function() {
            if (doc == 'oficio') {
                tipo_oficio = '&tipo=' + tipo_select;
            } else if (doc = 'memorando') {
                tipo_memorando = '&tipo=' + tipo_select;
            }
            $('#option_' + doc_select + '_default').removeAttr('selected');
            $('#option_' + doc_select + '_' + tipo_select).attr('selected', 'selected');
            var temp = doc_select.charAt(0).toUpperCase() + doc_select.slice(1);
            $('#combo' + temp + 'Tipo').trigger('change');
        });
    </script>
<?php } ?>
