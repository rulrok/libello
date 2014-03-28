<?php

require_once 'Evento_Log.php';

/**
 * Simular classe de enumeração
 */
final class TipoEventoSistema extends Evento_Log {

    const __table = "sistema_eventosistema";
    const __length = 9;
    
    const CADASTRO_USUARIO = 1;
    const DESATIVACAO_USUARIO = 2;
    const ATIVACAO_USUARIO = 3;
    const ALTERACAO_USUARIO = 4;
    
    const CADASTRO_POLO = 10;
    const REMOCAO_POLO = 11;
    const ALTERACAO_POLO = 12;
    
    const CADASTRO_CURSO = 20;
    const REMOCAO_CURSO = 21;
    const ALTERACAO_CURSO = 22;

}

?>
