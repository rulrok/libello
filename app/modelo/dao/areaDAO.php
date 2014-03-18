<?php

require_once 'abstractDAO.php';

class areaDAO extends abstractDAO {

    /**
     * 
     * @param int $idArea
     * @return string
     */
    public function obterNomeArea($idArea) {
        $idArea = (int) $idArea;
        $sql = "SELECT nomeArea FROM cursospolos_area WHERE idArea = :idArea";
        $params = array(
            ':idArea' => [$idArea, PDO::PARAM_STR]
        );
        return (string) $this->executarSelect($sql, $params, false);
    }

    /**
     * 
     * @param string $nomeArea
     * @return int
     */
    public function obterIdArea($nomeArea) {

        $sql = "SELECT idArea FROM cursospolos_area WHERE nome = :nome";
        $params = array(
            ':nome' => [$nomeArea, PDO::PARAM_STR]
        );
        return (int) $this->executarSelect($sql, $params, false);
    }

}

?>