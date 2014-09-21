<?php
namespace app\modelo;
/**
 * Uma mensagem para ser enviada a uma página depois de uma operação ser
 * concluída, como por exemplo, uma mensagem de erro ou sucesso.
 *
 * @author reuel
 */
class Mensagem {

    const __length = 3;
    const SUCESSO = "pop_sucesso";
    const ERRO = "pop_erro";
    const INFO = "pop_info";

    var $tipo;
    var $mensagem;

    /**
     * 
     * @return string
     */
    public function get_status() {
        return $this->tipo;
    }

    /**
     * 
     * @param string $tipo
     * @return \Mensagem
     */
    private function set_tipo($tipo) {
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
        $this->set_tipo(self::SUCESSO);
        return $this;
    }

    /**
     * 
     * @param string $mensagem
     * @return \Mensagem
     */
    public function set_mensagemErro($mensagem) {
        $this->set_mensagem($mensagem);
        $this->set_tipo(self::ERRO);
        return $this;
    }

    /**
     * 
     * @param string $mensagem
     * @return \Mensagem
     */
    public function set_mensagemInfo($mensagem) {
        $this->set_mensagem($mensagem);
        $this->set_tipo(self::INFO);
        return $this;
    }

    /**
     * 
     * @param type $mensagem
     * @param type $tipo
     */
    public function set_mensagemPersonalizada($tipo, $mensagem) {
        $this->set_mensagem($mensagem);
        $this->set_tipo($tipo);
    }

}

?>
