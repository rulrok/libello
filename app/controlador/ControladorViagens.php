<?php

include_once APP_LIBRARY_DIR . 'Mvc/Controlador.php';
include_once APP_LIBRARY_DIR . 'seguranca/criptografia.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxCurso.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxPolo.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxUsuarios.php';

class ControladorViagens extends Controlador {

    public function acaoNova() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->visao->cursos = ComboBoxCurso::montarTodosOsCursos();
        $this->visao->polos = ComboBoxPolo::montarTodosOsPolos();
        $this->visao->usuarios = ComboBoxUsuarios::listarTodosUsuarios();
        $this->renderizar();
    }

    public function acaoVerificarnova() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoGerenciar() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->visao->viagens = (new viagemDAO())->consultar("idViagem,nomeCurso,concat_ws(' - ',dataIda,horaIda) as ida,concat_ws(' - ',dataVolta,horaVolta) as volta,motivo,estadoViagem,diarias,concat(IFNULL(nomePolo,''),IFNULL(outroDestino,'')) as destino");
        $i = 0;
        foreach ($this->visao->viagens as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->viagens[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoEditar() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
       if (filter_has_var(INPUT_GET, 'viagemID') || filter_has_var(INPUT_POST, 'viagemID')) {
            $this->visao->usuarios = ComboBoxUsuarios::listarTodosUsuarios();
            $idViagem = fnDecrypt($_REQUEST['viagemID']); //TODO mudar para filter_input() quando INPUT_REQUEST estiver implementado no PHP
            $viagemDAO = new viagemDAO();
            $this->visao->viagemID = $_REQUEST['viagemID'];
            $viagem = $viagemDAO->recuperarViagem($idViagem);
            $this->visao->responsavel = $viagemDAO->recuperarResponsavel($viagem->get_responsavel());
            $this->visao->curso = $viagemDAO->recuperarCurso($viagem->get_idCurso());
            $this->visao->cursos = ComboBoxCurso::montarTodosOsCursos($this->visao->curso);
            if(!$viagem->get_idPolo()){
              $this->visao->destinoAlternativo = $viagemDAO->recuperarDestinoAlternativo($viagem->get_idViagem()); 
              $this->visao->polos = ComboBoxPolo::montarTodosOsPolos($this->visao->destinoAlternativo);
            }else{
                $this->visao->polos = ComboBoxPolo::montarTodosOsPolos($viagemDAO->recuperarDestino($viagem->get_idPolo()));
            }
            $this->visao->dataIda = $viagem->get_dataIda();
            $this->visao->dataVotlta = $viagem->get_dataVolta();
            $this->visao->horaIda = $viagem->get_horaIda();
            $this->visao->horaVotlta = $viagem->get_horaVolta();
            $this->visao->motivo = $viagem->get_motivo();
            $this->visao->estadoViagem = $viagem->get_estado();
            $this->visao->diarias = $viagem->get_diarias();
        } else {
            die("Acesso indevido");
        }
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Ferramenta::CONTROLE_VIAGENS;
    }

    

}

?>
