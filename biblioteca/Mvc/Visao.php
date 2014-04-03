<?php

require_once APP_LIBRARY_ABSOLUTE_DIR . "seguranca/seguranca.php";
require_once APP_LIBRARY_ABSOLUTE_DIR . "seguranca/Permissao.php";
require_once APP_DIR . "modelo/Utils.php";
require_once APP_DIR . "modelo/enumeracao/Papel.php";

class Visao {

    public function renderizar($diretorio, $arquivo) {
        $local = array('app/visao/', 'app/modelo/ferramentas/');
        if (isset($this->acessoMinimo)) {
            //Acessando alguma ferramenta do sistema
            if ($diretorio != 'sistema') {
                //Caso haja algum nível mínimo de acesso, verifica se o atual usuário logado pode realizar tal operação
                if (!usuarioAutorizado(obterUsuarioSessao(), $this->acessoMinimo)) {
                    require APP_DIR . "visao/acessoproibido.php";
                    registrar_erro("Tentativa de acesso a página não autorizada. [$diretorio/$arquivo]. Nível de acesso necessário: $this->acessoMinimo");
                    exit;
                }
            } else {
                //Acenssando um core do sistema
                //Verificação baseada em papel
                //Apenas administrador
                if (obterUsuarioSessao()->get_idPapel() != Papel::ADMINISTRADOR) {
                    require APP_DIR . "visao/acessoproibido.php";
                    registrar_erro("Tentativa de acesso a página não autorizada. [$diretorio/$arquivo]. Apenas administradores possuem acesso a essa parte do sistema");
                    exit;
                }
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