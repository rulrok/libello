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
    
    public function get_status() {
        return $this->status;
    }

    public function set_status($status) {
        $this->status = $status;
        return $this;
    }

    public function get_mensagem() {
        return $this->mensagem;
    }

    public function set_mensagem($mensagem) {
        $this->mensagem = $mensagem;
        return $this;
    }


}

?>
