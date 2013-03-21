<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';
include_once __DIR__.'/../../biblioteca/seguranca/seguranca.php';
include_once __DIR__.'/../modelo/dao/usuarioDAO.php';


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

    public function acaoGerenciarconta() {

        $this->visao->nome = $_SESSION['nome'];
        $this->visao->sobrenome = $_SESSION['sobrenome'];
        $this->visao->email = $_SESSION['email'];
        $this->visao->login = $_SESSION['login'];
        $usuario = new Usuario();
        $usuario->set_login($_SESSION['login']);

        $usuarioDao = new usuarioDAO();
        
        $this->visao->papel = $usuarioDao->consultarPapel($usuario);
        
        $this->renderizar();
    }

}

?>
