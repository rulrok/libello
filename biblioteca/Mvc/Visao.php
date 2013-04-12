<?php

class Visao {

    public function renderizar($diretorio, $arquivo) {
        $local = 'app/visao/';
        require ROOT . $local . $diretorio . '/' . $arquivo;
    }

}

?>
