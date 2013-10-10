<?php

require_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
require_once BIBLIOTECA_DIR . 'seguranca/seguranca.php';
require_once APP_LOCATION . 'modelo/Menu.php';

class ControladorInicial extends Controlador {

    public function acaoInicial() {
//        $seguranca = BIBLIOTECA_DIR . 'seguranca/seguranca.php';
        $usuario = obterUsuarioSessao();
        $this->visao->usuario = $usuario->get_PNome();
        $this->visao->papel = usuarioDAO::consultarPapel($usuario->get_email());
        $this->visao->titulo = "Controle CEAD";
//        $this->visao->conteudo = $_SERVER['DOCUMENT_ROOT'] . "/controle-cead/app/visao/inicial/homepage.php";
        $this->visao->menu = Menu::montarMenuNavegacao();
        $this->renderizar();
    }

    public function acaoHomepage() {
        $usuario = obterUsuarioSessao();
        $this->visao->usuario = $usuario->get_PNome();
        $this->renderizar();
    }

    public function acao404() {
        $this->renderizar();
    }

}

?>
