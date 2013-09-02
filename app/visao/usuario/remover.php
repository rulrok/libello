<?php
$id = $_GET['userID'];
$email = usuarioDAO::descobrirEmail($id);

if (usuarioDAO::remover($email)):
    sistemaDAO::registrarExclusaoUsuario($_SESSION['idUsuario'], $id);
    ?>
<script>showPopUp("Usuário removido com sucesso","sucesso");</script>
<?php else : ?>
<script>
    showPopUp("Erro ao remover o usuário","erro");
</script>
<?php endif; exit;?>
