<?php

require_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
require_once BIBLIOTECA_DIR . 'seguranca/seguranca.php';
require_once APP_LOCATION . 'modelo/Menu.php';
require_once APP_LOCATION . 'modelo/enumeracao/Papel.php';

class ControladorInicial extends Controlador {

    public function acaoInicial() {
        $usuario = obterUsuarioSessao();
        if ($usuario->get_idPapel() == Papel::ADMINISTRADOR) {
            $this->visao->administrador = true;
        } else {
            $this->visao->administrador = false;
        }
        $this->visao->nomeUsuario = $usuario->get_PNome();
        $this->visao->papel = (new usuarioDAO())->consultarPapel($usuario->get_email());
        $this->visao->titulo = "Controle CEAD";
        $this->visao->menu = Menu::montarMenuNavegacao();
        $this->renderizar();
    }

    public function acaoHomepage() {
        $usuario = obterUsuarioSessao();
        $this->visao->usuario = $usuario->get_PNome();
        $this->visao->papel = (int) $usuario->get_idPapel();
        $this->renderizar();
    }

    public function acao404() {
        $this->renderizar();
        exit;
    }

    public function idFerramentaAssociada() {
        return Ferramenta::DESCONHECIDO;
    }

}

?>
