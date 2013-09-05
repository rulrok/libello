<div class="btn-toolbar">
    <div class="btn-group">
        <button class="btn btn-adicionar"><i class="icon-user"></i> Adicionar novo</button>
        <button class="btn btn-editar" href="#"><i class="icon-edit"></i> Editar</button>
        <button class="btn btn-danger btn-deletar" href="#"><i class="icon-remove"></i> Excluir</button>
    </div>
</div>
<table id="gerenciar_equipamento" class="tabelaDeEdicao">
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
        <button class="btn btn-adicionar"><i class="icon-user"></i> Adicionar novo</button>
        <button class="btn btn-editar" href="#"><i class="icon-edit"></i> Editar</button>
        <button class="btn btn-danger btn-deletar" href="#"><i class="icon-remove"></i> Excluir</button>
    </div>
</div>
<script src="publico/js/oTable.js"></script>
<script>
    //Este script configura as ações para os botões da página.
    $(document).ready(function() {
        configurarTabela({
            idTabela: 'gerenciar_equipamento',
            adicionar: 'index.php?c=equipamento&a=novo',
            editar: 'index.php?c=equipamento&a=editar&equipamentoID=',
            deletar: 'index.php?c=equipamento&a=remover&equipamentoID='
        });
    });


</script>