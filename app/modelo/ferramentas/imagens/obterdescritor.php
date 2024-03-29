<?php

namespace app\modelo\ferramentas\imagens;

require_once APP_DIR . 'modelo/comboboxes/ComboBoxDescritores.php';

use \app\modelo as Modelo;

class obterdescritor extends \app\modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        if (filter_has_var(INPUT_GET, 'p') && filter_has_var(INPUT_GET, 'n')):
            $idDescritorPai = fnDecrypt(filter_input(INPUT_GET, 'p'));
            $nivel = filter_input(INPUT_GET, 'n');

            switch ($nivel) {
                case 1:
                case 2:
                case 3:
                    echo Modelo\ComboBoxDescritores::montarDescritorFilho($idDescritorPai);
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
        <?php

        endif;
    }

}
?>
