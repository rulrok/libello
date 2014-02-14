<?php

class ImagemSubcategoria {

    var $idSubcategoria;
    var $nomeSubcategoria;
    var $categoriaPai;

    public function get_idSubcategoria() {
        return $this->idSubcategoria;
    }

    public function set_idSubcategoria($idSubcategoria) {
        $this->idSubcategoria = $idSubcategoria;
        return $this;
    }

    public function get_nomeSubcategoria() {
        return $this->nomeSubcategoria;
    }

    public function set_nomeSubcategoria($nomeSubcategoria) {
        $this->nomeSubcategoria = $nomeSubcategoria;
        return $this;
    }

    public function get_categoriaPai() {
        return $this->categoriaPai;
    }

    public function set_categoriaPai($categoriaPai) {
        $this->categoriaPai = $categoriaPai;
        return $this;
    }


}

?>
