<?php
namespace app\controlador;

require_once APP_LIBRARY_ABSOLUTE_DIR . 'Mvc/Controlador.php';
require_once APP_LIBRARY_ABSOLUTE_DIR . 'seguranca/seguranca.php';
require_once APP_LIBRARY_ABSOLUTE_DIR . "verificacoes_sistema.php";
require_once APP_DIR . 'modelo/Menu.php';
require_once APP_DIR . 'modelo/enumeracao/Papel.php';

use \app\modelo as Modelo;
use \app\mvc as MVC;

class ControladorInicial extends MVC\Controlador {

    public function acaoInicial() {
        $usuario = obterUsuarioSessao();
        if ($usuario->get_idPapel() == Modelo\Papel::ADMINISTRADOR) {
            $this->visao->administrador = true;
        } else {
            $this->visao->administrador = false;
        }
        $this->visao->nomeAplicativo = APP_NAME;
        $this->visao->descricaoAplicativo = APP_DESCRIPTION;
        $verificador = new \verificador_instalacao();
        $verificador->testar();
        $this->visao->temErros = !$verificador->tudoCerto();
        $this->visao->erros = $verificador->mensagensErro();
        $this->visao->nomeUsuario = $usuario->get_PNome();
        $this->visao->papel = (new Modelo\usuarioDAO())->consultarPapel($usuario->get_email());
        $this->visao->titulo = APP_NAME;
        $this->visao->menu = Modelo\Menu::montarMenuNavegacao();
        $this->visao->modoManutencao = file_exists(ROOT . 'manutencao.php');
        $this->renderizar();
    }

    public function acaoHomepage() {
        $usuario = obterUsuarioSessao();
        $this->visao->usuario = $usuario->get_PNome();
        $this->visao->papel = (int) $usuario->get_idPapel();
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Modelo\Ferramenta::__default;
    }

}

?>
