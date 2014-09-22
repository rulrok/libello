<?php

namespace app\modelo;

/**
 * Uma mensagem para ser enviada a uma página depois de uma operação ser
 * concluída, como por exemplo, uma mensagem de erro ou sucesso.
 *
 * @author reuel
 */
class Mensagem {

    const __length = 8;
    const SUCESSO = "pop_sucesso";
    const SUCESSO_FIXO = "pop_sucesso_fixo";
    const ERRO = "pop_erro";
    const ERRO_FIXO = "pop_erro_fixo";
    const INFO = "pop_info";
    const INFO_FIXO = "pop_info_fixo";
    const ALERTA = "pop_alerta";
    const ALERTA_FIXO = "pop_alerta_fixo";

    var $tipo;
    var $mensagem;

    /**
     * 
     * @return string
     */
    public function get_tipo() {
        return $this->tipo;
    }

    /**
     * 
     * @param string $tipo
     * @return \app\modelo\Mensagem
     */
    private function _set_tipo($tipo) {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function get_mensagem() {
        return $this->mensagem;
    }

    /**
     * 
     * @param string $mensagem
     * @return \app\modelo\Mensagem
     */
    private function _set_mensagem($mensagem) {
        $this->mensagem = $mensagem;
        return $this;
    }

    /**
     * 
     * @param string $mensagem
     * @return \app\modelo\Mensagem
     */
    public function set_mensagemSucesso($mensagem, $fixa = false) {
        $this->_set_mensagem($mensagem);
        $this->_set_tipo($fixa ? self::SUCESSO_FIXO : self::SUCESSO);
        return $this;
    }

    /**
     * 
     * @param string $mensagem
     * @return \app\modelo\Mensagem
     */
    public function set_mensagemErro($mensagem, $fixa = false) {
        $this->_set_mensagem($mensagem);
        $this->_set_tipo($fixa ? self::ERRO_FIXO : self::ERRO);
        return $this;
    }

    /**
     * 
     * @param string $mensagem
     * @return \app\modelo\Mensagem
     */
    public function set_mensagemInfo($mensagem, $fixa = false) {
        $this->_set_mensagem($mensagem);
        $this->_set_tipo($fixa ? self::INFO_FIXO : self::INFO);
        return $this;
    }

    /**
     * 
     * @param string $mensagem
     * @return \app\modelo\Mensagem
     */
    public function set_mensagemAlerta($mensagem, $fixa = false) {
        $this->_set_mensagem($mensagem);
        $this->_set_tipo($fixa ? self::ALERTA_FIXO : self::ALERTA);
        return $this;
    }

    public function set_mensagemPersonalizada($tipo, $mensagem) {
        $this->_set_mensagem($mensagem);
        $this->_set_tipo($tipo);
        return $this;
    }

}

?>
