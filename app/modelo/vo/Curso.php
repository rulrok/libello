<?php
namespace app\modelo;

class Curso {

    /**
     *
     * @var int 
     */
    var $idCurso;

    /**
     *
     * @var string 
     */
    var $nomeCurso;

    /**
     *
     * @var int 
     */
    var $area;

    /**
     *
     * @var int 
     */
    var $tipo;

    /**
     * 
     * @return int
     */
    public function get_idCurso() {
        return (int) $this->idCurso;
    }

    /**
     * 
     * @param int $idCurso
     */
    public function set_idCurso($idCurso) {
        $this->idCurso = (int) $idCurso;
    }

    /**
     * 
     * @return string
     */
    public function get_nome() {
        return (string) $this->nomeCurso;
    }

    /**
     * 
     * @param string $nome
     */
    public function set_nome($nome) {
        $this->nomeCurso = (string) $nome;
    }

    /**
     * 
     * @return int
     */
    public function get_idArea() {
        return (int) $this->area;
    }

    /**
     * 
     * @param int $idArea
     */
    public function set_idArea($idArea) {
        $this->area = (int) $idArea;
    }

    /**
     * 
     * @return int
     */
    public function get_idTipo() {
        return (int) $this->tipo;
    }

    /**
     * 
     * @param int $idTipo
     */
    public function set_idTipo($idTipo) {
        $this->tipo = (int) $idTipo;
    }

}

?>
