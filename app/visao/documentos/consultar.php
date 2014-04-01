<title>Consultar</title>


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
    @media all{
        @media (max-width: 1150px){
            .menuContainer{
                height: inherit;
            }
        }

    }

</style>



<div style="text-align:center;">
    <input class="btn btn_oficio" type="button" id="b_oficio" value="Ofícios" onclick="mostraOpcao('oficio')" style="height: 30px; width: 150px;"/>
    <input class="btn btn_memorando" type="button" id="b_memorando" value="Memorandos" onclick="mostraOpcao('memorando')" style="height: 30px; width: 150px;"/>
</div>


<div id="tabela1" class="tabelaConteudo" style="display: none;">

    <div id="oficiosValidos" >
        <button class="btn btn-visualizar"><i class="icon-search"></i> Visualizar</button>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>

        <?php
        echo $this->oficios;
        ?>

        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
    </div>



</div>
<div id="tabela2" class="tabelaConteudo" style="display: none;">


    <div id="memorandosValidos" >
        <button class="btn btn-visualizar"><i class="icon-search"></i> Visualizar</button>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>
        <?php
        echo $this->memorandos;
        ?>
        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
    </div>


</div>
<form id="form_visualizar" target="_blank" method="post" action="">
    <input type="hidden" id="idv" name="idv" />
</form>

<script type="text/javascript">
    var tab_todosValidos,
            tab_memorandosValidos;

    var url_inicial = '#!documentos|consultar';
    var doc = null;

    function select(tab) {

        $(' tr.row_selected').each(function() {
            $(this).removeClass('row_selected');
        });
        var selectedElement = $($('#' + tab.attr('id') + ' tr')[1]).addClass('row_selected');

    }


    function mostraOpcao(opcao) {//acao dos botoes que mostra ou oficio ou memorando
        if (opcao == 'oficio') {
            $('#b_oficio').addClass('active');
            $('#b_memorando').removeClass('active');
            $('#tabela1').show();
            $('#tabela2').hide();
            tab_todosValidos.fnAdjustColumnSizing();
            select(tab_todosValidos);
            if (doc != 'oficio') {
                doc = 'oficio';
                document.ignorarHashChange = true;
                document.location.hash = url_inicial + '&doc=' + doc;
            }
        } else if (opcao == 'memorando') {
            $('#b_memorando').addClass('active');
            $('#b_oficio').removeClass('active');
            $('#tabela1').hide();
            $('#tabela2').show();
            tab_memorandosValidos.fnAdjustColumnSizing();
            select(tab_memorandosValidos);
            if (doc != 'memorando') {
                doc = 'memorando';
                document.ignorarHashChange = true;
                document.location.hash = url_inicial + '&doc=' + doc;
            }
        }
    }

    function mouseTabela(tab) {//funcao que atribui o evento de click as linhas de alguma data table
        tab.$('tr').mousedown(function(e) {

            $(this).parent().parent().find('tr.row_selected').removeClass('row_selected');
            $(this).addClass('row_selected');
            var selectedElement = this;

        });
    }


    $(document).ready(function() {

        $('#oficiosValidos .tabelaDeEdicao').attr('id', 'tabelaOficiosValidos');
        $('#memorandosValidos .tabelaDeEdicao').attr('id', 'tabelaMemorandosValidos');

        tab_todosValidos = $('#tabelaOficiosValidos').dataTable({"aaSorting": [[1, "asc"]]});
        tab_memorandosValidos = $('#tabelaMemorandosValidos').dataTable({"aaSorting": [[1, "asc"]]});

        mouseTabela(tab_todosValidos);
        mouseTabela(tab_memorandosValidos);

        $('.btn-visualizar').on('click', function() {
            if ($('#tabela1').css('display') != 'none') {
                window.open('index.php?c=documentos&a=visualizarOficio&idv=' + $('.row_selected td.campoID').text());
//                    $('#form_visualizar').attr('action', 'app/modelo/relatoriosPDF/visualizarOficio.php');
//                    $('#idv').val($('.row_selected td.campoID').text());
//                    $('#form_visualizar').submit();
                //window.open('app/modelo/relatoriosPDF/visualizarOficio.php');
            }
            else if ($('#tabela2').css('display') != 'none') {
                window.open('index.php?c=documentos&a=visualizarMemorando&idv=' + $('.row_selected td.campoID').text());
//                    $('#form_visualizar').attr('action', 'app/modelo/relatoriosPDF/visualizarMemorando.php');
//                    $('#idv').val($('.row_selected td.campoID').text());
//                    $('#form_visualizar').submit();
            }
        });

    });


</script>
<?php
if (isset($_GET['doc'])) {
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
?>
