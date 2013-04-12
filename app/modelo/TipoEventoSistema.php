<?php

/**
 * Simular classe de enumeração
 */
final class TipoEventoSistema {

    const __default = self::SEM_ACESSO;
    const __length = 3;
    
    const DESCONHECIDO = 0;
    const CADASTRO_USUARIO = 1;
    const REMOCAO_USUARIO = 2;

}
?>
