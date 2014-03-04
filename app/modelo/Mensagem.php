<?php

/**
 * Uma mensagem para ser enviada a uma página depois de uma operação ser
 * concluída, como por exemplo, uma mensagem de erro ou sucesso.
 *
 * @author reuel
 */
class Mensagem {

    const __length = 3;
    const SUCESSO = "Sucesso";
    const ERRO = "Erro";
    const INFO = "Informacao";

    var $status;
    var $mensagem;

    /**
     * 
     * @return string
     */
    public function get_status() {
        return $this->status;
    }

    /**
     * 
     * @param string $status
     * @return \Mensagem
     */
    private function set_status($status) {
        $this->status = $status;
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
     * @return \Mensagem
     */
    private function set_mensagem($mensagem) {
        $this->mensagem = $mensagem;
        return $this;
    }

    /**
     * 
     * @param string $mensagem
     * @return \Mensagem
     */
    public function set_mensagemSucesso($mensagem) {
        $this->set_mensagem($mensagem);
        $this->set_status(self::SUCESSO);
        return $this;
    }

    /**
     * 
     * @param string $mensagem
     * @return \Mensagem
     */
    public function set_mensagemErro($mensagem) {
        $this->set_mensagem($mensagem);
        $this->set_status(self::ERRO);
        return $this;
    }

    /**
     * 
     * @param string $mensagem
     * @return \Mensagem
     */
    public function set_mensagemInfo($mensagem) {
        $this->set_mensagem($mensagem);
        $this->set_status(self::INFO);
        return $this;
    }

}

?>
