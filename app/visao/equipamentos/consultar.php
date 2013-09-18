<title>Consultar equipamentos</title>
<!-- Início da página -->
<ul class="nav nav-tabs" id="abas">
    <li><a href="javascript:void(0)" onclick="ajax('index.php?c=equipamentos&a=consultar_nocead','#resultado_consulta',false);" data-toggle="tab">No CEAD</a></li>
    <li><a href="javascript:void(0)" onclick="ajax('index.php?c=equipamentos&a=consultar_foracead','#resultado_consulta',false);" data-toggle="tab">Fora do CEAD</a></li>
    <li><a href="javascript:void(0)" onclick="ajax('index.php?c=equipamentos&a=consultar_embaixa','#resultado_consulta',false);" data-toggle="tab">Baixa</a></li>
</ul>
<div id="resultado_consulta">
    
</div>
<!--<div class="tab-content">
    <div class="tab-pane active" id="nocead">
        <table id="consulta-equipamento_nocead" class="tabelaDeSelecao">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Qtd</th>
                    <th>Data de entrada</th>
                    <th>Patrimônio</th>
                </tr>
            </thead>
            <tbody>
                <?php
//                foreach ($this->equipamentosNoCead as $value) {
//                    echo '<tr>';
//                    for ($i = 0; $i < sizeof($value) / 2; $i++) {
//                        echo '<td>';
//                        echo $value[$i];
//                        echo '</td>';
//                    }
//                    echo '</tr>';
//                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="tab-pane" id="foracead">
        <table id="consulta-equipamento_foracead" class="tabelaDeSelecao">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Qtd</th>
                    <th>Data de entrada</th>
                    <th>Patrimônio</th>
                </tr>
            </thead>
            <tbody>
                <?php
//                foreach ($this->equipamentosForaCead as $value) {
//                    echo '<tr>';
//                    for ($i = 0; $i < sizeof($value) / 2; $i++) {
//                        echo '<td>';
//                        echo $value[$i];
//                        echo '</td>';
//                    }
//                    echo '</tr>';
//                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="tab-pane" id="embaixa">
        <table id="consulta-equipamento_embaixa" class="tabelaDeSelecao">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Qtd Baixa</th>
                    <th>Data da baixa</th>
                    <th>Patrimônio</th>
                    <th>Obs</th>
                </tr>
            </thead>
            <tbody>
                <?php
//                foreach ($this->equipamentosBaixa as $value) {
//                    echo '<tr>';
//                    for ($i = 0; $i < sizeof($value) / 2; $i++) {
//                        echo '<td>';
//                        echo $value[$i];
//                        echo '</td>';
//                    }
//                    echo '</tr>';
//                }
                ?>
            </tbody>
        </table>
    </div>
</div>-->
<script id="pos_script">
    $(document).ready(function() {
//        var oTable = $('table[id^=consulta-equipamento]').dataTable({
//            "aaSorting": [[0, "desc"]]
//        });
//        $(window).bind('resize', function() {
//            oTable.fnAdjustColumnSizing();
//        });

//        oTable.$('tr').mousedown(function() {
//            if ($(this).hasClass('row_selected')) {
//                return;
//            } else {
//                oTable.$('tr.row_selected').removeClass('row_selected');
//                $(this).addClass('row_selected');
//            }
//        });

        //Script necessário para as abas
        $('#abas a:first').tab('show');
        $('#abas a:first').click();
    });
</script>