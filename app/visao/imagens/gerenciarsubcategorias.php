<title>Subcategorias de imagens</title>
<!-- Início da página --><div class="btn-toolbar">
    <div class="btn-group">
        <a href="#!imagens|novaSubcategoria" class="btn btn-adicionar"><i class="icon-user"></i> Adicionar nova</a>
        <button class="btn btn-editar" href="#"><i class="icon-edit"></i> Editar</button>
        <button class="btn btn-danger btn-deletar" href="#"><i class="icon-ban-circle"></i> Excluir</button>
    </div>
</div>
<table id="gerenciar_subcategorias" class="tabelaDeEdicao">
    <thead>
        <tr>
            <th hidden>id</th>
            <th>Nome</th>
            <th>Categoria pai</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($this->subcategorias as $subcategoria) {
            echo '<tr>';
            for ($i = 0; $i < sizeof($subcategoria) / 2; $i++) {
                echo $i == 0 ? '<td hidden class="campoID">' : '<td>';
                echo $subcategoria[$i];
                echo '</td>';
            }
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<div class="btn-toolbar">
    <div class="btn-group">
        <a href="#!imagens|novaSubcategoria" class="btn btn-adicionar"><i class="icon-user"></i> Adicionar nova</a>
        <button class="btn btn-editar" href="#"><i class="icon-edit"></i> Editar</button>
        <button class="btn btn-danger btn-deletar" href="#"><i class="icon-ban-circle"></i> Excluir</button>
    </div>
</div>
<script>
    //Este script configura as ações para os botões da página.
    $(document).ready(function() {
        configurarTabela({
            idTabela: 'gerenciar_subcategorias',
            editar: '#!imagens|editarSubcategoria&subcategoriaID=',
            deletar: 'index.php?c=imagens&a=removerSubcategoria&subcategoriaID='
        });
    });


</script>