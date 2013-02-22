<?php

class Visao {

   public function renderizar($diretorio, $arquivo)
	{
            $local  = '../../Vision/';
	    require $local . $diretorio . '/' . $arquivo;
	}
}

?>
