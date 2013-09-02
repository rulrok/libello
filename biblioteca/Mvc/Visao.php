<?php

class Visao {

    public function renderizar($diretorio, $arquivo) {
        $local = 'app/visao/';
        if (file_exists(ROOT . $local . $diretorio . '/' . $arquivo)) {
            require ROOT . $local . $diretorio . '/' . $arquivo;
        } else {
            require ROOT."app/visao/paginaInexistente.php";
        }
    }

}

?>
