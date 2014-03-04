<?php

/**
 * Algum equipamento qualquer.
 *
 * @author reuel
 */
class Equipamento {

    var $idEquipamento;
    var $nomeEquipamento;
    var $quantidade;
    var $descricao;
    var $dataEntrada;
    var $numeroPatrimonio;

    public function get_idEquipamento() {
        return $this->idEquipamento;
    }

    public function get_nomeEquipamento() {
        return $this->nomeEquipamento;
    }

    public function get_quantidade() {
        return $this->quantidade;
    }

    public function get_descricao() {
        return $this->descricao;
    }

    public function get_dataEntrada() {
        return $this->dataEntrada;
    }

    public function get_numeroPatrimonio() {
        return $this->numeroPatrimonio;
    }

    public function set_idEquipamento($idEquipamento) {
        $this->idEquipamento = $idEquipamento;
        return $this;
    }

    public function set_nomeEquipamento($nomeEquipamento) {
        $this->nomeEquipamento = $nomeEquipamento;
        return $this;
    }

    public function set_quantidade($quantidade) {
        $this->quantidade = $quantidade;
        return $this;
    }

    public function set_descricao($descricao) {
        $this->descricao = $descricao;
        return $this;
    }

    public function set_dataEntrada($dataEntrada) {
        $this->dataEntrada = $dataEntrada;
        return $this;
    }

    public function set_numeroPatrimonio($numeroPatrimonio) {
        $this->numeroPatrimonio = $numeroPatrimonio;
        return $this;
    }

}

?>
