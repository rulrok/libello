<?php

require_once APP_LOCATION . 'modelo/ComboBoxDescritores.php';

if (filter_has_var(INPUT_GET, 'p') && filter_has_var(INPUT_GET, 'n')):
    $idDescritorPai = fnDecrypt(filter_input(INPUT_GET, 'p'));
    $nivel = filter_input(INPUT_GET, 'n');

    switch ($nivel) {
        case 1:
            echo ComboBoxDescritores::montarDescritorFilhoSegundoNivel($idDescritorPai);
            break;
        case 2:
            echo ComboBoxDescritores::montarDescritorFilhoTerceiroNivel($idDescritorPai);
            break;
        case 3:
            echo ComboBoxDescritores::montarDescritorFilhoQuartoNivel($idDescritorPai);
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
