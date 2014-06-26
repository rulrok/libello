<?php
/**
 * Simular classe de enumeração
 */
final class Permissao {

    const __default = self::SEM_ACESSO;
    const __length = 5;
    
    const SEM_ACESSO = 1;
    const CONSULTA = 10;
    const ESCRITA = 20;
    const GESTOR = 30;
    const ADMINISTRADOR = 40;

}

?>
