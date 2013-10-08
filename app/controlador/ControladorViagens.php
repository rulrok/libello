<?php

include_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
include_once BIBLIOTECA_DIR . 'seguranca/criptografia.php';
include_once ROOT . 'app/modelo/ComboBoxCurso.php';
include_once ROOT . 'app/modelo/ComboBoxPolo.php';
include_once ROOT . 'app/modelo/ComboBoxUsuarios.php';

class ControladorViagens extends Controlador {

    public function acaoNova() {
        $this->visao->cursos = ComboBoxCurso::montarTodosOsCursos();
        $this->visao->polos = ComboBoxPolo::montarTodosOsPolos();
        $this->visao->passageiros = ComboBoxUsuarios::montarPassageiros();
        $this->visao->responsavel = ComboBoxUsuarios::montarResponsavelViagem();
        $this->renderizar();
    }

    public function acaoVerificarnova(){
        $this->renderizar();
    }
    
    public function acaoGerenciar() {
        $this->renderizar();
    }
    
    

}

?>
