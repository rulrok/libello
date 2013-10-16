<?php

/**
 * Algum equipamento qualquer.
 *
 * @author reuel
 */
class Livro {

    var $idLivro;
    var $nomeLivro;
    var $quantidade;
    var $descricao;
    var $dataEntrada;
    var $numeroPatrimonio;
    var $area;
    var $grafica;

    public function get_idLivro() {
        return (int) $this->idLivro;
    }

    public function set_idLivro($idLivro) {
        $this->idLivro = (int) $idLivro;
        return $this;
    }

    public function get_nomeLivro() {
        return $this->nomeLivro;
    }

    public function set_nomeLivro($equipamento) {
        if ($equipamento == null || $equipamento == "") {
            die("Nome do equipamento inválido.");
        }
        $this->nomeLivro = $equipamento;
        return $this;
    }

    public function get_dataEntrada() {
        if ($this->dataEntrada != "NULL")
            return $this->dataEntrada;
        else {
            return "";
        }
    }

    public function set_dataEntrada($dataEntrada) {
        if ($dataEntrada == "") {
            $dataEntrada = "NULL";
        }
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

    public function get_descricao() {
        return $this->descricao;
    }

    public function set_descricao($descricao) {
        $this->descricao = $descricao;
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

    public function get_area() {
        return (int) $this->area;
    }

    public function set_area($area) {
        $this->area = (int) $area;
        return $this;
    }

    public function get_grafica() {
        return $this->grafica;
    }

    public function set_grafica($grafica) {
        $this->grafica = $grafica;
        return $this;
    }

}

?>
