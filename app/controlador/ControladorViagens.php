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

    public function acaoVerificarnova() {
        $this->renderizar();
    }

    public function acaoGerenciar() {
        $this->visao->viagens = viagemDAO::consultar("idViagem,nomeCurso,concat(dataIda,' - ',horaIda) as ida,concat(dataVolta,' - ',horaVolta) as volta,motivo,estado,diarias,nomePolo,outroDestino");
        $i = 0;
        foreach ($this->visao->viagens as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->viagens[$i++] = $value;
        }
        $this->renderizar();
    }

}

?>
