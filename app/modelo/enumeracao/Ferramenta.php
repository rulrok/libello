<?php

require_once APP_LOCATION . "modelo/dao/ferramentaDAO.php";

final class Ferramenta {

    const __default = self::DESCONHECIDO;
    const __length = 8;
    const DESCONHECIDO = 0;
    const CONTROLE_USUARIOS = 1;
    const CURSOS_E_POLOS = 2;
    const CONTROLE_LIVROS = 3;
    const CONTROLE_EQUIPAMENTOS = 4;
    const CONTROLE_DOCUMENTOS = 5;
    const CONTROLE_VIAGENS = 6;
    const TAREFAS = 7;
    const CONTROLE_PAGAMENTOS = 8;

    public static function get_nome_ferramenta($ferramentaID) {
        $retorno = ferramentaDAO::obterNomeFerramenta($ferramentaID);
        return $retorno;
    }

}

?>
