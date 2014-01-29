<?php

class Visao {

    public function renderizar($diretorio, $arquivo) {
        $local = array('app/visao/', 'app/modelo/');
        if (file_exists(ROOT . $local[0] . $diretorio . '/' . $arquivo)) {
            require ROOT . $local[0] . $diretorio . '/' . $arquivo;
        }else if(file_exists(ROOT . $local[1] . $diretorio . '/' . $arquivo)){
            require ROOT . $local[1] . $diretorio . '/' . $arquivo;
            
        }else {
        
            require ROOT."app/visao/paginaInexistente.php";
        }
    }

}

?>
