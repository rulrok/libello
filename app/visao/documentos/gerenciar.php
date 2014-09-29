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
    @media all{
        @media (max-width: 1150px){
            .menuContainer{
                height: inherit;
            }
        }

    }
</style>

<link href="publico/css/documentos.css" rel="stylesheet">

<div style="text-align:center;">
    <button class="btn btn_oficio ignorar"
            id="b_oficio" 
            onclick="mostraOpcao('oficio');" 
            style="height: 30px; width: 150px;"
            >Ofícios</button>
    <button class="btn btn_memorando ignorar" 
            id="b_memorando" 
            onclick="mostraOpcao('memorando');" 
            style="height: 30px; width: 150px;"
            >Memorandos</button>
</div>


<div id="tabela1" class="tabelaConteudo" style="display: none;">

    <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    <?php require('estruturas_auxiliares/visualizarOficio.php'); ?>
    <div style="" id="todosOficios">
        <?php require 'estruturas_auxiliares/topTable.php'; ?>

        <?php
        echo $this->todosOficios;
        ?>

        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
    </div>
    <div id="oficiosValidos" style="display:none;">
        <?php require 'estruturas_auxiliares/topTable.php'; ?>

        <?php
        echo $this->oficiosValidos;
        ?>

        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
    </div>
    <div id="oficiosInvalidos" hidden="true">
        <?php require 'estruturas_auxiliares/topTable.php'; ?>

        <?php
        echo $this->oficiosInvalidos;
        ?>

        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
    </div>
    <div id="oficiosEmAberto" hidden="true">
        <?php require 'estruturas_auxiliares/topTable.php'; ?>

        <?php
        echo $this->oficiosEmAberto;
        ?>

        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
    </div>
    <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    <?php require('estruturas_auxiliares/visualizarOficio.php'); ?>

</div>
<div id="tabela2" class="tabelaConteudo" style="display: none;">

    <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    <?php require('estruturas_auxiliares/visualizarMemorando.php'); ?>
    <div style="" id="todosMemorandos">
        <?php require 'estruturas_auxiliares/topTable.php'; ?>
        <?php
        echo $this->todosMemorandos;
        ?>
        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
    </div>
    <div id="memorandosValidos" hidden="true">
        <?php require 'estruturas_auxiliares/topTable.php'; ?>
        <?php
        echo $this->memorandosValidos;
        ?>
        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
    </div>
    <div id="memorandosInvalidos" hidden="true">
        <?php require 'estruturas_auxiliares/topTable.php'; ?>
        <?php
        echo $this->memorandosInvalidos;
        ?>
        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
    </div>
    <div id="memorandosEmAberto" hidden="true">
        <?php require 'estruturas_auxiliares/topTable.php'; ?>
        <?php
        echo $this->memorandosEmAberto;
        ?>
        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
    </div>
    <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    <?php require('estruturas_auxiliares/visualizarMemorando.php'); ?>
</div>

<form id="form_visualizar" target="_blank" method="post" action="">
    <input type="hidden" id="idv" name="idv" />
</form>

<script type="text/javascript">
    var tab_todosOficios, tab_todosValidos, tab_todosInvalidos,
            tab_todosAberto, tab_todosMemorando, tab_memorandosValidos,
            tab_memorandosInvalidos, tab_memorandosAberto;
    var primeiro_acesso_oficio = 0;
    var primeiro_acesso_memorando = 0;
    var ignorarhash = true;
    var url_inicial = '#!documentos|gerenciar';
    var doc = null, tipo_oficio = null, tipo_memorando = null;


