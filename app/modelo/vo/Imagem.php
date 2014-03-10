<?php

class Imagem {

    var $idImagem;
    var $idGaleria;
    var $titulo;
    var $observacoes;
    var $dificuldade;
    var $cpfAutor;
    var $ano;
    var $utilizadoAvaliacao;
    var $avaliacao;
    var $anoAvaliacao;
    var $nomeArquivo;
    var $nomeArquivoMiniatura;
    var $nomeArquivoVetorial;
    var $descritor1;
    var $descritor2;
    var $descritor3;
    var $descritor4;
    var $autor;

    public function get_autor() {
        return $this->autor;
    }

    public function set_autor($autor) {
        $this->autor = $autor;
        return $this;
    }

    public function get_idImagem() {
        return $this->idImagem;
    }

    public function set_idImagem($idImagem) {
        $this->idImagem = $idImagem;
        return $this;
    }

    public function get_idGaleria() {
        return $this->idGaleria;
    }

    public function set_idGaleria($idGaleria) {
        $this->idGaleria = $idGaleria;
        return $this;
    }

    public function get_titulo() {
        return $this->titulo;
    }

    public function set_titulo($titulo) {
        $this->titulo = $titulo;
        return $this;
    }

    public function get_observacoes() {
        return $this->observacoes;
    }

    public function set_observacoes($descricoes) {
        $this->observacoes = $descricoes;
        return $this;
    }

    public function get_dificuldade() {
        return $this->dificuldade;
    }

    public function set_dificuldade($dificuldade) {
        $this->dificuldade = $dificuldade;
        return $this;
    }

    public function get_cpfAutor() {
        return $this->cpfAutor;
    }

    public function get_ano() {
        return $this->ano;
    }

    public function get_utilizadoAvaliacao() {
        return $this->utilizadoAvaliacao;
    }

    public function get_avaliacao() {
        return $this->avaliacao;
    }

    public function get_nomeArquivo() {
        return $this->nomeArquivo;
    }

    public function get_nomeArquivoMiniatura() {
        return $this->nomeArquivoMiniatura;
    }

    public function set_cpfAutor($cpfAutor) {
        $this->cpfAutor = $cpfAutor;
        return $this;
    }

    public function set_ano($ano) {
        $this->ano = $ano;
        return $this;
    }

    public function set_utilizadoAvaliacao($utilizadoAvaliacao) {
        $this->utilizadoAvaliacao = $utilizadoAvaliacao;
        return $this;
    }

    public function set_avaliacao($avaliacao) {
        $this->avaliacao = $avaliacao;
        return $this;
    }

    public function get_anoAvaliacao() {
        return $this->anoAvaliacao;
    }

    public function set_anoAvaliacao($anoAvaliacao) {
        $this->anoAvaliacao = $anoAvaliacao;
        return $this;
    }

    public function set_nomeArquivo($nomeArquivo) {
        $this->nomeArquivo = $nomeArquivo;
        return $this;
    }

    public function set_nomeArquivoMiniatura($nomeArquivoMiniatura) {
        $this->nomeArquivoMiniatura = $nomeArquivoMiniatura;
        return $this;
    }

    public function get_nomeArquivoVetorial() {
        return $this->nomeArquivoVetorial;
    }

    public function set_nomeArquivoVetorial($nomeArquivoVetorial) {
        $this->nomeArquivoVetorial = $nomeArquivoVetorial;
        return $this;
    }

    public function get_descritor1() {
        return $this->descritor1;
    }

    public function get_descritor2() {
        return $this->descritor2;
    }

    public function get_descritor3() {
        return $this->descritor3;
    }

    public function get_descritor4() {
        return $this->descritor4;
    }

    public function set_descritor1($descritor1) {
        $this->descritor1 = $descritor1;
        return $this;
    }

    public function set_descritor2($descritor2) {
        $this->descritor2 = $descritor2;
        return $this;
    }

    public function set_descritor3($descritor3) {
        $this->descritor3 = $descritor3;
        return $this;
    }

    public function set_descritor4($descritor4) {
        $this->descritor4 = $descritor4;
        return $this;
    }

}

?>
