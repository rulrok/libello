<?php

namespace app\modelo;

require_once APP_LIBRARY_ABSOLUTE_DIR . "seguranca/Permissao.php";
require_once APP_DIR . "modelo/enumeracao/Ferramenta.php";

/**
 * Classe para armazenar as permissões de acesso de um usuário sobre as ferramentas
 * do sistema.
 * Antigamente para cada ferramenta era necessário criar uma variável própria nesta
 * classe e seus respectivos GETs e SETs. Isso não é necessário pois o PHP pode
 * fazer isso em tempo de execução através dos métodos mágicos __get() e __set().
 * Portanto nenhuma variável precisa ser definida aqui, deixando o sistema totalmente
 * flexível.
 */
class PermissoesFerramenta {
    /*
     * Apenas deixe o arquivo vazio.
     */
}

?>
