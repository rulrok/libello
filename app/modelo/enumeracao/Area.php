<?php

require_once ROOT . "app/modelo/dao/papelDAO.php";

final class Area {

    const __default = self::DESCONHECIDO;
    const __length = 3;
    const DESCONHECIDO = 0;
    const CIENCIAS_EXATAS_E_DA_TERRA = 1;
    const CIENCIAS_HUMANAS = 2;
    const CIENCIAS_BIOLOGICAS = 3;

    public static function get_nome_area($areaId) {
        $retorno = areaDAO::obterNomeArea($areaId);
        return $retorno;
    }

    public static function get_id_area($nomeArea) {
        $retorno = areaDAO::obterIdArea($nomeArea);
        return $retorno;
    }

}

?>
