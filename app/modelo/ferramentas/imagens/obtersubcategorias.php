<?php

require_once APP_LOCATION . 'modelo/ComboBoxCategoriasAfins.php';

if (isset($_GET['categoriaID'])):
    $idCategoria = fnDecrypt($_GET['categoriaID']);

    echo ComboBoxCategoriasAfins::montarTodasAsSubcategorias($idCategoria);
    exit;

else :
    ?>
    <select required>
        <option value="default">
            -- Escolha uma categoria --
        </option>
    </select>
<?php endif; ?>
