<?php

$id = $_GET['poloID'];

if (poloDAO::remover($id)):
    sistemaDAO::registrarExclusaoPolo($_SESSION['idUsuario']);
    ?>
    <script>showPopUp("Polo removido com sucesso", "sucesso");</script>
<?php else : ?>
    <script>
        showPopUp("Erro ao remover o polo", "erro");
    </script>
<?php endif;
exit; ?>
