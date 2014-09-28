<title>Consultar usuários</title>
<!-- Início da página --><table id="consulta_usuario" class="tabelaDeSelecao">
    <thead>
        <tr>
            <th hidden>id</th>
            <th>Nome completo</th>
            <th>Email</th>
            <th>Data de nascimento</th>
            <th>Papel</th>
            <th>Permissões</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($this->usuarios as $value) {
            echo '<tr>';
            for ($i = 0; $i < sizeof($value) / 2; $i++) {
                echo $i == 0 ? '<td hidden class="campoID">' : '<td>';
                echo $value[$i];
                echo '</td>';
            }
            echo '<td><center><input class="btn visualizarPermissoes" type="button" value="Ver"/></center></td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<script id="pos_script">
    $(document).ready(function () {
        var oTable = $('#consulta_usuario').dataTable({
            "aaSorting": [[1, "asc"]]
        });

        $(window).bind('resize', function () {
            oTable.fnAdjustColumnSizing();
        });
        oTable.$('tr').mousedown(function () {
            if ($(this).hasClass('row_selected')) {
                return;
            } else {
                oTable.$('tr.row_selected').removeClass('row_selected');
                $(this).addClass('row_selected');
            }
        });
    });
</script>