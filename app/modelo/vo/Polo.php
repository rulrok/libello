<?php

class Polo {
    var $idPolo;
    var $nome;
    var $cidade;
    var $estado;
    
    public function get_idPolo() {
        return $this->idPolo;
    }

    public function set_idPolo($idPolo) {
        $this->idPolo = $idPolo;
    }

    public function get_nome() {
        return $this->nome;
    }

    public function set_nome($nome) {
        $this->nome = $nome;
    }

    public function get_cidade() {
        return $this->cidade;
    }

    public function set_cidade($cidade) {
        $this->cidade = $cidade;
    }

    public function get_estado() {
        return $this->estado;
    }

    public function set_estado($estado) {
        $this->estado = $estado;
    }


}

?>