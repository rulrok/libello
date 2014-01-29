<?php

require_once BIBLIOTECA_DIR . "seguranca/Permissao.php";
require_once __DIR__ . "/../enumeracao/Ferramenta.php";

class PermissoesFerramenta {

    var $controleUsuarios = null;
    var $controleCursos = null;
    var $controleLivros = null;
    var $controleEquipamentos = null;
    var $controleDocumentos = null;
    var $controleViagens = null;
    var $tarefas = null;
    var $controlePagamentos = null;
    var $galeriaImagens = null;

    public function get_permissao($ferramenta) {

        $ferramenta = (int) $ferramenta;
        switch ($ferramenta) {
            case Ferramenta::CONTROLE_USUARIOS:
                return $this->controleUsuarios;
                break;
            case Ferramenta::CURSOS_E_POLOS:
                return $this->controleCursos;
                break;
            case Ferramenta::CONTROLE_LIVROS:
                return $this->controleLivros;
                break;
            case Ferramenta::CONTROLE_EQUIPAMENTOS:
                return $this->controleEquipamentos;
                break;
            case Ferramenta::CONTROLE_DOCUMENTOS:
                return $this->controleDocumentos;
                break;
            case Ferramenta::CONTROLE_VIAGENS:
                return $this->controleViagens;
                break;
            case Ferramenta::TAREFAS:
                return $this->tarefas;
                break;
            case Ferramenta::CONTROLE_PAGAMENTOS:
                return $this->controlePagamentos;
            case Ferramenta::GALERIA_IMAGENS:
                return $this->galeriaImagens;
                break;
            default :
                return null;
        }
    }

    public function get_controleUsuarios() {
        return $this->controleUsuarios;
    }

    public function set_controleUsuarios($controleUsuarios) {
        $this->controleUsuarios = $controleUsuarios;
    }

    public function get_controleCursos() {
        return $this->controleCursos;
    }

    public function set_controleCursos($controleCursos) {
        $this->controleCursos = $controleCursos;
    }

    public function get_controleLivros() {
        return $this->controleLivros;
    }

    public function set_controleLivros($controleLivros) {
        $this->controleLivros = $controleLivros;
    }

    public function get_controleEquipamentos() {
        return $this->controleEquipamentos;
    }

    public function set_controleEquipamentos($controleEquipamentos) {
        $this->controleEquipamentos = $controleEquipamentos;
    }

    public function get_controleDocumentos() {
        return $this->controleDocumentos;
    }

    public function set_controleDocumentos($controleDocumentos) {
        $this->controleDocumentos = $controleDocumentos;
    }

    public function get_controleViagens() {
        return $this->controleViagens;
    }

    public function set_controleViagens($controleViagens) {
        $this->controleViagens = $controleViagens;
    }

    public function get_tarefas() {
        return $this->tarefas;
    }

    public function set_tarefas($tarefas) {
        $this->tarefas = $tarefas;
    }

    public function get_controlePagamentos() {
        return $this->controlePagamentos;
    }

    public function set_controlePagamentos($controlePagamentos) {
        $this->controlePagamentos = $controlePagamentos;
    }

    public function set_galeriaImagens($galeriaImagens) {
        $this->galeriaImagens = $galeriaImagens;
    }

    public function get_galeriaImagens() {
        return $this->galeriaImagens;
    }

}

?>
