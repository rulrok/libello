


<div class="btn-toolbar">
    <div class="btn-group">
        <button class="btn btn-adicionar"><i class="icon-user"></i> Adicionar novo</button>
        <button class="btn btn-editar" href="#"><i class="icon-edit"></i> Editar</button>
        <button class="btn btn-danger btn-deletar" href="#"><i class="icon-remove"></i> Excluir</button>
    </div>
</div>
<table id="gerenciar_usuario" class="tabelaDeEdicao">
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
<div class="btn-toolbar">
    <div class="btn-group">
        <button class="btn btn-adicionar"><i class="icon-user"></i> Adicionar novo</button>
        <button class="btn btn-editar" href="#"><i class="icon-edit"></i> Editar</button>
        <button class="btn btn-danger btn-deletar" href="#"><i class="icon-remove"></i> Excluir</button>
    </div>
</div>
<script src="publico/js/oTable.js"></script>
<script>
    $(document).ready(function() {
        configurarTabela({
            idTabela: 'gerenciar_usuario',
            adicionar: 'index.php?c=usuario&a=novo',
            editar: 'index.php?c=usuario&a=editar&userID=',
            deletar: 'index.php?c=usuario&a=remover&userID='
        });
    });


</script>