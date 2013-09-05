<?php

/**
 * Algum equipamento qualquer.
 *
 * @author reuel
 */
class Equipamento {

    var $idEquipamento;
    var $nomeEquipamento;
    var $dataEntrada = null;
    var $quantidade;
//    var $tipo;
    var $numeroPatrimonio;

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
            throw new Exception("Nome do equipamento inválido.");
        }
        $this->nomeEquipamento = $equipamento;
        return $this;
    }

    public function get_dataEntrada() {
        if ($this->dataEntrada == "NULL") {
            return null;
        }
        return $this->dataEntrada;
    }

    public function set_dataEntrada($dataEntrada) {
        if ($dataEntrada == null || $dataEntrada == "") {
            $this->dataEntrada = "NULL";
        } else {
            $this->dataEntrada = $dataEntrada;
        }
        return $this;
    }

    public function get_quantidade() {
        return (int) $this->quantidade;
    }

    public function set_quantidadde($quantidadde) {
        $this->quantidade = (int) $quantidadde;
        return $this;
    }

//    public function get_tipo() {
//        return $this->tipo;
//    }
//
//    public function set_tipo($tipo) {
//        $this->tipo = $tipo;
//        return $this;
//    }

    public function get_numeroPatrimonio() {
        return $this->numeroPatrimonio;
    }

    public function set_numeroPatrimonio($numeroPatrimonio) {
        if ($numeroPatrimonio === ""){
            throw new Exception("Código de patrimônio inválido.");
        }
        if ($numeroPatrimonio == null) {
            $this->numeroPatrimonio = "NULL";
        } else {
            $this->numeroPatrimonio = $numeroPatrimonio;
        }
        return $this;
    }

    
//    public function __clone() {
//        $ret = new Equipamento();
//        $ret->quantidadde = $this->quantidadde;
//        $ret->dataEntrada = $this->dataEntrada;
//        $ret->idEquipamento = $this->idEquipamento;
//        $ret->numeroPatrimonio = $this->numeroPatrimonio;
//        $ret->nomeEquipamento = $this->nomeEquipamento;
//        
//        return $ret;
//    }
    
    
}

?>
