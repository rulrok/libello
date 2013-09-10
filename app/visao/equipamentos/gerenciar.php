<title>Gerenciar equipamentos</title>
<!-- Início da páginas -->
<div class="btn-toolbar">
    <div class="btn-group">
        <a href="#!equipamentos|novo" class="btn btn-adicionar"><i class="icon-plus"></i> Adicionar novo</a>
        <button class="btn btn-editar" href="#"><i class="icon-edit"></i> Editar</button>
        <button class="btn btn-saida btn-success" href="#"><i class="icon-arrow-left"></i> Registrar saída</button>
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
        <a href="#!equipamentos|novo" class="btn btn-adicionar"><i class="icon-plus"></i> Adicionar novo</a>
        <button class="btn btn-editar" href="#"><i class="icon-edit"></i> Editar</button>
        <button class="btn btn-saida btn-success" href="#"><i class="icon-arrow-left"></i> Registrar saída</button>
        <button class="btn btn-danger btn-deletar" href="#"><i class="icon-remove"></i> Excluir</button>
    </div>
</div>
<script>
    //Este script configura as ações para os botões da página.
    $(document).ready(function() {
        configurarTabela({
            idTabela: 'gerenciar_equipamento',
            editar: 'index.php?c=equipamentos&a=editar&equipamentoID=',
            deletar: 'index.php?c=equipamentos&a=remover&equipamentoID='
        });
    });
</script>