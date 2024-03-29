<?php

namespace app\modelo;

require_once 'abstractDAO.php';
require_once APP_DIR . 'modelo/Utils.php';

class sistemaDAO extends abstractDAO {

    public function registrarAccesso($idUsuario) {
        $tempo = time();
        $sql = "INSERT INTO usuario_acessos(idUsuario,data,ip) VALUES (:idU, :d, :ip)";
        $params = array(
            ':idU' => [$idUsuario, \PDO::PARAM_INT]
            , ':d' => [$tempo, \PDO::PARAM_INT]
            , ':ip' => [$_SERVER['REMOTE_ADDR'], \PDO::PARAM_STR]
        );
        $this->executarQuery($sql, $params);

        $sqlUltimoAcesso = "UPDATE usuario SET ultimoAcesso = :ultimoAcesso WHERE idUsuario = :idUsuario";
        $paramsUltimoAcesso = array(
            ':ultimoAcesso' => [$tempo, \PDO::PARAM_INT]
            , ':idUsuario' => [$idUsuario, \PDO::PARAM_INT]
        );

        return $this->executarQuery($sqlUltimoAcesso, $paramsUltimoAcesso);
    }

    public function recuperarMenu($ferramenta) {
        $sql = "SELECT idLink, nomeMenu FROM sistema_menu WHERE idFerramenta = :idFerramenta";
        $params = array(
            ':idFerramenta' => [$ferramenta, \PDO::PARAM_INT]
        );

        return $this->executarSelect($sql, $params);
    }

    public function recuperarSubmenu($ferramenta) {
        $sql = "SELECT nivelPermissao,link, nomeSubmenu FROM sistema_menu NATURAL JOIN sistema_submenu WHERE idFerramenta = :idFerramenta";
        $params = array(
            ':idFerramenta' => [$ferramenta, \PDO::PARAM_INT]
        );

        return $this->executarSelect($sql, $params);
    }

}
