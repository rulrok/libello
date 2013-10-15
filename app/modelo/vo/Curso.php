<?php

class Curso {
    var $idCurso;
    var $nomeCurso;
    var $area;
    var $tipo;
    
    public function get_idCurso() {
        return $this->idCurso;
    }

    public function set_idCurso($idCurso) {
        $this->idCurso = $idCurso;
    }

    public function get_nome() {
        return $this->nomeCurso;
    }

    public function set_nome($nome) {
        $this->nomeCurso = $nome;
    }

    public function get_area() {
        return $this->area;
    }

    public function set_area($area) {
        $this->area = $area;
    }

    public function get_tipo() {
        return $this->tipo;
    }

    public function set_tipo($tipo) {
        $this->tipo = $tipo;
    }



}

?>
