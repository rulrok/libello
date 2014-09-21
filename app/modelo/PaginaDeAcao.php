<?php

namespace app\modelo;

require_once APP_DIR . "modelo/Mensagem.php";

/**
 * <p>Páginas de ação são páginas que estão localizadas na pastas 'ferramentas' da
 * pasta 'modelo'. São páginas invocadas via ajax para executar algumas ação tais
 * como atualizar um cadastro, verificar um novo cadastro (paginas de verificação
 * Ajax), remover algum cadastro e etc. 
 * </p>
 * <p>Antigamente essas páginas não eram tratadas como objetos e apenas eram carregadas
 * com o seu corpo de código sendo executado (por causa do fluxo PHP). Isso criava
 * alguns problemas para uma padronização do retorno de mensagens da página para
 * o cliente que a chamou. Havia a limitação de apenas poder retornar uma mensagem
 * (geralmente utilizadas para exibir pop-ups).
 * </p>
 * <p>Com o novo modelo, cada página é uma classe em si e deve extender a classe
 * 'PaginaDeAcao' implementando o método abstrato <code>_acaoPadrao()</code>. Quando a página
 * for invocada, todo o seu comportamento principal deve estar implementado dentro
 * desse método. Métodos adicionais para a própria página podem ser implementados 
 * livremente. <b>!Recomenda-se que esses métodos sejem privados!</b></p>
 * <p>Outra vantagem dessa abordagem é a centralização das mensagens que devem
 * ser retornadas ao cliente. Agora mútiplas mensagens podem ser adiciondas ao
 * 'buffer' de mensagens, que será processado e enviado como resposta ao final da
 * execução do método <code>_acaoPadrao()</code>. Para mais detalhes, consulte os
 * métodos <code>terminarExecucao()</code> e <code>abortarExecucao()</code>.</p>
 *
 * @author reuel
 */
abstract class PaginaDeAcao {

    private $mensagensRetorno = array(['sys_msgs']);
    private $omitirMensagens = false;

    protected abstract function _acaoPadrao();

    public function executar() {
        $this->_acaoPadrao();
        $this->terminarExecucao();
    }

    public function adicionarMensagemSucesso($mensagem) {
        $this->mensagensRetorno[] = (new Mensagem())->set_mensagemSucesso($mensagem);
    }

    public function adicionarMensagemErro($mensagem) {
        $this->mensagensRetorno[] = (new Mensagem())->set_mensagemErro($mensagem);
    }

    public function adicionarMensagemInfo($mensagem) {
        $this->mensagensRetorno[] = (new Mensagem())->set_mensagemInfo($mensagem);
    }

    public function adicionarMensagemPersonalizada($tipo, $mensagem) {
        $this->mensagensRetorno[] = (new Mensagem())->set_mensagemPersonalizada($tipo, $mensagem);
    }

    private function adicionarMensagem(Mensagem $mensagem) {
        $this->mensagensRetorno[] = $mensagem;
    }

    /**
     * Impede que quaisque informações extra sejam enviadas para o cliente ao final
     * da execusão de uma página. Página que processam o download de imagens, por
     * exemplo, irão precisar disso pois elas precisam enviar um fluxo 'limpo'
     * como resposta. Qualquer outra informação extra corromperia o fluxo.
     */
    public function omitirMensagens() {
        $this->omitirMensagens = true;
    }

    /**
     * Reverte a ação tomada pelo método <code>omitirMensagens</code>.
     */
    public function permitirMensagens() {
        $this->omitirMensagens = false;
    }

    /**
     * Elimina todas as mensagens adicionadas até então no 'buffer' de saída
     */
    public function limparMensagens() {
        $this->mensagensRetorno = array(['sys_msgs']);
    }

    /**
     * Encerra a execução da página no ponto onde a função foi invocada, enviando
     * todas as mensagens até então adicionadas para o cliente com um sinal de
     * erro para o cliente (indicando que a operação como um todo não foi bem sucedida)
     */
    public function abortarExecucao() {
        if ($this->omitirMensagens) {
            exit;
        }
        $msg = new Mensagem();
        $msg->set_mensagemPersonalizada("sys_status", "erro");
        $this->adicionarMensagem($msg);
        echo json_encode($this->mensagensRetorno);
        exit;
    }

    /**
     * Encerra a execução da página no ponto onde a função foi invocada, enviando
     * todas as mensagens até então adicionadas para o cliente com um sinal de
     * sucesso para o cliente (indicando que a operação como um todo foi bem sucedida)
     */
    public function terminarExecucao() {
        if ($this->omitirMensagens) {
            exit;
        }
        $msg = new Mensagem();
        $msg->set_mensagemPersonalizada("sys_status", "sucesso");
        $this->adicionarMensagem($msg);
        echo json_encode($this->mensagensRetorno);
        exit;
    }

}

?>