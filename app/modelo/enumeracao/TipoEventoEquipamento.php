<?php

/**
 * Simular classe de enumeração
 */
final class TipoEventoEquipamento {

    const __default = self::DESCONHECIDO;
    const __length = 9;
    
    const DESCONHECIDO = 0;
    
    const CADASTRO_EQUIPAMENTO = 1;
    const REMOCAO_EQUIPAMENTO = 2;
    const ALTERACAO_EQUIPAMENTO = 3;
    
    
}
?>
