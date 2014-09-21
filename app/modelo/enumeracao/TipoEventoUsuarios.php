<?php

namespace app\modelo;

require_once 'Evento_Log.php';

/**
 * Simular classe de enumeração
 */
final class TipoEventoUsuarios extends Evento_Log {

    const __table = "sistema_eventosistema";
    const __length = 9;
    const CADASTRO_USUARIO = 1;
    const DESATIVACAO_USUARIO = 2;
    const ATIVACAO_USUARIO = 3;
    const ALTERACAO_USUARIO = 4;

}

?>
