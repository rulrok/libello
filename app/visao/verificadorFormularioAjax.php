<?php

/**
 * Essa classe centraliza algumas operações comuns à verificação de formulários enviados por Ajax usando Template Method.
 *
 * @author reuel
 */
require_once APP_LOCATION . "modelo/Mensagem.php";

abstract class verificadorFormularioAjax {

    /**
     *  Mensagem que será retornada à tela do usuário após alguma operação, por exemplo um cadastro de alguma coisa,
     * que pode ser de erro, sucesso ou informação.
     * 
     * @var Mensagem
     * @example new Mensagem()->set_mensagem("Uma mensagem qualquer")->set_status(Mensagem::Info)
     */
    //TODO Mudar visibilidade para privado e fazer todos os formulários usarem apenas os métodos de mensagens públicos.
    public $mensagem;

    /**
     * Função abstrata que deve ser implementada por todos os verificadores individuais.
     * O objetivo da função é recolher todos os dados passados por POST para a página,
     * e fazer as validações necessárias, tentar persistir os novos dados em banco, e configurar 
     * a variável $mensagem adequadamente.
     */
    public abstract function _validar();

    public function verificar() {
        //Verifica se uma requisição via post está sendo feita.
        if (!empty($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) == 'post') {

            $this->mensagem = new Mensagem();
            $this->mensagem->set_mensagem("Mensagem padrão do validador.")->set_status(Mensagem::INFO);
            $this->_validar();
            $this->retornar();
        } else {
            //Caso a página seja acessada diretamente
            expulsaVisitante("Não é permitido o acesso a esta página diretamente.");
        }
    }

    public function mensagemSucesso($mensagem) {
        $this->mensagem->set_mensagem($mensagem)->set_status(Mensagem::SUCESSO);
        $this->retornar();
    }

    public function mensagemErro($mensagem) {
        $this->mensagem->set_mensagem($mensagem)->set_status(Mensagem::ERRO);
        $this->retornar();
    }

    public function mensagemAviso($mensagem) {
        $this->mensagem->set_mensagem($mensagem)->set_status(Mensagem::INFO);
        $this->retornar();
    }

    private function retornar() {
        echo json_encode($this->mensagem);
        exit;
    }

}

?>