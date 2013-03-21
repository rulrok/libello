<?php
/**
 * Simular classe de enumeração
 */
final class Permissoes {

    const __default = self::SEM_ACESSO;
    const SEM_ACESSO = 1;
    const CONSULTA = 2;
    const ESCRITA = 3;
    const GESTOR = 4;
    const ADMINISTRADOR = 5;

}

?>
