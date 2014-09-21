<?php
namespace app\controlador;

include_once APP_LIBRARY_ABSOLUTE_DIR . 'Mvc/Controlador.php';
include_once APP_LIBRARY_ABSOLUTE_DIR . 'seguranca/seguranca.php';
include_once APP_LIBRARY_ABSOLUTE_DIR . 'seguranca/Permissao.php';
include_once __DIR__ . '/../modelo/dao/usuarioDAO.php';

/**
 * Diferente dos outros controladores, o controlador 'sistema' verifica as permissões
 * ao acesso às funções de forma diferente.
 * 
 * Ao invés de definir nível mínimo de acesso, é definido apenas se há ou não, com 
 * TRUE ou FALSE
 * 
 * Caso TRUE, um usuário deve ter papel administrativo para acessar a ação. Caso
 * contrátrio, o acesso é liberado para qualquer usuário autenticado.
 */
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
            $this->visao->nome = obterUsuarioSessao()->get_PNome();
            $this->visao->sobrenome = obterUsuarioSessao()->get_UNome();
            $this->visao->email = obterUsuarioSessao()->get_email();
            $this->visao->dataNascimento = obterUsuarioSessao()->get_dataNascimento();
            $this->visao->papel = (new \app\modelo\usuarioDAO())->consultarPapel(obterUsuarioSessao()->get_email());
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

    public function acaoAdministracao() {
        $this->visao->acessoMinimo = true;
        $this->renderizar();
    }

    public function acaoAtivarmanutencao() {
        $this->visao->acessoMinimo = true;
        $this->renderizar();
    }

    public function acaoDesativarmanutencao() {
        $this->visao->acessoMinimo = true;
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Ferramenta::DESCONHECIDO;
    }

}

?>
