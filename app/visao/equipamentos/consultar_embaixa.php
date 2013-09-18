
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
        foreach ($this->equipamentosBaixa as $value) {
            echo '<tr>';
            for ($i = 0; $i < sizeof($value) / 2; $i++) {
                echo '<td>';
                echo $value[$i];
                echo '</td>';
            }
            echo '</tr>';
        }
        ?>
    </tbody>
</table>

<script id="pos_script">
    $(document).ready(function() {
        var oTable = $('table[id^=consulta-equipamento]').dataTable({
            "aaSorting": [[0, "desc"]]
        });
        $(window).bind('resize', function() {
            oTable.fnAdjustColumnSizing();
        });

//        oTable.$('tr').mousedown(function() {
//            if ($(this).hasClass('row_selected')) {
//                return;
//            } else {
//                oTable.$('tr.row_selected').removeClass('row_selected');
//                $(this).addClass('row_selected');
//            }
//        });

        //Script necessário para as abas
//        $('#abas a:first').tab('show');
    });
</script>