<?php
$id = $_GET['userID'];
$login = usuarioDAO::descobrirLogin($id);
if (usuarioDAO::remover($login)):
    ?>
<script>showPopUp("Usuário removido com sucesso");</script>
<?php else : ?>
<script>
    showPopUp("Erro ao remover o usuário");
</script>
<?php endif; exit;?>
