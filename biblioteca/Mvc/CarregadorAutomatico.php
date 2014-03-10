<?php

class CarregadorAutomatico {

    public static function carregar($nomeClasse) {
        //lista de diretorios que as classes serão pesquisadas
        $diretorios = array('app/controlador', 'app/modelo/dao', 'app/modelo/vo');

        //transforma parte do nome da classe para diretorio
        $nomeClasse = str_replace(array('_', '\\'), '/', $nomeClasse);

        //procura as classes nos diretorios definidos
        foreach ($diretorios as $diretorio) {
            //pega o caminho real do diretorio e junta com o nome da classe
            $classeLocal = realpath($diretorio) . '/' . $nomeClasse . ".php";

            //checa se o arquivo existe
            if (file_exists($classeLocal)) {
                //inclue o arquivo
                require $classeLocal;
                //returna verdadeiro quando achou e para o loop
                return true;
            }
        }
        return false;
    }

    public static function registrar() {
        spl_autoload_register('CarregadorAutomatico::carregar');
    }

}

?>