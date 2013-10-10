
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

    <div id="oficiosValidos" >
        <button class="btn btn-visualizar"><i class="icon-search"></i> Visualizar</button>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>

        <?php
        echo $controladorAux->listarOficios('validos');
        ?>

        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
   
    

</div>
<div id="tabela2" class="tabelaConteudo" style="display: none;">

    
    <div id="memorandosValidos" >
        <button class="btn btn-visualizar"><i class="icon-search"></i> Visualizar</button>
        <?php require 'estruturas_auxiliares/topTable.php'; ?>
        <?php
        echo $controladorAux->listarMemorandos('validos');
        ?>
        <?php require 'estruturas_auxiliares/bottomTable.php'; ?>
        <?php require('estruturas_auxiliares/menuGerenciar.php'); ?>
    </div>
    
    
</div>
<script type="text/javascript">
        var tab_todosValidos,
                  tab_memorandosValidos;


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
               
            });
        }


        $(document).ready(function() {
        
            //configurarTabela({idTabela:'tabelaTodosOficios',editar:'',deletar:'',adicionar:''});
            $('#oficiosValidos .tabelaDeEdicao').attr('id', 'tabelaOficiosValidos');
            $('#memorandosValidos .tabelaDeEdicao').attr('id', 'tabelaMemorandosValidos');

            tab_todosValidos = $('#tabelaOficiosValidos').dataTable({"bJQueryUI": true});
            tab_memorandosValidos = $('#tabelaMemorandosValidos').dataTable({"bJQueryUI": true});

            mouseTabela(tab_todosValidos);
            mouseTabela(tab_memorandosValidos);

            function select(tab) {

                $(' tr.row_selected').each(function() {
                    $(this).removeClass('row_selected');
                });
                var selectedElement = $($('#' + tab.attr('id') + ' tr')[1]).addClass('row_selected');
                
            }

            $('.btn-visualizar').on('click', function() {
                if ($('#tabela1').css('display') != 'none')
                    window.open('app/modelo/relatoriosPDF/visualizarOficio.php?id=' + $('.row_selected td.campoID').text());
                else if ($('#tabela2').css('display') != 'none') {
                    window.open('app/modelo/relatoriosPDF/visualizarMemorando.php?id=' + $('.row_selected td.campoID').text());
                }
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