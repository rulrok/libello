<title>Consultar livros | Em estoque</title>
<table id="consulta-livro_interno" class="tabelaDeSelecao">
    <thead>
        <tr>
            <th>Livro</th>
            <th>Gráfica</th>
            <th>Área</th>
            <th>Qtd</th>
            <th>Data de entrada</th>
            <th>Patrimônio</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($this->livrosInternos as $value) {
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
            idTabela: "consulta-livro_interno",
            defs: {"aaSorting": [[0, "desc"]]}
        });
    });
</script>