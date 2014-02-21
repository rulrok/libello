<?php

require_once APP_LOCATION . 'modelo/ComboBoxCategoriasAfins.php';

if (filter_has_var(INPUT_GET, 'p') && filter_has_var(INPUT_GET, 'n')):
    $idDescritorPai = fnDecrypt(filter_input(INPUT_GET, 'p'));
    $nivel = filter_input(INPUT_GET, 'n');

    switch ($nivel) {
        case 1:
            echo ComboBoxCategoriasAfins::montarDescritorFilhoSegundoNivel($idDescritorPai);
            break;
        case 2:
            echo ComboBoxCategoriasAfins::montarDescritorFilhoTerceiroNivel($idDescritorPai);
            break;
        case 3:
            echo ComboBoxCategoriasAfins::montarDescritorFilhoQuartoNivel($idDescritorPai);
            break;
        default :
            ?>
            <select required>
                <option value="default">
                    -- Escolha um descritor acima --
                </option>
            </select>
        <?php

    }
    exit;

else :
    ?>
    <select required>
        <option value="default">
            -- Escolha um descritor acima --
        </option>
    </select>
<?php endif; ?>
