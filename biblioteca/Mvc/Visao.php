<?php

class Visao {

    public function renderizar($diretorio, $arquivo) {
        $local = 'app/visao/';
        require $_SERVER['DOCUMENT_ROOT'] . "/controle-cead/" . $local . $diretorio . '/' . $arquivo;
    }

}

?>
