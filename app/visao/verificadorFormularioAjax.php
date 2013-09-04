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
    public $mensagem;

    /**
     * Função abstrata que deve ser implementada por todos os verificadores individuais.
     * O objetivo da função é recolher todos os dados passados por POST para a página,
     * e fazer as validações necessárias, tentar persistir os novos dados em banco, e configurar 
     * a variável $mensagem adequadamente.
     */
    public abstract function _validar();

    public function verificar() {
        //Verifica se uma requisição via Ajax está sendo feita.
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

            $this->mensagem = new Mensagem();
            $this->mensagem->set_mensagem("Mensagem padrão do validador.")->set_status(Mensagem::INFO);
            $this->_validar();
            echo json_encode($this->mensagem);
        } else {
            //Caso a página seja acessada diretamente
            expulsaVisitante("Não é permitido o acesso a esta página diretamente.");
        }
    }

}

?>