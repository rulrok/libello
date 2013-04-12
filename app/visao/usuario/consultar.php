

<?php
$usuarios = usuarioDAO::consultar("concat(PNome,' ',UNome),email,login,dataNascimento,nome");
?>
<table id="consulta_usuario" class="tabelaDeSelecao">
    <thead>
        <tr>
            <th>Nome completo</th>
            <th>Email</th>
            <th>Login</th>
            <th>Data de nascimento</th>
            <th>Papel</th>
        </tr>
    </thead>
    <tbody>
        <?
        foreach ($usuarios as $value) {
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
        var oTable = $('#consulta_usuario').dataTable();

        $(window).bind('resize', function() {
            oTable.fnAdjustColumnSizing();
        });

        oTable.$('tr').click(function(e) {
//            if ($(this).hasClass('row_selected')) {
//                $(this).removeClass('row_selected');
//            } else {
                oTable.$('tr.row_selected').removeClass('row_selected');
                $(this).addClass('row_selected');
//            }
        });

        oTable.$('tr').dblclick(function() {
            var data = oTable.fnGetData(this);
            window.alert(data);
            // ... do something with the array / object of data for the row
        });
    });
//    $('#table_id').dataTable();
</script>