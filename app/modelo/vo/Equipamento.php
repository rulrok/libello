<?php

/**
 * Algum equipamento qualquer.
 *
 * @author reuel
 */
class Equipamento {

    var $idEquipamento;
    var $nomeEquipamento;
    var $dataEntrada;
    var $quantidade;
    var $numeroPatrimonio;
    var $descricao;

    public function get_descricao() {
        return $this->descricao;
    }

    public function set_descricao($descricao) {
        $this->descricao = $descricao;
        return $this;
    }

    public function get_idEquipamento() {
        return (int) $this->idEquipamento;
    }

    public function set_idEquipamento($idEquipamento) {
        $this->idEquipamento = (int) $idEquipamento;
        return $this;
    }

    public function get_nomeEquipamento() {
        return $this->nomeEquipamento;
    }

    public function set_nomeEquipamento($equipamento) {
        if ($equipamento == null || $equipamento == "") {
            die("Nome do equipamento inválido.");
        }
        $this->nomeEquipamento = $equipamento;
        return $this;
    }

    public function get_dataEntrada() {
        return $this->dataEntrada;
    }

    public function set_dataEntrada($dataEntrada) {
        $this->dataEntrada = $dataEntrada;
        return $this;
    }

    public function get_quantidade() {
        return (int) $this->quantidade;
    }

    public function set_quantidade($quantidadde) {
        $this->quantidade = (int) $quantidadde;
        return $this;
    }

    public function get_numeroPatrimonio() {
        return $this->numeroPatrimonio;
    }

    public function set_numeroPatrimonio($numeroPatrimonio) {
        if ($numeroPatrimonio === "") {
            die("Código de patrimônio inválido.");
        }
        if ($numeroPatrimonio == null) {
            $this->numeroPatrimonio = "NULL";
        } else {
            $this->numeroPatrimonio = $numeroPatrimonio;
        }
        return $this;
    }

}

?>
