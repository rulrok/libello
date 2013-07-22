<?php

require_once 'abstractDAO.php';

class areaDAO extends abstractDAO {

    public static function obterNomeArea($areaId) {
        $areaId = (int) $areaId;
        $sql = "SELECT nomeArea FROM area WHERE idArea = " . $areaId;
        try {
            $resultado = parent::getConexao()->query($sql)->fetch();
        } catch (Exception $e) {
            echo $e;
        }
        return $resultado[0];
    }

    public static function obterIdArea($nomeArea) {

        $sql = "SELECT idArea FROM area WHERE nome = '" . $nomeArea . "'";
        try {
            $resultado = parent::getConexao()->query($sql)->fetch();
        } catch (Exception $e) {
            echo $e;
        }
        return $resultado[0];
    }

}

?>