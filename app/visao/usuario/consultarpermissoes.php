<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

    <?php
    $login = usuarioDAO::descobrirLogin($_GET['userID']);
    if ($login != NULL) {
        $usuario = usuarioDAO::recuperarUsuario($login);
        echo "<h3 id=\"myModalLabel\">Usuário: " . $usuario->get_PNome() . " " . $usuario->get_UNome() . "</h3>";
        if ($usuario instanceof Usuario) :
            $resultado = usuarioDAO::obterPermissoes($_GET['userID']);
            ?>
        </div><div class="modal-body">


            <table class="tabelaPermissoes centered">
                <tr>
                    <th>Ferramenta</th>
                    <th>Permissão</th>
                </tr>
                <?php
                foreach ($resultado as $value) {
                    echo '<tr>';
                    echo '<td>' . $value['nome'] . "</td><td>" . $value['tipo'] . "</td>";
                    echo '</tr>';
                }
                ?>
            </table>
        </div>

        <?php
    else:
        echo "Usuário foi removido do banco de dados.";
    endif;
} else {
    echo "Nada foi encontrado";
}
?>
