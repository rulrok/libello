<?php
namespace app\modelo;

require_once APP_DIR . "modelo/dao/papelDAO.php";

final class Papel {

    const __default = self::DESCONHECIDO;
    const __length = 4;
    const DESCONHECIDO = 0;
    const ADMINISTRADOR = 1;
    const GESTOR = 2;
    const PROFESSOR = 3;
    const ALUNO = 4;

    public static function get_nome_papel($papelID) {
        $retorno = papelDAO::obterNomePapel($papelID);
        return $retorno;
    }

    public static function get_id_papel($nomePapel) {
        $retorno = papelDAO::obterIdPapel($nomePapel);
        return $retorno;
    }

}

?>
