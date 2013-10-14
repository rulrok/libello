<?php
require_once 'Evento_Log.php';
/**
 * Simular classe de enumeração
 */
final class TipoEventoSistema extends Evento_Log{

    const __table = "eventoSistema";
    const __length = 9;
    
    const CADASTRO_USUARIO = 1;
    const REMOCAO_USUARIO = 2;
    const ALTERACAO_USUARIO = 3;
    
    const CADASTRO_POLO = 4;
    const REMOCAO_POLO = 5;
    const ALTERACAO_POLO = 6;
    
    const CADASTRO_CURSO = 7;
    const REMOCAO_CURSO = 8;
    const ALTERACAO_CURSO = 9;
}
?>
