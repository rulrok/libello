<title>Saída de equipamentos</title>
<!-- Início da páginas -->
<div class="btn-toolbar">
    <div class="btn-group">
        <button class="btn btn-saida btn-success" href="#"><i class="icon-arrow-left"></i> Registrar saída</button>
        <!--<button class="btn btn-baixa btn-info" href="#"><i class="icon-arrow-down"></i> Registrar Baixa</button>-->
    </div>
</div>
<table id="saida_equipamento" class="tabelaDeEdicao">
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
<div class="btn-toolbar">
    <div class="btn-group">
        <button class="btn btn-saida btn-success" href="#"><i class="icon-arrow-left"></i> Registrar saída</button>
        <!--<button class="btn btn-baixa btn-info" href="#"><i class="icon-arrow-down"></i> Registrar Baixa</button>-->
    </div>
</div>
<script>
    //Este script configura as ações para os botões da página.
    $(document).ready(function() {
        configurarTabela({
            idTabela: 'saida_equipamento',
            saida: '#!equipamentos|novasaida&equipamentoID='
        });
    });
</script>