<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

    <?php
    $idUsuario = fnDecrypt(filter_input(INPUT_GET, 'userID'));
    $usuarioDAO = new usuarioDAO();
    $email = $usuarioDAO->descobrirEmail($idUsuario);
    if ($email != NULL) {
        $usuario = $usuarioDAO->recuperarUsuario($email);
        echo "<h3 id=\"myModalLabel\">Usuário: " . $usuario->get_PNome() . " " . $usuario->get_UNome() . "</h3>";
        if ($usuario instanceof Usuario) :
            $resultado = $usuarioDAO->obterPermissoes($idUsuario);
            ?>
        </div>
        <div class="modal-body">


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
        <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
        <?php
    else:
        echo "Usuário foi removido do banco de dados.";
    endif;
} else {
    echo "Nada foi encontrado (usuário sem email cadastrado?)";
}
?>