<?php

namespace app\controlador;

include_once APP_LIBRARY_DIR . 'Mvc/Controlador.php';


require_once APP_DIR . "modelo/enumeracao/Ferramenta.php";
require_once APP_DIR . "modelo/vo/Processo.php";
require_once APP_DIR . "modelo/enumeracao/Papel.php";

class ControladorProcessos extends controlador {

    public function acaoNovoProcesso() {
        //$this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoArvoreProcessos() {
        //$this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Ferramenta::PROCESSOS;
    }

}
