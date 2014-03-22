<?php

require_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
require_once BIBLIOTECA_DIR . 'seguranca/seguranca.php';
require_once BIBLIOTECA_DIR . "verificacoes_sistema.php";
require_once APP_DIR . 'modelo/Menu.php';
require_once APP_DIR . 'modelo/enumeracao/Papel.php';

class ControladorInicial extends Controlador {

    public function acaoInicial() {
        $usuario = obterUsuarioSessao();
        if ($usuario->get_idPapel() == Papel::ADMINISTRADOR) {
            $this->visao->administrador = true;
        } else {
            $this->visao->administrador = false;
        }
        $this->visao->nomeAplicativo = APP_NAME;
        $verificador = new verificador_instalacao();
        $verificador->testar();
        $this->visao->temErros = !$verificador->tudoCerto();
        $this->visao->erros = $verificador->mensagensErro();
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

    public function idFerramentaAssociada() {
        return Ferramenta::DESCONHECIDO;
    }

}

?>
