<?php

namespace app\modelo\ferramentas\imagens;

require_once APP_DIR . 'modelo/comboboxes/ComboBoxDescritores.php';

use \app\modelo as Modelo;

class arvoredescritores extends \app\modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
//        $this->omitirMensagens();
        $imagensDAO = new Modelo\imagensDAO();
        if (filter_has_var(INPUT_GET, 'completa') && filter_input(INPUT_GET, 'completa')) {
            if (filter_has_var(INPUT_GET, 'descritorExcluir')) {
                $descritorExcluido = fnDecrypt(filter_input(INPUT_GET, 'descritorExcluir'));
            } else {
                $descritorExcluido = null;
            }
            $arvore = $imagensDAO->arvoreDescritores(true, $descritorExcluido);
        } else {
            $arvore = $imagensDAO->arvoreDescritores();
        }

//        print_r(json_encode($arvore));
        $this->adicionarMensagemPersonalizada('sys_arvore',print_r(json_encode($arvore),true));
    }

}
