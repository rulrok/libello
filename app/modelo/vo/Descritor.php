<?php

class Descritor {

    var $idDescritor;
    var $nome;
    var $pai;
    var $nivel;
    var $rotulo;
    var $qtdFilhos;

    public function get_idDescritor() {
        return $this->idDescritor;
    }

    public function get_nome() {
        return $this->nome;
    }

    public function get_idPai() {
        return $this->pai;
    }

    public function get_nivel() {
        return $this->nivel;
    }

    public function get_rotulo() {
        return $this->rotulo;
    }

    public function get_qtdFilhos() {
        return $this->qtdFilhos;
    }

    public function set_idDescritor($idDescritor) {
        $this->idDescritor = $idDescritor;
        return $this;
    }

    public function set_nome($nome) {
        $this->nome = $nome;
        return $this;
    }

    public function set_pai($pai) {
        $this->pai = $pai;
        return $this;
    }

    public function set_nivel($nivel) {
        $this->nivel = $nivel;
        return $this;
    }

    public function set_rotulo($rotulo) {
        $this->rotulo = $rotulo;
        return $this;
    }

    public function set_qtdFilhos($qtdFilhos) {
        $this->qtdFilhos = $qtdFilhos;
        return $this;
    }


}
