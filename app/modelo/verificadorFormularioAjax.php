<?php
namespace app\modelo;
/**
 * Essa classe centraliza algumas operações comuns à verificação de formulários enviados por Ajax usando Template Method.
 *
 * @author reuel
 */
//require_once APP_DIR . "modelo/Mensagem.php";
require_once APP_DIR . "modelo/PaginaDeAcao.php";

abstract class verificadorFormularioAjax extends PaginaDeAcao {

    /**
     * Função abstrata que deve ser implementada por todos os verificadores individuais.
     * O objetivo da função é recolher todos os dados passados por POST para a página,
     * e fazer as validações necessárias, tentar persistir os novos dados em banco, e configurar 
     * a variável $mensagem adequadamente.
     */
    public abstract function _validar();

    public function _acaoPadrao() {
        //Verifica se uma requisição via post está sendo feita.
        if (!empty($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->_validar();
        } else {
            //Caso a página seja acessada diretamente
            expulsaVisitante("Não é permitido o acesso a esta página diretamente.");
        }
    }

    //duas setId e setDocumento são referentes a parte de gerar documentos,
    //id do documento gerado ou salvo para que possa ser visualizado ou editado
    public function setId($id) {
        $tmp_msg = new Mensagem();
        $tmp_msg->set_mensagemPersonalizada("id", fnEncrypt($id));
        $this->adicionarMensagem($tmp_msg);
    }

    public function setDocumento($doc) {
        $tmp_msg = new Mensagem();
        $tmp_msg->set_mensagemPersonalizada("doc", $doc);
        $this->adicionarMensagem($tmp_msg);
    }

}

?>