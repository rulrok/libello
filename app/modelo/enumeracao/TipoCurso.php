<?php

namespace app\modelo;

/**
 * Simular classe de enumeração
 */
final class TipoCurso {

    const __default = self::DESCONHECIDO;
    const __length = 3;
    const DESCONHECIDO = 0;
    const GRADUACAO = 1;
    const POS_GRADUACAO_LATO_SENSU = 2;
    const POS_GRADUACAO_STRICTU_SENSU = 3;

}

?>
