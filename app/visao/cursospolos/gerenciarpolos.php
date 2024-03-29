<title>Gerenciar polos</title>
<!-- Início da página -->
<div class="btn-toolbar">
    <div class="btn-group">
        <a href="#!cursospolos|novopolo" class="btn btn-adicionar"><i class="icon-plus"></i> Adicionar novo</a>
        <button class="btn btn-editar" href="#"><i class="icon-edit"></i> Editar</button>
        <button class="btn btn-danger btn-deletar" href="#"><i class="icon-remove"></i> Excluir</button>
    </div>
</div>
<table id="gerenciar_polo" class="tabelaDeEdicao">
    <thead>
        <tr>
            <th hidden>id</th>
            <th>Nome do polo</th>
            <th>Cidade</th>
            <th>UF</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($this->polos as $value) {
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
        <a href="#!cursospolos|novopolo" class="btn btn-adicionar"><i class="icon-plus"></i> Adicionar novo</a>
        <button class="btn btn-editar" href="#"><i class="icon-edit"></i> Editar</button>
        <button class="btn btn-danger btn-deletar" href="#"><i class="icon-remove"></i> Excluir</button>
    </div>
</div>

<script>
    $(document).ready(function() {
        configurarTabela({
            idTabela: 'gerenciar_polo',
            editar: '#!cursospolos|editarpolo&poloID=',
            deletar: 'index.php?c=cursospolos&a=removerPolo&poloID='
        });
    });
</script>