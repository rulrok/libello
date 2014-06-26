<?php

/**
 * Essa classe centraliza algumas operações comuns à verificação de formulários enviados por Ajax usando Template Method.
 *
 * @author reuel
 */
require_once APP_DIR . "modelo/Mensagem.php";

abstract class verificadorFormularioAjax {

    /**
     *  Mensagem que será retornada à tela do usuário após alguma operação, por exemplo um cadastro de alguma coisa,
     * que pode ser de erro, sucesso ou informação.
     * 
     * @var Mensagem
     * @example new Mensagem()->set_mensagem("Uma mensagem qualquer")->set_status(Mensagem::Info)
     */
    //TODO Mudar visibilidade para privado e fazer todos os formulários usarem apenas os métodos de mensagens públicos.
    /**
     *
     * @var \Mensagem 
     */
    private $mensagem;

    /**
     * Função abstrata que deve ser implementada por todos os verificadores individuais.
     * O objetivo da função é recolher todos os dados passados por POST para a página,
     * e fazer as validações necessárias, tentar persistir os novos dados em banco, e configurar 
     * a variável $mensagem adequadamente.
     */
    public abstract function _validar();

    public function verificar() {
        //Verifica se uma requisição via post está sendo feita.
        if (!empty($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->mensagem = new Mensagem();
            $this->mensagem->set_mensagemInfo("Mensagem padrão do validador.");
            $this->_validar();
            $this->retornar();
        } else {
            //Caso a página seja acessada diretamente
            expulsaVisitante("Não é permitido o acesso a esta página diretamente.");
        }
    }

    //duas setId e setDocumento são referentes a parte de gerar documentos,
    //id do documento gerado ou salvo para que possa ser visualizado ou editado
    public function setId($id){
        $this->mensagem->id = fnEncrypt($id);
    }
    
    public function setDocumento($doc){
        $this->mensagem->documento = $doc;
    }
    
    public function mensagemSucesso($mensagem) {
        $this->mensagem->set_mensagemSucesso($mensagem);
        $this->retornar();
    }

    public function mensagemErro($mensagem) {
        $this->mensagem->set_mensagemErro($mensagem);
        $this->retornar();
    }

    public function mensagemAviso($mensagem) {
        $this->mensagem->set_mensagemInfo($mensagem);
        $this->retornar();
    }

    private function retornar() {
        echo json_encode($this->mensagem);
        exit;
    }

}

?>