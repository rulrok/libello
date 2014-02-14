<?php
require_once 'Evento_Log.php';
/**
 * Simular classe de enumeração
 */
final class TipoEventoImagens extends Evento_Log{

    const __table = "imagens_tipoEvento";
    const __length = 9;
    
    const CADASTRO_IMAGEM = 1;
    const REMOCAO_IMAGEM = 2;
    const ALTERACAO_IMAGEM = 3;
    
    const CADASTRO_CATEGORIA = 21;
    const REMOCAO_CATEGORIA = 22;
    const ALTERACAO_CATEGORIA = 23;
    
    const CADASTRO_SUBCATEGORIA = 31;
    const REMOCAO_SUBCATEGORIA = 32;
    const ALTERACAO_SUBCATEGORIA = 33;
    
}
?>
