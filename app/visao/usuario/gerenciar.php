

<?php
$usuarios = usuarioDAO::consultar("idUsuario,concat(PNome,' ',UNome),email,login,dataNascimento,nome", "idUsuario <> " . $_SESSION['idUsuario']);
?>
<div class="botoesTabela">
    <label>
        <input type="button" id="btn_novo_superior" class="botaoTabela"  onclick="ajax('index.php?c=usuario&a=novo')" /> Adicionar
    </label>
    <label>
        <input type="button" id="btn_edit_superior" class="botaoTabela"/> Editar
    </label>
    <label>
        <input type="button" id="btn_del_superior" class="botaoTabela"/> Excluir
    </label>
</div>
<table id="gerenciar_usuario" class="tabelaDeEdicao">
    <thead>
        <tr>
            <th hidden>id</th>
            <th>Nome completo</th>
            <th>Email</th>
            <th>Login</th>
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
            echo '<td><center><input class="visualizarPermissoes" type="button" value="Ver"/></center></td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<div class="botoesTabela">
    <label>
        <input type="button" id="btn_novo_inferior" class="botaoTabela"  onmousedown="ajax('index.php?c=usuario&a=novo')" /> Adicionar
    </label>
    <label>
        <input type="button" id="btn_edit_inferior" class="botaoTabela"/> Editar
    </label>
    <label>
        <input type="button" id="btn_del_inferior" class="botaoTabela"/> Excluir
    </label>
</div>
<script id="pos_script">
            $(document).ready(function() {
                var selectedElement;
                var oTable = $('#gerenciar_usuario').dataTable({
                    "aaSorting": [[1, "asc"]]
                });

                $($("tr")[1]).addClass('row_selected');

                oTable.$('tr').click(function(e) {
                    oTable.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    selectedElement = this;
                });

                $("input[id^=btn_edit]").on('mousedown', function() {
                    var id = $("tr.row_selected>.campoID").html();
                    ajax("index.php?c=usuario&a=editar&userID=" + id);
                });

                $("input[id^=btn_del]").on('click', function() {
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
                    ajax("index.php?c=usuario&a=consultarpermissoes&userID=" + id, ".shaderFrameContent");
                });
            });


//    $('#table_id').dataTable();
</script>