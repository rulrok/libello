<?php

require_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
require_once BIBLIOTECA_DIR . 'seguranca/seguranca.php';
require_once APP_LOCATION . 'modelo/Menu.php';
require_once APP_LOCATION . 'modelo/enumeracao/Papel.php';

class ControladorInicial extends Controlador {

    public function acaoInicial() {
//        $seguranca = BIBLIOTECA_DIR . 'seguranca/seguranca.php';
        $usuario = obterUsuarioSessao();
        if ($usuario->get_papel() == Papel::ADMINISTRADOR) {
            $this->visao->administrador = true;
        } else {
            $this->visao->administrador = false;
        }
        $this->visao->nomeUsuario = $usuario->get_PNome();
        $this->visao->papel = usuarioDAO::consultarPapel($usuario->get_email());
        $this->visao->titulo = "Controle CEAD";
//        $this->visao->conteudo = $_SERVER['DOCUMENT_ROOT'] . "/controle-cead/app/visao/inicial/homepage.php";
        $this->visao->menu = Menu::montarMenuNavegacao();
        $this->renderizar();
    }

    public function acaoHomepage() {
        $usuario = obterUsuarioSessao();
        $this->visao->usuario = $usuario->get_PNome();
//        $this->visao->papel = usuarioDAO::consultarPapel($usuario->get_email());
        $this->visao->papel = (int) $usuario->get_papel();
        $this->renderizar();
    }

    public function acao404() {
        $this->renderizar();
    }

}

?>
