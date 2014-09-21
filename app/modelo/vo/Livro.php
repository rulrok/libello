<?php
namespace app\modelo;

/**
 * Algum equipamento qualquer.
 *
 * @author reuel
 */
class Livro {

    /**
     *
     * @var int 
     */
    var $idLivro;

    /**
     *
     * @var string 
     */
    var $nomeLivro;

    /**
     *
     * @var int 
     */
    var $quantidade;

    /**
     *
     * @var string 
     */
    var $descricao;

    /**
     *
     * @var string 
     */
    var $dataEntrada;

    /**
     *
     * @var string 
     */
    var $numeroPatrimonio;

    /**
     *
     * @var int 
     */
    var $area;

    /**
     *
     * @var string 
     */
    var $grafica;

    public function get_idLivro() {
        return $this->idLivro;
    }

    public function get_nomeLivro() {
        return $this->nomeLivro;
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

    public function get_area() {
        return $this->area;
    }

    public function get_grafica() {
        return $this->grafica;
    }

    public function set_idLivro($idLivro) {
        $this->idLivro = $idLivro;
        return $this;
    }

    public function set_nomeLivro($nomeLivro) {
        $this->nomeLivro = $nomeLivro;
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

    public function set_area($area) {
        $this->area = $area;
        return $this;
    }

    public function set_grafica($grafica) {
        $this->grafica = $grafica;
        return $this;
    }

}

?>