//
    function mouseTabela(tab) {


        $(' tr.row_selected').each(function () {
            $(this).removeClass('row_selected');
        });
        var selectedElement = $($('#' + tab.attr('id') + ' tr')[1]).addClass('row_selected');
        if ($(".numeracao", selectedElement).text() != '')
//            if ($(".numeracao", selectedElement).text() != "Em aberto") {
            if ($(".validacao", selectedElement).text() != "Em aberto") {
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

        tab.$('tr').mousedown(function (e) {
            $('tr.row_selected').removeClass('row_selected');
            $(this).parent().parent().find('tr.row_selected').removeClass('row_selected');
            $(this).addClass('row_selected');
            var selectedElement = this;
//            if ($(".numeracao", selectedElement).text() != "Em aberto") {
            if ($(".validacao", selectedElement).text() != "Em aberto") {
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

    function select(tab) {//selecionar primeiro elemento da tabela
//
//            $(' tr.row_selected').each(function() {
//                $(this).removeClass('row_selected');
//            });
//            var selectedElement = $($('#' + tab.attr('id') + ' tr')[1]).addClass('row_selected');
//           if($(".numeracao", selectedElement).text()!='')
//            if ($(".numeracao", selectedElement).text() != "Em aberto") {
//                $(".n_editavel").show();
//                if ($('.validacao', selectedElement).text() === 'Inválido') {
//                    $('.btn-invalidar').addClass('disabled');
//                    $('.btn-invalidar').attr({disabled: true});
//                } else {
//                    $('.btn-invalidar').removeClass('disabled');
//                    $('.btn-invalidar').removeAttr('disabled');
//                }
//            } else {
//                $(".editavel").show();
//            }
    }

    $(document).ready(function () {


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


        $('.visualizar-oficio').change(function () {
            var valor = $('.visualizar-oficio .active').val();
            //alert(valor);
            $('#todosOficios').hide();
            $('#oficiosValidos').hide();
            $('#oficiosInvalidos').hide();
            $('#oficiosEmAberto').hide();
            $(".n_editavel").hide();
            $(".editavel").hide();
            if (valor == "todos") {
                $('#todosOficios').show();
                if ($('#todosOficios th.ui-state-default').width() == 0) {
                    tab_todosOficios.fnAdjustColumnSizing();

                }
                //select(tab_todosOficios);
                if (tipo_oficio != '&tipo=todos') {
                    tipo_oficio = '&tipo=todos';
                    if (doc != null) {
                        document.ignorarHashChange = ignorarhash;
                        document.location.hash = url_inicial + '&doc=' + doc + tipo_oficio;
                    }
                }
            } else {
                if (valor == 'validos') {
                    $('#oficiosValidos').show();
                    if ($('#oficiosValidos th.ui-state-default').width() == 0) {

                        tab_todosValidos.fnAdjustColumnSizing();
                    }
                    // select(tab_todosValidos);
                    if (tipo_oficio != '&tipo=validos') {
                        tipo_oficio = '&tipo=validos';
                        document.ignorarHashChange = ignorarhash;
                        document.location.hash = url_inicial + '&doc=' + doc + tipo_oficio;
                    }
                } else {
                    if (valor == 'invalidos') {
                        $('#oficiosInvalidos').show();
                        if ($('#oficiosInvalidos th.ui-state-default').width() == 0) {

                            tab_todosInvalidos.fnAdjustColumnSizing();
                        }
                        if (tipo_oficio != '&tipo=invalidos') {
                            tipo_oficio = '&tipo=invalidos';
                            document.ignorarHashChange = ignorarhash;
                            document.location.hash = url_inicial + '&doc=' + doc + tipo_oficio;
                        }
                    } else {
                        if (valor == 'aberto') {
                            $('#oficiosEmAberto').show();
                            if ($('#oficiosEmAberto th.ui-state-default').width() == 0) {

                                tab_todosAberto.fnAdjustColumnSizing();
                            }
                            //   select(tab_todosAberto);
                            if (tipo_oficio != '&tipo=aberto') {
                                tipo_oficio = '&tipo=aberto';
                                document.ignorarHashChange = ignorarhash;
                                document.location.hash = url_inicial + '&doc=' + doc + tipo_oficio;
                            }
                        }
                    }
                }
            }
        });

        $('.visualizar-memorando').change(function () {
            var valor = $('.visualizar-memorando .active').val();
            $('#todosMemorandos').hide();
            $('#memorandosValidos').hide();
            $('#memorandosInvalidos').hide();
            $('#memorandosEmAberto').hide();
            $(".n_editavel").hide();
            $(".editavel").hide();

            if (valor == "todos") {
                $('#todosMemorandos').show();

                if ($('#todosMemorandos th.ui-state-default').width() == 0) {

                    tab_todosMemorandos.fnAdjustColumnSizing();
                }

                if (tipo_memorando != '&tipo=todos') {
                    tipo_memorando = '&tipo=todos';

                    if (doc != null) {
                        document.ignorarHashChange = ignorarhash;
                        document.location.hash = url_inicial + '&doc=' + doc + tipo_memorando;
                    }
                }
            } else {

                if (valor == 'validos') {

                    $('#memorandosValidos').show();
                    if ($('#memorandosValidos th.ui-state-default').width() == 0) {

                        tab_memorandosValidos.fnAdjustColumnSizing();
                    }

                    if (tipo_memorando != '&tipo=validos') {
                        tipo_memorando = '&tipo=validos';
                        document.ignorarHashChange = ignorarhash;
                        document.location.hash = url_inicial + '&doc=' + doc + tipo_memorando;
                    }
                } else {
                    if (valor == 'invalidos') {
                        $('#memorandosInvalidos').show();
                        if ($('#memorandosInvalidos th.ui-state-default').width() == 0) {

                            tab_memorandosInvalidos.fnAdjustColumnSizing();
                        }
                        if (tipo_memorando != '&tipo=invalidos') {
                            tipo_memorando = '&tipo=invalidos';
                            document.ignorarHashChange = ignorarhash;
                            document.location.hash = url_inicial + '&doc=' + doc + tipo_memorando;
                        }
                    } else {
                        if (valor == 'aberto') {
                            $('#memorandosEmAberto').show();
                            if ($('#memorandosEmAberto th.ui-state-default').width() == 0) {

                                tab_memorandosAberto.fnAdjustColumnSizing();
                            }
                            if (tipo_memorando != '&tipo=aberto') {
                                tipo_memorando = '&tipo=aberto';
                                document.ignorarHashChange = ignorarhash;
                                document.location.hash = url_inicial + '&doc=' + doc + tipo_memorando;
                            }
                        }
                    }
                }
            }
        });

        /**
         * Abaixo, botões de ação e visualizacao 
         *
         */
        //função botão visualizar
        //mostra o documento de acordo com o tipo da tabela visivel
        $('.btn-visualizar').on('click', function () {
            if ($('#tabela1').css('display') != 'none') {
                window.open('index.php?c=documentos&a=visualizarOficio&idv=' + $('.row_selected td.campoID').text());
            }
            else if ($('#tabela2').css('display') != 'none') {
                window.open('index.php?c=documentos&a=visualizarMemorando&idv=' + $('.row_selected td.campoID').text());
            }
        });

        //função botão invalidar
        $('.btn-invalidar').on('click', function () {
            var r = confirm("Tem certeza? O documento será permanentemente invalidado!");
            if (r) {
                var doc = $('tr.row_selected').attr('doc');
                var id = $('tr.row_selected .campoID').text();
                var acaoDeletar = "index.php?c=documentos&a=invalidar" + doc + "&i_id" + doc + "=";
                carregarAjax(acaoDeletar + id, {recipiente: null, async: false, sucesso: function () {
                        //Desabilitando os botões após a invalidação e antes da tela ser atualizada
                        $('.btn-invalidar').addClass('disabled');
                        $('.btn-invalidar').attr({disabled: true});

                        $('.btn-visualizar').addClass('disabled');
                        $('.btn-visualizar').attr({disabled: true});

                        $('.btn-aproveitar').addClass('disabled');
                        $('.btn-aproveitar').attr({disabled: true});

                        $('.btn-todos').addClass('disabled');
                        $('.btn-todos').attr({disabled: true});

                        $('.btn-validos').addClass('disabled');
                        $('.btn-validos').attr({disabled: true});

                        $('.btn-invalidos').addClass('disabled');
                        $('.btn-invalidos').attr({disabled: true});

                        $('.btn-em-aberto').addClass('disabled');
                        $('.btn-em-aberto').attr({disabled: true});

                        $('.btn_oficio').addClass('disabled');
                        $('.btn_oficio').attr({disabled: true});

                        $('.btn_memorando').addClass('disabled');
                        $('.btn_memorando').attr({disabled: true});

                        //TODO Ao invés de recarregar a páginas, poderia ser alterada a linha da dataTable apenas
                        setTimeout(function () {
                            document.location.reload();
                        }, 2500);
//                            document.location.reload();
//                            $('tr.row_selected').hide();
                    }
                });
            }
        });

        //função botão deletar
        $('.btn-deletar').on('click', function () {
            var r = confirm("Tem certeza? O documento será permanentemente excluido!");
            if (r) {
                var id = $('tr.row_selected .campoID').text();
                var doc = $('tr.row_selected').attr('doc');

                var acaoDeletar = "index.php?c=documentos&a=deletar" + doc + "&i_id" + doc + "=";
                carregarAjax(acaoDeletar + id, {recipiente: null, async: false, sucesso: function () {
                        //Desabilitando os botões após deletar a linha e antes da tela ser atualizada
                        $('.btn-visualizar').addClass('disabled');
                        $('.btn-visualizar').attr({disabled: true});

                        $('.btn-editar').addClass('disabled');
                        $('.btn-editar').attr({disabled: true});

                        $('.btn-deletar').addClass('disabled');
                        $('.btn-deletar').attr({disabled: true});

                        $('.btn-todos').addClass('disabled');
                        $('.btn-todos').attr({disabled: true});

                        $('.btn-validos').addClass('disabled');
                        $('.btn-validos').attr({disabled: true});

                        $('.btn-invalidos').addClass('disabled');
                        $('.btn-invalidos').attr({disabled: true});

                        $('.btn-em-aberto').addClass('disabled');
                        $('.btn-em-aberto').attr({disabled: true});

                        $('.btn_oficio').addClass('disabled');
                        $('.btn_oficio').attr({disabled: true});

                        $('.btn_memorando').addClass('disabled');
                        $('.btn_memorando').attr({disabled: true});

                        //Ocultando a linha que acabou de ser apagada
                        $('tr.row_selected').hide();

                        setTimeout(function () {
                            document.location.reload();
                        }, 2500);
                    }
                });
            }
        });

        //função botão editar
        $('.btn-editar').on('click', function () {
            var doc = $('tr.row_selected').attr('doc');
            var temp = doc[0].toUpperCase() + doc.slice(1);
            var id = $('tr.row_selected .campoID').text();
            document.location.href = '#!documentos|' + doc + '&id=' + id;
        });

        //função botão aproveitar
        $('.btn-aproveitar').on('click', function () {
            var doc = $('tr.row_selected').attr('doc');
            var temp = doc[0].toUpperCase() + doc.slice(1);
            var id = $('tr.row_selected .campoID').text();
            document.location.href = '#!documentos|' + doc + '&id=' + id + '&acao=aproveitar';
//document.location.href = '#!documentos|' + doc + '&id=' + id;
        });

<?php if (!isset($_GET['tipo'])) { ?>
            $('.btn-todos').click();
<?php } ?>

    });

    function mostraOpcao(opcao) {
        if (opcao == 'oficio') {
            $(".editavel").hide(); //Esconde os botoes de vizualização/ediçao/exclusao
            $(".n_editavel").hide(); //Esconde os botoes de visualizar/aproveitar/invalidar
            $('#b_oficio').addClass('active');
            $('#b_memorando').removeClass('active');
            $('#tabela1').show();
            $('#tabela2').hide();
            if (primeiro_acesso_oficio == 0) {
                //$('.visualizar-oficio ').change();
                setTimeout(function () {
                    tab_todosOficios.fnAdjustColumnSizing();
                    select(tab_todosOficios);
                }, 50);
                primeiro_acesso_oficio = 1;
            }
            if (doc != 'oficio') {
                doc = 'oficio';
                document.ignorarHashChange = ignorarhash;
                if (tipo_oficio == null) {
                    document.location.hash = url_inicial + '&doc=' + doc;

                } else {
                    document.location.hash = url_inicial + '&doc=' + doc + tipo_oficio;
                }
            }

        } else if (opcao == 'memorando') {
            $(".editavel").hide(); //Esconde os botoes de vizualização/ediçao/exclusao
            $(".n_editavel").hide(); //Esconde os botoes de visualizar/aproveitar/invalidar
            $('#b_memorando').addClass('active');
            $('#b_oficio').removeClass('active');
            $('#tabela1').hide();
            $('#tabela2').show();
            if (primeiro_acesso_memorando == 0) {
                setTimeout(function () {
                    tab_todosMemorandos.fnAdjustColumnSizing();
                    select(tab_todosMemorandos);
                }, 50);
                primeiro_acesso_memorando = 1;
            }
            if (doc != 'memorando') {
                doc = 'memorando';
                document.ignorarHashChange = ignorarhash;
                if (tipo_memorando == null) {
                    document.location.hash = url_inicial + '&doc=' + doc;

                } else {
                    document.location.hash = url_inicial + '&doc=' + doc + tipo_memorando;
                }
            }
        }
    }

</script>
<?php
if (filter_has_var(INPUT_GET, 'doc')) {//reload, delete ou invalidar usam isso para voltar na pagina certa
    ?>
    <script>
        var doc_select = '<?php echo filter_input(INPUT_GET, 'doc'); ?>';
        $(document).ready(function () {
            doc = doc_select;
            $('.btn_' + doc_select).click();
        });
    </script>
    <?php
}
if (filter_has_var(INPUT_GET, 'tipo')) {
    ?>
    <script>
        var tipo_select = '<?php echo filter_input(INPUT_GET, 'tipo'); ?>';
        $(document).ready(function () {
            ignorarhash = false;
            $('.visualizar-' + doc + ' .btn-' + tipo_select).click();
            ignorarhash = true;
            //            if (doc == 'oficio') {
            //                tipo_oficio = '&tipo=' + tipo_select;
            //            } else if (doc = 'memorando') {
            //                tipo_memorando = '&tipo=' + tipo_select;
            //            }
            //            $('#option_' + doc_select + '_default').removeAttr('selected');
            //            $('#option_' + doc_select + '_' + tipo_select).attr('selected', 'selected');
            //            var temp = doc_select.charAt(0).toUpperCase() + doc_select.slice(1);
            //            $('#combo' + temp + 'Tipo').trigger('change');
        });
    </script>
<?php } ?>
