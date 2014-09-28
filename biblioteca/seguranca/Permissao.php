<?php

namespace app\modelo;

/**
 * Simular classe de enumeração
 */
final class Permissao extends \SplEnum {

    const SEM_ACESSO = 1;
    const CONSULTA = 10;
    const ESCRITA = 20;
    const GESTOR = 30;
    const ADMINISTRADOR = 40;

    /**
     * 
     * @return type
     */
    public static function obterValores() {
        return (new Permissao())->getConstList();
    }

}

?>
