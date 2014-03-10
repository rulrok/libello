<?php

require_once APP_DIR . "modelo/dao/papelDAO.php";

final class Area {

    const __default = self::DESCONHECIDO;
    const __length = 9;
    const DESCONHECIDO = 0;
    const CIENCIAS_EXATAS_E_DA_TERRA = 1;
    const CIENCIAS_HUMANAS = 2;
    const CIENCIAS_BIOLOGICAS = 3;
    const CIENCIAS_AGRARIAS = 4;
    const CIENCIAS_DA_SAUDE = 5;
    const CIENCIAS_SOCIAIS_APLICADAS = 6;
    const ENGENHARIAS = 7;
    const LINGUISTICA_LETRAS_E_ARTES = 8;
    const MULTIDISCIPLINAS = 9;

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
