<?php

$id = $_GET['cursoID'];

if (cursoDAO::remover($id)):
    sistemaDAO::registrarExclusaoCurso($_SESSION['idUsuario']);
    ?>
    <script>showPopUp("Curso removido com sucesso", "sucesso");</script>
<?php else : ?>
    <script>
        showPopUp("Erro ao remover o curso", "erro");
    </script>
<?php endif;
exit; ?>
