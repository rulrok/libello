<?php

include_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
include_once BIBLIOTECA_DIR . 'seguranca/criptografia.php';
include_once ROOT . 'app/modelo/ComboBoxCurso.php';
include_once ROOT . 'app/modelo/ComboBoxPolo.php';
include_once ROOT . 'app/modelo/ComboBoxUsuarios.php';

class ControladorViagens extends Controlador {

    public function acaoNova() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->visao->cursos = ComboBoxCurso::montarTodosOsCursos();
        $this->visao->polos = ComboBoxPolo::montarTodosOsPolos();
        $this->visao->passageiros = ComboBoxUsuarios::montarPassageiros();
        $this->visao->responsavel = ComboBoxUsuarios::montarResponsavelViagem();
        $this->renderizar();
    }

    public function acaoVerificarnova() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoGerenciar() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->visao->viagens = viagemDAO::consultar("idViagem,nomeCurso,concat(dataIda,' - ',horaIda) as ida,concat(dataVolta,' - ',horaVolta) as volta,motivo,estadoViagem,diarias,concat(IFNULL(nomePolo,''),IFNULL(outroDestino,'')) as destino");
        $i = 0;
        foreach ($this->visao->viagens as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->viagens[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoEditar() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Ferramenta::CONTROLE_VIAGENS;
    }

}

?>
