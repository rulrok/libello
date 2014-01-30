<?php

require_once BIBLIOTECA_DIR . "seguranca/seguranca.php";
require_once BIBLIOTECA_DIR . "seguranca/Permissao.php";

class Visao {

//    var $acessoMinimo = Permissao::CONSULTA;

    public function renderizar($diretorio, $arquivo) {
        $local = array('app/visao/', 'app/modelo/');
        if (isset($this->acessoMinimo)) {
            //Caso haja algum nível mínimo de acesso, verifica se o atual usuário logado pode realizar tal operação
            if (!usuarioAutorizado(obterUsuarioSessao(), $this->acessoMinimo)) {
                require APP_LOCATION . "visao/acessoproibido.php";
                exit;
            }
        }
        
        if (file_exists(ROOT . $local[0] . $diretorio . '/' . $arquivo)) {
            require ROOT . $local[0] . $diretorio . '/' . $arquivo;
        }else if(file_exists(ROOT . $local[1] . $diretorio . '/' . $arquivo)){
            require ROOT . $local[1] . $diretorio . '/' . $arquivo;
            
        }else {
            require APP_LOCATION . "visao/paginaConstrucao.php";
        }
        
    }

}

?>
