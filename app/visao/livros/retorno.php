<title>Retorno de livros</title>
<!-- Início da páginas -->
<div class="btn-toolbar">
    <div class="btn-group">
        <button class="btn btn-retorno btn-success" href="#"><i class="icon-arrow-right"></i> Registrar retorno</button>
        <button class="btn btn-baixa btn-info" href="#"><i class="icon-arrow-down"></i> Registrar Baixa</button>
    </div>
</div>
<table id="saida_livro" class="tabelaDeEdicao">
    <thead>
        <tr>
            <th hidden>id</th>
            <th>Livro</th>
            <th>Patrimônio</th>
            <th>Responsável</th>
            <th>Local</th>
            <th>Qtd</th>
            <th>Data Saída</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($this->saidas as $value) {
            echo '<tr>';
            for ($i = 0; $i < sizeof($value) / 2; $i++) {
                if ($i === 0) {
                    echo '<td hidden class="campoID">';
                    } elseif ($i === 4 && $value[$i] == "") {
                    continue;
                    } elseif ($i === 5 && $value[$i] == "") {
                    
                } else {
                    echo "<td>";
                }
//                echo $i == 0 ? '<td hidden class="campoID">' : '<td>';
                echo $value[$i];
                echo '</td>';
            }
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<div class="btn-toolbar">
    <div class="btn-group">
        <button class="btn btn-retorno btn-success" href="#"><i class="icon-arrow-right"></i> Registrar retorno</button>
        <button class="btn btn-baixa btn-info" href="#"><i class="icon-arrow-down"></i> Registrar Baixa</button>
    </div>
</div>
<script>
    //Este script configura as ações para os botões da página.
    $(document).ready(function() {
        configurarTabela({
            idTabela: 'saida_livro',
            retorno: '#!livros|novoretorno&saidaID=',
            baixa: "#!livros|novabaixa&saidaID="
        });
    });
</script>