<?php

namespace app\mvc;

include_once APP_LIBRARY_ABSOLUTE_DIR . 'Mvc/Visao.php';
require_once APP_DIR . 'modelo/Mensagem.php';

use \app\modelo as Modelo;

abstract class Controlador {

    private $mensagensRetorno = array(['sys_msgs']);
    protected $visao;
    var $ferramenta;

    public function __construct() {
        $this->visao = new Visao();
    }

    public function renderizar() {
        $diretorio = strtolower(Mvc::pegarInstancia()->pegarControlador());
        $arquivo = strtolower(Mvc::pegarInstancia()->pegarAcao()) . ".php";
        $this->visao->renderizar($diretorio, $arquivo);
    }

    public abstract function idFerramentaAssociada();

    /**
     * Encerra a execução da página no ponto onde a função foi invocada, enviando
     * todas as mensagens até então adicionadas para o cliente com um sinal de
     * erro para o cliente (indicando que a operação como um todo não foi bem sucedida)
     */
    public function abortarExecucao() {
        $this->_terminarExecucao();
    }

    /**
     * Função padrão que será chamada ao final da execução de uma página.
     */
    private function _terminarExecucao() {
        $msg = new Modelo\Mensagem();
        $msg->set_mensagemPersonalizada("sys_status", "erro");
        $this->_adicionarMensagem($msg);
        echo json_encode($this->mensagensRetorno);
        exit;
    }

    public function adicionarMensagemErro($mensagem, $fixa = false) {
        $this->_adicionarMensagem((new Modelo\Mensagem())->set_mensagemErro($mensagem, $fixa));
    }

    public function adicionarMensagemAlerta($mensagem, $fixa = false) {
        $this->_adicionarMensagem((new Modelo\Mensagem())->set_mensagemAlerta($mensagem, $fixa));
    }

    private function _adicionarMensagem(Modelo\Mensagem $mensagem) {
        $this->mensagensRetorno[] = $mensagem;
    }

    /**
     * Elimina todas as mensagens adicionadas até então no 'buffer' de saída
     */
    public function limparMensagens() {
        $this->mensagensRetorno = array(['sys_msgs']);
    }

}

?>