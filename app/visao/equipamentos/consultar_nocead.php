<title>Consultar equipamentos | Em estoque</title>
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
        foreach ($this->equipamentosNoCead as $value) {
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
        configurarTabela({
            idTabela: "consulta-equipamento_nocead",
            defs: {"aaSorting": [[0, "desc"]]}
        });
    });
</script>