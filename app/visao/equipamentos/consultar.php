<title>Consultar equipamentos</title>
<!-- Início da página -->
<ul class="nav nav-tabs" id="abas">
    <li><a href="#nocead" data-toggle="tab">No CEAD</a></li>
    <li><a href="#foracead" data-toggle="tab">Fora do CEAD</a></li>
    <li><a href="#embaixa" data-toggle="tab">Baixa</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="nocead">
        <table id="consulta_equipamento" class="tabelaDeSelecao">
            <thead>
                <tr>
                    <th hidden>id</th>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Data de entrada</th>
                    <th>Patrimônio</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($this->equipamentos as $value) {
                    echo '<tr>';
                    for ($i = 0; $i < sizeof($value) / 2; $i++) {
                        echo $i == 0 ? '<td hidden class="campoID">' : '<td>';
                        echo $value[$i];
                        echo '</td>';
                    }
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="tab-pane" id="foracead">...</div>
    <div class="tab-pane" id="embaixa">...</div>
</div>
<script id="pos_script">
    $(document).ready(function() {
        var oTable = $('#consulta_equipamento').dataTable({
            "aaSorting": [[1, "asc"]]
//            "sDom": '<"toolbar">frtip'
        });
//        $("div.toolbar").html('Custom tool bar! Text/images etc.');
        $(window).bind('resize', function() {
            oTable.fnAdjustColumnSizing();
        });

        oTable.$('tr').mousedown(function() {
            if ($(this).hasClass('row_selected')) {
                return;
            } else {
                oTable.$('tr.row_selected').removeClass('row_selected');
                $(this).addClass('row_selected');
            }
        });

    });
</script>
<script>
  $(function () {
    $('#abas a:first').tab('show');
  });
</script>