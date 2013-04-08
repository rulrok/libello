

<?php
$teste = usuarioDAO::consultar("PNome,UNome,email,login,dataNascimento");
?>
<table id="table_id">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Sobrenome</th>
            <th>email</th>
            <th>login</th>
            <th>Data de nascimento</th>
        </tr>
    </thead>
    <tbody>
        <?
        foreach ($teste as $value) {
            echo '<tr>';
            for ($i = 0; $i < sizeof($value) / 2; $i++) {
                echo '<td>';
                echo $value[$i];
                echo '</td>';
            }
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<script id="pos_script">
    $('#table_id').dataTable();
</script>