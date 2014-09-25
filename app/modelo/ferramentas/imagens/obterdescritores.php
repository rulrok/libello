<?php

namespace app\modelo\ferramentas\imagens;

require_once APP_DIR . 'modelo/comboboxes/ComboBoxDescritores.php';

use \app\modelo as Modelo;

class obterdescritores extends \app\modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $retorno = array();
        if (filter_has_var(INPUT_POST, 'query')) {
            $imagensDAO = new Modelo\imagensDAO();
            $query = filter_input(INPUT_POST, 'query');
            $resultado = $imagensDAO->consultarDescritor('DISTINCT nome', " nome LIKE '%$query%'");

            foreach ($resultado as $descritor) {
                $retorno[] = $descritor['nome'];
            }
        }
        $this->adicionarMensagemPersonalizada("img_descritores", json_encode($retorno));
    }

}
