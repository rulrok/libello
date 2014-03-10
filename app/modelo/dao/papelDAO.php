<?php

require_once 'abstractDAO.php';

class papelDAO extends abstractDAO {

    public function obterNomePapel($papelID) {
        $sql = "SELECT nome FROM papel WHERE idpapel = :idPapel";
        $params = array(':idPapel' => array((int) $papelID, PDO::PARAM_INT));

        return $this->executarSelect($sql, $params, false);
    }

    public function obterIdPapel($nomePapel) {

        $sql = "SELECT idPapel FROM papel WHERE nome = '" . $nomePapel . "'";
        try {
            $resultado = parent::getConexao()->query($sql)->fetch();
        } catch (Exception $e) {
            echo $e;
        }
        return $resultado[0];
    }

}

?>