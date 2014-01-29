<?php

require_once BIBLIOTECA_DIR . "seguranca/seguranca.php";
require_once BIBLIOTECA_DIR . "seguranca/Permissao.php";

class Visao {

//    var $acessoMinimo = Permissao::CONSULTA;

    public function renderizar($diretorio, $arquivo) {
        $local = 'app/visao/';
        if (isset($this->acessoMinimo)) {
            //Caso haja algum nível mínimo de acesso, verifica se o atual usuário logado pode realizar tal operação
            if (!usuarioAutorizado(obterUsuarioSessao(), $this->acessoMinimo)) {
                require APP_LOCATION . "visao/acessoproibido.php";
                exit;
            }
        }
        if (file_exists(ROOT . $local . $diretorio . '/' . $arquivo)) {
            require ROOT . $local . $diretorio . '/' . $arquivo;
        } else {
            require APP_LOCATION . "visao/paginaConstrucao.php";
        }
    }

}

?>
