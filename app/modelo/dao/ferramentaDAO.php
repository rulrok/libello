<?php

require_once 'abstractDAO.php';

class ferramentaDAO extends abstractDAO {

    public function obterNomeFerramenta($ferramentaID) {
        $sql = "SELECT nome FROM ferramenta WHERE idFerramenta = :idFerramenta";
        $params = array(':idFerramenta' => array($ferramentaID, PDO::PARAM_INT));
        return $this->executarSelect($sql, $params, false);
    }

}

?>  