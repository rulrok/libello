<?php

namespace app\modelo;

/**
 * Eventos, por fins administrativos e de auditoria, são cadastrados
 * no banco de dados. Os arquivo que simulam arquivos de enumeração que herdam
 * desta classe, tem o intuito de serem usados futuramente, por um instalador do
 * software, que se encarregará de pré-configurar o banco de dados com as informações 
 * necessárias.
 *
 * @author Reuel
 */
class Evento_Log {

    /**
     * Por convensão, os eventos não devem ser cadastrados no banco de dados com
     * ID numérico igual a zero. Devem começar a partir do número 1 e seguir
     * espaçamento a vontade.
     */
    const __default = self::DESCONHECIDO;
    const DESCONHECIDO = 0;

}

?>
