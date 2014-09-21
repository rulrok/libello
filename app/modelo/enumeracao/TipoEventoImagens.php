<?php

namespace app\modelo;

require_once 'Evento_Log.php';

/**
 * Simular classe de enumeração
 */
final class TipoEventoImagens extends Evento_Log {

    const __table = "imagem_tipoevento";
    const __length = 6;
    const CADASTRO_IMAGEM = 1;
    const REMOCAO_IMAGEM = 2;
    const ALTERACAO_IMAGEM = 3;
    const CADASTRO_DESCRITOR = 21;
    const REMOCAO_DESCRITOR = 22;
    const ALTERACAO_DESCRITOR = 23;

}

?>
