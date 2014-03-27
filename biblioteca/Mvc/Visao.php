<?php

require_once BIBLIOTECA_DIR . "seguranca/seguranca.php";
require_once BIBLIOTECA_DIR . "seguranca/Permissao.php";
require_once APP_DIR . "modelo/Utils.php";

class Visao {

    public function renderizar($diretorio, $arquivo) {
        $local = array('app/visao/', 'app/modelo/ferramentas/');
        if (isset($this->acessoMinimo)) {
            //Caso haja algum nível mínimo de acesso, verifica se o atual usuário logado pode realizar tal operação
            if (!usuarioAutorizado(obterUsuarioSessao(), $this->acessoMinimo)) {
                require APP_DIR . "visao/acessoproibido.php";
                registrar_erro("Tentativa de acesso a página não autorizada. [$diretorio/$arquivo]. Nível de acesso necessário: $this->acessoMinimo");
                exit;
            }
        }

        $encontrou = false;
        for ($i = 0; $i < sizeof($local); $i++) {
            if (file_exists(ROOT . $local[$i] . $diretorio . '/' . $arquivo)) {
                require ROOT . $local[$i] . $diretorio . '/' . $arquivo;
                $encontrou = true;
                break;
            }
        }

        if (!$encontrou) {
            require APP_DIR . "visao/paginaConstrucao.php";
        }
    }

}

?>