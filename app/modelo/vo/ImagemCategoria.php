<?php

class ImagemCategoria {

    var $idCategoria;
    var $nomeCategoria;

    public function get_idCategoria() {
        return $this->idCategoria;
    }

    public function set_idCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
        return $this;
    }

    public function get_nomeCategoria() {
        return $this->nomeCategoria;
    }

    public function set_nomeCategoria($nomeCategoria) {
        $this->nomeCategoria = $nomeCategoria;
        return $this;
    }

}

?>
