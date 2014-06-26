<title>Gerenciar cursos</title>
<!-- Início da página -->
<div class="btn-toolbar">
    <div class="btn-group">
        <a href="#!cursospolos|novocurso" class="btn btn-adicionar"><i class="icon-plus"></i> Adicionar novo</a>
        <button class="btn btn-editar" href="#"><i class="icon-edit"></i> Editar</button>
        <button class="btn btn-danger btn-deletar" href="#"><i class="icon-remove"></i> Excluir</button>
    </div>
</div>
<table id="gerenciar_curso" class="tabelaDeEdicao">
    <thead>
        <tr>
            <th hidden>id</th>
            <th>Nome do curso</th>
            <th>Área do curso</th>
            <th>Tipo do curso</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($this->cursos as $value) {
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
        <a href="#!cursospolos|novocurso" class="btn btn-adicionar"><i class="icon-plus"></i> Adicionar novo</a>
        <button class="btn btn-editar" href="#"><i class="icon-edit"></i> Editar</button>
        <button class="btn btn-danger btn-deletar" href="#"><i class="icon-remove"></i> Excluir</button>
    </div>
</div>

<script>
    $(document).ready(function() {
        configurarTabela({
            idTabela: 'gerenciar_curso',
            editar: '#!cursospolos|editarcurso&cursoID=',
            deletar: 'index.php?c=cursospolos&a=removerCurso&cursoID='
        });
    });
</script>