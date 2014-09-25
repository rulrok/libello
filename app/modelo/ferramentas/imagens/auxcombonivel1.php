<?php

namespace app\modelo\ferramentas\imagens;

require_once APP_DIR . 'modelo/comboboxes/ComboBoxDescritores.php';

use \app\modelo as Modelo;

/**
 * @deprecated since version Alpha Não apresenta utilidade
 */
class auxcombonivel1 extends \app\modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        //TODO Mover isso para a classe ComboBoxDescritores
        $combobox = new Modelo\ComboBoxDescritores();
        $codigo = $combobox->montarDescritorPrimeiroNivel();
        echo $codigo;
    }

}
