<title>Retorno de equipamentos</title>
<!-- Início da páginas -->
<div class="btn-toolbar">
    <div class="btn-group">
        <button class="btn btn-retorno btn-success" href="#"><i class="icon-arrow-right"></i> Registrar retorno</button>
        <button class="btn btn-baixa btn-info" href="#"><i class="icon-arrow-down"></i> Registrar Baixa</button>
    </div>
</div>
<table id="saida_equipamento" class="tabelaDeEdicao">
    <thead>
        <tr>
            <th hidden>id</th>
            <th>Equipamento</th>
            <th>Patrimônio</th>
            <th>Responsável</th>
            <th>Destino</th>
            <th>Qtd</th>
            <th>Data Saída</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($this->saidas as $value) {
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
            idTabela: 'saida_equipamento',
            retorno: '#!equipamentos|novoretorno&saidaID=',
            baixa: "#!equipamentos|novabaixa&saidaID="
        });
    });
</script>