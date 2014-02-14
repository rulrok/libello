<?php

class Imagem {

    var $idImagem;
    var $titulo;
    var $descricoes;
    var $descritor1;
    var $descritor2;
    var $descritor3;
    var $dificuldade;
    var $caminhoImagem;

    public function get_idImagem() {
        return $this->idImagem;
    }

    public function set_idImagem($idImagem) {
        $this->idImagem = $idImagem;
        return $this;
    }

    public function get_titulo() {
        return $this->titulo;
    }

    public function set_titulo($titulo) {
        $this->titulo = $titulo;
        return $this;
    }

    public function get_descricoes() {
        return $this->descricoes;
    }

    public function set_descricoes($descricoes) {
        $this->descricoes = $descricoes;
        return $this;
    }

    public function get_descritor1() {
        return $this->descritor1;
    }

    public function set_descritor1($descritor1) {
        $this->descritor1 = $descritor1;
        return $this;
    }

    public function get_descritor2() {
        return $this->descritor2;
    }

    public function set_descritor2($descritor2) {
        $this->descritor2 = $descritor2;
        return $this;
    }

    public function get_descritor3() {
        return $this->descritor3;
    }

    public function set_descritor3($descritor3) {
        $this->descritor3 = $descritor3;
        return $this;
    }

    public function get_dificuldade() {
        return $this->dificuldade;
    }

    public function set_dificuldade($dificuldade) {
        $this->dificuldade = $dificuldade;
        return $this;
    }

    public function get_caminhoImagem() {
        return $this->caminhoImagem;
    }

    public function set_caminhoImagem($caminhoImagem) {
        $this->caminhoImagem = $caminhoImagem;
        return $this;
    }

}

?>
