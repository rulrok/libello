<?php

namespace app\modelo;

require_once 'Evento_Log.php';

/**
 * Simular classe de enumeração
 */
final class TipoEventoLivro extends Evento_Log {

    const __table = "livro_tipoEvento";
    const __length = 3;
    const CADASTRO_LIVRO = 1;
    const REMOCAO_LIVRO = 2;
    const ALTERACAO_LIVRO = 3;
    const CADASTRO_BAIXA = 21;
    const REMOCAO_BAIXA = 22;
    const CADASTRO_SAIDA = 31;
    const REMOCAO_SAIDA = 32;
    const CADASTRO_RETORNO = 41;

}

?>
