<?php
$id = $_GET['userID'];
$email = usuarioDAO::descobrirEmail($id);
if (usuarioDAO::remover($email)):
    ?>
<script>showPopUp("Usuário removido com sucesso","sucesso");</script>
<?php else : ?>
<script>
    showPopUp("Erro ao remover o usuário","erro");
</script>
<?php endif; exit;?>
