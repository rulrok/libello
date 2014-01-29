<?php

include_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
include_once BIBLIOTECA_DIR . 'seguranca/seguranca.php';
include_once BIBLIOTECA_DIR . 'seguranca/Permissao.php';
include_once __DIR__ . '/../modelo/dao/usuarioDAO.php';

class ControladorSistema extends Controlador {

    public function acaoInicial() {
        $this->renderizar();
    }

    public function acaoSair() {
        expulsaVisitante();
    }

    public function acaoNaoautenticado() {
        $this->renderizar();
    }

    public function acaoGerenciarconta($erro = false) {
        if ($erro == false) {
//            $this->visao->mensagem_usuario = null;
            $this->visao->nome = obterUsuarioSessao()->get_PNome();
            $this->visao->sobrenome = obterUsuarioSessao()->get_UNome();
            $this->visao->email = obterUsuarioSessao()->get_email();
            $this->visao->dataNascimento = obterUsuarioSessao()->get_dataNascimento();



            $this->visao->papel = usuarioDAO::consultarPapel(obterUsuarioSessao()->get_email());
        } else {
            if ($this->visao->mensagem_usuario == NULL || $this->visao->mensagem_usuario == "") {
                $this->visao->mensagem_usuario = "Informações inválidas.";
                $this->visao->tipo_mensagem = "erro";
            }
        }

        $this->renderizar();
    }

    public function acaoValidarAlteracoesConta() {
        $this->renderizar();
    }
    public function acaoAdministracao(){
        $this->visao->acessoMinimo = Permissao::ADMINISTRADOR;
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Ferramenta::DESCONHECIDO;
    }

}

?>
