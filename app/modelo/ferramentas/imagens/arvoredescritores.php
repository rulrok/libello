<?php

namespace app\modelo\ferramentas\imagens;

require_once APP_DIR . 'modelo/comboboxes/ComboBoxDescritores.php';

use \app\modelo as Modelo;

class arvoredescritores extends \app\modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $imagensDAO = new Modelo\imagensDAO();
        $arvoreRetornada;
        if (filter_has_var(INPUT_GET, 'completa') && filter_input(INPUT_GET, 'completa')) {
            if (filter_has_var(INPUT_GET, 'descritorExcluir')) {
                $descritorExcluido = fnDecrypt(filter_input(INPUT_GET, 'descritorExcluir'));
                $arvoreRetornada = "img_arvore_completa_semdescritor";
            } else {
                $arvoreRetornada = "img_arvore_completa";
                $descritorExcluido = null;
            }
            $arvore = $imagensDAO->arvoreDescritores(true, $descritorExcluido);
        } else {
            $arvoreRetornada = "img_arvore";
            $arvore = $imagensDAO->arvoreDescritores();
        }
        $this->adicionarMensagemPersonalizada($arvoreRetornada, json_encode($arvore));
    }

}
