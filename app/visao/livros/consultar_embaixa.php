<title>Consultar livros | Baixa</title>
<table id="consulta-livro_embaixa" class="tabelaDeSelecao">
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
        foreach ($this->livrosBaixa as $value) {
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
            idTabela: "consulta-livro_embaixa",
            defs: {"aaSorting": [[0, "desc"]]}
        });
    });
</script>