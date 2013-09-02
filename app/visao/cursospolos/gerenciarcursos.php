


<div class="btn-toolbar">
    <div class="btn-group">
        <button class="btn btn-adicionar"><i class="icon-user"></i> Adicionar novo</button>
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
//            echo '<td><center><input class="btn visualizarPermissoes" type="button" value="Ver"/></center></td>';
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
<script>
    $(document).ready(function() {
        var selectedElement;
        var oTable = $('#gerenciar_curso').dataTable({
            "aaSorting": [[1, "asc"]]
        });

        $('input[aria-controls="gerenciar_curso"]').on('keyup', function() {
            if ($('.row_selected').size() == 0) {
                $('.btn-deletar').addClass('disabled');
                $('.btn-deletar').attr('disabled', true);
                $('.btn-editar').addClass('disabled');
                $('.btn-editar').attr('disabled', true);
            } else {
                $('.btn-deletar').removeClass('disabled');
                $('.btn-deletar').attr('disabled', false);
                $('.btn-editar').removeClass('disabled');
                $('.btn-editar').attr('disabled', false);
            }
        });

        $($("#gerenciar_curso tr")[1]).addClass('row_selected');
        selectedElement = $("#gerenciar_curso tr")[1];

        oTable.$('tr').mousedown(function(e) {
            oTable.$('tr.row_selected').removeClass('row_selected');
            $(this).addClass('row_selected');
            $('.btn-deletar').removeClass('disabled');
            $('.btn-deletar').attr('disabled', false);
            $('.btn-editar').removeClass('disabled');
            $('.btn-editar').attr('disabled', false);
            selectedElement = this;
        });

        $(".btn-adicionar").on('click', function() {
            ajax('index.php?c=cursospolos&a=novocurso');
        });
        $(".btn-editar").on('mousedown', function() {
            if ($('.row_selected').size() == 0) {
                return false;
            }
            var id = $("tr.row_selected>.campoID").html();
            ajax("index.php?c=cursospolos&a=editarcurso&cursoID=" + id);
        });

        $(".btn-deletar").on('click', function() {
            if ($('.row_selected td').attr('class') == 'dataTables_empty' | $('.row_selected').size() == 0) {
                return false;
            }
            if (confirm('Deseja realmente fazer isso?')) {
                var id = $("tr.row_selected>.campoID").html();
                ajax("index.php?c=cursospolos&a=removerCurso&cursoID=" + id, "nenhum");
                var pos = oTable.fnGetPosition(selectedElement);
                oTable.fnDeleteRow(pos);

                $("tr.odd")[0].addClass("row_selected");

            }
        });
    });


//    $('#table_id').dataTable();
</script>