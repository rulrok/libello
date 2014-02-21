<title>Descritores</title>
<!-- Início da página --><div class="btn-toolbar">
    <div class="btn-group">
        <a href="#!imagens|novaCategoria" class="btn btn-adicionar"><i class="icon-user"></i> Adicionar nova</a>
        <button class="btn btn-editar" href="#"><i class="icon-edit"></i> Editar</button>
        <button class="btn btn-danger btn-deletar" href="#"><i class="icon-remove"></i> Excluir</button>
    </div>
</div>
<table id="gerenciar_categorias" class="tabelaDeEdicao">
    <thead>
        <tr>
            <th hidden>id</th>
            <th>Nome</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($this->categorias as $categoria) {
            echo '<tr>';
            for ($i = 0; $i < sizeof($categoria) / 2; $i++) {
                echo $i == 0 ? '<td hidden class="campoID">' : '<td>';
                echo $categoria[$i];
                echo '</td>';
            }
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<div class="btn-toolbar">
    <div class="btn-group">
        <a href="#!imagens|novaCategoria" class="btn btn-adicionar"><i class="icon-user"></i> Adicionar nova</a>
        <button class="btn btn-editar" href="#"><i class="icon-edit"></i> Editar</button>
        <button class="btn btn-danger btn-deletar" href="#"><i class="icon-remove"></i> Excluir</button>
    </div>
</div>
<script>
    //Este script configura as ações para os botões da página.
    $(document).ready(function() {
        configurarTabela({
            idTabela: 'gerenciar_categorias',
            editar: '#!imagens|editarCategoria&categoriaID=',
            deletar: 'index.php?c=imagens&a=removerCategoria&categoriaID='
        });
    });


</script>