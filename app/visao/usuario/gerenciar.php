

<?php
$usuarios = usuarioDAO::consultar("idUsuario,concat(PNome,' ',UNome),email,dataNascimento,nome", "idUsuario <> " . $_SESSION['idUsuario']);
?>
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
        <?
        foreach ($usuarios as $value) {
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
<script>
    $(document).ready(function() {
        var selectedElement;
        var oTable = $('#gerenciar_usuario').dataTable({
            "aaSorting": [[1, "asc"]]
        });

        $('input[aria-controls="gerenciar_usuario"]').on('keyup', function() {
            if ($('.row_selected').size() == 0) {
                $('.btn-deletar').addClass('disabled');
                $('.btn-deletar').attr('disabled',true);
                $('.btn-editar').addClass('disabled');
                $('.btn-editar').attr('disabled',true);
            } else {
                $('.btn-deletar').removeClass('disabled');
                $('.btn-deletar').attr('disabled',false);
                $('.btn-editar').removeClass('disabled');
                $('.btn-editar').attr('disabled',false);
            }
        });

        $($("#gerenciar_usuario tr")[1]).addClass('row_selected');

        oTable.$('tr').mousedown(function(e) {
            oTable.$('tr.row_selected').removeClass('row_selected');
            $(this).addClass('row_selected');
            selectedElement = this;
        });

        $(".btn-adicionar").on('click', function() {
            ajax('index.php?c=usuario&a=novo');
        });
        $(".btn-editar").on('mousedown', function() {
            if ($('.row_selected').size() == 0) {
                return false;
            }
            var id = $("tr.row_selected>.campoID").html();
            ajax("index.php?c=usuario&a=editar&userID=" + id);
        });

        $(".btn-deletar").on('click', function() {
            if ($('.row_selected').size() == 0) {
                return false;
            }
            if (confirm('Deseja realmente fazer isso?')) {
                var id = $("tr.row_selected>.campoID").html();
                ajax("index.php?c=usuario&a=remover&userID=" + id, "nenhum");
                var pos = oTable.fnGetPosition(selectedElement);
                oTable.fnDeleteRow(pos);
                $("tr.odd")[0].addClass("row_selected");
            }
        });

        $(".visualizarPermissoes").on('click', function() {
            var id = $("tr.row_selected>.campoID").html();
            $("#myModal").load("index.php?c=usuario&a=consultarpermissoes&userID=" + id).modal();

//            ajax("index.php?c=usuario&a=consultarpermissoes&userID=" + id, "#myModal");
        });
    });


//    $('#table_id').dataTable();
</script>