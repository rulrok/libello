<?php
namespace app\modelo;

class Viagem {

    var $idViagem;
    var $idCurso;
    var $idPolo;
    var $responsavel;
    var $dataIda;
    var $horaIda;
    var $dataVolta;
    var $horaVolta;
    var $motivo;
    var $estadoViagem;
    var $diarias;
    var $passageiros;
    var $destinoAlternativo;

    public function get_idViagem() {
        return $this->idViagem;
    }

    public function set_idViagem($idViagem) {
        $this->idViagem = $idViagem;
        return $this;
    }

    public function get_idCurso() {
        return $this->idCurso;
    }

    public function set_idCurso($idCurso) {
        $this->idCurso = $idCurso;
        return $this;
    }

    public function get_idPolo() {
        return $this->idPolo;
    }

    public function set_idPolo($idPolo) {
        $this->idPolo = $idPolo;
        return $this;
    }

    public function get_responsavel() {
        return $this->responsavel;
    }

    public function set_responsavel($responsavel) {
        $this->responsavel = $responsavel;
        return $this;
    }

    public function get_dataIda() {
        return $this->dataIda;
    }

    public function set_dataIda($dataIda) {
        $this->dataIda = $dataIda;
        return $this;
    }

    public function get_horaIda() {
        return $this->horaIda;
    }

    public function set_horaIda($horaIda) {
        $this->horaIda = $horaIda;
        return $this;
    }

    public function get_dataVolta() {
        return $this->dataVolta;
    }

    public function set_dataVolta($dataVolta) {
        $this->dataVolta = $dataVolta;
        return $this;
    }

    public function get_horaVolta() {
        return $this->horaVolta;
    }

    public function set_horaVolta($horaVolta) {
        $this->horaVolta = $horaVolta;
        return $this;
    }

    public function get_motivo() {
        return $this->motivo;
    }

    public function set_motivo($motivo) {
        $this->motivo = $motivo;
        return $this;
    }

    public function get_estado() {
        return $this->estadoViagem;
    }

    public function set_estado($estado) {
        $this->estadoViagem = $estado;
        return $this;
    }

    public function get_diarias() {
        return $this->diarias;
    }

    public function set_diarias($diarias) {
        $this->diarias = $diarias;
        return $this;
    }

    public function get_passageiros($index = null) {
        if ($index == NULL) {
            return $this->passageiros;
        } else {
            return $this->passageiros[$index];
        }
    }

    public function set_passageiros($passageiros) {
        if (is_array($passageiros)) {
            $this->passageiros = $passageiros;
        }
        return $this;
    }

    public function get_destinoAlternativo() {
        return $this->destinoAlternativo;
    }

    public function set_destinoAlternativo($destinoAlternativo) {
        $this->destinoAlternativo = $destinoAlternativo;
        return $this;
    }

}

?>